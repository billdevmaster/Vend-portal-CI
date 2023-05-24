<?php

require APPPATH . '/libraries/REST_Controller.php';

class Advertisement_Image_API_Controller extends REST_Controller
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
            $this->db->where('machine_id', $this->input->post('machine_id'));
            $advertisement_image = $this->db->get('advertisement_image')->result();
            $this->response(array('status' => 'success', 'advertisement_image' => $advertisement_image), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
