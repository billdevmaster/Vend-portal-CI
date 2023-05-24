<?php

class Product_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Product_model");
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('Authorization_Token');
    }

    public function getProductData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $product_category_id = $this->session->userdata('product_category_id');

            $this->db->select("*");
            $this->db->from('product_assign_category');
            $this->db->where('category_id', $product_category_id);
            $query = $this->db->get();
            $result = $query->result();
            $i = 0;
            $arr_data = array();
            foreach ($result as $row1) {
                $this->db->select("*");
                $this->db->from('product');
                $this->db->where('product_id', $row1->product_id);
                $query1 = $this->db->get();
                $result1 = $query1->result();
                foreach ($result1 as $row) {
                    $arr_data[$i]['product_id'] = $row->product_id;
                    $arr_data[$i]['product_category_id'] = $row->product_category_id;
                    $arr_data[$i]['product_category_name'] = $row->product_category_name;
                    $arr_data[$i]['product_name'] = $row->product_name;
                    $arr_data[$i]['client_id'] = $row->client_id;
                    $arr_data[$i]['product_price'] = $row->product_price;
                    $arr_data[$i]['product_image'] = $row->product_image;
                    $arr_data[$i]['product_image_thumbnail'] = $row->product_image_thumbnail;
                    $arr_data[$i]['product_more_info_image'] = $row->product_more_info_image;
                    $arr_data[$i]['product_more_info_image_thumbnail'] = $row->product_more_info_image_thumbnail;
                    $arr_data[$i]['product_description'] = $row->product_description;
                    $i++;
                }
            }
            $arr = array('code' => 200, 'products' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getAllProductDataEdit()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->select("*");
            $this->db->from('product');
            $query1 = $this->db->get();
            $result1 = $query1->result();
            $i = 0;
            foreach ($result1 as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['product_id'] = $row->product_id;

                $this->db->select("*");
                $this->db->from('product_assign_category');
                $this->db->where('product_id', $row->product_id);
                $query3 = $this->db->get();
                $result3 = $query3->result();
                foreach ($result3 as $row3) {
                    $arr_data[$i]['product_category_id'] = $row3->category_id;
                    $this->db->select("*");
                    $this->db->from('category');
                    $this->db->where('category_id', $row3->category_id);
                    $query2 = $this->db->get();
                    $result2 = $query2->result();
                    foreach ($result2 as $row2) {
                        $arr_data[$i]['product_category_name'] = $row2->category_name;
                    }
                }

                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['product_price'] = $row->product_price;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['product_image'] = $row->product_image;
                $arr_data[$i]['product_image_thumbnail'] = $row->product_image_thumbnail;
                $arr_data[$i]['product_more_info_image'] = $row->product_more_info_image;
                $arr_data[$i]['product_more_info_image_thumbnail'] = $row->product_more_info_image_thumbnail;
                $arr_data[$i]['product_description'] = $row->product_description;
                $i++;
            }

            $arr = array('code' => 200, 'products' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function getAllProductDataEditClient()
    {
        $headers = $this->input->request_headers();
        if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
            $this->db->select("*");
            $this->db->from('product');
            $this->db->where('client_id', $this->input->post('client_id'));
            $query1 = $this->db->get();
            $result1 = $query1->result();
            $i = 0;
            foreach ($result1 as $row) {
                $arr_data[$i]['id'] = $row->id;
                $arr_data[$i]['product_id'] = $row->product_id;

                $this->db->select("*");
                $this->db->from('product_assign_category');
                $this->db->where('product_id', $row->product_id);
                $query3 = $this->db->get();
                $result3 = $query3->result();
                foreach ($result3 as $row3) {
                    $arr_data[$i]['product_category_id'] = $row3->category_id;
                    $this->db->select("*");
                    $this->db->from('category');
                    $this->db->where('category_id', $row3->category_id);
                    $query2 = $this->db->get();
                    $result2 = $query2->result();
                    foreach ($result2 as $row2) {
                        $arr_data[$i]['product_category_name'] = $row2->category_name;
                    }
                }

                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['product_price'] = $row->product_price;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['product_image'] = $row->product_image;
                $arr_data[$i]['product_image_thumbnail'] = $row->product_image_thumbnail;
                $arr_data[$i]['product_more_info_image'] = $row->product_more_info_image;
                $arr_data[$i]['product_more_info_image_thumbnail'] = $row->product_more_info_image_thumbnail;
                $arr_data[$i]['product_description'] = $row->product_description;
                $i++;
            }

            $arr = array('code' => 200, 'products' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function updateMachineProductMap()
    {
        if ($this->checkToken($this->input->request_headers())) {

            $this->db->where('machine_client_id', $this->input->post('client_id'));
            $result = $this->db->get('machine')->result();
            $machine_array = array();
            $h = 0;
            foreach ($result as $row) {
                $machine_array[] = $row->id;
                $h++;
            }

            $this->db->where('product_id', $this->input->post('product_id'));
            $q = $this->db->get('machine_product_map');
            if ($q->num_rows() > 0) {
                $result = $q->result();
                foreach ($result as $row) {
                    $data = array(
                        'product_name' => $this->input->post('product_name'),
                        'product_image' => $this->input->post('product_image'),
                    );
                    $this->db->where_in('machine_id', $machine_array);
                    $this->db->where('product_id', $this->input->post('product_id'));
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

    public function getAllProductData()
    {
        if ($this->checkAdminToken($this->input->request_headers())) {
            $this->db->select("*");
            $this->db->from('product');
            $query = $this->db->get();
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['product_id'] = $row->product_id;
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['product_price'] = $row->product_price;
                $arr_data[$i]['product_image'] = $row->product_image;
                $arr_data[$i]['product_image_thumbnail'] = $row->product_image_thumbnail;
                $arr_data[$i]['product_more_info_image'] = $row->product_more_info_image;
                $arr_data[$i]['product_more_info_image_thumbnail'] = $row->product_more_info_image_thumbnail;
                $arr_data[$i]['product_description'] = $row->product_description;

                $i++;
            }
            $arr = array('code' => 200, 'products' => $arr_data);
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
            $this->db->select("*");
            $this->db->from('product');
            $this->db->where('client_id', $this->input->post('client_id'));
            $query = $this->db->get();
            $result = $query->result();
            $arr_data = array();
            $i = 0;
            foreach ($result as $row) {
                $arr_data[$i]['product_id'] = $row->product_id;
                $arr_data[$i]['product_name'] = $row->product_name;
                $arr_data[$i]['client_id'] = $row->client_id;
                $arr_data[$i]['product_price'] = $row->product_price;
                $arr_data[$i]['product_image'] = $row->product_image;
                $arr_data[$i]['product_image_thumbnail'] = $row->product_image_thumbnail;
                $arr_data[$i]['product_more_info_image'] = $row->product_more_info_image;
                $arr_data[$i]['product_more_info_image_thumbnail'] = $row->product_more_info_image_thumbnail;
                $arr_data[$i]['product_description'] = $row->product_description;

                $i++;
            }

            $arr = array('code' => 200, 'products' => $arr_data);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function deleteProductController()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $this->Product_model->deleteProduct($this->input->post('id'), $this->input->post('product_id'), $this->input->post('client_id'));
            if ('ngapp/assets/img/default_category.png' != $this->input->post('product_image_thumbnail')) {
                if (is_readable($this->input->post('product_image_thumbnail')) && unlink($this->input->post('product_image_thumbnail'))) {
                    log_message('debug', 'The file has been deleted Thumbnail Image');
                } else {
                    log_message('debug', 'The file was not found or not readable and could not be deleted Thumbnail Image');
                }
            }
            if ('ngapp/assets/img/default_category.png' != $this->input->post('product_image')) {
                if (is_readable($this->input->post('product_image')) && unlink($this->input->post('product_image'))) {
                    log_message('debug', 'The file has been deleted Original Image');
                } else {
                    log_message('debug', 'The file was not found or not readable and could not be deleted Original Image');
                }
            }

            if ('ngapp/assets/img/default_category.png' != $this->input->post('product_more_info_image')) {
                if (is_readable($this->input->post('product_more_info_image')) && unlink($this->input->post('product_more_info_image'))) {
                    log_message('debug', 'The file has been deleted Original More Info Image');
                } else {
                    log_message('debug', 'The file was not found or not readable and could not be deleted Original More Info Image');
                }
            }
            if ('ngapp/assets/img/default_category.png' != $this->input->post('product_more_info_image_thumbnail')) {
                if (is_readable($this->input->post('product_more_info_image_thumbnail')) && unlink($this->input->post('product_more_info_image_thumbnail'))) {
                    log_message('debug', 'The file has been deleted More Info Thumbnail Image');
                } else {
                    log_message('debug', 'The file was not found or not readable and could not be deleted More Info Thumbnail Image');
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

    public function deleteImage()
    {
        if ($this->checkToken($this->input->request_headers())) {
            if (is_readable($this->input->post('product_image_thumbnail')) && unlink($this->input->post('product_image_thumbnail'))) {
                log_message('debug', 'The file has been deleted Thumbnail Image');
            } else {
                log_message('debug', 'The file was not found or not readable and could not be deleted Thumbnail Image');
            }

            if (is_readable($this->input->post('product_image')) && unlink($this->input->post('product_image'))) {
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

    public function deleteImageMoreInfo()
    {
        if (is_readable($this->input->post('product_more_info_image')) && unlink($this->input->post('product_more_info_image'))) {
            log_message('debug', 'The file has been deleted Original More Info Image');
        } else {
            log_message('debug', 'The file was not found or not readable and could not be deleted Original More Info Image');
        }

        if (is_readable($this->input->post('product_more_info_image_thumbnail')) && unlink($this->input->post('product_more_info_image_thumbnail'))) {
            log_message('debug', 'The file has been deleted More Info Thumbnail Image');
        } else {
            log_message('debug', 'The file was not found or not readable and could not be deleted More Info Thumbnail Image');
        }
    }

    public function uploadProduct()
    {
        // log_message('debug', 'Inside uploadProduct');
        if ($this->checkToken($this->input->request_headers())) {
            $data = array(
                'product_id' => $this->input->post('product_id'),
                'product_name' => $this->input->post('product_name'),
                'client_id' => $this->input->post('client_id'),
                'product_price' => $this->input->post('product_price'),
                'product_image' => $this->input->post('product_image'),
                'product_image_thumbnail' => $this->input->post('product_image_thumbnail'),
                'product_more_info_image' => $this->input->post('product_more_info_image'),
                'product_more_info_image_thumbnail' => $this->input->post('product_more_info_image_thumbnail'),
                'product_description' => $this->input->post('product_description'),
            );
            $this->Product_model->createProduct($data);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function uploadProductImage()
    {
        $filename = date('YmdHis');
        log_message('debug', 'Inside uploadProductImage');
        $config['upload_path'] = 'ngapp/assets/images/product/original/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = '4096';
        $config['file_name'] = $filename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
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
        $source_path = 'ngapp/assets/images/product/original/' . $filename;
        $target_path = 'ngapp/assets/images/product/thumbnail/';
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => false,
            'width' => 200,
            'height' => 200,
        );

        $this->load->library('image_lib', $config_manip);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    public function sendCategoryId()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $currentCategoryId = array(
                'product_category_id' => $this->input->post('product_category_id'),
            );
            $this->session->set_userdata($currentCategoryId);
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function assignProductToCategory()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside assignProductToCategory');

            $this->db->where('product_id', $this->input->post('product_id'));
            $q = $this->db->get('product_assign_category');
            log_message('debug', 'assignProductGet' . $q->num_rows());
            if ($q->num_rows() > 0) {
                $data = array(
                    'category_id' => $this->input->post('category_id'),
                );
                $this->db->where('product_id', $this->input->post('product_id'));
                $this->db->update('product_assign_category', $data);
            } else {
                $data = array(
                    'category_id' => $this->input->post('category_id'),
                    'product_id' => $this->input->post('product_id'),
                );
                $this->db->insert('product_assign_category', $data);
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

    public function deleteAssignProductToCategory()
    {
        if ($this->checkToken($this->input->request_headers())) {
            log_message('debug', 'Inside deleteAssignProductToCategory');
            $this->db->where('product_id', $this->input->post('product_id'));
            $this->db->delete('product_assign_category');
            $arr = array('code' => 200);
            header('Content-type:application/json');
            echo json_encode($arr);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication failed");
            header('Content-type:application/json');
            echo json_encode($arr);
        }
    }

    public function checkProductIdValidity()
    {
        if ($this->checkToken($this->input->request_headers())) {
            $this->db->where('client_id', $this->input->post('client_id'));
            $this->db->where('product_id', $this->input->post('product_id'));
            $query = $this->db->get('product');
            $arr_data['isPresent'] = 'none';
            if ($query->num_rows() > 0) {
                $arr_data['isPresent'] = 'product_id';
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

    public function uploadProductList()
    {
        log_message('debug', 'uploadProductList');
        $config['upload_path'] = 'ngapp/assets/csv/product/';
        $config['allowed_types'] = 'csv|xls|xlsx';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $uploadedFile = $this->upload->data();
            @chmod($uploadedFile['full_path'], 0777);
            $error_text = ' ';
            $success_text = ' ';
            $noOfProductUpdated = 0;
            $noOfError = 0;
            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->spreadsheet_excel_reader->read($uploadedFile['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];
            error_reporting(0);
            $data_excel = array();

            $correctFormat = true;

            if (
                $sheets['cells'][1][1] != 'Product Code' || $sheets['cells'][1][2] != 'Product Name'
                || $sheets['cells'][1][3] != 'Product Price' || $sheets['cells'][1][4] != 'Product Description'
            ) {
                $correctFormat = false;
            }

            if ($correctFormat) {
                for ($i = 2; $i <= $sheets['numRows']; $i++) {
                    if ($sheets['cells'][$i][1] == '') {
                        break;
                    }

                    $productCode = $sheets['cells'][$i][1];
                    if ($sheets['cells'][$i][2] == '') {
                        break;
                    }

                    $productName = $sheets['cells'][$i][2];
                    if ($sheets['cells'][$i][3] == '') {
                        break;
                    }

                    $productPrice = $sheets['cells'][$i][3];

                    if (empty($sheets['cells'][$i][4])) {
                        $productDescription = "";
                    } else {
                        $productDescription = $sheets['cells'][$i][4];
                    }

                    $data_excel[$i - 1]['product_id'] = $productCode;
                    $data_excel[$i - 1]['product_name'] = $productName;
                    $data_excel[$i - 1]['product_price'] = $productPrice;
                    $data_excel[$i - 1]['client_id'] = $this->session->userdata('client_id');
                    $data_excel[$i - 1]['product_image'] = 'ngapp/assets/img/default_category.png';
                    $data_excel[$i - 1]['product_image_thumbnail'] = 'ngapp/assets/img/default_category.png';
                    $data_excel[$i - 1]['product_more_info_image'] = 'ngapp/assets/img/default_category.png';
                    $data_excel[$i - 1]['product_more_info_image_thumbnail'] = 'ngapp/assets/img/default_category.png';
                    $data_excel[$i - 1]['product_description'] = $productDescription;
                    $this->db->where('product_id', $data_excel[$i - 1]['product_id']);
                    $this->db->where('client_id', $this->session->userdata('client_id'));
                    $q = $this->db->get('product');
                    if ($q->num_rows() == 0) {
                        $this->Product_model->createProduct($data_excel[$i - 1]);
                        $noOfProductUpdated++;
                    } else {
                        $error_text = $error_text . 'Row : ' . $i . ' Product ID : ' . $data_excel[$i - 1]['product_id'] . ' already exists;';
                        log_message('debug', 'Product CSV : Error Found - ' . $error_text);
                        $noOfError++;
                    }
                }
            } else {
                $error_text = 'Data Format is not as per requirement.';
                log_message('debug', 'Product CSV : Error Found - ' . $error_text);
                $noOfError++;
            }

            $success_text = 'No of Product Updated Successfully : ' . $noOfProductUpdated;
            $error_text = 'Total Error : ' . $noOfError . ';' . $error_text;
        } else {
            // show_error($this->upload->print_debugger());
            log_message('debug', 'product sheet upload failed');
        }
        $arr_data['success'] = $success_text;
        $arr_data['error'] = $error_text;
        $arr_data['no_of_product_updated'] = $noOfProductUpdated;
        $arr_data['no_of_error'] = $noOfError;
        echo json_encode($arr_data);
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
}
