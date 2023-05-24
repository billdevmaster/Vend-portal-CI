<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Sale_Report_API extends REST_Controller
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

            $sale_report_list = $data->sale_report_list;
            foreach ($sale_report_list as $sale_report_element) {
                $sale_report['transaction_id'] = $sale_report_element->transaction_id;
                $sale_report['product_id'] = $sale_report_element->product_id;
                $sale_report['product_name'] = $sale_report_element->product_name;
                $sale_report['product_price'] = $sale_report_element->product_price;
                $sale_report['machine_id'] = $sale_report_element->machine_id;
                $sale_report['machine_name'] = $sale_report_element->machine_name;
                $sale_report['client_id'] = $sale_report_element->client_id;
                $sale_report['timestamp'] = $sale_report_element->timestamp;
                if (isset($sale_report_element->transaction_status)) {
                    $sale_report['transaction_status'] = $sale_report_element->transaction_status;
                }
                $this->db->insert('sale_report', $sale_report);
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
