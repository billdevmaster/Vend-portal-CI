<?php

require APPPATH . '/libraries/REST_Controller.php';

class Product_Restriction_API_Controller extends REST_Controller
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
            $this->db->where('client_id',  $this->input->post('client_id'));
            $total_quantity_restriction = $this->db->get('total_quantity_restriction')->result();

            $this->response(array('status' => 'success', 'total_quantity_restriction' => $total_quantity_restriction), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }
}
