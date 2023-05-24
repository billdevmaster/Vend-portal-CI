<?php
class Checkout_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        
    }

    public function checkout() {
        log_message('debug', 'Inside checkout');
        require_once("vendor/autoload.php");
        if(file_exists(__DIR__ . "/../.env")) {
            $dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
            $dotenv->load();
        }

        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'xgztwy3h862pnyb2',
            'publicKey' => 'jy7r7mtdhmrtxhzs',
            'privateKey' => 'a99723c872f748be31ced8a091ea4c98'
        ]);
        $amount = $this->input->post('amount');
        $nonce = $this->input->post('payment_method_nonce');
        log_message('debug','Amount'.$amount);
        log_message('debug','Payment Method'.$nonce);
        $milliseconds = round(microtime(true) * 1000);
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        if ($result->success || !is_null($result->transaction)) {
            $transaction = $result->transaction;
            $data = array(
                'transaction_id' =>  $transaction->id
             );
             $this->session->set_userdata('transaction_id',$transaction->id);

            $this->db->where('mobilenumber', $this->session->userdata('mobilenumber'));
            $this->db->where('upt_no', $this->session->userdata('upt_no'));
            $this->db->where('client_token', $this->session->userdata('client_token'));
            $q = $this->db->get('live_transaction');
            if ( $q->num_rows() > 0 ) 
            {
                $this->db->where('mobilenumber', $this->session->userdata('mobilenumber'));
                $this->db->where('upt_no', $this->session->userdata('upt_no'));
                $this->db->where('client_token', $this->session->userdata('client_token'));
                $this->db->update('live_transaction',$data);
            }

            $arr_data['transaction_id']=$transaction->id;
            log_message('debug','Transaction ID : '.$transaction->id);
            echo json_encode($arr_data);
        
        } else {
            $errorString = "";

            foreach($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }

            $_SESSION["errors"] = $errorString;

            $arr_data['errors']=$errorString;
            echo json_encode($arr_data);
        
        }
    }


    public function createTransaction() {
        log_message('debug', 'Inside createTransaction');
        $data = array(
          'mobilenumber' => $this->session->userdata('mobilenumber'),
          'upt_no' => $this->session->userdata('upt_no') ,
          'username' => $this->session->userdata('firstname') ,
          'client_token'=>$this->input->post('client_token')
       );
       $this->session->set_userdata('client_token',$this->input->post('client_token'));
        $this->db->insert('live_transaction',$data);
      }


      public function checkoutTransaction(){
        require_once("vendor/autoload.php");
        if(file_exists(__DIR__ . "/../.env")) {
            $dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
            $dotenv->load();
        }

        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'xgztwy3h862pnyb2',
            'publicKey' => 'jy7r7mtdhmrtxhzs',
            'privateKey' => 'a99723c872f748be31ced8a091ea4c98'
        ]);

                $transaction = $gateway->transaction()->find($this->session->userdata('transaction_id'));
    
            $transactionSuccessStatuses = [
                Braintree\Transaction::AUTHORIZED,
                Braintree\Transaction::AUTHORIZING,
                Braintree\Transaction::SETTLED,
                Braintree\Transaction::SETTLING,
                Braintree\Transaction::SETTLEMENT_CONFIRMED,
                Braintree\Transaction::SETTLEMENT_PENDING,
                Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT
            ];
    
            if (in_array($transaction->status, $transactionSuccessStatuses)) {
                $header = "Transaction Success!";
                $icon = "success";
                $message = "Your test transaction has been successfully processed. See the Braintree API response and try again.";
            } else {
                $header = "Transaction Failed";
                $icon = "fail";
                $message = "Your test transaction has a status of " . $transaction->status . ". See the Braintree API response and try again.";
            }

            log_message('debug',$message);

            $arr_data['header']=$header;
            $arr_data['icon']=$icon;
            $arr_data['message']=$message;
            $arr_data['transaction']=$transaction;


            $data = array(
                'transaction_type' =>  $transaction->type,
                'transaction_amount' =>  $transaction->amount,
                'transaction_status' =>  $transaction->status,
                'transaction_created_at' =>  $transaction->createdAt->format('Y-m-d H:i:s'),
                'transaction_updated_at' =>  $transaction->updatedAt->format('Y-m-d H:i:s'),
                'credit_card_details_token' =>  $transaction->creditCardDetails->token,
                'credit_card_details_bin' =>  $transaction->creditCardDetails->bin,
                'credit_card_details_last4' =>  $transaction->creditCardDetails->last4,
                'credit_card_details_card_type' =>  $transaction->creditCardDetails->cardType,
                'credit_card_details_expiration_date' =>  $transaction->creditCardDetails->expirationDate,
                'credit_card_details_card_holder_name' =>  $transaction->creditCardDetails->cardholderName,
                'credit_card_details_customer_location' =>  $transaction->creditCardDetails->customerLocation,
                'customer_detail_id' =>  $transaction->customerDetails->id,
                'customer_detail_first_name' =>  $transaction->customerDetails->firstName,
                'customer_detail_last_name' =>  $transaction->customerDetails->lastName,
                'customer_detail_email' =>  $transaction->customerDetails->email,
                'customer_detail_company' =>  $transaction->customerDetails->company,
                'customer_detail_website' =>  $transaction->customerDetails->website,
                'customer_detail_phone' =>  $transaction->customerDetails->phone,
                'customer_detail_fax' =>  $transaction->customerDetails->fax
            );

            $this->db->where('mobilenumber', $this->session->userdata('mobilenumber'));
            $this->db->where('upt_no', $this->session->userdata('upt_no'));
            $this->db->where('client_token', $this->session->userdata('client_token'));
            $q = $this->db->get('live_transaction');
            if ( $q->num_rows() > 0 ) 
            {
                $this->db->where('mobilenumber', $this->session->userdata('mobilenumber'));
                $this->db->where('upt_no', $this->session->userdata('upt_no'));
                $this->db->where('client_token', $this->session->userdata('client_token'));
                $this->db->update('live_transaction',$data);
            }

            $this->db->where('upt_no', $this->session->userdata('upt_no'));
            $q = $this->db->get('user_transaction_details');
            if ( $q->num_rows() > 0 ) 
            {
                $res = $q->result(); 
                $row = $res[0];
                $data = array(
                    'account_balance' =>  $row->account_balance+$transaction->amount
                );
                $this->db->where('upt_no', $this->session->userdata('upt_no'));
                $this->db->update('user_transaction_details',$data);
            }
            echo json_encode($arr_data);
        
      }

}
