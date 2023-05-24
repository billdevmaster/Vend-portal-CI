<?php
class User_model extends CI_Model {
  public function __construct()	{
    $this->load->database();
    $this->load->library('session');
    
  }
  public function createUser($request) {
    log_message('debug', 'Inside createUser');
    $data = array(
      'mobilenumber' => $request['mobilenumber'],
      'firstname' => $request['firstname'] ,
      'lastname' => $request['lastname'],
      'username' => $request['username'],
      'emailid' => $request['emailid'],
      'upt_no'=> $request['upt_no'],
      'client_id'=> $request['client_id'],
      'password'=>$request['password']
   );
    $this->db->insert('user',$data);
  }
  public function isUserAuthenticated($request) {
    $mobilenumber = $request['mobilenumber'];
    $password = $request['password'];
    $pas=base64_decode($password);
    log_message('debug',$pas);
    $sql1 = "SELECT upt_no,password,firstname,mobilenumber,emailid FROM user WHERE mobilenumber = ?";
    $query1 = $this->db->query($sql1, array($mobilenumber));
    if ($query1->num_rows() > 0) {
      $res = $query1->result(); 
      $row = $res[0];
      log_message('debug', $row->password);
      if(password_verify($pas, $row->password)){
      $this->session->set_userdata('upt_no',$row->upt_no);
      $this->session->set_userdata('firstname',$row->firstname);
      $this->session->set_userdata('mobilenumber',$row->mobilenumber);
      $this->session->set_userdata('emailid',$row->emailid);
      $this->session->set_userdata('loggedin','true');

        return true;
      }
      else{
        return false;
      }
    } else {
      $sql2 = "SELECT upt_no,password,firstname,mobilenumber,emailid FROM user WHERE upt_no = ?";
      $query2 = $this->db->query($sql2, array($mobilenumber));
      if ($query2->num_rows() > 0) {
        $res = $query2->result(); 
        $row = $res[0];
        log_message('debug', $row->password);
        if(password_verify($pas, $row->password)){
          $this->session->set_userdata('upt_no',$row->upt_no);
          $this->session->set_userdata('firstname',$row->firstname);
          $this->session->set_userdata('emailid',$row->emailid);
          $this->session->set_userdata('loggedin','true');
          $this->session->set_userdata('mobilenumber',$row->mobilenumber);
          return true;
        }
        else{
          return false;
        }
      } 
      else{
        return false;
      }
    }
  }



  public function isAdminAuthenticated($request) {
    $mobilenumber = $request['mobilenumber'];
    $password = $request['password'];
    $pas=base64_decode($password);
    log_message('debug','password entered '.$pas);
    $sql1 = "SELECT upt_no,password,firstname,mobilenumber,emailid,client_id FROM admin WHERE mobilenumber = ?";
    $query1 = $this->db->query($sql1, array($mobilenumber));
    if ($query1->num_rows() > 0) {
      $res = $query1->result(); 
      $row = $res[0];
      log_message('debug', $row->password);
      if(password_verify($pas, $row->password)){
      $this->session->set_userdata('upt_no',$row->upt_no);
      $this->session->set_userdata('firstname',$row->firstname);
      $this->session->set_userdata('mobilenumber',$row->mobilenumber);
      $this->session->set_userdata('emailid',$row->emailid);
      $this->session->set_userdata('loggedin','true');
      $this->session->set_userdata('client_id',$row->client_id);

        return true;
      }
      else{
        return false;
      }
    } else {
      $sql2 = "SELECT upt_no,password,firstname,mobilenumber,emailid,client_id FROM admin WHERE upt_no = ?";
      $query2 = $this->db->query($sql2, array($mobilenumber));
      if ($query2->num_rows() > 0) {
        $res = $query2->result(); 
        $row = $res[0];
        log_message('debug', $row->password);
        if(password_verify($pas, $row->password)){
          $this->session->set_userdata('upt_no',$row->upt_no);
          $this->session->set_userdata('firstname',$row->firstname);
          $this->session->set_userdata('emailid',$row->emailid);
          $this->session->set_userdata('loggedin','true');
          $this->session->set_userdata('mobilenumber',$row->mobilenumber);
          $this->session->set_userdata('client_id',$row->client_id);
          return true;
        }
        else{
          return false;
        }
      } 
      else{
        return false;
      }
    }
  }

  public function isAdminUsernameAuthenticated($request) {
    $username = $request['username'];
    $password = $request['password'];
    $pas=base64_decode($password);
    log_message('debug','password entered '.$pas);
    $sql1 = "SELECT upt_no,password,firstname,mobilenumber,emailid,client_id FROM admin WHERE username = ?";
    $query1 = $this->db->query($sql1, array($username));
    if ($query1->num_rows() > 0) {
      $res = $query1->result(); 
      $row = $res[0];
      log_message('debug', $row->password);
      if(password_verify($pas, $row->password)){
      $this->session->set_userdata('upt_no',$row->upt_no);
      $this->session->set_userdata('firstname',$row->firstname);
      $this->session->set_userdata('mobilenumber',$row->mobilenumber);
      $this->session->set_userdata('emailid',$row->emailid);
      $this->session->set_userdata('loggedin','true');
      $this->session->set_userdata('client_id',$row->client_id);

        return true;
      }
      else{
        return false;
      }
    } else {
      return false;
    }
  }


}
