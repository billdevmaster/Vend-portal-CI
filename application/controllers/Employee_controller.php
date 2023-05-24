<?php
class Employee_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    public function insertEmployeeGroupName()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'insertEmployeeGroupName');

            $data = array(
                'group_name' => $this->input->post('groupname'),
                'client_id' => $this->getClientId(),
                'created_by' => $this->session->userdata('firstname'),
            );
            $this->db->insert('employee_group', $data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function insertEmployeeGroupRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'insertEmployeeGroupRestriction');
            $this->db->where('group_id', $this->input->post('group_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $q = $this->db->get('employee_group_product_restriction');
            if ($q->num_rows() == 0) {
                $data = array(
                    'group_id' => $this->input->post('group_id'),
                    'group_name' => $this->input->post('group_name'),
                    'client_id' => $this->getClientId(),
                    'product_id' => $this->input->post('product_id'),
                    'product_name' => $this->input->post('product_name'),
                    'product_image' => $this->input->post('product_image'),
                    'added_by' => $this->session->userdata('firstname'),
                );
                $this->db->insert('employee_group_product_restriction', $data);
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

    public function insertEmployeeProductRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'insertEmployeeProductRestriction');
            $clientId = $this->getClientId();
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $this->db->where('client_id', $clientId);
            $q = $this->db->get('employee_product_restriction');
            if ($q->num_rows() == 0) {
                $data = array(
                    'client_id' => $clientId,
                    'employee_id' => $this->input->post('employee_id'),
                    'product_id' => $this->input->post('product_id'),
                    'added_by' => $this->session->userdata('firstname'),
                );
                $this->db->insert('employee_product_restriction', $data);
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

    public function insertEmployeeProductQuantityRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $clientId = $this->getClientId();
            log_message('debug', 'insertEmployeeProductQuantityRestriction');
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $this->db->where('client_id', $clientId);
            $q = $this->db->get('employee_product_quantity_restriction');
            $data = array(
                'client_id' => $clientId,
                'employee_id' => $this->input->post('employee_id'),
                'product_id' => $this->input->post('product_id'),
                'quantity' => $this->input->post('quantity'),
                'added_by' => $this->session->userdata('firstname'),
            );
            if ($q->num_rows() == 0) {
                $this->db->insert('employee_product_quantity_restriction', $data);
            } else {
                $this->db->where('employee_id', $this->input->post('employee_id'));
                $this->db->where('product_id', $this->input->post('product_id'));
                $this->db->where('client_id', $clientId);
                $this->db->update('employee_product_quantity_restriction', $data);
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

    public function uploadEmployee()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $clientId = $this->getClientId();
            log_message('debug', 'uploadEmployee');
            $data = array(
                'mobile_number' => $this->input->post('mobilenumber'),
                'first_name' => $this->input->post('firstname'),
                'last_name' => $this->input->post('lastname'),
                'job_number' => $this->input->post('jobnumber'),
                'employee_id' => $this->input->post('employeeid'),
                'emp_card_no' => $this->input->post('emp_card_no'),
                'group_id' => $this->input->post('group_id'),
                'client_id' => $clientId,
                'group_name' => $this->input->post('group_name'),
                'account_created_by' => $this->session->userdata('firstname'),
            );
            $this->db->insert('employee', $data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getEmployeeGroup()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $clientId = $this->getClientId();
            $this->db->where('client_id', $clientId);
            $result = $this->db->get('employee_group')->result();
            $arr_data = array();
            $i = 0;
            $arr_data[$i]['id'] = '-1';
            $arr_data[$i]['group_name'] = '';
            $arr_data[$i]['client_id'] = '-1';
            $arr_data[$i]['client_name'] = '';
            $i++;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['client_name'] = $row2->client_name;
                }
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

    public function getEmployeeGroupData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $result = $this->db->get('employee_group')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['client_name'] = $row2->client_name;
                }
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

    public function getEmployeeGroupSorted()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $query = $this->db->query("SELECT * FROM employee_group ORDER BY client_id DESC");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['client_name'] = $row2->client_name;
                }
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

    public function getEmployeeGroupDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            $clientId = $this->getClientId();
            $this->db->where('client_id', $clientId);
            $result = $this->db->get('employee_group')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['client_name'] = $row2->client_name;
                }
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

    public function getEmployeeData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'Inside Employee Controller getEmployeeData');
            $result = $this->db->get('employee')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['mobilenumber'] = $row->mobile_number;
                $arr_data[$i]['firstname'] = $row->first_name;
                $arr_data[$i]['lastname'] = $row->last_name;
                $arr_data[$i]['fullname'] = $row->first_name . ' ' . $row->last_name;
                $arr_data[$i]['jobnumber'] = $row->job_number;
                $arr_data[$i]['employeeid'] = $row->employee_id;
                $arr_data[$i]['emp_card_no'] = $row->emp_card_no;
                $arr_data[$i]['groupid'] = $row->group_id;
                $arr_data[$i]['clientid'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['clientname'] = $row2->client_name;
                }
                $arr_data[$i]['groupname'] = $row->group_name;
                $arr_data[$i]['accountcreatedby'] = $row->account_created_by;
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

    public function getEmployeeDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside Employee Controller getEmployeeData');
            $clientId = $this->getClientId();
            $this->db->where('client_id', $clientId);
            $result = $this->db->get('employee')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['mobilenumber'] = $row->mobile_number;
                $arr_data[$i]['firstname'] = $row->first_name;
                $arr_data[$i]['lastname'] = $row->last_name;
                $arr_data[$i]['fullname'] = $row->first_name . ' ' . $row->last_name;
                $arr_data[$i]['jobnumber'] = $row->job_number;
                $arr_data[$i]['employeeid'] = $row->employee_id;
                $arr_data[$i]['groupid'] = $row->group_id;
                $arr_data[$i]['emp_card_no'] = $row->emp_card_no;
                $arr_data[$i]['clientid'] = $row->client_id;
                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['clientname'] = $row2->client_name;
                }
                $arr_data[$i]['groupname'] = $row->group_name;
                $arr_data[$i]['accountcreatedby'] = $row->account_created_by;
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

    public function getEmployeeTransactionData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getEmployeeTransactionData');
            $query = $this->db->query("SELECT * FROM employee_transaction ORDER BY timestamp DESC");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['transaction_id'] = $row->transaction_id;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['job_number'] = $row->job_number;
                $arr_data[$i]['cost_center'] = $row->cost_center;
                $arr_data[$i]['employee_id'] = $row->employee_id;
                $arr_data[$i]['employee_full_name'] = $row->employee_full_name;
                $arr_data[$i]['product_id'] = $row->product_id;
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['timestamp'] = $row->timestamp;

                $this->db->where('id', $row->client_id);
                $q2 = $this->db->get('client');
                $result2 = $q2->result();
                foreach ($result2 as $row2) {
                    $clientName = $row2->client_name;
                    $arr_data[$i]['client_name'] = $clientName;
                }

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

    public function getViewEmployeeProductRestrictionData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'getViewEmployeeProductRestrictionData');
            $query = $this->db->query("
    select employee_id, group_concat(product_id SEPARATOR ' , ') as product_id from employee_product_restriction group by employee_id
        ");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $this->db->where('employee_id', $row->employee_id);
                $q1 = $this->db->get('employee');
                $result1 = $q1->result();
                $arr_data[$i]['employee_id'] = $row->employee_id;
                foreach ($result1 as $row1) {
                    $arr_data[$i]['employee_name'] = $row1->first_name . ' ' . $row1->last_name;
                }

                $keywords = explode(',', $row->product_id);
                $product_name = '';
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    $this->db->where('product_id', $keyword);
                    $q2 = $this->db->get('product');
                    $result2 = $q2->result();
                    foreach ($result2 as $row2) {
                        $product_name = $row2->product_name . ' , ' . $product_name;
                    }
                }
                $product_name = rtrim($product_name, ", ");
                $arr_data[$i]['product_name'] = $product_name;
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

    public function getViewEmployeeProductRestriction()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getViewEmployeeProductRestriction');
            $query = $this->db->query("select employee_id, product_id from employee_product_restriction order by employee_id");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $this->db->where('employee_id', $row->employee_id);
                $q1 = $this->db->get('employee');
                $result1 = $q1->result();
                $arr_data[$i]['employee_id'] = $row->employee_id;
                foreach ($result1 as $row1) {
                    $arr_data[$i]['employee_name'] = $row1->first_name . ' ' . $row1->last_name;
                }
                $arr_data[$i]['product_id'] = $row->product_id;
                $this->db->where('product_id', $row->product_id);
                $q2 = $this->db->get('product');
                $result2 = $q2->result();
                foreach ($result2 as $row2) {
                    $product_name = $row2->product_name;
                    $arr_data[$i]['product_name'] = $product_name;
                }
                $i++;
            }

            usort($arr_data, function ($a, $b) {
                return strcasecmp($a['employee_name'], $b['employee_name']);
            });

            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function deleteEmployeeProductRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'deleteEmployeeProductRestriction');
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $this->db->delete('employee_product_restriction');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getViewEmployeeGroupProductRestrictionData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'getViewEmployeeGroupProductRestrictionData');
            $query = $this->db->query("
    select group_name, group_concat(product_name SEPARATOR ' , ') as products_name from employee_group_product_restriction group by group_name
        ");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['product_name'] = $row->products_name;
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

    public function getViewEmployeeGroupProductRestriction()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getViewEmployeeGroupProductRestriction');
            $query = $this->db->query("select group_name, product_name from employee_group_product_restriction order by group_name");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['product_name'] = $row->product_name;
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

    public function getViewEmployeeGroupProductRestrictionByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            log_message('debug', 'getViewEmployeeGroupProductRestriction');
            $clientId = $this->getClientId();
            $this->db->where('client_id', $clientId);
            $queryStatement = "select group_name, product_name from employee_group_product_restriction where client_id = " . $clientId . " order by group_name";
            log_message('debug', $queryStatement);
            $query = $this->db->query($queryStatement);
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['group_name'] = $row->group_name;
                $arr_data[$i]['product_name'] = $row->product_name;
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

    public function deleteEmployeeGroup()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'deleteEmployeeGroup');
            $this->db->where('group_name', $this->input->post('group_name'));
            $this->db->where('product_name', $this->input->post('product_name'));
            $this->db->delete('employee_group_product_restriction');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function deleteEmployeeGroupById()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'deleteEmployeeGroupById');
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('employee_group');
            //  $this->db->where('group_id', $this->input->post('id'));
            //  $this->db->delete('employee');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function deactivateEmployee()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside Employee Controller deactivateEmployee');
            $this->db->where('employee_id', $this->session->userdata('employeeid'));
            $q = $this->db->get('employee');
            if ($q->num_rows() > 0) {
                $this->db->where('employee_id', $this->session->userdata('employeeid'));
                $this->db->delete('employee');
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

    public function updateEmployeeData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $data = array(
                'mobile_number' => $this->input->post('mobilenumber'),
                'job_number' => $this->input->post('jobnumber'),
                'first_name' => $this->input->post('firstname'),
                'last_name' => $this->input->post('lastname'),
                'emp_card_no' => $this->input->post('emp_card_no'),
            );
            $this->db->where('employee_id', $this->input->post('employeeid'));
            $q = $this->db->get('employee');
            if ($q->num_rows() > 0) {
                $this->db->where('employee_id', $this->input->post('employeeid'));
                $this->db->update('employee', $data);
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

    public function uploadEmployeeList()
    {
        log_message('debug', 'uploadEmployeeList');
        $config['upload_path'] = 'ngapp/assets/csv/employee/';
        $config['allowed_types'] = 'csv|xls|xlsx';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploadedFile = $this->upload->data();
            //  @chmod($uploadedFile['full_path'], 0777);
            $error_text = ' ';
            $success_text = ' ';
            $noOfEmployeeUpdated = 0;
            $noOfError = 0;
            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->spreadsheet_excel_reader->read($uploadedFile['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];
            error_reporting(0);
            $data_excel = array();

            $correctFormat = true;

            if (
                $sheets['cells'][1][1] != 'First Name' || $sheets['cells'][1][2] != 'Last Name' || $sheets['cells'][1][3] != 'Employee ID'
                || $sheets['cells'][1][4] != 'Mobile Number' || $sheets['cells'][1][5] != 'Passcode' || $sheets['cells'][1][6] != 'Employee Card Number'
                || $sheets['cells'][1][7] != 'Group Name'
            ) {
                $correctFormat = false;
            }

            if ($correctFormat) {
                for ($i = 2; $i <= $sheets['numRows']; $i++) {
                    if ($sheets['cells'][$i][1] == '') {
                        break;
                    }

                    $firstName = $sheets['cells'][$i][1];

                    if (empty($sheets['cells'][$i][2])) {
                        $lastName = "";
                    } else {
                        $lastName = $sheets['cells'][$i][2];
                    }

                    $employeeId = $sheets['cells'][$i][3];

                    if (empty($sheets['cells'][$i][4])) {
                        $mobileNumber = "";
                    } else {
                        $mobileNumber = $sheets['cells'][$i][4];
                    }

                    if (empty($sheets['cells'][$i][5])) {
                        $passcode = "";
                    } else {
                        $passcode = $sheets['cells'][$i][5];
                    }

                    if (empty($sheets['cells'][$i][6])) {
                        $empCardNo = "";
                    } else {
                        $empCardNo = $sheets['cells'][$i][6];
                    }

                    if (empty($sheets['cells'][$i][7])) {
                        $groupName = "";
                    } else {
                        $groupName = $sheets['cells'][$i][7];
                    }

                    $data_excel[$i - 1]['first_name'] = $firstName;
                    $data_excel[$i - 1]['last_name'] = $lastName;
                    $data_excel[$i - 1]['employee_id'] = $employeeId;
                    $data_excel[$i - 1]['mobile_number'] = $mobileNumber;
                    $data_excel[$i - 1]['job_number'] = $passcode;
                    $data_excel[$i - 1]['emp_card_no'] = $empCardNo;

                    $this->db->where('client_id', $this->session->userdata('client_id'));
                    $this->db->where('group_name', $groupName);
                    $q2 = $this->db->get('employee_group');

                    if ($q2->num_rows() == 0) {
                        $data = array(
                            'group_name' => $groupName,
                            'client_id' => $this->session->userdata('client_id'),
                            'created_by' => $this->session->userdata('firstname'),
                        );
                        $this->db->insert('employee_group', $data);

                        $this->db->where('client_id', $this->session->userdata('client_id'));
                        $this->db->where('group_name', $groupName);
                        $q2 = $this->db->get('employee_group');
                    }

                    if ($q2->num_rows() > 0) {
                        $result2 = $q2->result();
                        foreach ($result2 as $row2) {
                            $groupId = $row2->id;
                            $data_excel[$i - 1]['group_id'] = $groupId;
                        }
                        $data_excel[$i - 1]['group_name'] = $groupName;
                        $data_excel[$i - 1]['client_id'] = $this->session->userdata('client_id');
                        $data_excel[$i - 1]['account_created_by'] = $this->session->userdata('firstname');
                        $this->db->where('employee_id', $data_excel[$i - 1]['employee_id']);
                        $this->db->where('client_id', $this->session->userdata('client_id'));
                        $q = $this->db->get('employee');
                        if ($q->num_rows() == 0) {
                            $this->db->insert('employee', $data_excel[$i - 1]);
                            $noOfEmployeeUpdated++;
                        } else {
                            $error_text = $error_text . 'Row : ' . $i . ' Employee ID : ' . $data_excel[$i - 1]['employee_id'] . ' already exists;';
                            log_message('debug', 'Employee CSV : Error Found - ' . $error_text);
                            $noOfError++;
                        }
                    } else {
                        $error_text = $error_text . 'Row : ' . $i . ' Group Name : ' . $sheets['cells'][$i][7] . ' not found;';
                        log_message('debug', 'Employee CSV : Error Found - ' . $error_text);
                        $noOfError++;
                    }
                }
            } else {
                $error_text = 'Data Format is not as per requirement.';
                log_message('debug', 'Employee CSV : Error Found - ' . $error_text);
                $noOfError++;
            }

            $success_text = 'No of Employee Updated Successfully : ' . $noOfEmployeeUpdated;
            $error_text = 'Total Error : ' . $noOfError . ';' . $error_text;
        } else {
            // show_error($this->upload->print_debugger());
            log_message('debug', 'employee sheet upload failed');
        }
        $arr_data['success'] = $success_text;
        $arr_data['error'] = $error_text;
        $arr_data['no_of_employee_updated'] = $noOfEmployeeUpdated;
        $arr_data['no_of_error'] = $noOfError;
        echo json_encode($arr_data);
    }

    public function getEmployeeProductQuantityRestriction()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            log_message('debug', 'getEmployeeProductQuantityRestriction');
            $query = $this->db->query("select employee_id, product_id,quantity from employee_product_quantity_restriction order by employee_id");
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $this->db->where('employee_id', $row->employee_id);
                $q1 = $this->db->get('employee');
                $result1 = $q1->result();
                $arr_data[$i]['employee_id'] = $row->employee_id;
                foreach ($result1 as $row1) {
                    $arr_data[$i]['employee_name'] = $row1->first_name . ' ' . $row1->last_name;
                }
                $arr_data[$i]['product_id'] = $row->product_id;
                $this->db->where('product_id', $row->product_id);
                $q2 = $this->db->get('product');
                $result2 = $q2->result();
                foreach ($result2 as $row2) {
                    $product_name = $row2->product_name;
                    $arr_data[$i]['product_name'] = $product_name;
                }
                $arr_data[$i]['quantity'] = $row->quantity;
                $i++;
            }

            usort($arr_data, function ($a, $b) {
                return strcasecmp($a['employee_name'], $b['employee_name']);
            });
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function deleteEmployeeProductQuantityRestriction()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'deleteEmployeeProductQuantityRestriction');
            $this->db->where('employee_id', $this->input->post('employee_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $this->db->delete('employee_product_quantity_restriction');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getViewEmployeeProductRestrictionByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'getViewEmployeeProductRestrictionByClientId');
            $clientId = $this->getClientId();
            $this->db->where('client_id', $clientId);
            $queryStatement = "select employee_id, product_id from employee_product_restriction where client_id = " . $clientId . " order by employee_id";
            $query = $this->db->query($queryStatement);
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $this->db->where('employee_id', $row->employee_id);
                $q1 = $this->db->get('employee');
                $result1 = $q1->result();
                $arr_data[$i]['employee_id'] = $row->employee_id;
                foreach ($result1 as $row1) {
                    $arr_data[$i]['employee_name'] = $row1->first_name . ' ' . $row1->last_name;
                }
                $arr_data[$i]['product_id'] = $row->product_id;
                $this->db->where('product_id', $row->product_id);
                $q2 = $this->db->get('product');
                $result2 = $q2->result();
                foreach ($result2 as $row2) {
                    $product_name = $row2->product_name;
                    $arr_data[$i]['product_name'] = $product_name;
                }
                $i++;
            }

            usort($arr_data, function ($a, $b) {
                return strcasecmp($a['employee_name'], $b['employee_name']);
            });

            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getEmployeeProductQuantityRestrictionByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'getEmployeeProductQuantityRestrictionByClientId');
            $clientId = $this->getClientId();
            $this->db->where('client_id', $clientId);
            $queryStatement = "select employee_id, product_id,quantity from employee_product_quantity_restriction where client_id = " . $clientId . " order by employee_id";
            $query = $this->db->query($queryStatement);
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $this->db->where('employee_id', $row->employee_id);
                $q1 = $this->db->get('employee');
                $result1 = $q1->result();
                $arr_data[$i]['employee_id'] = $row->employee_id;
                foreach ($result1 as $row1) {
                    $arr_data[$i]['employee_name'] = $row1->first_name . ' ' . $row1->last_name;
                }
                $arr_data[$i]['product_id'] = $row->product_id;
                $this->db->where('product_id', $row->product_id);
                $q2 = $this->db->get('product');
                $result2 = $q2->result();
                foreach ($result2 as $row2) {
                    $product_name = $row2->product_name;
                    $arr_data[$i]['product_name'] = $product_name;
                }
                $arr_data[$i]['quantity'] = $row->quantity;
                $i++;
            }

            usort($arr_data, function ($a, $b) {
                return strcasecmp($a['employee_name'], $b['employee_name']);
            });

            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getEmployeeTransactionDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'getEmployeeTransactionData');
            $clientId = $this->getClientId();
            $queryStatement = "SELECT * FROM employee_transaction where client_id = " . $clientId . " ORDER BY timestamp DESC";
            $query = $this->db->query($queryStatement);
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['transaction_id'] = $row->transaction_id;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['job_number'] = $row->job_number;
                $arr_data[$i]['cost_center'] = $row->cost_center;
                $arr_data[$i]['employee_id'] = $row->employee_id;
                $arr_data[$i]['employee_full_name'] = $row->employee_full_name;
                $arr_data[$i]['product_id'] = $row->product_id;
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['timestamp'] = $row->timestamp;

                $this->db->where('id', $row->client_id);
                $q2 = $this->db->get('client');
                $result2 = $q2->result();
                foreach ($result2 as $row2) {
                    $clientName = $row2->client_name;
                    $arr_data[$i]['client_name'] = $clientName;
                }

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

    public function checkEmployeeIdValidity()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside checkEmployeeIdValidity');
            $this->db->where('client_id', $this->getClientId());
            $this->db->where('employee_id', $this->input->post('employeeid'));
            $query = $this->db->get('employee');
            $arr_data['isPresent'] = null;
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'employee_id';
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

    public function deleteSelectedEmployee()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside Employee Controller deleteSelectedEmployee');
            $employees = $this->input->post('employees');
            $employeeObj = json_decode($employees);
            for ($i = 0; $i < count($employeeObj->employees); $i++) {
                $this->db->where('employee_id', $employeeObj->employees[$i]->employeeid);
                $q = $this->db->get('employee');
                if ($q->num_rows() > 0) {
                    $this->db->where('employee_id', $employeeObj->employees[$i]->employeeid);
                    $this->db->delete('employee');
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
