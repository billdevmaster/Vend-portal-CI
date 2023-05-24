<?php

require APPPATH . '/libraries/REST_Controller.php';

class Non_Functional_Location extends REST_Controller
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

            $nonFunctionalLocation['defect_id'] = $data->defect_id;
            $nonFunctionalLocation['machine_id'] = $data->machine_id;
            $nonFunctionalLocation['machine_name'] = $data->machine_name;
            $nonFunctionalLocation['product_name'] = $data->product_name;
            $nonFunctionalLocation['defective_location'] = $data->defective_location;
            $nonFunctionalLocation['error_code'] = $data->error_code;
            $nonFunctionalLocation['status'] = 'Set';
            $nonFunctionalLocation['timestamp'] = $data->timestamp;
            $this->db->insert('location_non_functional', $nonFunctionalLocation);


            $this->db->where('defect_id', $data->defect_id);
            $location_non_functional_response = $this->db->get('location_non_functional')->result();

            $i = 0;
            foreach ($location_non_functional_response as $row) {
                $defect_id = $row->defect_id;
                $i++;
            }


            $this->response(array('status' => 'success', 'defect_id' => $defect_id), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
