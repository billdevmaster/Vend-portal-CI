<?php
class Signup_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('email');
    }

    public function uploadUser()
    {
        log_message('debug', 'Inside uploadUser');
        log_message('debug', $this->input->post('mobilenumber'));
        $pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        log_message('debug', $pass);
        $data = array(
            'client_id' => $this->input->post('client_id'),
            'mobilenumber' => $this->input->post('mobilenumber'),
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'username' => $this->input->post('username'),
            'emailid' => $this->input->post('emailid'),
            'password' => $pass,
            'upt_no' => "+87810" . $this->input->post('mobilenumber')
        );
        $this->User_model->createUser($data);


        $this->db->where('id', $this->input->post('client_id'));
        $query = $this->db->get('client');
        $result = $query->result();
        foreach ($result as $row) {
            $data['title'] = "Machine Login Request";
            $data['body'] = "Please approve the Machine Login request for the below mentioned Client.";
            $data['client_name'] = $row->client_name;
            $data['client_address'] = $row->client_address;
            $data['client_mobile_number'] =  substr($row->client_phone, 0, 4) . ' ' . substr($row->client_phone, 4, 3) . ' ' . substr($row->client_phone, 7);
            $data['client_email'] = $row->client_email;
            $data['business_registration_number'] = $row->business_registration_number;
            $this->sendMailToAdmin($data);
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

    public function uploadAdmin()
    {
        log_message('debug', 'Inside uploadAdmin');
        $pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        log_message('debug', $pass);
        log_message('debug', 'insertClient');
        $data = array(
            'client_code' => $this->input->post('code'),
            'client_name' => $this->input->post('firstname') . ' ' . $this->input->post('lastname'),
            'client_address' => $this->input->post('address'),
            'client_email' => $this->input->post('emailid'),
            'client_phone' => $this->input->post('mobilenumber'),
            'role' => $this->input->post('role'),
            'business_registration_number' => $this->input->post('business_registration_number'),
            'client_username' => $this->input->post('username'),
            'client_password' => $pass,
            'created_by' => 'Self Sign Up'
        );
        $this->db->insert('client', $data);

        $this->db->where('client_name', $this->input->post('firstname') . ' ' . $this->input->post('lastname'));
        $this->db->where('client_email', $this->input->post('emailid'));
        $this->db->where('client_phone', $this->input->post('mobilenumber'));
        $result = $this->db->get('client')->result();
        foreach ($result as $row) {
            $client_id = $row->id;
        }

        $data = array(
            'mobilenumber' => $this->input->post('mobilenumber'),
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'role' => $this->input->post('role'),
            'organization' => $this->input->post('organisation'),
            'emailid' => $this->input->post('emailid'),
            'password' => $pass,
            'client_id' => $client_id,
            'username' => $this->input->post('username'),
            'upt_no' => "+87810" . $this->input->post('mobilenumber')
        );
        $this->db->insert('admin', $data);

        $this->db->where('id', $client_id);
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

    }


    public function checkExistence()
    {
        log_message('debug', 'checkExistence');
        $arr_data['isPresent'] = 'false';
        $this->db->where('client_phone', $this->input->post('mobilenumber'));
        $query = $this->db->get('client');
        if ($query->num_rows() > 0) {
            $arr_data['isPresent'] = 'mobile';
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr_data);
        } else {
            $this->db->where('client_email', $this->input->post('emailid'));
            $query = $this->db->get('client');
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'email';
                $arr = array('code' => 200, 'data' => $arr_data);
                header('Content-type:application/json');
                echo json_encode($arr_data);
            } else {

                $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
                $query = $this->db->get('admin');
                if ($query->num_rows() > 0) {
                    $arr_data['isPresent'] = 'mobile';
                    $arr = array('code' => 200, 'data' => $arr_data);
                    header('Content-type:application/json');
                    echo json_encode($arr_data);
                } else {
                    $this->db->where('emailid', $this->input->post('emailid'));
                    $query = $this->db->get('admin');
                    if ($query->num_rows() > 0) {
                        $arr_data['isPresent'] = 'email';
                        $arr = array('code' => 200, 'data' => $arr_data);
                        header('Content-type:application/json');
                        echo json_encode($arr_data);
                    } else {
                        $this->db->where('client_code', $this->input->post('code'));
                        $query = $this->db->get('client');
                        if ($query->num_rows() > 0) {
                            $arr_data['isPresent'] = 'code';
                            $arr = array('code' => 200, 'data' => $arr_data);
                            header('Content-type:application/json');
                            echo json_encode($arr_data);
                        } else {
                            $this->db->where('client_username', $this->input->post('username'));
                            $query = $this->db->get('client');
                            if ($query->num_rows() > 0) {
                                $arr_data['isPresent'] = 'username';
                                $arr = array('code' => 200, 'data' => $arr_data);
                                header('Content-type:application/json');
                                echo json_encode($arr_data);
                            } else {
                                $this->db->where('username', $this->input->post('username'));
                                $query = $this->db->get('admin');
                                if ($query->num_rows() > 0) {
                                    $arr_data['isPresent'] = 'username';
                                    $arr = array('code' => 200, 'data' => $arr_data);
                                    header('Content-type:application/json');
                                    echo json_encode($arr_data);
                                } else {
                                    $arr = array('code' => 200, 'data' => $arr_data);
                                    header('Content-type:application/json');
                                    echo json_encode($arr_data);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function checkAdminExistence()
    {

        $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
        $query = $this->db->get('admin');
        if ($query->num_rows() > 0) {
            $arr_data['isPresent'] = 'mobile';
            echo json_encode($arr_data);
        } else {
            $this->db->where('emailid', $this->input->post('emailid'));
            $query = $this->db->get('admin');
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'email';
                echo json_encode($arr_data);
            } else {
                $this->db->where('username', $this->input->post('username'));
                $query = $this->db->get('admin');
                if ($query->num_rows() > 0) {
                    $arr_data['isPresent'] = 'username';
                    echo json_encode($arr_data);
                } else {
                    $arr_data['isPresent'] = 'false';
                    echo json_encode($arr_data);
                }
            }
        }
    }
}
