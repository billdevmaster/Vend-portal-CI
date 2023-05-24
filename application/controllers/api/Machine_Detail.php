<?php

require APPPATH . '/libraries/REST_Controller.php';

class Machine_Detail extends REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
    }

    public function index_get()
    {}

    public function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $assignedMachine = $this->check_assign_machine($this->input->post('username'), $this->input->post('machine_id'));
            if ($assignedMachine) {

                $this->db->where('machine_id', $this->input->post('machine_id'));
                $assign_product = $this->db->get('machine_assign_product')->result();

                $this->db->where('machine_id', $this->input->post('machine_id'));
                $assign_category = $this->db->get('machine_assign_category')->result();
                $clientId = "";
                foreach ($assignedMachine as $assignedMac) {
                    $clientId = $assignedMac->machine_client_id;
                    break;
                }
                $i = 0;
                $product_array = array();
                foreach ($assign_product as $row1) {
                    $this->db->select("*");
                    $this->db->from('product');
                    $this->db->where('product_id', $row1->product_id);
                    $this->db->where('client_id', $clientId);
                    $query1 = $this->db->get();
                    $result1 = $query1->result();
                    foreach ($result1 as $row) {
                        $product_array[$i] = $row;
                        $i++;
                    }
                }

                $j = 0;
                $category_array = array();
                foreach ($assign_category as $row2) {
                    $this->db->select("*");
                    $this->db->from('category');
                    $this->db->where('category_id', $row2->category_id);
                    $query2 = $this->db->get();
                    $result2 = $query2->result();
                    foreach ($result2 as $row) {
                        $category_array[$j] = $row;
                        $j++;
                    }
                }

                $this->db->where('machine_id', $this->input->post('machine_id'));
                $product_map = $this->db->get('machine_product_map')->result();

                $this->response(array('status' => 'success', 'category' => $category_array, 'product' => $product_array, 'assign_product' => $assign_product, 'assign_category' => $assign_category, 'product_map' => $product_map), 200);
            } else {
                $this->response(array('status' => 'fail', 'message' => 'Products and Category Not Assigned to this User'), 401);
            }
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }
    }

    public function index_put()
    {}

    public function index_delete()
    {}

    public function check_assign_machine($machine_username, $machine_id)
    {
        $this->db->where('machine_username', $machine_username);
        $this->db->where('id', $machine_id);
        $login_check = $this->db->get('machine')->result();
        return $login_check;
    }
}
