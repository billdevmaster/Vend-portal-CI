<?php
class User_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }
    public function registerUser()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside registerUser');
            $this->User_model->createUser();
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function validateToken()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $token_response = $this->authorization_token->validateTokenFromSession($this->session->userdata('token'));
            $arr_data['valid_token'] = $token_response;
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function authenticateUser()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $user = array(
                'mobilenumber' => $this->input->post('mobilenumber'),
                'password' => $this->input->post('password')
            );

            if ($this->User_model->isUserAuthenticated($user)) {
                $arr = array('code' => 200, 'msg' => "OK");
            } else {
                $arr = array('code' => 500, 'msg' => "Authentication failed");
            }
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function authenticateAdmin()
    {
        $user = array(
            'mobilenumber' => $this->input->post('mobilenumber'),
            'password' => $this->input->post('password')
        );

        $usernameQuery = array(
            'username' => $this->input->post('mobilenumber'),
            'password' => $this->input->post('password')
        );

        if ($this->User_model->isAdminAuthenticated($user) || $this->User_model->isAdminUsernameAuthenticated($usernameQuery)) {


            $data = array(
                'mobilenumber' => $this->session->userdata('mobilenumber'),
                'upt_no' => $this->session->userdata('upt_no'),
                'terms_and_condition_accepted' => true,
                'ip_address' => $this->input->ip_address()
            );
            $this->db->insert('admin_log', $data);
            $this->db->where('mobilenumber', $this->session->userdata('mobilenumber'));
            $result = $this->db->get('admin')->result();
            $role = "";
            $isActivated = false;
            foreach ($result as $row) {
                $role = $row->role;
                $clientId = $row->client_id;
                $isActivated = $row->is_activated;
            }


            $token_data['username'] = $this->session->userdata('mobilenumber');
            $token_data['client_id'] = $clientId;
            $token_data['time'] = time();
            $user_token = $this->authorization_token->generateToken($token_data);
            log_message('debug', "User Token : " . $user_token);
            $this->session->set_userdata('token', $user_token);
            //$token_response = $this->authorization_token->validateTokenFromSession($this->session->userdata('token'));
            //log_message('debug',"User Token : ".$token_response);
            $auth_token = array(
                'mobile_number' => $this->session->userdata('mobilenumber'),
                'client_id' => $clientId,
                'token_type' => 'WEB',
                'token' => $user_token
            );
            $this->db->insert('auth_token', $auth_token);

            if ($isActivated) {
                $arr = array('code' => 200, 'msg' => "OK", 'role' => $role, 'client_id' => $clientId, 'token' => $user_token);
                header('Content-type:application/json');
                echo json_encode($arr);
            } else {
                $arr = array('code' => 401, 'msg' => "Your Account is not Activated. Please reach out to support for more information");
                header('Content-type:application/json');
                echo json_encode($arr);
            }
        } else {
            $arr = array('code' => 500, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
        exit;
    }

    public function checkUserExistence()
    {
        log_message('debug', 'checkUserExistence');
        $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            $arr_data['isPresent'] = 'mobile';
            echo json_encode($arr_data);
        } else {
            $this->db->where('emailid', $this->input->post('emailid'));
            $query = $this->db->get('user');
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'email';
                echo json_encode($arr_data);
            } else {
                $this->db->where('username', $this->input->post('username'));
                $query = $this->db->get('user');
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

    public function checkUserNameExistence()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'checkUserNameExistence');

            $this->db->where('username', $this->input->post('username'));
            $query = $this->db->get('user');
            $arr_data['isPresent'] = '';
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'username';
            } else {
                $arr_data['isPresent'] = 'false';
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


    public function checkExistence()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', $this->input->post('mobilenumber'));
            log_message('debug', $this->input->post('oldmobilenumber'));
            log_message('debug', 'checkExistence');
            $arr_data['isPresent'] = '';
            $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
            $query = $this->db->get('user');
            if ($query->num_rows() > 0 && $this->input->post('mobilenumber') != $this->input->post('oldmobilenumber')) {
                $arr_data['isPresent'] = 'mobile';
            } else {
                $this->db->where('emailid', $this->input->post('emailid'));
                $query = $this->db->get('user');
                if ($query->num_rows() > 0 &&  $this->input->post('emailid') != $this->input->post('oldemailid')) {
                    $arr_data['isPresent'] = 'email';
                } else {
                    $arr_data['isPresent'] = 'false';
                }
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

    function getUserData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'Inside User Controller getUserData');
            $this->db->where('is_deactivated', '0');
            $result = $this->db->get('user')->result();
            $result_transaction = $this->db->get('user_transaction_details')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['card_no'] = $row->mobilenumber;
                $arr_data[$i]['firstname'] = $row->firstname;
                $arr_data[$i]['lastname'] = $row->lastname;
                $arr_data[$i]['emailid'] = $row->emailid;
                $arr_data[$i]['mobilenumber'] = $row->mobilenumber;
                $arr_data[$i]['upt_no'] = $row->upt_no;
                $arr_data[$i]['activated_on'] = $row->activated_on;
                $arr_data[$i]['last_updated'] = $row->last_updated;
                $arr_data[$i]['account_balance'] = '0.00';
                foreach ($result_transaction as $row_transaction) {
                    if ($row->upt_no == $row_transaction->upt_no) {
                        $arr_data[$i]['account_balance'] = $row_transaction->account_balance;
                    }
                }
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

    function getData()
    {
        log_message('debug', 'Inside User Controller getData');
        $this->db->where('upt_no', $this->session->userdata('upt_no'));
        $result = $this->db->get('admin')->result();
        $arr_data=null;
        foreach ($result as $row) {
            $arr_data['mobilenumber'] = $row->mobilenumber;
            $arr_data['firstname'] = $row->firstname;
            $arr_data['lastname'] = $row->lastname;
            $arr_data['emailid'] = $row->emailid;
            $arr_data['upt_no'] = $row->upt_no;
        }
        echo json_encode($arr_data);
    }

    function getAccountBalance()
    {
        log_message('debug', 'Inside User Controller getAccountBalance');
        $this->db->where('upt_no', $this->session->userdata('upt_no'));
        $result = $this->db->get('user_transaction_details')->result();
        $arr_data=null;
        foreach ($result as $row) {
            $arr_data['account_balance'] = $row->account_balance;
        }
        echo json_encode($arr_data);
    }

    function updateData()
    {
        $data = array(
            'mobilenumber' => $this->input->post('mobilenumber'),
            'emailid' => $this->input->post('emailid'),
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname')
        );
        $this->db->where('upt_no', $this->input->post('upt_no'));
        $q = $this->db->get('admin');
        if ($q->num_rows() > 0) {
            $this->db->where('upt_no', $this->input->post('upt_no'));
            $this->db->update('admin', $data);
        }
    }

    function resetPassword()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data = array(
                'password' => $pass
            );
            $this->db->where('username', $this->input->post('username'));
            $q = $this->db->get('user');
            if ($q->num_rows() > 0) {
                $this->db->where('username', $this->input->post('username'));
                $this->db->update('user', $data);
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


    function updateUserData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $data = array(
                'mobilenumber' => $this->input->post('mobilenumber'),
                'emailid' => $this->input->post('emailid'),
                'activated_on' => $this->input->post('activated_on'),
                'last_updated' => $this->input->post('last_updated'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname')
            );
            $this->db->where('upt_no', $this->session->userdata('user_upt_no'));
            $q = $this->db->get('user');
            if ($q->num_rows() > 0) {
                $this->db->where('upt_no', $this->session->userdata('user_upt_no'));
                $this->db->update('user', $data);
            }

            $data_transaction = array(
                'account_balance' => $this->input->post('account_balance')
            );
            $this->db->where('upt_no', $this->session->userdata('user_upt_no'));
            $q = $this->db->get('user_transaction_details');
            if ($q->num_rows() > 0) {
                $this->db->where('upt_no', $this->session->userdata('user_upt_no'));
                $this->db->update('user_transaction_details', $data_transaction);
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


    function deactivateUser()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside User Controller deactivateUser');
            $data = array(
                'is_deactivated' => '1'
            );
            $this->db->where('upt_no', $this->session->userdata('user_upt_no'));
            $q = $this->db->get('user');
            if ($q->num_rows() > 0) {
                $this->db->where('upt_no', $this->session->userdata('user_upt_no'));
                $this->db->update('user', $data);
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

    function getAllUserName()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('status', '0');
            $result = $this->db->get('user')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['username'] = $row->username;
                $arr_data[$i]['upt_no'] = $row->upt_no;
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

    function getAllUserNameByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            $this->db->where('status', '0');
            $this->db->where('client_id', $this->input->post('client_id'));
            $result = $this->db->get('user')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['username'] = $row->username;
                $arr_data[$i]['upt_no'] = $row->upt_no;
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

    function getUserList()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'Inside User Controller getUserList');
            $this->db->where('status !=', '-1');
            $result = $this->db->get('user')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['firstname'] = $row->firstname;
                $arr_data[$i]['lastname'] = $row->lastname;
                $arr_data[$i]['emailid'] = $row->emailid;
                $arr_data[$i]['mobilenumber'] = $row->mobilenumber;
                $arr_data[$i]['username'] = $row->username;
                $arr_data[$i]['upt_no'] = $row->upt_no;
                $arr_data[$i]['activated_on'] = $row->activated_on;
                $arr_data[$i]['last_updated'] = $row->last_updated;
                $arr_data[$i]['status'] = $row->status;
                $arr_data[$i]['is_deactivated'] = $row->is_deactivated;
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

    function getUserListByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            log_message('debug', 'Inside User Controller getUserList');
            $this->db->where('status !=', '-1');
            $this->db->where('client_id', $this->input->post('client_id'));
            $result = $this->db->get('user')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['firstname'] = $row->firstname;
                $arr_data[$i]['lastname'] = $row->lastname;
                $arr_data[$i]['emailid'] = $row->emailid;
                $arr_data[$i]['mobilenumber'] = $row->mobilenumber;
                $arr_data[$i]['username'] = $row->username;
                $arr_data[$i]['upt_no'] = $row->upt_no;
                $arr_data[$i]['activated_on'] = $row->activated_on;
                $arr_data[$i]['last_updated'] = $row->last_updated;
                $arr_data[$i]['status'] = $row->status;
                $arr_data[$i]['is_deactivated'] = $row->is_deactivated;
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

    function deactivateUserByMobileNumber()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside User Controller deactivateUser');
            $data = array(
                'is_deactivated' => '1'
            );
            $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
            $q = $this->db->get('user');
            if ($q->num_rows() > 0) {
                $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
                $this->db->update('user', $data);
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

    function activateUserByMobileNumber()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside User Controller activateUser');
            $data = array(
                'is_deactivated' => '0'
            );
            $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
            $q = $this->db->get('user');
            if ($q->num_rows() > 0) {
                $this->db->where('mobilenumber', $this->input->post('mobilenumber'));
                $this->db->update('user', $data);
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
