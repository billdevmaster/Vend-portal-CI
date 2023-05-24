<?php

require APPPATH . '/libraries/REST_Controller.php';

class Gift_Vend_API extends REST_Controller
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

            $gift_report['transaction_id'] = $data->transaction_id;
            $gift_report['product_id'] = $data->product_id;
            $gift_report['product_name'] = $data->product_name;
            $gift_report['product_price'] = $data->product_price;
            $gift_report['name'] = $data->name;
            $gift_report['last_name'] = $data->last_name;
            $gift_report['email'] = $data->email;
            $gift_report['mobile'] = $data->mobile;
            $gift_report['client_id'] = $data->client_id;
            $gift_report['machine_id'] = $data->machine_id;
            $gift_report['timestamp'] = $data->timestamp;
            $gift_report['concern'] = $data->concern;
            $this->db->insert('gift_report', $gift_report);

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
