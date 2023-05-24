<?php

class Advertisement_Report_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    function getAdvertisementReportData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getAdvertisementReportData');
            $this->db->order_by('timestamp', 'DESC');
            $result = $this->db->get('advertisement_report')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['advertisement_id'] = $row->advertisement_id;
                $arr_data[$i]['advertisement_name'] = $row->advertisement_name;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['advertisement_position'] = $row->advertisement_position;
                $arr_data[$i]['advertisement_screen'] = $row->advertisement_screen;
                $arr_data[$i]['timestamp'] = $row->timestamp;
                $i++;
            }

            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function getAdvertisementReportDataMachineWise()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'getAdvertisementReportData');
            $this->db->order_by('timestamp', 'DESC');
            $this->db->where('machine_id', $this->input->post('machine_id'));
            $result = $this->db->get('advertisement_report')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['advertisement_id'] = $row->advertisement_id;
                $arr_data[$i]['advertisement_name'] = $row->advertisement_name;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['advertisement_position'] = $row->advertisement_position;
                $arr_data[$i]['advertisement_screen'] = $row->advertisement_screen;
                $arr_data[$i]['timestamp'] = $row->timestamp;
                $i++;
            }
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }


    function getAdvertisementReportDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            log_message('debug', 'getAdvertisementReportDataByClientId');
            $this->db->order_by('timestamp', 'DESC');
            $this->db->where('client_id', $this->input->post('client_id'));
            $result = $this->db->get('advertisement_report')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['advertisement_id'] = $row->advertisement_id;
                $arr_data[$i]['advertisement_name'] = $row->advertisement_name;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['advertisement_position'] = $row->advertisement_position;
                $arr_data[$i]['advertisement_screen'] = $row->advertisement_screen;
                $arr_data[$i]['timestamp'] = $row->timestamp;
                $i++;
            }
            $arr = array('code' => 200, 'data' => $arr_data);
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
