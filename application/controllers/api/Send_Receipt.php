<?php

require APPPATH . '/libraries/REST_Controller.php';

class Send_Receipt extends REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
        $this->load->library('email');
        $this->load->library('pdf');
    }

    public function index_get()
    {
    }

    public function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {
            $data = json_decode(file_get_contents('php://input'));
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
            //$config['smtp_user'] = 'noreply@visualvend.com';
            //$config['smtp_pass'] = 'V15ualV3nd';
            $config['smtp_user'] = 'larocheposay@visualvend.com';
            $config['smtp_pass'] = 'P1mgr0up';
            $config['mailtype'] = 'html';
            $config['smtp_port'] = 465;

            $arr = explode(" ", $data->name, 1);
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
                $data->client_mobile_number = substr($clientObject->client_phone, 0, 4) . ' ' . substr($clientObject->client_phone, 4, 3) . ' ' . substr($clientObject->client_phone, 7);
                $data->client_email = $clientObject->client_email;
                $data->business_registration_number = $clientObject->business_registration_number;
            }
            $this->email->clear(true);
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from("larocheposay@visualvend.com", "reply@e.larocheposay.com.au");
            $message = "";
            $createDate = date("YmdHis");
            if ($isNewsletterEnabled) {
                $this->email->reply_to("reply@e.larocheposay.com.au", "La Roche-Posay");
                $this->email->subject('Welcome to La Roche-Posay ' . ucwords($arr[0]) . ' 💙');
                $message = $this->load->view('signup_mail', $data, true);
            } else {
                $this->email->subject('Vend Receipt');
                $message = $this->load->view('receipt_email', $data, true);

                $pdf = $this->load->view('invoice_pdf', $data, true);
                $dompdf = new PDF();
                $dompdf->load_html($pdf);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $output = $dompdf->output();

                file_put_contents('ngapp/assets/pdf/receipts/' . $createDate . $data->transaction_id . '.pdf', $output);
                $this->email->attach($output, 'application/pdf', $data->transaction_id . ".pdf", false);
            }

            $this->email->message($message);
            $this->email->to($data->email);

            if ($isNewsletterEnabled) {
                $personalizations = array(array("to" => array(array("email" => $data->email)), "dynamic_template_data" => array("username" => ucwords($arr[0]))));
                $from = array("email" => "larocheposay@visualvend.com", "name" => "reply@e.larocheposay.com.au");
                $reply_to = array("email" => "reply@e.larocheposay.com.au", "name" => "La Roche-Posay");
                $open_tracking = array("enable" => true);
                $templateId = "d-a9d7afeb1708429c9767acc9ce14811e";
                $array = array("from" => $from, "personalizations" => $personalizations, "reply_to" => $reply_to, "open_tracking" => $open_tracking, "template_id" => $templateId);
                $this->callCurlApi("POST", "https://api.sendgrid.com/v3/mail/send", json_encode($array));
                if ($isNewsletterEnabled) {
                    $personalizations = array(array("to" => array(array("email" => $data->email)), "dynamic_template_data" => array("username" => ucwords($arr[0]))));
                    $from = array("email" => "larocheposay@visualvend.com");
                    $reply_to = array("email" => "reply@e.larocheposay.com.au");
                    $open_tracking = array("enable" => true);
                    $templateId = "d-a9d7afeb1708429c9767acc9ce14811e";
                    $array = array("from" => $from, "personalizations" => $personalizations, "reply_to" => $reply_to, "open_tracking" => $open_tracking, "template_id" => $templateId);
                    callCurlApi("POST", "https://api.sendgrid.com/v3/mail/send", json_encode($array));
                    log_message('debug', "Email Send Successfully.");

                } else {
                    if ($this->email->send()) {
                        log_message('debug', "Email Send Successfully.");
                    } else {
                        log_message('debug', "You have encountered an error " . $data->email);
                    }
                }

                $receipt['machine_id'] = $data->machine_id;
                $receipt['transaction_id'] = $data->transaction_id;
                $receipt['name'] = $data->name;
                $receipt['email'] = $data->email;
                $receipt['mobile_number'] = $data->mobile_number;
                $receipt['date_time'] = $data->date_time;
                $receipt['product'] = $data->product;
                $receipt['price'] = $data->price;
                $receipt['url'] = 'ngapp/assets/pdf/receipts/' . $createDate . $data->transaction_id . '.pdf';
                $this->db->insert('receipts', $receipt);

                $this->response(array('status' => 'success'), 200);
            } else {

                $this->response(array('status' => 'fail', 'message' => 'No such User Found'), 200);
            }
        }
    }

    public function index_put()
    {
    }

    public function index_delete()
    {
    }

    public function callCurlApi($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }

                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }

                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }

        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer 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',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
