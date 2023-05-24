<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Non_Functional_Location extends REST_Controller
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
            $i = 0;
            $location_non_functional_response[] = [];
            $location_non_functional_list = $data->location_non_functional;
            foreach ($location_non_functional_list as $location_non_functional_element) {
                $nonFunctionalLocation['defect_id'] = $location_non_functional_element->defect_id;
                $nonFunctionalLocation['machine_id'] = $location_non_functional_element->machine_id;
                $nonFunctionalLocation['machine_name'] = $location_non_functional_element->machine_name;
                $nonFunctionalLocation['product_name'] = $location_non_functional_element->product_name;
                $nonFunctionalLocation['defective_location'] = $location_non_functional_element->defective_location;
                $nonFunctionalLocation['error_code'] = $location_non_functional_element->error_code;
                $nonFunctionalLocation['status'] = 'Set';
                $nonFunctionalLocation['timestamp'] = $location_non_functional_element->timestamp;
                $this->db->insert('location_non_functional', $nonFunctionalLocation);

                $this->db->where('defect_id', $location_non_functional_element->defect_id);
                $location_non_functional_db_response = $this->db->get('location_non_functional')->result();

                foreach ($location_non_functional_db_response as $row) {
                    $location_non_functional_response_element = $row;
                }
                $location_non_functional_response[$i] = $location_non_functional_response_element;
                $i++;
            }
            $this->response(array('status' => 'success', 'location_non_functional_response' => $location_non_functional_response), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}