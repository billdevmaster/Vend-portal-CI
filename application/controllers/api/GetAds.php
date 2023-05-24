<?php

require APPPATH . '/libraries/REST_Controller.php';

class getAds extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->library('Authorization_Token_Device');
    }

    function index_get()
    {
    }

    function index_post()
    {
        if ($this->authorization_token_device->checkToken($this->input->request_headers())) {

            $i = 0;
            $arr_data = array();
            $this->db->where('machine_id', $this->input->post('ads_machine_id'));
            $advertisement_assigns = $this->db->get('advertisement_assign')->result();
            foreach ($advertisement_assigns as $advertisement_assign) {
                $arr_data[$i]['id'] = $advertisement_assign->id;
                $arr_data[$i]['ads_position'] = $advertisement_assign->position;
                $arr_data[$i]['client_id'] = $advertisement_assign->client_id;
                $arr_data[$i]['ads_starts'] = $advertisement_assign->start_date;
                $arr_data[$i]['ads_ends'] = $advertisement_assign->end_date;
                $arr_data[$i]['ads_machine_id'] = $advertisement_assign->machine_id;
                $this->db->select("*");
                $this->db->from('advertisement');
                $this->db->where('id', $advertisement_assign->advertisement_id);
                $query1 = $this->db->get();
                $result1 = $query1->result();
                foreach ($result1 as $row1) {
                    $arr_data[$i]['ads_name'] = $row1->ads_name;
                    $arr_data[$i]['ads_path'] = $row1->ads_path;
                    $arr_data[$i]['ads_filetype'] = '';
                    $arr_data[$i]['ads_thumbnail'] = '';
                    $arr_data[$i]['ads_resolution'] = $row1->ads_resolution;
                }

                $this->db->select("*");
                $this->db->from('machine');
                $this->db->where('id', $advertisement_assign->machine_id);
                $query2 = $this->db->get();
                $result2 = $query2->result();
                foreach ($result2 as $row2) {
                    $arr_data[$i]['ads_machine_name'] = $row2->machine_name;
                }
                $i++;
            }
            $this->response(array('status' => 'success', 'ads' => $arr_data), 200);
        } else {
            $arr = array('code' => 401, 'msg' => "Authentication Failed");
            header('Content-type:application/json');
            $this->response($arr, 401);
        }
    }

    function index_put()
    {
    }


    function index_delete()
    {
    }
}
