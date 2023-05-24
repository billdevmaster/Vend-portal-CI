<?php

require APPPATH . '/libraries/REST_Controller.php';

class Log_API extends REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
        $this->load->library('email');
    }

    public function index_get()
    {}

    public function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $data = json_decode(file_get_contents('php://input'));

            $machine_log['machine_id'] = $data->machine_id;

            $date = date('YmdHis');
            $file_string = $data->file_string;
            $file_base64 = base64_decode($file_string);
            $file_name = 'ngapp/assets/logs/' . $data->machine_id . '_' . $date . '.zip';
            file_put_contents($file_name, $file_base64);
            @chmod($file_name, 0777);
            $machine_log['file_url'] = $file_name;
            $this->db->insert('machine_log', $machine_log);

            $machineName = '';
            $this->db->where('id', $data->machine_id);
            $machineList = $this->db->get('machine')->result();
            foreach ($machineList as $machine) {
                $machineName = $machine->machine_name;
            }

            $this->sendMail($file_name, $machineName);

            $this->response(array('status' => 'success'), 200);

        } else {
            $arr = array('code' => 401, 'msg' => "Authentication Failed");
            header('Content-type:application/json');
            $this->response($arr, 401);
        }
    }

    public function sendMail($fileUrl, $machineName)
    {
        $config = array();
        $config['protocol'] = 'mail';
        // $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
        $config['smtp_host'] = 'mail.visualvend.com';
        $config['smtp_user'] = 'noreply@visualvend.com';
        $config['smtp_pass'] = 'V15ualV3nd';
        $config['mailtype'] = 'html';
        $config['smtp_port'] = 465;

        $this->email->clear(true);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->to("info@cc2go.com.au,learndroid53@gmail.com,huzefar52@gmail.com");
        $this->email->from("noreply@visualvend.com");
        $this->email->subject("Debug Log File | " . $machineName);
        $this->email->message("PFA the Debug Log File");
        //$this->email->attach($fileUrl);
        $this->email->send();
    }

    public function index_put()
    {}

    public function index_delete()
    {}
}
