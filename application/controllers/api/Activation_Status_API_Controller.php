<?php

require APPPATH . '/libraries/REST_Controller.php';

class Activation_Status_API_Controller extends REST_Controller
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
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $data = json_decode(file_get_contents('php://input'));
            $isActivated = false;
            $this->db->where('username', $data->user_name);
            $user = $this->db->get('user')->result();
            foreach ($user as $row1) {
                if ($row1->is_deactivated) {
                    $isActivated = false;
                } else {
                    $isActivated = true;
                    $this->db->where('machine_username', $data->user_name);
                    $this->db->where('id', $data->machine_id);
                    $machine = $this->db->get('machine');
                    if ($machine->num_rows() === 0) {
                        $isActivated = false;
                    }
                }
            }

            $activation_status['machine_id'] = $data->machine_id;
            $activation_status['machine_name'] = $data->machine_name;
            $activation_status['user_name'] = $data->user_name;
            $activation_status['imei_number'] = $data->imei_number;
            $activation_status['wifi_mac'] = $data->wifi_mac;
            $activation_status['ip_address'] = $data->ip_address;
            $activation_status['is_activated'] = $isActivated;
            $this->db->insert('activation_status', $activation_status);

            $this->response(array('status' => 'success', 'is_activated' => $isActivated), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
