<?php

require APPPATH . '/libraries/REST_Controller.php';

class Employee_Transaction_Update extends REST_Controller
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

            $employee_transaction['transaction_id'] = $data->transaction_id;
            $employee_transaction['employee_id'] = $data->employee_id;
            $employee_transaction['client_id'] = $data->client_id;
            $employee_transaction['employee_full_name'] = $data->employee_full_name;
            $employee_transaction['product_id'] = $data->product_id;
            $employee_transaction['product_name'] = $data->product_name;
            $employee_transaction['machine_id'] = $data->machine_id;
            $employee_transaction['machine_name'] = $data->machine_name;
            $employee_transaction['timestamp'] = $data->timestamp;
            if(!empty($data->job_number)){
                $employee_transaction['job_number'] = $data->job_number;
            }
            if(!empty($data->cost_center)){
                $employee_transaction['cost_center'] = $data->cost_center;
            }
            $this->db->insert('employee_transaction', $employee_transaction);

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
