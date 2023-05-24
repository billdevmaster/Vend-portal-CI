<?php

class Feed_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    public function getFeed()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateAdminTokenFromSession($headers['Authorization'], $headers['ClientId']);
                if ($token_response === true) {
                    $query = $this->db->query("SELECT * FROM feed ORDER BY id DESC LIMIT 20");
                    $result = $query->result();
                    $arr_data = array();
                    $i = 0;
                    foreach ($result as $row) {
                        $arr_data[$i]['id'] = $row->id;
                        $arr_data[$i]['machine_id'] = $row->machine_id;
                        $arr_data[$i]['feed'] = $row->feed;
                        $arr_data[$i]['created_on'] = $row->created_on;
                        $i++;
                    }
                    $response = array('code' => 200, 'feed' => $arr_data);
                    header('Content-type:application/json');
                    echo json_encode($response);
                } else {
                    $arr = array('code' => 401, 'msg' => "Authentication failed");
                    header('Content-type:application/json');
                    echo json_encode($arr);
                }
            } else {
                $arr = array('code' => 401, 'msg' => "Authentication failed");
                header('Content-type:application/json');
                echo json_encode($arr);
            }
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getFeedByClientId()
    {
        log_message('debug', 'getFeedByClientId');

        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateTokenFromSession($headers['Authorization'], $headers['ClientId']);
                if ($headers['ClientId'] == $this->input->post('client_id')) {
                    $token_response = true;
                } else {
                    $token_response = false;
                }
                if ($token_response === true) {
                    $clientId = $this->getClientId();
                    $query = $this->db->query("SELECT * FROM feed WHERE client_id = " . $clientId . " ORDER BY id DESC LIMIT 20");
                    $result = $query->result();
                    $arr_data = array();
                    $i = 0;
                    foreach ($result as $row) {
                        $arr_data[$i]['id'] = $row->id;
                        $arr_data[$i]['machine_id'] = $row->machine_id;
                        $arr_data[$i]['feed'] = $row->feed;
                        $arr_data[$i]['created_on'] = $row->created_on;
                        $i++;
                    }
                    $response = array('code' => 200, 'feed' => $arr_data);
                    header('Content-type:application/json');
                    echo json_encode($response);
                } else {
                    $arr = array('code' => 401, 'msg' => "Authentication failed");
                    header('Content-type:application/json');
                    echo json_encode($arr);
                }
            } else {
                $arr = array('code' => 401, 'msg' => "Authentication failed");
                header('Content-type:application/json');
                echo json_encode($arr);
            }
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
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
