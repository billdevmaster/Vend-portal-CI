<?php

require APPPATH . '/libraries/REST_Controller.php';

class Employee_Product_Quantity_Restriction extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
    }

    function index_get()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $employee_product_quantity_restriction = $this->db->get('employee_product_quantity_restriction')->result();
            $this->response(array('status' => 'success', 'employee_product_quantity_restriction' => $employee_product_quantity_restriction), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $employee_product_quantity_restriction = $this->db->get('employee_product_quantity_restriction')->result();
            $this->response(array('status' => 'success', 'employee_product_quantity_restriction' => $employee_product_quantity_restriction), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }
}
