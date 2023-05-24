<?php

class Location_Non_Functional_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    public function getLocationNonFunctionalData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getLocationNonFunctionalData');
            $this->db->order_by('timestamp', 'DESC');
            $result = $this->db->get('location_non_functional')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['defect_id'] = $row->defect_id;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $this->db->where('id', $row->machine_id);
                $result1 = $this->db->get('machine')->result();
                foreach ($result1 as $row1) {
                    $arr_data[$i]['machine_name'] = $row1->machine_name;
                }
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['defective_location'] = $row->defective_location;
                $arr_data[$i]['error_code'] = $row->error_code;
                $arr_data[$i]['status'] = $row->status;
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

    public function getLocationNonFunctionalDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            log_message('debug', 'getFeedbackDataByClientId');
            $this->db->where('machine_client_id', $this->getClientId());
            $result = $this->db->get('machine')->result();
            $machine_array = array();
            $h = 0;
            foreach ($result as $row) {
                $machine_array[] = $row->id;
                $h++;
            }

            $this->db->where_in('machine_id', $machine_array);
            $this->db->order_by('timestamp', 'DESC');
            $result = $this->db->get('location_non_functional')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['defect_id'] = $row->defect_id;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $this->db->where('id', $row->machine_id);
                $result1 = $this->db->get('machine')->result();
                foreach ($result1 as $row1) {
                    $arr_data[$i]['machine_name'] = $row1->machine_name;
                }
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['defective_location'] = $row->defective_location;
                $arr_data[$i]['error_code'] = $row->error_code;
                $arr_data[$i]['status'] = $row->status;
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
                $token_response = $this->authorization_token->validateTokenFromSession($headers['Authorization'], $headers['ClientId']);
                if ($token_response === true) {
                    log_message('debug', "Check Token 1");
                    return true;
                } else {
                    log_message('debug', "Check Token 2");
                    return false;
                }
            } else {
                log_message('debug', "Check Token 3");
                return false;
            }
        } else {
            log_message('debug', "Check Token 4");
            return false;
        }
    }

    public function checkAdminToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateAdminTokenFromSession($headers['Authorization'], $headers['ClientId']);
                if ($token_response === true) {
                    log_message('debug', "Check Token 1");
                    return true;
                } else {
                    log_message('debug', "Check Token 2");
                    return false;
                }
            } else {
                log_message('debug', "Check Token 3");
                return false;
            }
        } else {
            log_message('debug', "Check Token 4");
            return false;
        }
    }

    private function getClientId()
    {
        $clientId = $this->input->post('client_id');
        if ($clientId == 75 || $clientId == 76 || $clientId == 77) {
            $clientId = 22;
        }
        return $clientId;
    }
}
