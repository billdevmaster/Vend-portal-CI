<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Employee_Transaction_Update extends REST_Controller
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

            $employee_transaction_list = $data->employee_transaction_list;
            foreach ($employee_transaction_list as $employee_transaction_element) {
                $employee_transaction['transaction_id'] = $employee_transaction_element->transaction_id;
                $employee_transaction['employee_id'] = $employee_transaction_element->employee_id;
                $employee_transaction['client_id'] = $employee_transaction_element->client_id;
                $employee_transaction['employee_full_name'] = $employee_transaction_element->employee_full_name;
                $employee_transaction['product_id'] = $employee_transaction_element->product_id;
                $employee_transaction['product_name'] = $employee_transaction_element->product_name;
                $employee_transaction['machine_id'] = $employee_transaction_element->machine_id;
                $employee_transaction['machine_name'] = $employee_transaction_element->machine_name;
                $employee_transaction['timestamp'] = $employee_transaction_element->timestamp;
                if(!empty($employee_transaction_element->job_number)){
                    $employee_transaction['job_number'] = $employee_transaction_element->job_number;
                }
                if(!empty($employee_transaction_element->cost_center)){
                    $employee_transaction['cost_center'] = $employee_transaction_element->cost_center;
                }

                $this->db->insert('employee_transaction', $employee_transaction);
            }

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
