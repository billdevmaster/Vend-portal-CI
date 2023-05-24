<?php

require APPPATH . '/libraries/REST_Controller.php';

class Feed_API extends REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
    }

    public function index_get()
    {}

    public function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $data = json_decode(file_get_contents('php://input'));

            $feed['client_id'] = $data->client_id;
            $feed['machine_id'] = $data->machine_id;
            $feed['feed'] = $data->feed;
            if (isset($data->created_on)) {
                $feed['created_on'] = $data->created_on;
            }

            if (isset($data->transaction_status)) {
                $feed['transaction_status'] = $data->transaction_status;
            }
            $this->db->insert('feed', $feed);

            $this->response(array('status' => 'success'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    public function index_put()
    {}

    public function index_delete()
    {}
}
