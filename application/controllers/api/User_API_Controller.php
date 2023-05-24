<?php

require APPPATH . '/libraries/REST_Controller.php';

class User_API_Controller extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
    }

    function index_get()
    { }

    function index_post()
    {
        $login_key = $this->input->post('login_key');
        $password = $this->input->post('password');
        $imei_number = $this->input->post('imei_number');

        if ($login_key[0] == '+') {
            log_message('debug', 'Upt Entered');
            $this->db->where('upt_no', $login_key);
        } else {
            log_message('debug', 'Username Entered');
            $this->db->where('username', $login_key);
        }
        $login = $this->db->get('user')->result();
        if ($login) {
            $arr_data = array();
            $i = 0;
            $user_name = "";
            $upt_no = "";
            $pas = "";
            $client_id = "";
            foreach ($login as $row) {
                $user_name = $row->username;
                $upt_no = $row->upt_no;
                $pas = $row->password;
                $client_id = $row->client_id;
                $i++;
            }
            if (password_verify($password, $pas)) {

                $token_data['username'] = $user_name;
                $token_data['time'] = time();
                $token_data['client_id'] = $client_id;
                $user_token = $this->authorization_token_device->generateToken($token_data);
                log_message('debug', "User Token : " . $user_token);
                $auth_token = array(
                    'mobile_number' => $user_name,
                    'client_id' => $client_id,
                    'token_type' => 'MOBILE',
                    'token' => $user_token
                );
                $update = $this->db->insert('auth_token', $auth_token);

                if ($update) {
                    $this->db->where('username', $user_name);
                    $this->db->where('upt_no', $upt_no);
                    $this->db->where('terms_and_condition_accepted', $this->input->post('terms_and_condition'));
                    $data = array(
                        'username' => $user_name,
                        'upt_no' => $upt_no,
                        'terms_and_condition_accepted' => $this->input->post('terms_and_condition') === 'true',
                        'ip_address' => $this->input->ip_address(),
                        'device_imei_number' => $imei_number
                    );
                    $this->db->insert('login_log', $data);

                    $this->db->where('machine_username', $user_name);
                    $machine_details = $this->db->get('machine')->result();

                    $this->response(array('status' => 'success', 'id_token' => $user_token, 'machine_details' => $machine_details), 200);
                } else {

                    $this->response(array('status' => 'fail', 'message' => 'Token Updation Failed'), 200);
                }
            } else {

                $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 200);
            }
        } else {

            $this->response(array('status' => 'fail', 'message' => 'No such User Found'), 200);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }
}
