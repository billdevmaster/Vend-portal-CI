<?php
class Advertisement_model extends CI_Model {

  public function __construct()	{
    $this->load->database();
  }

  public function createAdvertisement($request) {
    log_message('debug', 'Inside createAdvertisement');
    $data = array(
      'ads_path' => $request['ads_path'],
      'ads_name' => $request['ads_name'],
      'client_id' => $request['client_id'],
      'ads_resolution' => $request['ads_resolution']
   );    
    $this->db->insert('advertisement',$data);
  }

  public function deleteAdvertisement($id){
    log_message('debug', 'Inside deleteAdvertisement'.$id);
    $this->db->where('id',$id);
    $this->db->delete('advertisement');
  }
}
