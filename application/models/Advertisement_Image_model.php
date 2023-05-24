<?php
class Advertisement_Image_model extends CI_Model {

  public function __construct()	{
    $this->load->database();
    $this->load->helper('url');
    $this->load->database();
    $this->load->library('session');
  }

  public function createImageAdvertisement($request) {
    log_message('debug', 'Inside createImageAdvertisement');
    $data = array(
      'client_id' => $request['client_id'],
      'machine_id' => $request['machine_id'],
      'image_advertisement_title' => $request['image_advertisement_title'],
      'image_advertisement_url' => $request['image_advertisement_url'],
      'image_position' => $request['image_position'],
      'start_date' => $request['start_date'],
      'end_date' => $request['end_date'],
      'added_by' => $this->session->userdata('firstname')
   );    
    $this->db->insert('advertisement_image',$data);
  }

  public function deleteImageAdvertisement($id){
    log_message('debug', 'Inside deleteImageAdvertisement'.$id);
    $this->db->where('id',$id);
    $this->db->delete('advertisement_image');
  }
}
