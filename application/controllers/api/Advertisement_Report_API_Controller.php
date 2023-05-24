<?php

require APPPATH . '/libraries/REST_Controller.php';

class Advertisement_Report_API_Controller extends REST_Controller
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

            $advertisement_report['advertisement_id'] = $data->advertisement_id;
            $advertisement_report['advertisement_name'] = $data->advertisement_name;
            $advertisement_report['client_id'] = $data->client_id;
            $advertisement_report['machine_id'] = $data->machine_id;
            $advertisement_report['machine_name'] = $data->machine_name;
            $advertisement_report['advertisement_position'] = $data->advertisement_position;
            $advertisement_report['advertisement_screen'] = $data->advertisement_screen;
            $advertisement_report['timestamp'] = $data->timestamp;
            $this->db->insert('advertisement_report', $advertisement_report);

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
