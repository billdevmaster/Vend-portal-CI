<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Feed_API extends REST_Controller
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

            $feed_list = $data->feed_list;
            foreach ($feed_list as $feed_element) {
                $feed['client_id'] = $feed_element->client_id;
                $feed['machine_id'] = $feed_element->machine_id;
                $feed['feed'] = $feed_element->feed;
                if (isset($feed_element->created_on)) {
                    $feed['created_on'] = $feed_element->created_on;
                }
                if (isset($feed_element->transaction_status)) {
                    $feed['transaction_status'] = $feed_element->transaction_status;
                }
                $this->db->insert('feed', $feed);
            }

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
