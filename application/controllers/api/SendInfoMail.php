<?php

require APPPATH . '/libraries/REST_Controller.php';

class SendInfoMail extends REST_Controller
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
      if ($this->check_assign_machine($this->input->post('ads_machine_id'), $this->input->post('machine_token'))) {
        $config = array(
          'protocol' => 'smtp',

          'smtp_host' => 'ssl://smtp.googlemail.com',
          'smtp_port' => '465',
          'smtp_user' => 'baitngotest@gmail.com', // change it to yours
          'smtp_pass' => 'cc2go@123', // change it to yours
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
        );

        $message = nl2br("
    
              Dear " . $this->input->post('name') . ",
              \r\n
              We have received your request and will get in touch with you soon.
              \r\n
              With regards,
              Support Team | CC2Go
              \r\n
              ");

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('baitngotest@gmail.com');  // change it to yours
        $this->email->to($this->input->post('email')); // change it to yours
        $this->email->subject('Request Submitted Successfully');
        $this->email->message($message);
        if ($this->email->send())
          log_message('debug', "Email Send Successfully.");
        else
          log_message('debug', "You have encountered an error");
        $this->response(array('status' => 'success'), 200);
      } else {
        $this->response(array('status' => 'fail', 'message' => 'Machine Check Failed'), 200);
      }
    } else {

      $this->response(array('status' => 'fail', 'message' => 'No such User Found'), 200);
    }
  }

  function check_assign_machine($machine_id, $machine_token)
  {
    $this->db->where('id', $machine_id);
    $this->db->where('machine_token', $machine_token);
    $machine_check = $this->db->get('machine')->result();
    if ($machine_check) {
      log_message('debug', 'Machine Check Pass');
      return true;
    } else {

      return false;
    }
  }

  function index_put()
  { }


  function index_delete()
  { }
}
