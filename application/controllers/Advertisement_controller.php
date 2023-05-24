<?php
class Advertisement_controller extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("Advertisement_model");
    $this->load->helper('url');
    $this->load->database();
    $this->load->library('session');
    $this->load->library('Authorization_Token');
  }

  function getData()
  {
    if ($this->checkToken($this->input->request_headers())) {
      $result = $this->db->get('advertisement')->result();
      $arr_data = array();
      $i = 0;
      foreach ($result as $row) {
        $arr_data[$i]['id'] = $row->id;
        $arr_data[$i]['ads_name'] = $row->ads_name;
        $arr_data[$i]['ads_path'] = "http://tcn.vendportal.com/ngapp/assets/videos/" . $row->ads_path;
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

  function getDataByClientId()
  {
    $headers = $this->input->request_headers();
    if ($this->checkToken($this->input->request_headers()) && $headers['ClientId'] == $this->input->post('client_id')) {
      $this->db->where('client_id', $this->input->post('client_id'));
      $result = $this->db->get('advertisement')->result();
      $arr_data = array();
      $i = 0;
      foreach ($result as $row) {
        $arr_data[$i]['id'] = $row->id;
        $arr_data[$i]['ads_name'] = $row->ads_name;
        $arr_data[$i]['ads_path'] = "http://tcn.vendportal.com/ngapp/assets/videos/" . $row->ads_path;
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


  function getMachineAdvertisement()
  {
    $headers = $this->input->request_headers();
    if ($this->checkToken($this->input->request_headers())) {
      $clientId = $this->input->post('client_id');
      log_message('debug', 'Inside getMachineAdvertisement' . $clientId);
      if ($clientId  > 0) {
        log_message('debug', 'Inside getMachineAdvertisement' . $clientId);
        $this->db->where('client_id', $clientId);
      }
      $result = $this->db->get('advertisement_assign')->result();
      $arr_data = array();
      $i = 0;
      foreach ($result as $row) {
        $arr_data[$i]['id'] = $row->id;
        $arr_data[$i]['advertisement_id'] = $row->advertisement_id;

        $this->db->select("*");
        $this->db->from('advertisement');
        $this->db->where('id', $row->advertisement_id);
        $query1 = $this->db->get();
        $result1 = $query1->result();
        foreach ($result1 as $row1) {
          $arr_data[$i]['advertisement_name'] = $row1->ads_name;
        }
        $arr_data[$i]['client_id'] = $row->client_id;

        $this->db->select("*");
        $this->db->from('machine');
        $this->db->where('id', $row->machine_id);
        $query2 = $this->db->get();
        $result2 = $query2->result();
        foreach ($result2 as $row2) {
          $arr_data[$i]['machine_name'] = $row2->machine_name;
        }


        $this->db->select("*");
        $this->db->from('client');
        $this->db->where('id', $row->client_id);
        $query3 = $this->db->get();
        $result3 = $query3->result();
        foreach ($result3 as $row3) {
          $arr_data[$i]['client_name'] = $row3->client_name;
        }

        $arr_data[$i]['machine_id'] = $row->machine_id;
        $arr_data[$i]['position'] = $row->position;
        $arr_data[$i]['start_date'] = $row->start_date;
        $arr_data[$i]['end_date'] = $row->end_date;
        if ($row->start_date == '0000-00-00 00:00:00') {
          $arr_data[$i]['start_date'] = "";
        } else {
          $arr_data[$i]['start_date'] = date("d-m-Y", strtotime($row->start_date));
        }
        if ($row->end_date == '0000-00-00 00:00:00') {
          $arr_data[$i]['end_date'] = "";
        } else {
          $arr_data[$i]['end_date'] = date("d-m-Y", strtotime($row->end_date));
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

  function deleteMachineAdvertisement()
  {
    if ($this->checkToken($this->input->request_headers())) {
      log_message('debug', 'Inside deleteMachineAdvertisement' . $this->input->post('id'));
      $this->db->where('id', $this->input->post('id'));
      $this->db->delete('advertisement_assign');
      $arr = array('code' => 200);
      header('Content-type:application/json');
      echo json_encode($arr);
    } else {
      $arr = array('code' => 401, 'msg' => "Authentication failed");
      header('Content-type:application/json');
      echo json_encode($arr);
    }
  }

  function deleteAdvertisementController()
  {
    if ($this->checkToken($this->input->request_headers())) {
      log_message('debug', 'Inside deleteAdvertisementController' . $this->input->post('id'));
      $this->Advertisement_model->deleteAdvertisement($this->input->post('id'));
      if (is_readable($this->input->post('ads_path')) && unlink($this->input->post('ads_path'))) {
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



  public function uploadAdvertisement()
  {
    $headers = $this->input->request_headers();
    if ($this->checkToken($this->input->request_headers())) {
      log_message('debug', 'Inside uploadAdvertisement');
      $data = array(
        'ads_path' => $this->input->post('ads_path'),
        'ads_name' => $this->input->post('ads_name'),
        'client_id' => $this->input->post('client_id'),
        'ads_resolution' => $this->input->post('ads_resolution')
      );
      $this->Advertisement_model->createAdvertisement($data);
      $arr = array('code' => 200);
      header('Content-type:application/json');
      echo json_encode($arr);
    } else {
      $arr = array('code' => 401, 'msg' => "Authentication failed");
      header('Content-type:application/json');
      echo json_encode($arr);
    }
  }

  public function assignAdvertisement()
  {
    if ($this->checkToken($this->input->request_headers())) {
      log_message('debug', 'Inside assignAdvertisement');
      $data = array(
        'advertisement_id' => $this->input->post('advertisement_id'),
        'client_id' => $this->input->post('client_id'),
        'machine_id' => $this->input->post('machine_id'),
        'position' => $this->input->post('position'),
        'start_date' => $this->input->post('start_date'),
        'end_date' => $this->input->post('end_date')
      );
      $this->db->insert('advertisement_assign', $data);
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
    log_message('debug', 'Inside uploadDocuments');
    //$this->Career_model->createCandidate();
    ini_set('upload_max_filesize', '200M');
    ini_set('post_max_size', '200M');
    ini_set('max_input_time', 3000);
    ini_set('max_execution_time', 3000);
    $config['upload_path']   = 'ngapp/assets/videos/';
    $config['allowed_types'] = 'mp4';
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
      //   show_error($this->upload->print_debugger());
      //  log_message('upload',$this->upload->print_debugger());
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
}
