<?php
class Product_model extends CI_Model
{

  public function __construct()
  {
    $this->load->database();
  }

  public function createProduct($request)
  {
    log_message('debug', 'Inside createProduct');
    $data = array(
      'product_id' => $request['product_id'],
      'product_name' => $request['product_name'],
      'client_id' => $request['client_id'],
      'product_price' => $request['product_price'],
      'product_description' => $request['product_description'],
      'product_image' => $request['product_image'],
      'product_image_thumbnail' => $request['product_image_thumbnail'],
      'product_more_info_image' => $request['product_more_info_image'],
      'product_more_info_image_thumbnail' => $request['product_more_info_image_thumbnail']
    );
    $this->db->where('product_id', $request['product_id']);
    $this->db->where('client_id', $request['client_id']);
    $q = $this->db->get('product');
    if ($q->num_rows() > 0) {
      $this->db->where('client_id', $request['client_id']);
      $this->db->where('product_id', $request['product_id']);
      $this->db->update('product', $data);
    } else {
      $this->db->insert('product', $data);
    }
  }

  public function deleteProduct($id, $product_id, $client_id)
  {
    $this->db->where('id', $id);
    $this->db->delete('product');

    $this->db->where('machine_client_id', $client_id);
    $result = $this->db->get('machine')->result();
    $machine_array = array();
    $h = 0;
    foreach ($result as $row) {
      $machine_array[] = $row->id;
      $h++;
    }

    $this->db->where_in('machine_id', $machine_array);
    $this->db->where('product_id', $product_id);
    $this->db->delete('machine_assign_product');

    $data = array(
      'category_id' => "",
      'product_id' => "",
      'product_name' => "",
      'product_image' => "ngapp/assets/images/product/thumbnail/no_product.png",
      'product_quantity' => "0"
    );
    $this->db->where_in('machine_id', $machine_array);
    $this->db->where('product_id', $product_id);
    $this->db->update('machine_product_map', $data);
  }
}
