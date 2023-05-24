<?php

class Advertisement_Image_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Advertisement_Image_model");
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }


    function getData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $result = $this->db->get('advertisement_image')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['client_id'] = $row->client_id;

                $this->db->select("*");
                $this->db->from('client');
                $this->db->where('id', $row->client_id);
                $query1 = $this->db->get();
                $result1 = $query1->result();
                foreach ($result1 as $row1) {
                    $arr_data[$i]['client_name'] = $row1->client_name;
                }

                $arr_data[$i]['machine_id'] = $row->machine_id;
                $this->db->select("*");
                $this->db->from('machine');
                $this->db->where('id', $row->machine_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['machine_name'] = $row2->machine_name;
                }


                $arr_data[$i]['image_advertisement_title'] = $row->image_advertisement_title;
                $arr_data[$i]['image_advertisement_relative_url'] = $row->image_advertisement_url;
                $arr_data[$i]['image_advertisement_url'] = "http://tcn.vendportal.com/" . $row->image_advertisement_url;
                $arr_data[$i]['image_position'] = $row->image_position;
                if ($row->start_date === "0000-00-00") {
                    $arr_data[$i]['start_date'] = '';
                } else {
                    $arr_data[$i]['start_date'] = date('d-m-Y', strtotime($row->start_date));
                }

                if ($row->end_date === "0000-00-00") {
                    $arr_data[$i]['end_date'] = '';
                } else {
                    $arr_data[$i]['end_date'] = date('d-m-Y', strtotime($row->end_date));
                }

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

    function getDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            $this->db->where('client_id', $this->input->post('client_id'));
            $result = $this->db->get('advertisement_image')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['client_id'] = $row->client_id;

                $this->db->where('id', $row->client_id);
                $this->db->select("*");
                $this->db->from('client');
                $query1 = $this->db->get();
                $result1 = $query1->result();
                foreach ($result1 as $row1) {
                    $arr_data[$i]['client_name'] = $row1->client_name;
                }

                $arr_data[$i]['machine_id'] = $row->machine_id;
                $this->db->select("*");
                $this->db->from('machine');
                $this->db->where('id', $row->machine_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['machine_name'] = $row2->machine_name;
                }

                $arr_data[$i]['image_advertisement_title'] = $row->image_advertisement_title;
                $arr_data[$i]['image_advertisement_relative_url'] = $row->image_advertisement_url;
                $arr_data[$i]['image_advertisement_url'] = "http://tcn.vendportal.com/" . $row->image_advertisement_url;
                $arr_data[$i]['image_position'] = $row->image_position;
                if ($row->start_date === "0000-00-00") {
                    $arr_data[$i]['start_date'] = '';
                } else {
                    $arr_data[$i]['start_date'] = date('d-m-Y', strtotime($row->start_date));
                }

                if ($row->end_date === "0000-00-00") {
                    $arr_data[$i]['end_date'] = '';
                } else {
                    $arr_data[$i]['end_date'] = date('d-m-Y', strtotime($row->end_date));
                }
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


    function deleteImageAdvertisementController()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside deleteImageAdvertisementController' . $this->input->post('id') . ' ' . $this->input->post('image_advertisement_relative_url'));
            $this->Advertisement_Image_model->deleteImageAdvertisement($this->input->post('id'));
            if (is_readable($this->input->post('image_advertisement_relative_url')) && unlink($this->input->post('image_advertisement_relative_url'))) {
                log_message('debug', 'The file has been deleted Original Image');
            } else {
                log_message('debug', 'The file was not found or not readable and could not be deleted Original Image');
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

    public function uploadImageAdvertisement()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside uploadAdvertisement');
            $data = array(
                'client_id' => $this->input->post('client_id'),
                'machine_id' => $this->input->post('machine_id'),
                'image_advertisement_title' => $this->input->post('image_advertisement_title'),
                'image_advertisement_url' => $this->input->post('image_advertisement_url'),
                'image_position' => $this->input->post('image_position'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date')
            );
            $this->Advertisement_Image_model->createImageAdvertisement($data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function uploadFile()
    {
        $filename = date('YmdHis');
        log_message('debug', 'Inside uploadFile');
        ini_set('upload_max_filesize', '200M');
        ini_set('post_max_size', '200M');
        ini_set('max_input_time', 3000);
        ini_set('max_execution_time', 3000);
        $config['upload_path']   = 'ngapp/assets/images/ads/original/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '100000';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $filename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploadedVideo = $this->upload->data();
            echo json_encode($uploadedVideo['file_name']);
            log_message('debug', 'done');
        } else {
            log_message('debug', 'failed');
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
