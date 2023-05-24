<?php

require APPPATH . '/libraries/REST_Controller.php';

class Bulk_Send_Receipt extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
        $this->load->library('email');
        $this->load->library('pdf');
    }

    function index_get()
    {
    }

    function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $receipt_data = json_decode(file_get_contents('php://input'));
            $receipt_data_list = $receipt_data->receipts;
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
            $config['smtp_user'] = 'noreply@visualvend.com';
            $config['smtp_pass'] = 'V15ualV3nd';
            $config['mailtype'] = 'html';
            $config['smtp_port'] = 465;
          

            foreach ($receipt_data_list as $data) {

                $this->db->where('id', $data->machine_id);
                $machineObjects = $this->db->get('machine')->result();
                $client_id = -1;
                $isNewsletterEnabled = 0;
                foreach ($machineObjects as $machineObject) {
                    $data->machine_name = $machineObject->machine_name;
                    $data->machine_address = $machineObject->machine_address;
                    $client_id = $machineObject->machine_client_id;
                    $isNewsletterEnabled = $machineObject->newsletter_enabled;
                }

                $this->db->where('id', $client_id);
                $clientObjects = $this->db->get('client')->result();

                foreach ($clientObjects as $clientObject) {
                    $data->client_name = $clientObject->client_name;
                    $data->client_address = $clientObject->client_address;
                    $data->client_mobile_number =  substr($clientObject->client_phone,0,4).' '.substr($clientObject->client_phone,4,3).' '.substr($clientObject->client_phone,7);
                    $data->client_email = $clientObject->client_email;
                    $data->business_registration_number = $clientObject->business_registration_number;
                }
                $this->email->clear(TRUE);
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from("noreply@visualvend.com");
                 if($isNewsletterEnabled){
                    $this->email->subject('Thank you for signing up');
                    $message = $this->load->view('signup_mail', $data, TRUE);    
                }
                else{
                    $this->email->subject('Vend Receipt');
                    $message = $this->load->view('receipt_email', $data, TRUE);
    
                    $pdf = $this->load->view('invoice_pdf', $data, TRUE);
                    $dompdf = new PDF();
                    $dompdf->load_html($pdf);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    $output = $dompdf->output();
        
                    $createDate = date("YmdHis");
        
                    file_put_contents('ngapp/assets/pdf/receipts/'.$createDate.$data->transaction_id.'.pdf', $output);
                    $this->email->attach($output, 'application/pdf', $data->transaction_id . ".pdf", false);
                }

                $this->email->message($message);
                $this->email->to($data->email);


                if ($this->email->send())
                    log_message('debug', "Email Send Successfully.");
                else
                    log_message('debug', "You have encountered an error " . $data->email);

                $receipt['machine_id'] = $data->machine_id;
                $receipt['transaction_id'] = $data->transaction_id;
                $receipt['name'] = $data->name;
                $receipt['email'] = $data->email;
                $receipt['mobile_number'] = $data->mobile_number;
                $receipt['date_time'] = $data->date_time;
                $receipt['product'] = $data->product;
                $receipt['price'] = $data->price;
                $receipt['url'] = 'ngapp/assets/pdf/receipts/'.$createDate.$data->transaction_id.'.pdf';
                $this->db->insert('receipts', $receipt);

            
            }
            $this->response(array('status' => 'success'), 200);
        } else {

            $this->response(array('status' => 'fail', 'message' => 'No such User Found'), 200);
        }
    }

    function index_put()
    {
    }


    function index_delete()
    {
    }
}
