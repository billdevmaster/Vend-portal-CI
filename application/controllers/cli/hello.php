<?php
class Hello extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    // $this->load->library('input');
    $this->load->library('email');
    $this->load->helper('url');
    $this->load->database();
    $this->load->library('session');
    // $this->load->model('Appointment_model');
  }
  public function index()
  {
    if (!$this->input->is_cli_request()) {
      echo "controller only to be accessed from the command line";
      return;
    }
    echo "Hello, World" . PHP_EOL;
  }

  public function greet($name)
  {
    if (!$this->input->is_cli_request()) {
      echo "greet only to be accessed from the command line";
      return;
    }
    echo "Hello, $name" . PHP_EOL;
  }

  public function sendmail()
  {
    if (!$this->input->is_cli_request()) {
      echo "This sendmail only to be accessed from the command line";
      return;
    }
    $config = array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
    $config['smtp_user'] = 'noreply@visualvend.com';
    $config['smtp_pass'] = 'V15ualV3nd';
    $config['smtp_port'] = 465;

    $clientID = -1;

    $this->load->library("excel");
    $object = new PHPExcel();

    $object->setActiveSheetIndex(0);

    $table_columns = array("Transaction ID","Job Number","Cost Center", "Employee ID","Employee Name","Product ID","Product Name","Machine ID","Machine Name","Timestamp");

    $query = $this->db->query("SELECT * FROM employee_transaction WHERE client_id =".$clientID." AND DATE_FORMAT(`timestamp`, '%Y-%m-%d') = ( CURDATE() - INTERVAL 1 DAY )");
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

    $this->db->where('id', $clientID);
    $clientResult = $this->db->get('client')->result();
    $clientName;
    foreach ($clientResult as $clientRow) {
      $clientName = $clientRow->client_name;
    }
    $clientName="RSEA";
    $file_path = 'ngapp/assets/csv/reports/ '.$clientName.' - Employee Report '.date('d-m-Y',strtotime("-1 days")).'.xls';

    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    $object_writer->save($file_path);
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from("noreply@visualvend.com");
    $this->email->subject("cc2go Vend mail test");
    $this->email->message("This is a test email");
    $this->email->attach($file_path);
    $this->email->send();

    echo "Mail Send" . PHP_EOL;
  }


  public function testsendmail()
  {
    if (!$this->input->is_cli_request()) {
      echo "This sendmail only to be accessed from the command line";
      return;
    }
    $config = array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://cp169.ezyreg.com';
    $config['smtp_user'] = 'noreply@visualvend.com';
    $config['smtp_pass'] = 'V15ualV3nd';
    $config['smtp_port'] = 465;

   
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from("noreply@visualvend.com");
    $this->email->subject("cc2go Vend mail test");
    $this->email->message("This is a test email");
    $this->email->send();

    echo "Mail Send" . PHP_EOL;
  }



}
