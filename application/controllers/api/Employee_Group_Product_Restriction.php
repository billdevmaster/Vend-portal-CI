<?php

require APPPATH . '/libraries/REST_Controller.php';

class Employee_Group_Product_Restriction extends REST_Controller
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
            $employee_group_product_restriction = $this->db->get('employee_group_product_restriction')->result();
            $this->response(array('status' => 'success', 'employee_group_product_restriction' => $employee_group_product_restriction), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $employee_group_product_restriction = $this->db->get('employee_group_product_restriction')->result();
            $this->response(array('status' => 'success', 'employee_group_product_restriction' => $employee_group_product_restriction), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
