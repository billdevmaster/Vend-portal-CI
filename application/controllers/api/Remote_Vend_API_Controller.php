<?php

require APPPATH . '/libraries/REST_Controller.php';

class Remote_Vend_API_Controller extends REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
        $this->load->library('email');
    }

    public function index_get()
    {
        try {
            if ($this->authorization_token_device->checkUserAccessToken($this->input->request_headers())) {

                $type = $this->get('operation_type');
                $vendId = $this->get('vend_id');
                $machineId = $this->get('machine_id');
                if (isset($vendId)) {
                    log_message('debug', 'getVendQueue isset($vendId)');
                    $this->db->select("*");
                    $this->db->from('remote_vend_log');
                    $this->db->where('machine_id', $machineId);
                    $this->db->where('vend_id', $vendId);
                    $query1 = $this->db->get();
                    $result1 = $query1->result();
                    $this->response(array('status' => 'success', 'data' => $result1), 200);
                } else if (isset($type) && $type == "all") {
                    log_message('debug', 'getVendQueue isset($type) && $type == all');
                    $this->db->select("*");
                    $this->db->from('remote_vend_log');
                    $this->db->where('machine_id', $machineId);
                    $query1 = $this->db->get();
                    $result1 = $query1->result();
                    $this->response(array('status' => 'success', 'data' => $result1), 200);
                } else if (isset($type) && $type == "status") {
                    log_message('debug', 'getVendQueue isset($type) && $type == status');
                    $this->db->select("*");
                    $this->db->from('remote_vend_log');
                    $this->db->where('machine_id', $machineId);
                    $this->db->order_by('timeOfCreation', "DESC");
                    $this->db->limit(1, 0);
                    $query1 = $this->db->get();
                    $result1 = $query1->result();
                    $this->response(array('status' => 'success', 'data' => $result1), 200);
                } else if (isset($type) && $type == "availability") {
                    log_message('debug', 'getVendQueue isset($type) && $type == availability');
                    $validTime = date("Y-m-d H:i:s", (time() - 42));
                    $this->db->select("*");
                    $this->db->from('remote_vend_log');
                    $this->db->where('machine_id', $machineId);
                    $this->db->where('timeOfCreation >', $validTime);
                    $this->db->group_start()
                        ->where('status', "1")
                        ->or_where('status', '0')
                        ->group_end();
                    $this->db->order_by('timeOfCreation', "DESC");
                    $this->db->limit(1, 0);
                    $query1 = $this->db->get();
                    $result1 = $query1->result();
                    $response = false;
                    if ($result1 != null && $result1 && sizeof($result1) > 0) {
                        $response = false;
                    } else {
                        $response = true;
                    }
                    $this->db->select("*");
                    $this->db->from('remote_vend_ping_status');
                    $this->db->where('machine_id', $machineId);
                    $query2 = $this->db->get();
                    $result2 = $query2->result();

                    $this->response(array('status' => 'success', 'data' => $response, "ping" => $result2), 200);
                } else if (isset($type) && $type == "stock") {
                    log_message('debug', 'getVendQueue isset($type) && $type == stock');
                    $this->db->select("count(status) as count,status");
                    $this->db->from('remote_vend_log');
                    $this->db->where('machine_id', $machineId);
                    $this->db->group_by("status");
                    $query1 = $this->db->get();
                    $result1 = $query1->result();

                    $this->db->select("sum(product_quantity) as quantity");
                    $this->db->where('machine_id', $machineId);
                    $result = $this->db->get('machine_product_map')->result();
                    $dataToSend = array();
                    if ($result != null && $result && sizeof($result) > 0) {
                        foreach ($result as $row) {
                            $dataToSend["TotalCapacity"] = $row->quantity;
                        }

                    }

                    if ($result1 != null && $result1 && sizeof($result1) > 0) {
                        $totalFails = 0;
                        foreach ($result1 as $row) {
                            if ($row->status == "2") {
                                $dataToSend["TotalVends"] = $row->count % $dataToSend["TotalCapacity"];
                                $dataToSend["TotalRemaining"] = $dataToSend["TotalCapacity"] - $dataToSend["TotalVends"];
                            } else {
                                $totalFails += $row->count;
                            }
                        }
                        $dataToSend["TotalFails"] = $totalFails;
                    }
                    $this->response(array('status' => 'success', 'data' => $result1, "result" => $dataToSend), 200);
                } else if (isset($type) && $type == "email") {
                    $response = $this->sendMail($machineId, "2", date("Y-m-d H:i:s"));
                    echo $this->email->print_debugger();
                    $this->response(array('status' => 'success', 'data' => $response), 200);

                } else {
                    $this->addPingTime($machineId);
                    log_message('debug', 'getVendQueue');
                    $validTime = date("Y-m-d H:i:s", (time() - 10));
                    $this->db->select("*");
                    $this->db->from('remote_vend_log');
                    $this->db->where('machine_id', $machineId);
                    $this->db->where('status', "0");
                    $this->db->where('timeOfCreation >', $validTime);
                    $query1 = $this->db->get();
                    $result1 = $query1->result();
                    $this->response(array('status' => 'success', 'data' => $result1), 200);
                }

            } else {
                $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
            }

        } catch (Exception $e) {
            $this->response(array('status' => 'fail', 'message' => $e), 403);
        }

    }

    public function sendMail($machineId, $errorType, $timestamp)
    {
        // $config = array();
        // $config['protocol'] = 'mail';
        // $config['useragent'] = "CodeIgniter";
        // // $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
        // $config['smtp_host'] = 'mail.visualvend.com';

        // $config['smtp_user'] = 'noreply@visualvend.com';
        // $config['smtp_pass'] = 'V15ualV3nd';
        // $config['mailtype'] = 'html';
        // // $config['smtp_port'] = 587;
        // $config['smtp_port'] = 465;
        // $config['mailpath'] = "/usr/bin/sendmail";
        // $config['newline'] = "\r\n";
        // $config['charset'] = 'utf-8';
        // $config['wordwrap'] = true;

        // $this->email->clear(true);
        // $this->email->initialize($config);
        // //$this->email->set_newline("\r\n");
        // $this->email->to("learndroid53@gmail.com,huzefa@perfect108.com,noreply@visualvend.com");
        // $this->email->from("noreply@visualvend.com");
        // $this->email->subject("Test From Huzefa");
        // $this->email->message("Hi Huzefa");
        // echo $this->email->print_debugger();
        // return $this->email->send();

        // $config = array();
        // $config['protocol'] = 'smtp';
        // $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
        // //$config['smtp_user'] = 'noreply@visualvend.com';
        // //$config['smtp_pass'] = 'V15ualV3nd';
        // $config['smtp_user'] = 'larocheposay@visualvend.com';
        // $config['smtp_pass'] = 'P1mgr0up';
        // $config['mailtype'] = 'html';
        // $config['smtp_port'] = 465;
        // $this->email->clear(true);
        // $this->email->initialize($config);
        // $this->email->set_newline("\r\n");
        // $this->email->from("noreply@visualvend.com", "noreply@visualvend.com");
        // $this->email->reply_to("noreply@visualvend.com", "Visual Vend");
        // $this->email->subject('Error occured for machine ');
        // $this->email->message("Yo Man");
        // $this->email->to("huzefar52@gmail.com");

        $personalizations = array(array("to" => array(array("email" => "xpo@visualvend.com"), array("email" => "huzefar52@gmail.com")), "dynamic_template_data" => array("machine_id" => $machineId, "error_type" => $errorType, "timestamp" => $timestamp)));
        $from = array("email" => "xpoalerts@visualvend.com");
        $reply_to = array("email" => "xpoalerts@visualvend.com");
        $open_tracking = array("enable" => true);
        $templateId = "d-08332c666f714bfc99c8877952b7964f";
        $array = array("from" => $from, "personalizations" => $personalizations, "reply_to" => $reply_to, "open_tracking" => $open_tracking, "template_id" => $templateId);
        $this->callCurlApi("POST", "https://api.sendgrid.com/v3/mail/send", json_encode($array));
    }

    public function index_put($id)
    {

        if ($this->authorization_token_device->checkUserAccessToken($this->input->request_headers())) {

            try {
                log_message('debug', 'updateVendQueue');
                $data = $this->put();
                $this->addPingTime($data["machine_id"]);
                $this->db->where('id', $id);
                $this->db->update('remote_vend_log', $data);
                if ($data["status"] > 2) {
                    $this->sendMail($data["machine_id"], $data["status"], date("Y-m-d H:i:s"));
                }
                $this->response(array('status' => 'success', 'data' => null), 200);

            } catch (Exception $e) {
                $this->response(array('status' => 'fail', 'message' => $e), 403);
            }
        } else {
            $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
        }

    }

    public function index_delete()
    {}

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

    public function index_post()
    {
        try {
            if ($this->authorization_token_device->checkUserAccessToken($this->input->request_headers())) {
                log_message('debug', 'remoteVend');

                $machineId = $this->input->post('machine_id');
                $aisleNumber = $this->input->post('aisle_number');
                $timeOfCreation = date("Y-m-d H:i:s");
                $customerName = $this->input->post('customer_name');
                $vendId = $this->input->post('vend_id');

                $data = array();
                $data["machine_id"] = $machineId;
                $data["aisle_number"] = $aisleNumber;
                $data["timeOfCreation"] = $timeOfCreation;
                $data["customer_name"] = $customerName;
                $data["vend_id"] = $vendId;

                $this->db->insert("remote_vend_log", $data);

                $this->response(array('status' => 'success', 'data' => null), 200);
            } else {
                $this->response(array('status' => 'fail', 'message' => 'Authentication Failure'), 401);
            }

        } catch (Exception $e) {
            $this->response(array('status' => 'fail', 'message' => $e), 403);
        }
    }

    public function addPingTime($machineId)
    {
        log_message('debug', "appPingTime");
        try {
            $time_of_ping = date("Y-m-d H:i:s");
            $data = array();
            $data["machine_id"] = $machineId;
            $data["ping_time"] = $time_of_ping;
            $this->db->replace('remote_vend_ping_status', $data);
        } catch (Exception $e) {
            log_message('debug', "appPingTime Error");
            log_message('debug', $e);
        }

    }
}

// public function remoteVend()
//     {

//         try {
//             log_message('debug', 'remoteVend');

//             $machineId = $this->input->post('machine_id');
//             $aisleNumber = $this->input->post('aisle_number');
//             $timeOfCreation = date("Y-m-d H:i:s");
//             $customerName = $this->input->post('customer_name');

//             $data = array();
//             $data["machine_id"] = $machineId;
//             $data["aisle_number"] = $aisleNumber;
//             $data["timeOfCreation"] = $timeOfCreation;
//             $data["customer_name"] = $customerName;

//             $this->db->insert("remote_vend_log", $data);

//             $arr = array('code' => 200, 'data' => 'success');
//             header('Content-type:application/json');
//             echo json_encode($arr);

//         } catch (Exception $e) {
//             $arr = array('code' => 403, 'data' => $e);
//             header('Content-type:application/json');
//             echo json_encode($arr);
//         }

//     }

//     public function getVendQueue()
//     {

//         try {
//             log_message('debug', 'getVendQueue');

//             $machineId = $this->input->post('machine_id');
//             $validTime = date("Y-m-d H:i:s", (time() - 10));
//             $this->db->select("*");
//             $this->db->from('remote_vend_log');
//             $this->db->where('machine_id', $machineId);
//             $this->db->where('status', "0");
//             $this->db->where('timeOfCreation >', $validTime);
//             $query1 = $this->db->get();
//             $result1 = $query1->result();
//             $arr = array('code' => 200, 'data' => $result1);
//             header('Content-type:application/json');
//             echo json_encode($arr);

//         } catch (Exception $e) {
//             $arr = array('code' => 403, 'msg' => $e);
//             header('Content-type:application/json');
//             echo json_encode($arr);
//         }

//     }

//     public function updateVendQueue()
//     {

//         try {
//             log_message('debug', 'updateVendQueue');

//             $machineId = $this->input->post('machine_id');
//             $id = $this->input->post('id');
//             $data = array(
//                 'machine_id' => $machineId,
//                 'id' => $id,
//                 'status' => "1",
//             );
//             $this->db->where('machine_id', $machineId);
//             $this->db->where('id', $id);
//             $this->db->update('remote_vend_log', $data);

//             $arr = array('code' => 200, 'data' => "success");
//             header('Content-type:application/json');
//             echo json_encode($arr);

//         } catch (Exception $e) {
//             $arr = array('code' => 403, 'msg' => $e);
//             header('Content-type:application/json');
//             echo json_encode($arr);
//         }

//     }
