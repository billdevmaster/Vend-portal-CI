<?php
class Client_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
        $this->load->library('email');
    }

    public function insertClient()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $clientpassword = password_hash($this->input->post('clientpassword'), PASSWORD_BCRYPT);
            log_message('debug', 'insertClient');
            $data = array(
                'client_code' => $this->input->post('clientcode'),
                'client_name' => $this->input->post('clientname'),
                'business_registration_number' => $this->input->post('business_registration_number'),
                'client_address' => $this->input->post('clientaddress'),
                'client_email' => $this->input->post('clientemail'),
                'client_phone' => $this->input->post('clientphone'),
                'client_username' => $this->input->post('username'),
                'role' => $this->input->post('role'),
                'client_password' => $clientpassword,
                'created_by' => $this->session->userdata('firstname')
            );
            $this->db->insert('client', $data);

            $data = array(
                'client_code' => $this->input->post('clientcode'),
                'client_name' => $this->input->post('clientname'),
                'client_address' => $this->input->post('clientaddress'),
                'client_email' => $this->input->post('clientemail'),
                'client_phone' => $this->input->post('clientphone'),
                'created_by' => $this->session->userdata('firstname')
            );
            $this->db->where('client_code', $this->input->post('clientcode'));
            $this->db->where('client_name', $this->input->post('clientname'));
            $this->db->where('client_address', $this->input->post('clientaddress'));
            $this->db->where('client_email', $this->input->post('clientemail'));
            $this->db->where('client_phone', $this->input->post('clientphone'));
            $result = $this->db->get('client')->result();
            foreach ($result as $row) {
                $client_id = $row->id;
            }

            $clientname = explode(' ', $this->input->post('clientname'));

            if (count($clientname) == 1) {
                $clientname[1] = '';
            }
            $data = array(
                'mobilenumber' => $this->input->post('clientphone'),
                'organization' => $this->input->post('clientname'),
                'firstname' => '',
                'lastname' => '',
                'emailid' => $this->input->post('clientemail'),
                'upt_no' => "+87810" . $this->input->post('clientphone'),
                'role' => $this->input->post('role'),
                'username' => $this->input->post('username'),
                'client_id' => $client_id,
                'password' => $clientpassword
            );
            $this->db->insert('admin', $data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);


            $this->db->where('id',$client_id);
            $query = $this->db->get('client');
            $result = $query->result();
            foreach ($result as $row) {
                $data['title'] = "Portal Login Request";
                $data['body'] = "Please approve the Portal Login request for the below mentioned New Client.";
                $data['client_name'] = $row->client_name;
                $data['client_address'] = $row->client_address;
                $data['client_mobile_number'] =  substr($row->client_phone, 0, 4) . ' ' . substr($row->client_phone, 4, 3) . ' ' . substr($row->client_phone, 7);
                $data['client_email'] = $row->client_email;
                $data['business_registration_number'] = $row->business_registration_number;
                $this->sendMailToAdmin($data);
            }



        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function sendMailToAdmin($data)
    {
        $this->db->where('role', 'Super Admin');
        $query = $this->db->get('admin');
        $result = $query->result();
        foreach ($result as $row) {
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
            $config['smtp_user'] = 'noreply@visualvend.com';
            $config['smtp_pass'] = 'V15ualV3nd';
            $config['mailtype'] = 'html';
            $config['smtp_port'] = 465;

            $this->email->clear(TRUE);
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from("noreply@visualvend.com");
            $this->email->subject('Approval Required');
            $message = $this->load->view('notification_mail', $data, TRUE);
            $this->email->message($message);
           // $this->email->to($row->emailid);

            if ($this->email->send()) {
                log_message('debug', "Email Send Successfully.");
            } else {
                log_message('debug', "You have encountered an error " . $row->emailid);
            }
        }
    }


    public function checkExistence()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'checkExistence');
            $arr_data['isPresent'] = 'none';
            $this->db->where('client_phone', $this->input->post('clientphone'));
            $query = $this->db->get('client');
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'mobile';
                $arr = array('code' => 200, 'data' => $arr_data);
                header('Content-type:application/json');
                echo json_encode($arr);
            } else {
                $this->db->where('client_email', $this->input->post('clientemail'));
                $query = $this->db->get('client');
                if ($query->num_rows() > 0) {
                    $arr_data['isPresent'] = 'email';
                    $arr = array('code' => 200, 'data' => $arr_data);
                    header('Content-type:application/json');
                    echo json_encode($arr);
                } else {
                    $this->db->where('client_code', $this->input->post('clientcode'));
                    $query = $this->db->get('client');
                    if ($query->num_rows() > 0) {
                        $arr_data['isPresent'] = 'code';
                        $arr = array('code' => 200, 'data' => $arr_data);
                        header('Content-type:application/json');
                        echo json_encode($arr);
                    } else {
                        $this->db->where('mobilenumber', $this->input->post('clientphone'));
                        $query = $this->db->get('admin');
                        if ($query->num_rows() > 0) {
                            $arr_data['isPresent'] = 'mobile';
                            $arr = array('code' => 200, 'data' => $arr_data);
                            header('Content-type:application/json');
                            echo json_encode($arr);
                        } else {
                            $this->db->where('emailid', $this->input->post('clientemail'));
                            $query = $this->db->get('admin');
                            if ($query->num_rows() > 0) {
                                $arr_data['isPresent'] = 'email';
                                $arr = array('code' => 200, 'data' => $arr_data);
                                header('Content-type:application/json');
                                echo json_encode($arr);
                            } else {
                                $this->db->where('username', $this->input->post('username'));
                                $query = $this->db->get('admin');
                                if ($query->num_rows() > 0) {
                                    $arr_data['isPresent'] = 'username';
                                    $arr = array('code' => 200, 'data' => $arr_data);
                                    header('Content-type:application/json');
                                    echo json_encode($arr);
                                } else {
                                    $this->db->where('client_username', $this->input->post('username'));
                                    $query = $this->db->get('client');
                                    if ($query->num_rows() > 0) {
                                        $arr_data['isPresent'] = 'username';
                                        $arr = array('code' => 200, 'data' => $arr_data);
                                        header('Content-type:application/json');
                                        echo json_encode($arr);
                                    } else {
                                        $arr = array('code' => 200, 'data' => $arr_data);
                                        header('Content-type:application/json');
                                        echo json_encode($arr);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function checkUpdateExistence()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'checkExistence');
            $arr_data['isPresent'] = 'none';
            $this->db->where_not_in('client_code', $this->input->post('clientcode'));
            $this->db->where('client_phone', $this->input->post('clientphone'));
            $query = $this->db->get('client');
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'mobile';
                $arr = array('code' => 200, 'data' => $arr_data);
                header('Content-type:application/json');
                echo json_encode($arr);
            } else {
                $this->db->where_not_in('client_code', $this->input->post('clientcode'));
                $this->db->where('client_email', $this->input->post('clientemail'));
                $query = $this->db->get('client');
                if ($query->num_rows() > 0) {
                    $arr_data['isPresent'] = 'email';
                    $arr = array('code' => 200, 'data' => $arr_data);
                    header('Content-type:application/json');
                    echo json_encode($arr);
                } else {
                    $this->db->where_not_in('client_code', $this->input->post('clientcode'));
                    $this->db->where('client_username', $this->input->post('username'));
                    $query = $this->db->get('client');
                    if ($query->num_rows() > 0) {
                        $arr_data['isPresent'] = 'username';
                        $arr = array('code' => 200, 'data' => $arr_data);
                        header('Content-type:application/json');
                        echo json_encode($arr);
                    } else {
                        $arr = array('code' => 200, 'data' => $arr_data);
                        header('Content-type:application/json');
                        echo json_encode($arr);
                    }
                }
            }
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function getClients()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'Inside getClients');
            $result = $this->db->get('client')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['clientcode'] = $row->client_code;
                $arr_data[$i]['clientname'] = $row->client_name;
                $arr_data[$i]['clientaddress'] = $row->client_address;
                $arr_data[$i]['clientemail'] = $row->client_email;
                $arr_data[$i]['business_registration_number'] = $row->business_registration_number;
                $arr_data[$i]['clientphone'] = $row->client_phone;
                $arr_data[$i]['role'] = $row->role;
                $arr_data[$i]['username'] = $row->client_username;
                $i++;
            }
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function removeClient()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'removeClient');
            $this->db->where('id', $this->input->post('clientid'));
            $this->db->delete('client');
            $this->db->where('client_id', $this->input->post('clientid'));
            $this->db->delete('admin');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function editClient()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'editClient');
            $data = array(
                'client_name' => $this->input->post('clientname'),
                'client_address' => $this->input->post('clientaddress'),
                'client_email' => $this->input->post('clientemail'),
                'role' => $this->input->post('role'),
                'business_registration_number' => $this->input->post('business_registration_number'),
                'client_username' => $this->input->post('username'),
                'client_phone' => $this->input->post('clientphone')
            );
            $this->db->where('client_code', $this->input->post('clientcode'));
            $this->db->update('client', $data);

            $this->db->where('client_code', $this->input->post('clientcode'));
            $this->db->where('client_name', $this->input->post('clientname'));
            $this->db->where('client_email', $this->input->post('clientemail'));
            $this->db->where('client_phone', $this->input->post('clientphone'));
            $result = $this->db->get('client')->result();
            foreach ($result as $row) {
                $client_id = $row->id;
            }

            $clientname = explode(' ', $this->input->post('clientname'));

            if (count($clientname) == 1) {
                $clientname[1] = '';
            }
            $data = array(
                'mobilenumber' => $this->input->post('clientphone'),
                'firstname' => $clientname[0],
                'lastname' => $clientname[1],
                'emailid' => $this->input->post('clientemail'),
                'upt_no' => "+87810" . $this->input->post('clientphone'),
                'role' => $this->input->post('role'),
                'username' => $this->input->post('username')
            );
            $this->db->where('client_id', $client_id);
            $this->db->update('admin', $data);


            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function getMachineClients()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'Inside getMachineClients');
            $result = $this->db->get('client')->result();
            $arr_data = array();
            $i = 0;
            $arr_data[$i]['id'] = '-1';
            $arr_data[$i]['clientcode'] = '';
            $arr_data[$i]['clientname'] = '';
            $arr_data[$i]['business_registration_number'] = '';
            $arr_data[$i]['clientaddress'] = '';
            $arr_data[$i]['clientemail'] = '';
            $arr_data[$i]['clientphone'] = '';
            $arr_data[$i]['role'] = '';
            $arr_data[$i]['username'] = '';
            $i++;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['clientcode'] = $row->client_code;
                $arr_data[$i]['clientname'] = $row->client_name;
                $arr_data[$i]['business_registration_number'] = $row->business_registration_number;
                $arr_data[$i]['clientaddress'] = $row->client_address;
                $arr_data[$i]['clientemail'] = $row->client_email;
                $arr_data[$i]['clientphone'] = $row->client_phone;
                $arr_data[$i]['role'] = $row->role;
                $arr_data[$i]['username'] = $row->client_username;
                $i++;
            }
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function resetPassword()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $pass = password_hash($this->input->post('clientpassword'), PASSWORD_BCRYPT);
            $data = array(
                'client_password' => $pass
            );
            $this->db->where('id', $this->input->post('clientid'));
            $q = $this->db->get('client');
            if ($q->num_rows() > 0) {
                $this->db->where('id', $this->input->post('clientid'));
                $this->db->update('client', $data);
            }

            $data = array(
                'password' => $pass
            );
            $this->db->where('client_id', $this->input->post('clientid'));
            $q = $this->db->get('admin');
            if ($q->num_rows() > 0) {
                $this->db->where('client_id', $this->input->post('clientid'));
                $this->db->update('admin', $data);
            }
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function checkToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateTokenFromSession($headers['Authorization'],$headers['ClientId']);
                if ($token_response === TRUE) {
                    log_message('debug', "Check Token 1");
                    return TRUE;
                } else {
                    log_message('debug', "Check Token 2");
                    return FALSE;
                }
            } else {
                log_message('debug', "Check Token 3");
                return FALSE;
            }
        } else {
            log_message('debug', "Check Token 4");
            return FALSE;
        }
    }


    public function checkAdminToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateAdminTokenFromSession($headers['Authorization'],$headers['ClientId']);
                if ($token_response === TRUE) {
                    log_message('debug', "Check Token 1");
                    return TRUE;
                } else {
                    log_message('debug', "Check Token 2");
                    return FALSE;
                }
            } else {
                log_message('debug', "Check Token 3");
                return FALSE;
            }
        } else {
            log_message('debug', "Check Token 4");
            return FALSE;
        }
    }
}
