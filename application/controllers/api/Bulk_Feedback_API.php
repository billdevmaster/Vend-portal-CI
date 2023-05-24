<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Feedback_API extends REST_Controller
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
            $feedback_response[] = [];
            $feedback_list = $data->feedback_list;
            foreach ($feedback_list as $feedback_element) {
                $feedback['transaction_id'] = $feedback_element->transaction_id;
                $feedback['client_id'] = $feedback_element->client_id;
                $feedback['machine_id'] = $feedback_element->machine_id;
                $feedback['product_id'] = $feedback_element->product_id;
                $feedback['product_name'] = $feedback_element->product_name;
                $feedback['customer_name'] = $feedback_element->customer_name;
                $feedback['customer_phone'] = $feedback_element->customer_phone;
                $feedback['customer_email'] = $feedback_element->customer_email;
                $feedback['complaint'] = $feedback_element->complaint;
                $feedback['complaint_type'] = $feedback_element->complaint_type;
                $feedback['feedback'] = $feedback_element->feedback;
                $this->db->insert('feedback', $feedback);

                $this->db->where('transaction_id', $feedback_element->transaction_id);
                $feedback_db_response = $this->db->get('feedback')->result();

                foreach ($feedback_db_response as $row) {
                    $feedback_response_element = $row;
                }
                $feedback_response[$i] = $feedback_response_element;
                $i++;
            }

            $this->response(array('status' => 'success', 'feedback' => $feedback_response), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
