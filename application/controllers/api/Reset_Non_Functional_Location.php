<?php

require APPPATH . '/libraries/REST_Controller.php';

class Reset_Non_Functional_Location extends REST_Controller
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
            $updateData = array('status' => 'Reset');

            $this->db->where('defect_id', $data->defect_id);
            $q = $this->db->get('location_non_functional');
            if ($q->num_rows() > 0) {
                $this->db->where('defect_id', $data->defect_id);
                $this->db->update('location_non_functional', $updateData);
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
