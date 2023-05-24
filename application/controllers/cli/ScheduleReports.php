<?php
class ScheduleReports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library("excel");
    }

    public function index()
    {
        if (!$this->input->is_cli_request()) {
            echo "controller only to be accessed from the command line";
            return;
        }
        echo "Hello, World" . PHP_EOL;
    }

    public function mailEmployeeReport($schedule)
    {
        $interval = 0;
        if ($schedule == "Daily") {
            $interval = 1;
        } else if ($schedule == "Weekly") {
            $interval = 7;
        } else if ($schedule == "Monthly") {
            $interval = 30;
        }

        if (!$this->input->is_cli_request()) {
            echo "This mailReport only to be accessed from the command line";
            return;
        }
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
        $config['smtp_user'] = 'noreply@visualvend.com';
        $config['smtp_pass'] = 'V15ualV3nd';
        $config['smtp_port'] = 465;

        $this->db->where('enable_mail_report', true);
        $clientList = $this->db->get('client')->result();
        $object = new PHPExcel();
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');

        $date = isset($_GET['date']) ? $_GET['date'] : date('d-m-Y');

        foreach ($clientList as $currentClient) {
            $clientID = $currentClient->id;
            $object->disconnectWorksheets();
            $object->createSheet();
            $object->setActiveSheetIndex(0);
            $table_columns = array("Transaction ID", "Job Number", "Cost Center", "Employee ID", "Employee Name", "Product ID", "Product Name", "Machine ID", "Machine Name", "Timestamp");
            if ($schedule === 'Daily') {
                $query = $this->db->query("SELECT * FROM employee_transaction WHERE client_id =" . $clientID . " AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') = ( CURDATE() - INTERVAL 1 DAY )");
            } else {
                $query = $this->db->query("SELECT * FROM employee_transaction WHERE client_id =" . $clientID . " AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') > ( CURDATE() - INTERVAL " . $interval . " DAY )");
            }

            $result = $query->result();

            $column = 0;

            foreach ($table_columns as $field) {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach ($result as $row) {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->transaction_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->job_number);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->cost_center);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->employee_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->employee_full_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->product_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->product_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->machine_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->machine_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->timestamp);
                $excel_row++;
            }
            $clientName = $currentClient->client_name;

            $this->db->where('client_id', $clientID);
            $this->db->where('frequency', $schedule);
            $this->db->where('type', "EMPLOYEE_REPORT");
            $reportEmailList = $this->db->get('report_email')->result();
            echo "Employee Transaction Report | Mail Send to " . $clientName . PHP_EOL;
            foreach ($reportEmailList as $reportEmail) {

                $this->email->clear(true);
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->to($reportEmail->email);
                $this->email->from("noreply@visualvend.com");
                $this->email->subject("Vending Machines Employee Transaction Report");
                if ($excel_row == 2) {
                    if ($schedule == 'Daily') {
                        $this->email->message("No Transaction occurred on - " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Weekly') {
                        $this->email->message("No Transaction occurred last week starting - " . date('d-m-Y', strtotime($date . ' -8 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Montly') {
                        $this->email->message("No Transaction occurred last month starting - " . date('d-m-Y', strtotime($date . ' -31 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    }
                } else {
                    $file_path = 'ngapp/assets/csv/employee_reports/ ' . $clientName . ' - Employee Report ' . date('d-m-Y') . '.xls';
                    $object_writer->save($file_path);
                    if ($schedule == 'Daily') {
                        $this->email->message("Attached Employee Transactions report for - " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Weekly') {
                        $this->email->message("Attached Employee Transactions report for last week - " . date('d-m-Y', strtotime($date . ' -8 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Montly') {
                        $this->email->message("Attached Employee Transactions report for last month - " . date('d-m-Y', strtotime($date . ' -31 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    }
                    $this->email->attach($file_path);
                }
                $this->email->send();
                echo $reportEmail->email . ' ' . $interval . ' ' . $excel_row . PHP_EOL;
            }
        }
    }

    public function mailFeedback($schedule)
    {
        $interval = 0;
        if ($schedule == "Daily") {
            $interval = 1;
        } else if ($schedule == "Weekly") {
            $interval = 7;
        } else if ($schedule == "Monthly") {
            $interval = 30;
        }

        if (!$this->input->is_cli_request()) {
            echo "This mailFeedback only to be accessed from the command line";
            return;
        }
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
        $config['smtp_user'] = 'noreply@visualvend.com';
        $config['smtp_pass'] = 'V15ualV3nd';
        $config['smtp_port'] = 465;

        $this->db->where('enable_mail_feedback', true);
        $clientList = $this->db->get('client')->result();
        $object = new PHPExcel();
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');

        $date = isset($_GET['date']) ? $_GET['date'] : date('d-m-Y');

        foreach ($clientList as $currentClient) {
            $clientID = $currentClient->id;
            $object->disconnectWorksheets();
            $object->createSheet();
            $object->setActiveSheetIndex(0);
            $table_columns = array("Feedback Id", "Transaction Id", "Machine Name", "Product ID", "Product Name", "Customer Name", "Customer Phone", "Customer Email", "Complaint", "Feedback", "Timestamp");
            if ($schedule == 'Daily') {
                $query = $this->db->query("SELECT * FROM feedback WHERE client_id =" . $clientID . " AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') = ( CURDATE() - INTERVAL " . $interval . " DAY )");
            } else {
                $query = $this->db->query("SELECT * FROM feedback WHERE client_id =" . $clientID . " AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') > ( CURDATE() - INTERVAL " . $interval . " DAY )");
            }
            $result = $query->result();

            $column = 0;

            foreach ($table_columns as $field) {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach ($result as $row) {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->feedback_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->transaction_id);

                $this->db->select("*");
                $this->db->from('machine');
                $this->db->where('id', $row->machine_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row2->machine_name);
                }

                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->product_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->product_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->customer_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->customer_phone);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->customer_email);
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->complaint);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->feedback);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->timestamp);
                $excel_row++;
            }
            $clientName = $currentClient->client_name;

            $this->db->where('client_id', $clientID);
            $this->db->where('frequency', $schedule);
            $this->db->where('type', "FEEDBACK_REPORT");
            $reportEmailList = $this->db->get('report_email')->result();
            echo "Feedback Report | Mail Send to " . $clientName . PHP_EOL;
            foreach ($reportEmailList as $reportEmail) {
                $this->email->clear(true);
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->to($reportEmail->email);
                $this->email->from("noreply@visualvend.com");
                $this->email->subject("Vending Machine Feedback Report");
                if ($excel_row == 2) {
                    if ($schedule == 'Daily') {
                        $this->email->message("No Feedback reported on - " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Weekly') {
                        $this->email->message("No Feedback reported for the week - " . date('d-m-Y', strtotime($date . ' -8 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Montly') {
                        $this->email->message("No Feedback reported for the last month - " . date('d-m-Y', strtotime($date . ' -31 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    }
                } else {
                    $file_path = 'ngapp/assets/csv/feedback_reports/ ' . $clientName . ' - Feedback Report ' . date('d-m-Y') . '.xls';
                    $object_writer->save($file_path);
                    if ($schedule == 'Daily') {
                        $this->email->message("Attached Feedback report for - " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Weekly') {
                        $this->email->message("Attached Feedback report for last week starting - " . date('d-m-Y', strtotime($date . ' -8 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Montly') {
                        $this->email->message("Attached Feedback report for last month starting - " . date('d-m-Y', strtotime($date . ' -31 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    }
                    $this->email->attach($file_path);
                }
                $this->email->send();
                echo $reportEmail->email . ' ' . $interval . ' ' . $excel_row . PHP_EOL;
            }
        }
    }

    public function mailSaleReport($schedule)
    {
        $interval = 0;
        if ($schedule == "Daily") {
            $interval = 1;
        } else if ($schedule == "Weekly") {
            $interval = 7;
        } else if ($schedule == "Monthly") {
            $interval = 30;
        }

        if (!$this->input->is_cli_request()) {
            echo "This mailSaleReport only to be accessed from the command line";
            return;
        }
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
        $config['smtp_user'] = 'noreply@visualvend.com';
        $config['smtp_pass'] = 'V15ualV3nd';
        $config['smtp_port'] = 465;

        $this->db->where('enable_mail_sale_report', true);
        $clientList = $this->db->get('client')->result();
        $object = new PHPExcel();
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');

        $date = isset($_GET['date']) ? $_GET['date'] : date('d-m-Y');

        foreach ($clientList as $currentClient) {
            $clientID = $currentClient->id;
            $object->disconnectWorksheets();
            $object->createSheet();
            $object->setActiveSheetIndex(0);
            $table_columns = array("Id", "Transaction Id", "Product Id", "Product Name", "Product Price", "Machine Id", "Machine Name", "Timestamp");

            if ($schedule == 'Daily') {
                $query = $this->db->query("SELECT * FROM sale_report WHERE client_id =" . $clientID . " AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') = CURDATE()");
            } else {
                $query = $this->db->query("SELECT * FROM sale_report WHERE client_id =" . $clientID . " AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') > ( CURDATE() - INTERVAL " . $interval . " DAY )");
            }

            $result = $query->result();

            $column = 0;

            foreach ($table_columns as $field) {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach ($result as $row) {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->transaction_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->product_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->product_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->product_price);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->machine_id);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->machine_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->timestamp);
                $excel_row++;
            }
            $clientName = $currentClient->client_name;

            $this->db->where('client_id', $clientID);
            $this->db->where('frequency', $schedule);
            $this->db->where('type', "SALE_REPORT");
            $reportEmailList = $this->db->get('report_email')->result();
            echo "Sale Report | Mail Send to " . $clientName . PHP_EOL;
            foreach ($reportEmailList as $reportEmail) {
                $this->email->clear(true);
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->to($reportEmail->email);
                $this->email->from("noreply@visualvend.com");
                $this->email->subject("Sales Report");
                if ($excel_row == 2) {
                    if ($schedule == 'Daily') {
                        $this->email->message("No Sales occurred on - " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Weekly') {
                        $this->email->message("No Sales occurred in the week - " . date('d-m-Y', strtotime($date . ' -8 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Montly') {
                        $this->email->message("No Sales occurred in the last month - " . date('d-m-Y', strtotime($date . ' -31 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    }
                } else {
                    $file_path = 'ngapp/assets/csv/sales_reports/ ' . $clientName . ' - Sales Report ' . date('d-m-Y') . '.xls';
                    $object_writer->save($file_path);
                    if ($schedule == 'Daily') {
                        $this->email->message("Attached sales report for - " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Weekly') {
                        $this->email->message("Attached sales report for last week starting - " . date('d-m-Y', strtotime($date . ' -8 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    } else if ($schedule == 'Montly') {
                        $this->email->message("Attached sales report for last month starting - " . date('d-m-Y', strtotime($date . ' -31 day')) . " to " . date('d-m-Y', strtotime($date . ' -1 day')));
                    }
                    $this->email->attach($file_path);
                }
                $this->email->send();
                echo $reportEmail->email . ' ' . $interval . ' ' . $excel_row . PHP_EOL;
            }
        }
    }
}
