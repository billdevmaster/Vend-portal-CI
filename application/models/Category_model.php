<?php
class Category_model extends CI_Model
{

  public function __construct()
  {
    $this->load->database();
  }

  public function createCategory($request)
  {
    log_message('debug', 'Inside createCategory');
    $data = array(
      'category_id' => $request['category_id'],
      'category_name' => $request['category_name'],
      'client_id' => $request['client_id'],
      'category_image' => $request['category_image'],
      'category_image_thumbnail' => $request['category_image_thumbnail']
    );
    $this->db->where('category_id', $request['category_id']);
    $q = $this->db->get('category');
    if ($q->num_rows() > 0) {
      $this->db->where('category_id', $request['category_id']);
      $this->db->update('category', $data);
    } else {
      $this->db->insert('category', $data);
    }
  }

  public function deleteCategory($id)
  {
    log_message('debug', 'Inside deleteCategory' . $id);
    $this->db->where('category_id', $id);
    $this->db->delete('category');
    $this->db->where('category_id', $id);
    $this->db->delete('machine_assign_category');
  }
}
