<?php

require APPPATH . '/libraries/REST_Controller.php';

class Machine_Live_Status_API_Controller extends REST_Controller
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

            $live_status['machine_id'] = $data->machine_id;
            $live_status['machine_name'] = $data->machine_name;
            $live_status['user_name'] = $data->user_name;
            $live_status['imei_number'] = $data->imei_number;
            $live_status['ip_address'] = $data->ip_address;
            $this->db->insert('machine_live_status', $live_status);

            $this->response(array('status' => 'success'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
