<?php
class Machine_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Machine_model");
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('Authorization_Token');
    }

    public function getData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $result = $this->db->get('machine')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['machine_row'] = $row->machine_row;
                $arr_data[$i]['machine_column'] = $row->machine_column;
                $arr_data[$i]['machine_upt_no'] = $row->machine_upt_no;
                $arr_data[$i]['machine_latitude'] = $row->machine_latitude;
                $arr_data[$i]['machine_username'] = $row->machine_username;
                $arr_data[$i]['machine_longitude'] = $row->machine_longitude;
                $arr_data[$i]['machine_is_single_category'] = $row->machine_is_single_category;
                $arr_data[$i]['machine_mode'] = $row->machine_mode;
                $arr_data[$i]['serial_port_number'] = $row->serial_port_number;
                $arr_data[$i]['machine_passcode_screen'] = $row->machine_passcode_screen;
                $arr_data[$i]['advertisement_type'] = $row->advertisement_type;
                $arr_data[$i]['machine_advertisement_mode'] = $row->machine_advertisement_mode;
                $arr_data[$i]['machine_is_game_enabled'] = $row->machine_is_game_enabled;
                $arr_data[$i]['machine_game'] = $row->machine_game;
                $arr_data[$i]['machine_address'] = $row->machine_address;
                $arr_data[$i]['machine_info_button_enabled'] = $row->machine_info_button_enabled;
                $arr_data[$i]['machine_screensaver_enabled'] = $row->machine_screensaver_enabled;
                $arr_data[$i]['machine_volume_control_enabled'] = $row->machine_volume_control_enabled;
                $arr_data[$i]['machine_wheel_chair_enabled'] = $row->machine_wheel_chair_enabled;
                $arr_data[$i]['machine_is_feed_enabled'] = $row->machine_is_feed_enabled;
                $arr_data[$i]['machine_helpline'] = $row->machine_helpline;
                $arr_data[$i]['machine_helpline_enabled'] = $row->machine_helpline_enabled;
                $arr_data[$i]['receipt_enabled'] = $row->receipt_enabled;
                $arr_data[$i]['machine_is_job_number_enabled'] = $row->machine_is_job_number_enabled;
                $arr_data[$i]['machine_is_cost_center_enabled'] = $row->machine_is_cost_center_enabled;
                $arr_data[$i]['machine_is_gift_enabled'] = $row->machine_is_gift_enabled;
                $arr_data[$i]['newsletter_enabled'] = $row->newsletter_enabled;
                $arr_data[$i]['serial_port_speed'] = $row->serial_port_speed;
                $arr_data[$i]['screen_orientation'] = $row->screen_orientation;
                $arr_data[$i]['screen_size'] = $row->screen_size;
                $arr_data[$i]['machine_client_id'] = $row->machine_client_id;
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

    public function getDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('machine_client_id', $this->getClientId());
            $result = $this->db->get('machine')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['machine_row'] = $row->machine_row;
                $arr_data[$i]['machine_column'] = $row->machine_column;
                $arr_data[$i]['machine_upt_no'] = $row->machine_upt_no;
                $arr_data[$i]['machine_latitude'] = $row->machine_latitude;
                $arr_data[$i]['machine_username'] = $row->machine_username;
                $arr_data[$i]['machine_longitude'] = $row->machine_longitude;
                $arr_data[$i]['machine_is_single_category'] = $row->machine_is_single_category;
                $arr_data[$i]['machine_mode'] = $row->machine_mode;
                $arr_data[$i]['serial_port_number'] = $row->serial_port_number;
                $arr_data[$i]['machine_passcode_screen'] = $row->machine_passcode_screen;
                $arr_data[$i]['machine_advertisement_mode'] = $row->machine_advertisement_mode;
                $arr_data[$i]['machine_is_game_enabled'] = $row->machine_is_game_enabled;
                $arr_data[$i]['machine_game'] = $row->machine_game;
                $arr_data[$i]['machine_address'] = $row->machine_address;
                $arr_data[$i]['machine_info_button_enabled'] = $row->machine_info_button_enabled;
                $arr_data[$i]['machine_screensaver_enabled'] = $row->machine_screensaver_enabled;
                $arr_data[$i]['machine_volume_control_enabled'] = $row->machine_volume_control_enabled;
                $arr_data[$i]['machine_wheel_chair_enabled'] = $row->machine_wheel_chair_enabled;
                $arr_data[$i]['machine_is_feed_enabled'] = $row->machine_is_feed_enabled;
                $arr_data[$i]['machine_helpline'] = $row->machine_helpline;
                $arr_data[$i]['machine_helpline_enabled'] = $row->machine_helpline_enabled;
                $arr_data[$i]['receipt_enabled'] = $row->receipt_enabled;
                $arr_data[$i]['machine_is_job_number_enabled'] = $row->machine_is_job_number_enabled;
                $arr_data[$i]['machine_is_cost_center_enabled'] = $row->machine_is_cost_center_enabled;
                $arr_data[$i]['machine_is_gift_enabled'] = $row->machine_is_gift_enabled;
                $arr_data[$i]['newsletter_enabled'] = $row->newsletter_enabled;
                $arr_data[$i]['serial_port_speed'] = $row->serial_port_speed;
                $arr_data[$i]['screen_orientation'] = $row->screen_orientation;
                $arr_data[$i]['screen_size'] = $row->screen_size;
                $arr_data[$i]['machine_client_id'] = $row->machine_client_id;
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

    public function getCurrentData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('id', $this->session->userdata('machine_id'));
            $result = $this->db->get('machine')->result();
            foreach ($result as $row) {
                $arr_data['id'] = $row->id;
                $arr_data['machine_name'] = $row->machine_name;
                $arr_data['machine_row'] = $row->machine_row;
                $arr_data['machine_column'] = $row->machine_column;
                $arr_data['serial_port_number'] = $row->serial_port_number;
                $arr_data['machine_passcode_screen'] = $row->machine_passcode_screen;
                $arr_data['machine_upt_no'] = $row->machine_upt_no;
                $arr_data['machine_latitude'] = $row->machine_latitude;
                $arr_data['machine_username'] = $row->machine_username;
                $arr_data['machine_longitude'] = $row->machine_longitude;
                $arr_data['machine_is_single_category'] = $row->machine_is_single_category;
                $arr_data['machine_mode'] = $row->machine_mode;
                $arr_data['advertisement_type'] = $row->advertisement_type;
                $arr_data['machine_advertisement_mode'] = $row->machine_advertisement_mode;
                $arr_data['machine_is_game_enabled'] = $row->machine_is_game_enabled;
                $arr_data['machine_address'] = $row->machine_address;
                $arr_data['machine_game'] = $row->machine_game;
                $arr_data['machine_info_button_enabled'] = $row->machine_info_button_enabled;
                $arr_data['machine_screensaver_enabled'] = $row->machine_screensaver_enabled;
                $arr_data['machine_volume_control_enabled'] = $row->machine_volume_control_enabled;
                $arr_data['machine_wheel_chair_enabled'] = $row->machine_wheel_chair_enabled;
                $arr_data['machine_is_asset_tracking'] = $row->machine_is_asset_tracking;
                $arr_data['machine_is_advertisement_reporting'] = $row->machine_is_advertisement_reporting;
                $arr_data['machine_is_feed_enabled'] = $row->machine_is_feed_enabled;
                $arr_data['machine_helpline'] = $row->machine_helpline;
                $arr_data['machine_helpline_enabled'] = $row->machine_helpline_enabled;
                $arr_data['receipt_enabled'] = $row->receipt_enabled;
                $arr_data['machine_customer_care_number'] = $row->machine_customer_care_number;
                $arr_data['machine_is_job_number_enabled'] = $row->machine_is_job_number_enabled;
                $arr_data['machine_is_cost_center_enabled'] = $row->machine_is_cost_center_enabled;
                $arr_data['machine_is_gift_enabled'] = $row->machine_is_gift_enabled;
                $arr_data['newsletter_enabled'] = $row->newsletter_enabled;
                $arr_data['serial_port_speed'] = $row->serial_port_speed;
                $arr_data['screen_orientation'] = $row->screen_orientation;
                $arr_data['screen_size'] = $row->screen_size;
                $arr_data['machine_client_id'] = $row->machine_client_id;
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

    public function deleteMachine()
    {
        log_message('debug', 'deleteMachine');
        if ($this->checkToken($this->input->request_headers())) {
            $data = array(
                'status' => '0',
            );
            $this->db->where('username', $this->input->post('machine_username'));
            $this->db->update('user', $data);
            $this->Machine_model->deleteMachine($this->input->post('machine_id'), $this->input->post('machine_name'), $this->input->post('machine_username'));
            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->delete('machine_product_map');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getMachineData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $result = $this->db->get('machine')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['machine_name'] = $row->machine_name;
                $arr_data[$i]['machine_row'] = $row->machine_row;
                $arr_data[$i]['machine_column'] = $row->machine_column;
                $arr_data[$i]['machine_upt_no'] = $row->machine_upt_no;
                $arr_data[$i]['machine_username'] = $row->machine_username;
                $arr_data[$i]['machine_latitude'] = $row->machine_latitude;
                $arr_data[$i]['machine_longitude'] = $row->machine_longitude;
                $arr_data[$i]['machine_is_single_category'] = $row->machine_is_single_category;
                $arr_data[$i]['machine_mode'] = $row->machine_mode;
                $arr_data[$i]['machine_address'] = $row->machine_address;
                $arr_data[$i]['serial_port_number'] = $row->serial_port_number;
                $arr_data[$i]['machine_passcode_screen'] = $row->machine_passcode_screen;
                $arr_data[$i]['advertisement_type'] = $row->advertisement_type;
                $arr_data[$i]['machine_advertisement_mode'] = $row->machine_advertisement_mode;
                $arr_data[$i]['machine_is_game_enabled'] = $row->machine_is_game_enabled;
                $arr_data[$i]['machine_game'] = $row->machine_game;
                $arr_data[$i]['machine_info_button_enabled'] = $row->machine_info_button_enabled;
                $arr_data[$i]['machine_screensaver_enabled'] = $row->machine_screensaver_enabled;
                $arr_data[$i]['machine_volume_control_enabled'] = $row->machine_volume_control_enabled;
                $arr_data[$i]['machine_wheel_chair_enabled'] = $row->machine_wheel_chair_enabled;
                $arr_data[$i]['machine_is_asset_tracking'] = $row->machine_is_asset_tracking;
                $arr_data[$i]['machine_is_advertisement_reporting'] = $row->machine_is_advertisement_reporting;
                $arr_data[$i]['machine_is_feed_enabled'] = $row->machine_is_feed_enabled;
                $arr_data[$i]['machine_helpline'] = $row->machine_helpline;
                $arr_data[$i]['machine_helpline_enabled'] = $row->machine_helpline_enabled;
                $arr_data[$i]['receipt_enabled'] = $row->receipt_enabled;
                $arr_data[$i]['machine_is_job_number_enabled'] = $row->machine_is_job_number_enabled;
                $arr_data[$i]['machine_is_cost_center_enabled'] = $row->machine_is_cost_center_enabled;
                $arr_data[$i]['machine_is_gift_enabled'] = $row->machine_is_gift_enabled;
                $arr_data[$i]['newsletter_enabled'] = $row->newsletter_enabled;
                $arr_data[$i]['serial_port_speed'] = $row->serial_port_speed;
                $arr_data[$i]['screen_orientation'] = $row->screen_orientation;
                $arr_data[$i]['screen_size'] = $row->screen_size;
                $arr_data[$i]['machine_client_id'] = $row->machine_client_id;
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

    public function addMachine()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside addMachine');
            $data = array(
                'machine_username' => $this->input->post('machine_username'),
                'machine_row' => $this->input->post('machine_row'),
                'machine_column' => $this->input->post('machine_column'),
                'machine_upt_no' => $this->input->post('machine_upt_no'),
                'machine_name' => $this->input->post('machine_name'),
                'machine_client_id' => $this->input->post('machine_client_id'),
                'machine_address' => $this->input->post('machine_address'),
                'machine_latitude' => $this->input->post('machine_latitude'),
                'machine_longitude' => $this->input->post('machine_longitude'),
                'machine_is_single_category' => $this->input->post('machine_is_single_category'),
            );
            $this->Machine_model->createMachine($data);

            $this->db->where('machine_name', $this->input->post('machine_name'));
            $machine_object = $this->db->get('machine')->result();

            /* for ($i = 1; $i <= $this->input->post('machine_row') * 10  $this->input->post('machine_column') ; $i++) {
            $data = array(
            'machine_id' => $machine_object[0]->id,
            'product_location' => $i);
            $this->db->insert('machine_product_map', $data);
            } */

            for ($i = 0; $i < $this->input->post('machine_row'); $i++) {
                for ($j = 1; $j <= $this->input->post('machine_column'); $j++) {
                    $z = ($i * 10) + $j;
                    if ($z < 10) {
                        $z = '0' . $z;
                    }
                    $data = array(
                        'machine_id' => $machine_object[0]->id,
                        'product_location' => $z,
                    );
                    $this->db->insert('machine_product_map', $data);
                }
            }

            $data = array(
                'status' => '1',
            );
            $this->db->where('username', $this->input->post('machine_username'));
            $this->db->where('upt_no', $this->input->post('machine_upt_no'));
            $this->db->update('user', $data);

            $arr = array('code' => 200, 'msg' => "OK");
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function updateMachine()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside addMachine');
            $data = array(
                'machine_username' => $this->input->post('machine_username'),
                'machine_upt_no' => $this->input->post('machine_upt_no'),
                'machine_name' => $this->input->post('machine_name'),
                'machine_address' => $this->input->post('machine_address'),
                'machine_latitude' => $this->input->post('machine_latitude'),
                'machine_longitude' => $this->input->post('machine_longitude'),
            );
            $this->db->where('id', $this->input->post('machine_id'));
            $q = $this->db->get('machine');
            if ($q->num_rows() > 0) {
                $this->db->where('id', $this->input->post('machine_id'));
                $this->db->update('machine', $data);
            }

            if ($this->input->post('machine_upt_no') != $this->input->post('machine_old_upt_no')) {
                $data = array(
                    'status' => '1',
                );
                $this->db->where('upt_no', $this->input->post('machine_upt_no'));
                $this->db->update('user', $data);

                $data = array(
                    'status' => '0',
                );
                $this->db->where('upt_no', $this->input->post('machine_old_upt_no'));
                $this->db->update('user', $data);
            }

            $arr = array('code' => 200, 'msg' => "OK");
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function assignProductToMachine() // Not Used

    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside assignProductToMachine');

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->where('category_id', $this->input->post('category_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $this->db->where('product_location', $this->input->post('product_location'));
            $q = $this->db->get('machine_assign_product');
            if ($q->num_rows() > 0) {
                $result = $q->result();
                foreach ($result as $row) {

                    $current_quantity = $row->product_quantity;
                    log_message('debug', 'Current Quantity 2' . $current_quantity);
                    $data = array(
                        'machine_id' => $this->input->post('machine_id'),
                        'category_id' => $this->input->post('category_id'),
                        'product_id' => $this->input->post('product_id'),
                        'product_location' => $this->input->post('product_location'),
                        'product_quantity' => $this->input->post('product_quantity') + $current_quantity,
                    );
                    $this->db->where('machine_id', $this->input->post('machine_id'));
                    $this->db->where('category_id', $this->input->post('category_id'));
                    $this->db->where('product_id', $this->input->post('product_id'));
                    $this->db->where('product_location', $this->input->post('product_location'));
                    $this->db->update('machine_assign_product', $data);
                }
            } else {
                $data = array(
                    'machine_id' => $this->input->post('machine_id'),
                    'category_id' => $this->input->post('category_id'),
                    'product_id' => $this->input->post('product_id'),
                    'product_location' => $this->input->post('product_location'),
                    'product_quantity' => $this->input->post('product_quantity'),
                );
                $this->db->insert('machine_assign_product', $data);
            }

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->where('category_id', $this->input->post('category_id'));
            $q = $this->db->get('machine_assign_category');
            if ($q->num_rows() === 0) {
                $data = array(
                    'machine_id' => $this->input->post('machine_id'),
                    'category_id' => $this->input->post('category_id'),
                );
                $this->db->insert('machine_assign_category', $data);
            }
            $arr = array('code' => 200, 'msg' => "OK");
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getMachineMapData()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $result = $this->db->get('machine_product_map')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {

                $this->db->select("product_price");
                $this->db->from('product');
                $this->db->where('product_id', $row->product_id);
                $query1 = $this->db->get();
                $result1 = $query1->result();
                $arr_data[$i]['product_price'] = "";
                foreach ($result1 as $row1) {
                    $arr_data[$i]['product_price'] = "$ " . $row1->product_price;
                }
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['machine_id'] = $row->machine_id;
                $arr_data[$i]['category_id'] = $row->category_id;
                $arr_data[$i]['product_id'] = $row->product_id;
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['product_image'] = $row->product_image;
                $arr_data[$i]['product_location'] = $row->product_location;
                $arr_data[$i]['product_quantity'] = $row->product_quantity;
                $i++;
            }
            log_message('debug', $i);
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function setMachineId()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $currentMachineId = array(
                'machine_id' => $this->input->post('machine_id'),
            );
            log_message('debug', $this->input->post('machine_id') . "dd");
            $this->session->set_userdata($currentMachineId);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function setProductMachineMapId()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $currentMachineId = array(
                'product_machine_map_id' => $this->input->post('product_machine_map_id'),
            );
            log_message('debug', $this->input->post('product_machine_map_id') . "dd");
            $this->session->set_userdata($currentMachineId);

            $currentProductLocation = array(
                'current_machine_location' => $this->input->post('product_location'),
            );
            log_message('debug', $this->input->post('product_location') . "dd");
            $this->session->set_userdata($currentProductLocation);

            $currentProductQuantity = array(
                'current_machine_quantity' => $this->input->post('product_quantity'),
            );
            log_message('debug', $this->input->post('product_quantity') . "dd");
            $this->session->set_userdata($currentProductQuantity);

            $currentMachineMapId = array(
                'current_machine_id' => $this->input->post('selected_machine_id'),
            );
            log_message('debug', $this->input->post('selected_machine_id') . "dd");
            $this->session->set_userdata($currentMachineMapId);

            $currentCategoryId = array(
                'current_category_id' => $this->input->post('category_id'),
            );
            log_message('debug', $this->input->post('selected_category_id') . "dd");
            $this->session->set_userdata($currentCategoryId);

            $currentProductName = array(
                'current_product_name' => $this->input->post('product_name'),
            );
            log_message('debug', $this->input->post('selected_product_name') . "dd");
            $this->session->set_userdata($currentProductName);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getProductMachineMapLocation()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside getProductMachineMapId');
            log_message('debug', $this->session->userdata('current_machine_location'));
            $arr_data['product_location'] = $this->session->userdata('current_machine_location');
            $arr_data['product_quantity'] = $this->session->userdata('current_machine_quantity');
            $arr_data['product_machine_map_id'] = $this->session->userdata('product_machine_map_id');
            $arr_data['product_name'] = $this->session->userdata('current_product_name');
            $arr_data['category_id'] = $this->session->userdata('current_category_id');
            $this->db->where('id', $this->session->userdata('current_machine_id'));
            $result = $this->db->get('machine')->result();
            foreach ($result as $row) {
                $arr_data['machine_is_single_category'] = $row->machine_is_single_category;
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

    public function assignProductToMachineMap()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside assignProductToMachineMap');

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->where('product_map_id', $this->input->post('id'));
            $q = $this->db->get('machine_assign_product');
            if ($q->num_rows() > 0) {
                $result = $q->result();
                foreach ($result as $row) {

                    $current_quantity = $row->product_quantity;
                    log_message('debug', 'Current Quantity 3' . $current_quantity);
                    $data = array(
                        'machine_id' => $this->input->post('machine_id'),
                        'category_id' => $this->input->post('category_id'),
                        'product_id' => $this->input->post('product_id'),
                        'product_map_id' => $this->input->post('id'),
                        'product_location' => $this->input->post('product_location'),
                        'product_quantity' => $this->input->post('product_quantity'),
                    );
                    $this->db->where('machine_id', $this->input->post('machine_id'));
                    $this->db->where('product_map_id', $this->input->post('id'));
                    $this->db->update('machine_assign_product', $data);
                }
            } else {
                $data = array(
                    'machine_id' => $this->input->post('machine_id'),
                    'category_id' => $this->input->post('category_id'),
                    'product_id' => $this->input->post('product_id'),
                    'product_map_id' => $this->input->post('id'),
                    'product_location' => $this->input->post('product_location'),
                    'product_quantity' => $this->input->post('product_quantity'),
                );
                $this->db->insert('machine_assign_product', $data);
            }

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->where('category_id', $this->input->post('category_id'));
            $q = $this->db->get('machine_assign_category');
            if ($q->num_rows() === 0) {
                $data = array(
                    'machine_id' => $this->input->post('machine_id'),
                    'category_id' => $this->input->post('category_id'),
                );
                $this->db->insert('machine_assign_category', $data);
            }

            $this->db->where('id', $this->input->post('id'));
            $q = $this->db->get('machine_product_map');
            if ($q->num_rows() > 0) {
                $result = $q->result();
                foreach ($result as $row) {
                    log_message('debug', 'Machine Map Product Updated');

                    //$current_quantity = $row->product_quantity;
                    $data = array(
                        'machine_id' => $this->input->post('machine_id'),
                        'category_id' => $this->input->post('category_id'),
                        'product_id' => $this->input->post('product_id'),
                        'product_name' => $this->input->post('product_name'),
                        'product_image' => $this->input->post('product_image'),
                        'product_location' => $this->input->post('product_location'),
                        'product_quantity' => $this->input->post('product_quantity'),
                    );
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('machine_product_map', $data);
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

    public function cloneMachine()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $oldMachineId = $this->input->post('machine_id');
            $newMachineId = "";
            log_message('debug', 'cloneMachine');

            $this->db->where('id', $this->input->post('machine_id'));
            $result = $this->db->get('machine')->result();

            foreach ($result as $row) {
                $arr_data['machine_name'] = $this->input->post('machine_name');
                $arr_data['machine_row'] = $row->machine_row;
                $arr_data['machine_column'] = $row->machine_column;
                $arr_data['machine_upt_no'] = $this->input->post('machine_upt_no');
                $arr_data['machine_latitude'] = $this->input->post('machine_latitude');
                $arr_data['machine_username'] = $this->input->post('machine_username');
                $arr_data['machine_longitude'] = $this->input->post('machine_longitude');
                $arr_data['machine_address'] = $this->input->post('machine_address');
                $arr_data['machine_is_single_category'] = $row->machine_is_single_category;
                $arr_data['machine_mode'] = $row->machine_mode;
                $arr_data['machine_client_id'] = $row->machine_client_id;
                $arr_data['advertisement_type'] = $row->advertisement_type;
                $arr_data['serial_port_number'] = $row->serial_port_number;
                $arr_data['machine_passcode_screen'] = $row->machine_passcode_screen;
                $arr_data['machine_advertisement_mode'] = $row->machine_advertisement_mode;
                $arr_data['machine_is_game_enabled'] = $row->machine_is_game_enabled;
                $arr_data['machine_game'] = $row->machine_game;
                $arr_data['machine_info_button_enabled'] = $row->machine_info_button_enabled;
                $arr_data['machine_screensaver_enabled'] = $row->machine_screensaver_enabled;
                $arr_data['machine_volume_control_enabled'] = $row->machine_volume_control_enabled;
                $arr_data['machine_wheel_chair_enabled'] = $row->machine_wheel_chair_enabled;
                $arr_data['machine_is_asset_tracking'] = $row->machine_is_asset_tracking;
                $arr_data['machine_is_advertisement_reporting'] = $row->machine_is_advertisement_reporting;
                $arr_data['machine_is_feed_enabled'] = $row->machine_is_feed_enabled;
                $arr_data['machine_helpline'] = $row->machine_helpline;
                $arr_data['machine_helpline_enabled'] = $row->machine_helpline_enabled;
                $arr_data['receipt_enabled'] = $row->receipt_enabled;
                $arr_data['machine_customer_care_number'] = $row->machine_customer_care_number;
                $arr_data['machine_is_job_number_enabled'] = $row->machine_is_job_number_enabled;
                $arr_data['machine_is_cost_center_enabled'] = $row->machine_is_cost_center_enabled;
                $arr_data['machine_is_gift_enabled'] = $row->machine_is_gift_enabled;
                $arr_data['newsletter_enabled'] = $row->newsletter_enabled;
                $arr_data['serial_port_speed'] = $row->serial_port_speed;
                $arr_data['screen_orientation'] = $row->screen_orientation;
                $arr_data['screen_size'] = $row->screen_size;
                $arr_data['machine_client_id'] = $row->machine_client_id;

                $machineName = $this->input->post('machine_name');
            }
            $this->db->insert('machine', $arr_data);

            $this->db->where('machine_name', $machineName);
            $machine_object = $this->db->get('machine')->result();
            foreach ($machine_object as $row) {
                $newMachineId = $row->id;
            }

            $this->db->where('machine_id', $oldMachineId);
            $product_map_array = $this->db->get('machine_product_map')->result();

            foreach ($product_map_array as $row) {
                $data['machine_id'] = $newMachineId;
                $data['category_id'] = $row->category_id;
                $data['product_id'] = $row->product_id;
                $data['product_name'] = $row->product_name;
                $data['product_image'] = $row->product_image;
                $data['product_location'] = $row->product_location;
                $data['product_quantity'] = $row->product_quantity;
                $this->db->insert('machine_product_map', $data);
            }

            $this->db->where('machine_id', $oldMachineId);
            $machine_assign_category_array = $this->db->get('machine_assign_category')->result();

            foreach ($machine_assign_category_array as $row) {
                $assign_category['machine_id'] = $newMachineId;
                $assign_category['category_id'] = $row->category_id;
                $this->db->insert('machine_assign_category', $assign_category);
            }

            $this->db->where('machine_id', $oldMachineId);
            $machine_assign_product_array = $this->db->get('machine_assign_product')->result();

            foreach ($machine_assign_product_array as $row) {
                $assign_product['machine_id'] = $newMachineId;
                $assign_product['category_id'] = $row->category_id;
                $assign_product['product_id'] = $row->product_id;
                $assign_product['product_location'] = $row->product_location;
                $assign_product['product_quantity'] = $row->product_quantity;

                $this->db->where('machine_id', $newMachineId);
                $this->db->where('product_id', $row->product_id);
                $this->db->where('product_location', $row->product_location);
                $q = $this->db->get('machine_product_map');
                if ($q->num_rows() > 0) {
                    $result = $q->result();
                    foreach ($result as $row) {
                        $product_map_id = $row->id;
                    }
                }

                $assign_product['product_map_id'] = $product_map_id;
                log_message('debug', 'Product Map ID : ' . $product_map_id);
                $this->db->insert('machine_assign_product', $assign_product);
            }

            $this->db->where('machine_id', $oldMachineId);
            $advertisement_assign_array = $this->db->get('advertisement_assign')->result();

            foreach ($advertisement_assign_array as $row) {
                $advertisement_assign['advertisement_id'] = $row->advertisement_id;
                $advertisement_assign['client_id'] = $row->client_id;
                $advertisement_assign['machine_id'] = $newMachineId;
                $advertisement_assign['position'] = $row->position;
                $advertisement_assign['start_date'] = $row->start_date;
                $advertisement_assign['end_date'] = $row->end_date;
                $this->db->insert('advertisement_assign', $advertisement_assign);
            }

            $data = array(
                'status' => '1',
            );
            $this->db->where('upt_no', $this->input->post('machine_upt_no'));
            $this->db->update('user', $data);

            $arr_data['id'] = $newMachineId;
            $arr = array('code' => 200, 'data' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function checkAvailability()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('machine_name', $this->input->post('machine_name'));
            $this->db->where('machine_client_id', $this->input->post('machine_client_id'));
            $q = $this->db->get('machine');
            if ($q->num_rows() > 0) {
                $arr_data['status'] = false;
            } else {
                $arr_data['status'] = true;
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

    public function configureMachine()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'configureMachine');
            $data = array(
                'machine_mode' => $this->input->post('machine_mode'),
                'serial_port_number' => $this->input->post('serial_port_number'),
                'serial_port_speed' => $this->input->post('serial_port_speed'),
                'screen_size' => $this->input->post('screen_size'),
                'screen_orientation' => $this->input->post('screen_orientation'),
                'machine_passcode_screen' => $this->input->post('machine_passcode_screen'),
                'advertisement_type' => $this->input->post('advertisement_type'),
                'machine_advertisement_mode' => $this->input->post('machine_advertisement_mode'),
                'machine_is_game_enabled' => $this->input->post('machine_is_game_enabled'),
                'machine_game' => $this->input->post('machine_game'),
                'machine_info_button_enabled' => $this->input->post('machine_info_button_enabled'),
                'machine_screensaver_enabled' => $this->input->post('machine_screensaver_enabled'),
                'machine_volume_control_enabled' => $this->input->post('machine_volume_control_enabled'),
                'machine_is_asset_tracking' => $this->input->post('machine_is_asset_tracking'),
                'machine_is_advertisement_reporting' => $this->input->post('machine_is_advertisement_reporting'),
                'machine_wheel_chair_enabled' => $this->input->post('machine_wheel_chair_enabled'),
                'machine_is_feed_enabled' => $this->input->post('machine_is_feed_enabled'),
                'machine_helpline' => $this->input->post('machine_helpline'),
                'machine_helpline_enabled' => $this->input->post('machine_helpline_enabled'),
                'receipt_enabled' => $this->input->post('receipt_enabled'),
                'machine_customer_care_number' => $this->input->post('machine_customer_care_number'),
                'machine_is_job_number_enabled' => $this->input->post('machine_is_job_number_enabled'),
                'machine_is_cost_center_enabled' => $this->input->post('machine_is_cost_center_enabled'),
                'machine_is_gift_enabled' => $this->input->post('machine_is_gift_enabled'),
                'newsletter_enabled' => $this->input->post('newsletter_enabled'),
                'machine_is_single_category' => $this->input->post('machine_is_single_category'),
            );
            $this->db->where('id', $this->input->post('machine_id'));
            $this->db->update('machine', $data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function resetMachineMapByLocation()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'resetMachineMapByLocation');
            $data = array(
                'machine_id' => $this->input->post('machine_id'),
                'category_id' => "",
                'product_id' => "",
                'product_name' => "",
                'product_image' => "ngapp/assets/images/product/thumbnail/no_product.png",
                'product_location' => $this->input->post('product_location'),
                'product_quantity' => "0",
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('machine_product_map', $data);

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->where('product_location', $this->input->post('product_location'));
            $this->db->delete('machine_assign_product');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function resetMachineMapByMachineIdValue()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'resetMachineMapByMachineId');
            $data = array(
                'machine_id' => $this->input->post('machine_id'),
                'category_id' => "",
                'product_id' => "",
                'product_name' => "",
                'product_image' => "ngapp/assets/images/product/thumbnail/no_product.png",
                'product_quantity' => "0",
            );
            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->update('machine_product_map', $data);

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->delete('machine_assign_category');

            $this->db->where('machine_id', $this->input->post('machine_id'));
            $this->db->delete('machine_assign_product');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function resetMachineMapByMachineId()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'resetMachineMapByMachineId');
            $data = array(
                'machine_id' => $this->session->userdata('machine_id'),
                'category_id' => "",
                'product_id' => "",
                'product_name' => "",
                'product_image' => "ngapp/assets/images/product/thumbnail/no_product.png",
                'product_quantity' => "0",
            );
            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $this->db->update('machine_product_map', $data);

            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $this->db->delete('machine_assign_category');

            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $this->db->delete('machine_assign_product');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function uploadProductPlanogram()
    {

        $this->db->where('id', $this->session->userdata('machine_id'));
        $result = $this->db->get('machine')->result();
        foreach ($result as $row) {
            $isSingleCategory = $row->machine_is_single_category;
        }
        log_message('debug', 'Product CSV : ' . $isSingleCategory);
        $config['upload_path'] = 'ngapp/assets/csv/planogram/';
        $config['allowed_types'] = 'csv|xls|xlsx';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploadedFile = $this->upload->data();
            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->spreadsheet_excel_reader->read($uploadedFile['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];
            error_reporting(0);
            $data_excel = array();
            $error_text = ' ';
            $success_text = ' ';
            $noOfProductsUpdated = 0;
            $noOfError = 0;

            $clientId = $this->session->userdata('client_id');
            $this->db->where('id', $this->session->userdata('machine_id'));
            $machineModels = $this->db->get('machine');
            if ($machineModels->num_rows() > 0) {
                $result = $machineModels->result();
                foreach ($result as $row) {
                    $clientId = $row->machine_client_id;
                }
            }

            $data = array(
                'machine_id' => $this->session->userdata('machine_id'),
                'category_id' => "",
                'product_id' => "",
                'product_name' => "",
                'product_image' => "ngapp/assets/images/product/thumbnail/no_product.png",
                'product_quantity' => "0",
            );
            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $this->db->update('machine_product_map', $data);

            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $this->db->delete('machine_assign_category');

            $this->db->where('machine_id', $this->session->userdata('machine_id'));
            $this->db->delete('machine_assign_product');

            for ($i = 2; $i <= $sheets['numRows']; $i++) {
                if ($sheets['cells'][$i][1] == '') {
                    break;
                }

                $product_id = $sheets['cells'][$i][1];

                if ($isSingleCategory) {
                    $category_id = 'no_category';
                    $quantity = $sheets['cells'][$i][2];
                    $location_string = $sheets['cells'][$i][3];
                } else {
                    $category_id = $sheets['cells'][$i][2];
                    $quantity = $sheets['cells'][$i][3];
                    $location_string = $sheets['cells'][$i][4];
                }

                $this->db->where('product_id', $product_id);
                $this->db->where('client_id', $clientId);
                $q = $this->db->get('product');

                if ($q->num_rows() > 0) {
                    $result = $q->result();
                    foreach ($result as $row) {
                        $product_name = $row->product_name;
                        $product_image = $row->product_image;
                    }

                    if (!$isSingleCategory) {
                        $this->db->where('category_id', $category_id);
                        $category_query = $this->db->get('category');
                        $noOfCategory = $category_query->num_rows();
                    } else {
                        $noOfCategory = 1;
                    }
                    if ($noOfCategory > 0) {
                        $locations = explode(',', $location_string);
                        foreach ($locations as $location) {
                            $location = trim($location);
                            if ($location < 10 && strlen($location) == 1) {
                                $location = '0' . $location;
                            }

                            $this->db->where('machine_id', $this->session->userdata('machine_id'));
                            $this->db->where('product_location', $location);
                            $location_query = $this->db->get('machine_product_map');
                            if ($location_query->num_rows() > 0) {

                                $data = array(
                                    'machine_id' => $this->session->userdata('machine_id'),
                                    'category_id' => $category_id,
                                    'product_id' => $product_id,
                                    'product_name' => $product_name,
                                    'product_image' => $product_image,
                                    'product_location' => $location,
                                    'product_quantity' => $quantity,
                                );
                                $this->db->where('machine_id', $this->session->userdata('machine_id'));
                                $this->db->where('product_location', $location);
                                $this->db->update('machine_product_map', $data);

                                $noOfProductsUpdated++;

                                $this->db->where('machine_id', $this->session->userdata('machine_id'));
                                $this->db->where('product_id', $product_id);
                                $this->db->where('product_location', $location);
                                $q = $this->db->get('machine_product_map');
                                if ($q->num_rows() > 0) {
                                    $result = $q->result();
                                    foreach ($result as $row) {
                                        $product_map_id = $row->id;
                                    }
                                }

                                $this->db->where('machine_id', $this->session->userdata('machine_id'));
                                $this->db->where('product_map_id', $product_map_id);
                                $this->db->where('product_location', $location);
                                $q = $this->db->get('machine_assign_product');
                                if ($q->num_rows() > 0) {
                                    $result = $q->result();
                                    foreach ($result as $row) {
                                        $data = array(
                                            'machine_id' => $this->session->userdata('machine_id'),
                                            'category_id' => $category_id,
                                            'product_id' => $product_id,
                                            'product_map_id' => $product_map_id,
                                            'product_location' => $location,
                                            'product_quantity' => $quantity,
                                        );
                                        $this->db->where('machine_id', $this->session->userdata('machine_id'));
                                        $this->db->where('product_location', $location);
                                        $this->db->update('machine_assign_product', $data);
                                    }
                                } else {
                                    $data = array(
                                        'machine_id' => $this->session->userdata('machine_id'),
                                        'category_id' => $category_id,
                                        'product_id' => $product_id,
                                        'product_map_id' => $product_map_id,
                                        'product_location' => $location,
                                        'product_quantity' => $quantity,
                                    );
                                    $this->db->insert('machine_assign_product', $data);
                                }

                                $this->db->where('machine_id', $this->session->userdata('machine_id'));
                                $this->db->where('category_id', $category_id);
                                $q = $this->db->get('machine_assign_category');
                                if ($q->num_rows() === 0) {
                                    $data = array(
                                        'machine_id' => $this->session->userdata('machine_id'),
                                        'category_id' => $category_id,
                                    );
                                    $this->db->insert('machine_assign_category', $data);
                                }

                                log_message('debug', 'Product CSV : ' . $product_id . ' + ' . $product_name . ' + ' . $product_image . ' + ' . $category_id . ' . ' . $quantity . ' . ' . $location);
                            } else {
                                $error_text = $error_text . 'Row : ' . $i . ' Product Location Code : ' . $location . ' not present;';
                                log_message('debug', 'Product CSV : Error Found - ' . $error_text);
                                $noOfError++;
                            }
                        }
                    } else {
                        $error_text = $error_text . 'Row : ' . $i . ' Category Code : ' . $category_id . ' not found;';
                        log_message('debug', 'Product CSV : Error Found - ' . $error_text);
                        $noOfError++;
                    }
                } else {
                    $error_text = $error_text . 'Row : ' . $i . ' Product Code : ' . $product_id . ' not found;';
                    log_message('debug', 'Product CSV : Error Found - ' . $error_text);
                    $noOfError++;
                }
            }
            $success_text = 'No of Aisle Updated Successfully : ' . $noOfProductsUpdated;
            $error_text = 'Total Error : ' . $noOfError . ';' . $error_text;
            log_message('debug', 'Product CSV : Success - ' . $success_text);
            log_message('debug', 'Product CSV : Error - ' . $error_text);
        }
        $arr_data['success'] = $success_text;
        $arr_data['error'] = $error_text;
        $arr_data['no_of_product_updated'] = $noOfProductsUpdated;
        $arr_data['no_of_error'] = $noOfError;
        echo json_encode($arr_data);
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
