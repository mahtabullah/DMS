<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Business_zones');
    }

    public function load() {

        $data['layer1'] = $this->Business_zones->getAllBusinessZone();
        $data['filter_text_main'] = 'Geo layer';
        $this->load->view('filter_data/filter_business_zone', $data);
    }

    public function add_layer() {
        $layer_number = $this->input->post('layer_number');
        $text = $this->input->post('text');
        if ($layer_number == 1) {
            $arr = array();
            $biz_zone_layer = $this->input->post('layer_value');
            $biz_zone = $this->Business_zones->getAllBizZoneNamesById($biz_zone_layer);
            foreach ($biz_zone as $biz) {
                $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => $text, 'layer_number' => $layer_number, 'biz_zone_category_id' => $biz['biz_zone_category_id']);
            }
            $data['arr'] = $arr;
        } else {
            $arr = array();
            $biz_zone_layer = $this->input->post('layer_value');
            $biz_zone = $this->Business_zones->get_biz_zone_by_id($biz_zone_layer);
            foreach ($biz_zone as $biz) {
                $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => $biz['biz_zone_category_name'], 'layer_number' => $layer_number, 'biz_zone_category_id' => $biz['biz_zone_category_id']);
            }
            $data['arr'] = $arr;
        }
        if (!empty($data['arr'])) {
            $this->load->view('filter_data/add_new_layer', $data);
        }
    }

}
