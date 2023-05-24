<?php

class Transaction_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
    }

    function getTransactionData(){
        $result=$this->db->get('transaction')->result();
        $arr_data=array();
        $i=0;
        foreach($result as $row)
        {
            $this->db->where('upt_no',$row->upt_no);
            $result1=$this->db->get('user')->result();
            foreach($result1 as $row1)
            {
                $arr_data[$i]['card_no']=$row1->mobilenumber;
            }
            $arr_data[$i]['date']=$row->date;
            $arr_data[$i]['time']=$row->time;
            $arr_data[$i]['transactionId']=$row->transactionId;
            $arr_data[$i]['store']=$row->store;
            $arr_data[$i]['amount']=$row->amount;
            $arr_data[$i]['amount_debit']=$row->amount_debit;
            $arr_data[$i]['amount_credit']=$row->amount_credit;
          $i++;  
        }
        echo json_encode($arr_data);
    }


    function getUserTransactionData(){
        $this->db->where('upt_no',$this->session->userdata('user_upt_no'));
        $result=$this->db->get('transaction')->result();
        $arr_data=array();
        $i=0;
        foreach($result as $row)
        {
            $arr_data[$i]['date']=$row->date;
            $arr_data[$i]['time']=$row->time;
            $arr_data[$i]['transactionId']=$row->transactionId;
            $arr_data[$i]['store']=$row->store;
            $arr_data[$i]['amount']=$row->amount;
            $arr_data[$i]['amount_debit']=$row->amount_debit;
            $arr_data[$i]['amount_credit']=$row->amount_credit;
          $i++;  
        }
        echo json_encode($arr_data);
    }


}
