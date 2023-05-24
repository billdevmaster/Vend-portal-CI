<?php
class ProductRestriction_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    public function insertTotalQuantityRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $data = array(
                'client_id' => $this->input->post('client_id'),
                'group_id' => $this->input->post('group_id'),
                'quantity' => $this->input->post('quantity'),
                'added_by' => $this->session->userdata('firstname')
            );
            $this->db->where('client_id', $this->input->post('client_id'));
            $this->db->where('group_id', $this->input->post('group_id'));
            $q = $this->db->get('total_quantity_restriction');
            if ($q->num_rows() > 0) {
                $this->db->where('client_id', $this->input->post('client_id'));
                $this->db->where('group_id', $this->input->post('group_id'));
                $this->db->update('total_quantity_restriction', $data);
            } else {
                $this->db->insert('total_quantity_restriction', $data);
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

    function getProductRestrictionByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            $this->db->select("*");
            $this->db->from('total_quantity_restriction');
            $this->db->where('client_id', $this->input->post('client_id'));
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
                $this->db->select("*");
                $this->db->from('employee_group');
                $this->db->where('id', $row->group_id);
                $query3 = $this->db->get();
                $result3 = $query3->result();
                foreach ($result3 as $row3) {
                    $arr_data[$i]['group_name'] = $row3->group_name;
                }
                $arr_data[$i]['quantity'] = $row->quantity;
                $i++;
            }

            $arr = array('code' => 200, 'total_quantity_restrictions' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function getProductRestriction()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->select("*");
            $this->db->from('total_quantity_restriction');
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
                $this->db->select("*");
                $this->db->from('employee_group');
                $this->db->where('id', $row->group_id);
                $query3 = $this->db->get();
                $result3 = $query3->result();
                foreach ($result3 as $row3) {
                    $arr_data[$i]['group_name'] = $row3->group_name;
                }
                $arr_data[$i]['quantity'] = $row->quantity;
                $i++;
            }

            $arr = array('code' => 200, 'total_quantity_restrictions' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    function deleteProductRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'deleteProductRestriction');
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('total_quantity_restriction');
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
