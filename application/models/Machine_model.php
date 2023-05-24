<?php
class Machine_model extends CI_Model {

  public function __construct()	{
    $this->load->database();
  }

  public function createMachine($request) {
    log_message('debug', 'Inside createMachine');
    $data = array(
      'machine_name' => $request['machine_name'],
      'machine_row' => $request['machine_row'],
      'machine_column' => $request['machine_column'],
      'machine_username' => $request['machine_username'],
      'machine_upt_no' => $request['machine_upt_no'],
      'machine_address' => $request['machine_address'] ,
      'machine_client_id' => $request['machine_client_id'] ,
      'machine_latitude' => $request['machine_latitude'] ,
      'machine_longitude' => $request['machine_longitude'],
      'machine_is_single_category' => $request['machine_is_single_category'],
      'machine_mode' => '1',
      'machine_advertisement_mode' => '1',
      'machine_is_game_enabled' => '0', 
      'machine_game' => '1', 
      'machine_info_button_enabled' =>'0', 
      'machine_screensaver_enabled' => '0', 
      'machine_volume_control_enabled' => '1',
      'machine_wheel_chair_enabled' => '0',
      'machine_is_job_number_enabled' => '0',
      'machine_is_gift_enabled' => '0',
      'machine_is_cost_center_enabled' => '0',
   );    
   
    $this->db->where('machine_name', $request['machine_name']);
    $this->db->where('machine_client_id', $request['machine_client_id']);
    $q = $this->db->get('machine');
    if ( $q->num_rows() > 0 ) 
   {
    $this->db->where('machine_name', $request['machine_name']);
    $this->db->update('machine',$data);
  }
  else
  {
    $this->db->insert('machine',$data);
  }  
  }

  public function deleteMachine($machineId,$machineName,$machineUsername){
    $this->db->where('id',$machineId);
    $this->db->where('machine_name',$machineName);
    $this->db->where('machine_username',$machineUsername);
    $this->db->delete('machine');
  }
}
