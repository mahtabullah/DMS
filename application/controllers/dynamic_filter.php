<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dynamic_filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dynamic_filters');
    }

    public function load() {
        
        $type = $this->input->post('type');
        $target = $this->input->post('target');
        //$biz_zone_id = $this->input->post('biz_zone_id');
        
        
        
        if ($type == 'geography') {
            $data['frst_layer'] = $this->dynamic_filters->getAllBusinessZone();
            $data['frst_layer_index'] = 'biz_zone_category_name';
            $data['type'] = $type;
            $data['target'] = $target;
            $data['filter_text_main'] = 'Business Area Layer';
            $data['filter_text_secondary'] = 'Business Area';
            
            $this->load->view('dynamic_filter/dynamic_filter_2_layers', $data);
        }
//        if ($type == 'distribution_channel') {
//            $data['frst_layer'] = $this->Distribution_houses->select_db_house();
//            $data['frst_layer_index'] = 'dbhouse_name';
//            $data['type'] = $type;
//            $data['target'] = $target;
//            $data['filter_text_main'] = 'Distribution House';
//
//            $this->load->view('dynamic_filter_1_layer', $data);
//        }
    }

    public function filter_layer1() {
        $type = $this->input->post('type');
        if ($type == 'geography') {
            $arr = array();
            $biz_zone_layer = $this->input->post('id');
            $biz_zone = $this->dynamic_filters->getAllBizZoneNamesById($biz_zone_layer);
            foreach ($biz_zone as $biz) {
                $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => 'Business Zone');
            }
            echo json_encode($arr);
        }
//        if ($type == 'geography') {
//            $arr = array();
//            $biz_zone_layer = $this->input->post('id');
//            $biz_zone = $this->Business_zones->getAllBizZoneNamesById($biz_zone_layer);
//            foreach ($biz_zone as $biz) {
//                $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => 'Business Zone');
//            }
//            echo json_encode($arr);
//        }
    }
    
    public function filter_layer2() {
        $type = $this->input->post('type');
        if ($type == 'geography') {
            $arr = array();
            $biz_zone_layer = $this->input->post('id');
            $biz_zone = $this->dynamic_filters->getAllBusinessZonesChildren($biz_zone_layer);
            foreach ($biz_zone as $biz) {
                $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => 'Business Zone');
            }
            echo json_encode($arr);
        }
    }
    
    public function getDbhouseById() {
        $biz_zone_id = $this->input->post('id');
        //echo $biz_zone_id;
        $dbhouse = $this->dynamic_filters->select_db_house_by_biz_zone($biz_zone_id);
        foreach ($dbhouse as $db) {
            $dbhouse_name = $this->dynamic_filters->select_dbhouse_name_by_id($db['dbhouse_id']);
            foreach($dbhouse_name as $dbh){
                $dbhouse_names[]=array('id'=>$dbh['id'],'name'=>$dbh['dbhouse_name']);
            }
        }
        echo json_encode($dbhouse_names);
    }
    
    public function getDbChannelById() {
        $biz_zone_id = $this->input->post('id');
        //echo $dbhouse_id;
        $dist_channel_element = $this->dynamic_filters->getDistributionChannelByBizZoneId($biz_zone_id);
        foreach ($dist_channel_element as $element) {
//            $element_name = $this->Distribution_houses->select_dbhouse_name_by_id($element['dbhouse_id']);
//            foreach($element_name as $elem){
                $elem_names[]=array('id'=>$element['id'],'name'=>$element['db_channel_element_name']);
//            }
        }
        echo json_encode($elem_names);
    }

}
