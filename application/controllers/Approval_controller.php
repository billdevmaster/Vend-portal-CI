<?php
class Approval_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    function getAdminList()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->order_by('is_activated', 'ASC');
            $result = $this->db->get('admin')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['mobilenumber'] = $row->mobilenumber;
                $arr_data[$i]['firstname'] = $row->firstname;
                $arr_data[$i]['lastname'] = $row->lastname;
                $arr_data[$i]['organization'] = $row->organization;
                $arr_data[$i]['emailid'] = $row->emailid;
                $arr_data[$i]['role'] = $row->role;
                if($row->client_id>0){
                    $arr_data[$i]['client_id'] = $row->client_id;
                }
                else{
                    $arr_data[$i]['client_id'] = '';
                }
                $arr_data[$i]['is_activated'] = $row->is_activated;
                $originalDate = $row->timestamp;
                $newDate = date("d-m-Y", strtotime($originalDate));
                $arr_data[$i]['timestamp'] = $newDate;
                $i++;
            }
            $response = array('code' => 200, 'admins' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($response);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function activateAdmin()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $data = array(
                'is_activated' => $this->input->post('is_activated')
            );
            $this->db->where('id', $this->input->post('id'));
            $q = $this->db->get('admin');
            if ($q->num_rows() > 0) {
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('admin', $data);
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

    function getMachineLoginList()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->order_by('status', 'ASC');
            $result = $this->db->get('user')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['mobilenumber'] = $row->mobilenumber;
                $arr_data[$i]['firstname'] = $row->firstname;
                $arr_data[$i]['lastname'] = $row->lastname;
                $arr_data[$i]['username'] = $row->username;
                $arr_data[$i]['emailid'] = $row->emailid;
                if($row->client_id>0){
                    $arr_data[$i]['client_id'] = $row->client_id;
                }
                else{
                    $arr_data[$i]['client_id'] = '';
                }
                $arr_data[$i]['status'] = $row->status;
                $arr_data[$i]['is_deactivated'] = $row->is_deactivated;
                $originalDate = $row->activated_on;
                $newDate = date("d-m-Y", strtotime($originalDate));
                $arr_data[$i]['timestamp'] = $newDate;
                $i++;
            }
            $response = array('code' => 200, 'users' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($response);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function activateMachineLogin()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $data = array(
                'status' => $this->input->post('status')
            );
            $this->db->where('username', $this->input->post('username'));
            $q = $this->db->get('user');
            if ($q->num_rows() > 0) {
                $this->db->where('username', $this->input->post('username'));
                $this->db->update('user', $data);
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

    function getScheduleReportList()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->order_by('is_approval', 'ASC');
            $result = $this->db->get('schedule_report_approval')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['client_code'] = $row->client_code;
                $arr_data[$i]['client_name'] = $row->client_name;
                $arr_data[$i]['report_type'] = $row->report_type;
                if($row->client_id>0){
                    $arr_data[$i]['client_id'] = $row->client_id;
                }
                else{
                    $arr_data[$i]['client_id'] = '';
                }
                $arr_data[$i]['is_approval'] = $row->is_approval;
                $originalDate = $row->requested_on;
                $newDate = date("d-m-Y", strtotime($originalDate));
                $arr_data[$i]['requested_on'] = $newDate;
                $i++;
            }
            $response = array('code' => 200, 'schedule_report_approval' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($response);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function activateScheduleReportList()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $data = array(
                'is_approval' => 1
            );
            $this->db->where('id', $this->input->post('id'));
            $q = $this->db->get('schedule_report_approval');
            if ($q->num_rows() > 0) {
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('schedule_report_approval', $data);
            }


            if('SALE_REPORT'==$this->input->post('type')){
                log_message('debug', "activateScheduleReportList SALE_REPORT");
                $data = array(
                    'enable_mail_sale_report' => 1
                );
                $this->db->where('id', $this->input->post('client_id'));
                $q = $this->db->get('client');
                if ($q->num_rows() > 0) {
                    $this->db->where('id', $this->input->post('client_id'));
                    $this->db->update('client', $data);
                }
            }
            else if('FEEDBACK_REPORT'==$this->input->post('type')){
                log_message('debug', "activateScheduleReportList FEEDBACK_REPORT");
                $data = array(
                    'enable_mail_feedback' => 1
                );
                $this->db->where('id', $this->input->post('client_id'));
                $q = $this->db->get('client');
                if ($q->num_rows() > 0) {
                    $this->db->where('id', $this->input->post('client_id'));
                    $this->db->update('client', $data);
                }
            }
            else if('EMPLOYEE_REPORT'==$this->input->post('type')){
                log_message('debug', "activateScheduleReportList EMPLOYEE_REPORT");
                $data = array(
                    'enable_mail_report' => 1
                );
                $this->db->where('id', $this->input->post('client_id'));
                $q = $this->db->get('client');
                if ($q->num_rows() > 0) {
                    $this->db->where('id', $this->input->post('client_id'));
                    $this->db->update('client', $data);
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

    function deactivateScheduleReportList()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $data = array(
                'is_approval' => 2
            );
            $this->db->where('id', $this->input->post('id'));
            $q = $this->db->get('schedule_report_approval');
            if ($q->num_rows() > 0) {
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('schedule_report_approval', $data);
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


    public function checkToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateTokenFromSession($headers['Authorization'],$headers['ClientId']);
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
                $token_response = $this->authorization_token->validateAdminTokenFromSession($headers['Authorization'],$headers['ClientId']);
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
