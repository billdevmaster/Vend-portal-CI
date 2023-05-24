<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Gift_Vend_API extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
    }

    function index_get()
    {
    }

    function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $data = json_decode(file_get_contents('php://input'));

            $gift_report_list = $data->gift_report_list;
            foreach ($gift_report_list as $gift_report_element) {
                $gift_report['transaction_id'] = $gift_report_element->transaction_id;
                $gift_report['product_id'] = $gift_report_element->product_id;
                $gift_report['product_name'] = $gift_report_element->product_name;
                $gift_report['product_price'] = $gift_report_element->product_price;
                $gift_report['name'] = $gift_report_element->name;
                $gift_report['email'] = $gift_report_element->email;
                $gift_report['mobile'] = $gift_report_element->mobile;
                $gift_report['client_id'] = $gift_report_element->client_id;
                $gift_report['machine_id'] = $gift_report_element->machine_id;
                $gift_report['timestamp'] = $gift_report_element->timestamp;
                $this->db->insert('gift_report', $gift_report);
            }

            $this->response(array('status' => 'success'), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    {
    }


    function index_delete()
    {
    }
}
