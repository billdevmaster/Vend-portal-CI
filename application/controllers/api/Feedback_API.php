<?php

require APPPATH . '/libraries/REST_Controller.php';

class Feedback_API extends REST_Controller
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

            $feedback['transaction_id'] = $data->transaction_id;
            $feedback['client_id'] = $data->client_id;
            $feedback['machine_id'] = $data->machine_id;
            $feedback['product_id'] = $data->product_id;
            $feedback['product_name'] = $data->product_name;
            $feedback['customer_name'] = $data->customer_name;
            $feedback['customer_phone'] = $data->customer_phone;
            $feedback['customer_email'] = $data->customer_email;
            $feedback['complaint'] = $data->complaint;
            $feedback['complaint_type'] = $data->complaint_type;
            $feedback['feedback'] = $data->feedback;
            $this->db->insert('feedback', $feedback);

            $this->db->where('transaction_id', $data->transaction_id);
            $feedback_response = $this->db->get('feedback')->result();

            $i = 0;
            foreach ($feedback_response as $row) {
                $feedback_id = $row->feedback_id;
                $i++;
            }

            $this->response(array('status' => 'success', 'feedback_id' => $feedback_id), 200);
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    function index_put()
    { }


    function index_delete()
    { }

}
