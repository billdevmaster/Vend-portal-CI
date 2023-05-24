<?php

class ReportEmail_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
        $this->load->library('email');
    }

    public function insertReportEmail()
    {
        if ($this->checkToken($this->input->request_headers())) {




            $data = array(
                'client_id' => $this->input->post('client_id'),
                'type' => $this->input->post('type'),
                'email' => $this->input->post('email'),
                'frequency' => $this->input->post('frequency'),
                'created_by' => $this->session->userdata('firstname')
            );
            $this->db->where('client_id', $this->input->post('client_id'));
            $this->db->where('email', $this->input->post('email'));
            $this->db->where('type', $this->input->post('type'));
            $this->db->where('frequency', $this->input->post('frequency'));
            $q = $this->db->get('report_email');
            if ($q->num_rows() > 0) {
                $this->db->where('client_id', $this->input->post('client_id'));
                $this->db->where('email', $this->input->post('email'));
                $this->db->update('report_email', $data);
            } else {
                $this->db->insert('report_email', $data);
            }


            $this->db->where('id', $this->input->post('client_id'));
            $query = $this->db->get('client');
            $result = $query->result();
            foreach ($result as $row) {
                if ('SALE_REPORT' == $this->input->post('type')) {
                    if ($row->enable_mail_sale_report == false) {
                        $data = array(
                            'client_id' => $this->input->post('client_id'),
                            'client_code' => $row->client_code,
                            'client_name' => $row->client_name,
                            'report_type' => $this->input->post('type'),
                            'is_approval' => 0
                        );
                        $this->db->where('client_id', $this->input->post('client_id'));
                        $this->db->where('report_type', $this->input->post('type'));
                        $q = $this->db->get('schedule_report_approval');
                        if ($q->num_rows() == 0) {
                            $this->db->insert('schedule_report_approval', $data);
                        } else {
                            $this->db->where('client_id', $this->input->post('client_id'));
                            $this->db->where('report_type', $this->input->post('type'));
                            $this->db->update('schedule_report_approval', $data);
                        }
                        $data = array();
                        $data['title'] = "Sale Report Mail Request";
                        $data['body'] = "Please approve the request for Sale Report Mailing for the below mentioned Client.";
                        $data['client_name'] = $row->client_name;
                        $data['client_address'] = $row->client_address;
                        $data['client_mobile_number'] =  substr($row->client_phone, 0, 4) . ' ' . substr($row->client_phone, 4, 3) . ' ' . substr($row->client_phone, 7);
                        $data['client_email'] = $row->client_email;
                        $data['business_registration_number'] = $row->business_registration_number;
                        $this->sendMailToAdmin($data);
                    }
                } else if ('FEEDBACK_REPORT' == $this->input->post('type')) {
                    if ($row->enable_mail_feedback == false) {
                        $data = array(
                            'client_id' => $this->input->post('client_id'),
                            'client_code' => $row->client_code,
                            'client_name' => $row->client_name,
                            'report_type' => $this->input->post('type'),
                            'is_approval' => 0
                        );
                        $this->db->where('client_id', $this->input->post('client_id'));
                        $this->db->where('report_type', $this->input->post('type'));
                        $q = $this->db->get('schedule_report_approval');
                        if ($q->num_rows() == 0) {
                            $this->db->insert('schedule_report_approval', $data);
                        } else {
                            $this->db->where('client_id', $this->input->post('client_id'));
                            $this->db->where('report_type', $this->input->post('type'));
                            $this->db->update('schedule_report_approval', $data);
                        }
                        $data = array();
                        $data['title'] = "Feedback Report Mail Request";
                        $data['body'] = "Please approve the request for Feedback Report Mailing for the below mentioned Client.";
                        $data['client_name'] = $row->client_name;
                        $data['client_address'] = $row->client_address;
                        $data['client_mobile_number'] =  substr($row->client_phone, 0, 4) . ' ' . substr($row->client_phone, 4, 3) . ' ' . substr($row->client_phone, 7);
                        $data['client_email'] = $row->client_email;
                        $data['business_registration_number'] = $row->business_registration_number;
                        $this->sendMailToAdmin($data);
                    }
                } else if ('EMPLOYEE_REPORT' == $this->input->post('type')) {
                    if ($row->enable_mail_report == false) {
                        $data = array(
                            'client_id' => $this->input->post('client_id'),
                            'client_code' => $row->client_code,
                            'client_name' => $row->client_name,
                            'report_type' => $this->input->post('type'),
                            'is_approval' => 0
                        );
                        $this->db->where('client_id', $this->input->post('client_id'));
                        $this->db->where('report_type', $this->input->post('type'));
                        $q = $this->db->get('schedule_report_approval');
                        if ($q->num_rows() == 0) {
                            $this->db->insert('schedule_report_approval', $data);
                        } else {
                            $this->db->where('client_id', $this->input->post('client_id'));
                            $this->db->where('report_type', $this->input->post('type'));
                            $this->db->update('schedule_report_approval', $data);
                        }
                        $data = array();
                        $data['title'] = "Employee Report Mail Request";
                        $data['body'] = "Please approve the request for Employee Report Mailing for the below mentioned Client.";
                        $data['client_name'] = $row->client_name;
                        $data['client_address'] = $row->client_address;
                        $data['client_mobile_number'] =  substr($row->client_phone, 0, 4) . ' ' . substr($row->client_phone, 4, 3) . ' ' . substr($row->client_phone, 7);
                        $data['client_email'] = $row->client_email;
                        $data['business_registration_number'] = $row->business_registration_number;
                        $this->sendMailToAdmin($data);
                    }
                }
            }


            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function sendMailToAdmin($data)
    {
        $this->db->where('role', 'Super Admin');
        $query = $this->db->get('admin');
        $result = $query->result();
        foreach ($result as $row) {
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
            $config['smtp_user'] = 'noreply@visualvend.com';
            $config['smtp_pass'] = 'V15ualV3nd';
            $config['mailtype'] = 'html';
            $config['smtp_port'] = 465;

            $this->email->clear(TRUE);
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from("noreply@visualvend.com");
            $this->email->subject('Approval Required');
            $message = $this->load->view('notification_mail', $data, TRUE);
            $this->email->message($message);
           // $this->email->to($row->emailid);

            if ($this->email->send()) {
                log_message('debug', "Email Send Successfully.");
            } else {
                log_message('debug', "You have encountered an error " . $row->emailid);
            }
        }
    }

    function getReportEmailByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            $this->db->select("*");
            $this->db->from('report_email');
            $this->db->where('client_id', $this->input->post('client_id'));
            $this->db->where('type', $this->input->post('type'));
            $query = $this->db->get();
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['client_id'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['client_name'] = $row2->client_name;
                }
                $arr_data[$i]['type'] = $row->type;
                $arr_data[$i]['email'] = $row->email;
                $arr_data[$i]['frequency'] = $row->frequency;
                $i++;
            }

            $arr = array('code' => 200, 'report_emails' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function getReportEmail()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->select("*");
            $this->db->from('report_email');
            $this->db->where('type', $this->input->post('type'));
            $query = $this->db->get();
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['client_id'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['client_name'] = $row2->client_name;
                }
                $arr_data[$i]['type'] = $row->type;
                $arr_data[$i]['email'] = $row->email;
                $arr_data[$i]['frequency'] = $row->frequency;
                $i++;
            }

            $arr = array('code' => 200, 'report_emails' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function deleteReportEmail()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'deleteReportEmail');
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('report_email');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }


    public function checkToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateTokenFromSession($headers['Authorization'], $headers['ClientId']);
                if ($token_response === TRUE) {
                    log_message('debug', "Check Token 1");
                    return TRUE;
                } else {
                    log_message('debug', "Check Token 2");
                    return FALSE;
                }
            } else {
                log_message('debug', "Check Token 3");
                return FALSE;
            }
        } else {
            log_message('debug', "Check Token 4");
            return FALSE;
        }
    }

    public function checkAdminToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateAdminTokenFromSession($headers['Authorization'], $headers['ClientId']);
                if ($token_response === TRUE) {
                    log_message('debug', "Check Token 1");
                    return TRUE;
                } else {
                    log_message('debug', "Check Token 2");
                    return FALSE;
                }
            } else {
                log_message('debug', "Check Token 3");
                return FALSE;
            }
        } else {
            log_message('debug', "Check Token 4");
            return FALSE;
        }
    }
}
