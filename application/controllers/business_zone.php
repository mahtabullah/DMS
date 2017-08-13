<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_zone extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Business_zones');
    }

    public function get_business_zone_name() {
        $id = $this->input->post('business_zone_layer');
        $data = $this->Business_zones->getAllBusiness_zones_name($id);
        echo json_encode($data);
        //$this->load->view('promotion_builder/add', $data);
    }

    public function get_db_house_name() {
        $biz_zone_str = $this->input->post('business_zone_name');
        $biz_zone_id=explode(',',$biz_zone_str);
        $data = $this->Business_zones->getAllDBHouseID($biz_zone_id);
        $datas = $this->Business_zones->getAllDBHouseName($data);
        echo json_encode($datas);
    }
}
