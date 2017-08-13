<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dynamic_filter_hierarchy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dynamic_filter_hierarchys');
    }

    public function load() {
        $children_biz_zone_data = $this->get_data_for_hierarchy_filter($this->session->userdata('biz_zone_id'), 'return');
        $children_biz_zone_data['target'] = $this->input->post('target');
        //var_dump($children_biz_zone_data);
        $this->load->view('dynamic_filter/dynamic_filter_hierarchy', $children_biz_zone_data);
    }
    
    public function get_data_for_hierarchy_filter($biz_zone_id, $type) {
        $children_biz_zone_info['data_biz_zones'] = $this->dynamic_filter_hierarchys->getAllBusinessZonesChildren($biz_zone_id);
        if(count($children_biz_zone_info['data_biz_zones']) == 0){
            $biz_zone_info = $this->dynamic_filter_hierarchys->get_tbld_business_zone_by_id($biz_zone_id);
            $children_biz_zone_info['data_biz_zones'][] = array('id' => $biz_zone_id, 'biz_zone_name' => $biz_zone_info[0]['biz_zone_name']);
        }
        $children_biz_zone_info['layer_name'] = $this->dynamic_filter_hierarchys->getBizZoneLayerInfoById($children_biz_zone_info['data_biz_zones'][0]['biz_zone_category_id']);
//        var_dump($children_biz_zone_info);
        if($type == 'return'){
            return $children_biz_zone_info;
        }
        else if ($type == 'echo'){
            echo json_encode($children_biz_zone_info);
        }
    }
    
    public function getDbhouseById() {
        $biz_zone_id = $this->input->post('id');
        //echo $dbhouse_id;
        $dbhouse = $this->dynamic_filter_hierarchys->select_db_house_by_biz_zone($biz_zone_id);
//        var_dump($dbhouse);
        foreach ($dbhouse as $db) {
            $dbhouse_name = $this->dynamic_filter_hierarchys->select_dbhouse_name_by_id($db['dbhouse_id']);
            foreach($dbhouse_name as $dbh){
                $dbhouse_names[]=array('id'=>$dbh['id'],'biz_zone_name'=>$dbh['dbhouse_name']);
            }
        }
        echo json_encode($dbhouse_names);
    }
    
    public function getDbhouseSrsById() {
        $db_id = $this->input->post('db_id');
        //echo $$db_id;
        $sr = $this->dynamic_filter_hierarchys->getEmpNameByIdSRs($db_id);
        foreach ($sr as $s) {
            $sr_names[]=array('id'=>$s['id'],'biz_zone_name'=>$s['first_name']);
        }
        echo json_encode($sr_names);
    }
}
