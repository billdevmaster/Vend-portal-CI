<?php
class Category_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Category_model");
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    function getData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $result = $this->db->get('category')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['category_id'] = $row->category_id;
                $arr_data[$i]['category_name'] = $row->category_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['category_image'] = $row->category_image;
                $arr_data[$i]['category_image_thumbnail'] = $row->category_image_thumbnail;
                $i++;
            }
            $response = array('code' => 200, 'category' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($response);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }


    function getDataByClientId()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('client_id', $this->input->post('client_id'));
            $result = $this->db->get('category')->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['category_id'] = $row->category_id;
                $arr_data[$i]['category_name'] = $row->category_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['category_image'] = $row->category_image;
                $arr_data[$i]['category_image_thumbnail'] = $row->category_image_thumbnail;
                $i++;
            }
            $response = array('code' => 200, 'category' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($response);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }


    function deleteCategory()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside deleteCategoryImage' . $this->input->post('category_id'));
            $this->Category_model->deleteCategory($this->input->post('category_id'));
            if ('ngapp/assets/img/default_category.png' != $this->input->post('category_image')) {
                if (is_readable($this->input->post('category_image')) && unlink($this->input->post('category_image'))) {
                    log_message('debug', 'The file has been deleted Original Image');
                } else {
                    log_message('debug', 'The file was not found or not readable and could not be deleted Original Image');
                }
            }
            if ('ngapp/assets/img/default_category.png' != $this->input->post('category_image_thumbnail')) {
                if (is_readable($this->input->post('category_image_thumbnail')) && unlink($this->input->post('category_image_thumbnail'))) {
                    log_message('debug', 'The file has been deleted Thumbnail');
                } else {
                    log_message('debug', 'The file was not found or not readable and could not be deleted Thumbnail');
                }
            }
            $arr = array('code' => 200, 'msg' => "Deleted Successfully");
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }


    function deleteImage()
    {
        if ($this->checkToken($this->input->request_headers())) {
            if (is_readable($this->input->post('category_image')) && unlink($this->input->post('category_image'))) {
                log_message('debug', 'The file has been deleted Original Image');
            } else {
                log_message('debug', 'The file was not found or not readable and could not be deleted Original Image');
            }

            if (is_readable($this->input->post('category_image_thumbnail')) && unlink($this->input->post('category_image_thumbnail'))) {
                log_message('debug', 'The file has been deleted Thumbnail');
            } else {
                log_message('debug', 'The file was not found or not readable and could not be deleted Thumbnail');
            }
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function addCategory()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside addCategory');
            $data = array(
                'category_id' => $this->input->post('category_id'),
                'category_name' => $this->input->post('category_name'),
                'client_id' => $this->input->post('client_id'),
                'category_image' => $this->input->post('category_image'),
                'category_image_thumbnail' => $this->input->post('category_image_thumbnail')
            );
            $this->Category_model->createCategory($data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function uploadCategoryImage()
    {
        $filename = date('YmdHis');
        log_message('debug', 'Inside uploadCategoryImage');
        //$this->Career_model->createCandidate();
        $config['upload_path']   = 'ngapp/assets/images/category/original/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '4096';
        $config['file_name'] = $filename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            log_message('debug', 'done');
            $uploadedImage = $this->upload->data();
            log_message('debug', $uploadedImage['file_name']);
            $this->resizeImage($uploadedImage['file_name']);
            echo json_encode($uploadedImage['file_name']);
        } else {
            show_error($this->upload->print_debugger());
        }
    }

    public function resizeImage($filename)
    {
        $source_path = 'ngapp/assets/images/category/original/' . $filename;
        $target_path = 'ngapp/assets/images/category/thumbnail/';
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => FALSE,
            'width' => 200,
            'height' => 200
        );


        $this->load->library('image_lib', $config_manip);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    public function checkCategoryIdValidity()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside checkCategoryIdValidity');
            $this->db->where('client_id', $this->input->post('client_id'));
            $this->db->where('category_id', $this->input->post('category_id'));
            $query = $this->db->get('category');
            $arr_data['isPresent'] = null;
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'category_id';
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

    public function uploadCategoryList()
    {
        log_message('debug', 'uploadCategoryList');
        $config['upload_path']   = 'ngapp/assets/csv/category/';
        $config['allowed_types'] = 'csv|xls|xlsx';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploadedFile = $this->upload->data();
            //  @chmod($uploadedFile['full_path'], 0777);
            $error_text = ' ';
            $success_text = ' ';
            $noOfCategoryUpdated = 0;
            $noOfError = 0;
            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->spreadsheet_excel_reader->read($uploadedFile['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];
            error_reporting(0);
            $data_excel = array();

            $correctFormat = true;

            if ($sheets['cells'][1][1] != 'Category Code' || $sheets['cells'][1][2] != 'Category Name') {
                $correctFormat = false;
            }


            if ($correctFormat) {
                for ($i = 2; $i <= $sheets['numRows']; $i++) {
                    if ($sheets['cells'][$i][1] == '') break;
                    $categoryCode = $sheets['cells'][$i][1];
                    if ($sheets['cells'][$i][2] == '') break;
                    $categoryName = $sheets['cells'][$i][2];

                    $data_excel[$i - 1]['category_id']    = $categoryCode;
                    $data_excel[$i - 1]['category_name']   = $categoryName;
                    $data_excel[$i - 1]['client_id'] = $this->session->userdata('client_id');
                    $data_excel[$i - 1]['category_image'] = 'ngapp/assets/img/default_category.png';
                    $data_excel[$i - 1]['category_image_thumbnail'] = 'ngapp/assets/img/default_category.png';
                    $this->db->where('category_id', $data_excel[$i - 1]['category_id']);
                    $this->db->where('client_id', $this->session->userdata('client_id'));
                    $q = $this->db->get('category');
                    if ($q->num_rows() == 0) {
                        $this->Category_model->createCategory($data_excel[$i - 1]);
                        $noOfCategoryUpdated++;
                    } else {
                        $error_text = $error_text . 'Row : ' . $i . ' Category ID : ' . $data_excel[$i - 1]['category_id'] . ' already exists;';
                        log_message('debug', 'Category CSV : Error Found - ' . $error_text);
                        $noOfError++;
                    }
                }
            } else {
                $error_text = 'Data Format is not as per requirement.';
                log_message('debug', 'Category CSV : Error Found - ' . $error_text);
                $noOfError++;
            }

            $success_text = 'No of Category Updated Successfully : ' . $noOfCategoryUpdated;
            $error_text = 'Total Error : ' . $noOfError . ';' . $error_text;
        } else {
            // show_error($this->upload->print_debugger());
            log_message('debug', 'category sheet upload failed');
        }
        $arr_data['success'] = $success_text;
        $arr_data['error'] = $error_text;
        $arr_data['no_of_employee_updated'] = $noOfCategoryUpdated;
        $arr_data['no_of_error'] = $noOfError;
        echo json_encode($arr_data);
    }

    public function checkAdminToken($headers)
    {
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            if ($headers['Authorization'] != false) {
                $token_response = $this->authorization_token->validateAdminTokenFromSession($headers['Authorization'], $headers['ClientId']);
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
