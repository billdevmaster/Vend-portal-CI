<?php
class Session_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
    }

    public function getUserName() {
        log_message('debug', 'Inside getUserName');
        log_message('debug',$this->session->userdata('firstname'));
        $arr_data['firstname']=$this->session->userdata('firstname');
        echo json_encode($arr_data);
    }

    public function getUptNo() {
        log_message('debug', 'Inside getUptNo');
        log_message('debug',$this->session->userdata('upt_no'));
        $arr_data['upt_no']=$this->session->userdata('upt_no');
        echo json_encode($arr_data);
    }

    public function getPhoneNumber() {
        log_message('debug', 'Inside getPhoneNumber');
        log_message('debug',$this->session->userdata('mobilenumber'));
        $arr_data['mobilenumber']=$this->session->userdata('mobilenumber');
        echo json_encode($arr_data);
    }

    public function getEmailId() {
        log_message('debug', 'Inside getEmailId');
        log_message('debug',$this->session->userdata('emailid'));
        $arr_data['emailid']=$this->session->userdata('emailid');
        echo json_encode($arr_data);
    }

    public function getTransactionId() {
        log_message('debug', 'Inside getTransactionId');
        log_message('debug',$this->session->userdata('transaction_id'));
        $arr_data['transaction_id']=$this->session->userdata('transaction_id');
        echo json_encode($arr_data);
    }

    public function getLoginStatus() {
        log_message('debug', 'Inside getLoginStatus');
        log_message('debug',$this->session->userdata('loggedin'));
        $arr_data['loggedin']=$this->session->userdata('loggedin');
        echo json_encode($arr_data);
    }
    public function setLoginStatus() {
        log_message('debug', 'Inside setLoginStatus');
        $this->session->set_userdata('loggedin','false');
        $this->session->set_userdata('upt_no','0');
        $arr_data['loggedin']=$this->session->userdata('loggedin');
        echo json_encode($arr_data);
    }
    public function setUserSearch() {
        log_message('debug', 'Inside setUserSearch');
        $this->session->set_userdata('user_upt_no',$this->input->post('upt_no'));
        $arr_data['user_upt_no']=$this->session->userdata('user_upt_no');
        echo json_encode($arr_data);
    }

    public function setMachineId() {
        log_message('debug', 'Inside setMachineId');
        $this->session->set_userdata('machine_id',$this->input->post('machine_id'));
        $arr_data['machine_id']=$this->session->userdata('machine_id');
        echo json_encode($arr_data);
    }

    public function getMachineId() {
        log_message('debug', 'Inside getMachineId');
        log_message('debug',$this->session->userdata('machine_id'));
        $arr_data['machine_id']=$this->session->userdata('machine_id');
        echo json_encode($arr_data);
    }


    public function setEmployeeSearch() {
        log_message('debug', 'Inside setEmployeeSearch');
        $this->session->set_userdata('employeeid',$this->input->post('employeeid'));
        $arr_data['employeeid']=$this->session->userdata('employeeid');
        echo json_encode($arr_data);
    }
    public function getUserSearch() {
        log_message('debug', 'Inside getUserSearch');
        log_message('debug',$this->session->userdata('user_upt_no'));
        $this->db->where('upt_no',$this->session->userdata('user_upt_no'));
        $result=$this->db->get('user')->result();
        $this->db->where('upt_no',$this->session->userdata('user_upt_no'));
        $result_transaction=$this->db->get('user_transaction_details')->result();
        $arr_data;
        $i=0;
        foreach($result as $row)
        {
            log_message('debug',$row->mobilenumber);
            $arr_data['card_no']=$row->mobilenumber;
            $arr_data['firstname']=$row->firstname;
            $arr_data['lastname']=$row->lastname;
            $arr_data['emailid']=$row->emailid;
            $arr_data['mobilenumber']=$row->mobilenumber;
            $arr_data['upt_no']=$row->upt_no;
            $arr_data['activated_on']=$row->activated_on;
            $arr_data['last_updated']=$row->last_updated;
            $arr_data['account_balance']='0.00';
            foreach($result_transaction as $row_transaction)
            {
                if($row->upt_no==$row_transaction->upt_no){
                    $arr_data['account_balance']=$row_transaction->account_balance;
                }
            }
            $i++;
        }
        echo json_encode($arr_data);
    }

    public function getEmployeeSearch() {
        log_message('debug', 'Inside getEmployeeSearch');
        log_message('debug',$this->session->userdata('employeeid'));
        $this->db->where('employee_id',$this->session->userdata('employeeid'));
        $result=$this->db->get('employee')->result();
        $arr_data;
        $i=0;
        foreach($result as $row)
        {
            log_message('debug',$row->mobile_number);
            log_message('debug',$row->first_name);
            log_message('debug',$row->last_name);
            log_message('debug',$row->job_number);
            log_message('debug',$row->employee_id);
            log_message('debug',$row->account_created_by);

            $arr_data['mobilenumber']=$row->mobile_number;
            $arr_data['firstname']=$row->first_name;
            $arr_data['lastname']=$row->last_name;
            $arr_data['jobnumber']=$row->job_number;
            $arr_data['employeeid']=$row->employee_id;
            $arr_data['emp_card_no']=$row->emp_card_no;
            $arr_data['accountcreatedby']=$row->account_created_by;
            $i++;
        }
        echo json_encode($arr_data);
    }

}
