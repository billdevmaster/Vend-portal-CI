<?php

class EReceipt_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    public function getEReceiptData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getEReceiptData');
            $this->db->order_by('id', 'DESC');
            $result = $this->db->get('receipts')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['machine_id'] = $row->machine_id;

                $this->db->where('id', $row->machine_id);
                $machineObjects = $this->db->get('machine')->result();
                foreach ($machineObjects as $machineObject) {
                    $machine_name = $machineObject->machine_name;
                }

                $arr_data[$i]['machine_name'] = $machine_name;
                $arr_data[$i]['transaction_id'] = $row->transaction_id;
                $arr_data[$i]['name'] = $row->name;
                $arr_data[$i]['email'] = $row->email;
                $arr_data[$i]['mobile_number'] = $row->mobile_number;
                $arr_data[$i]['url'] = $row->url;
                $arr_data[$i]['date_time'] = $row->date_time;
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

    public function getEReceiptDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            log_message('debug', 'getEReceiptDataByClientId');

            $this->db->where('machine_client_id', $this->getClientId());
            $result = $this->db->get('machine')->result();
            $machine_array = array();
            $h = 0;
            foreach ($result as $row) {
                $machine_array[] = $row->id;
                $h++;
            }

            $this->db->where_in('machine_id', $machine_array);
            $this->db->order_by('id', 'DESC');
            $result = $this->db->get('receipts')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['machine_id'] = $row->machine_id;

                $this->db->where('id', $row->machine_id);
                $machineObjects = $this->db->get('machine')->result();
                foreach ($machineObjects as $machineObject) {
                    $machine_name = $machineObject->machine_name;
                }

                $arr_data[$i]['machine_name'] = $machine_name;
                $arr_data[$i]['transaction_id'] = $row->transaction_id;
                $arr_data[$i]['name'] = $row->name;
                $arr_data[$i]['email'] = $row->email;
                $arr_data[$i]['mobile_number'] = $row->mobile_number;
                $arr_data[$i]['url'] = $row->url;
                $arr_data[$i]['date_time'] = $row->date_time;
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
