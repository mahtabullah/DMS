<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Configs');
        $this->load->model('Business_zones');
        $this->load->model('Distribution_houses');
        $this->load->model('Distribution_channels');
        $this->load->model('Skus');
        //$this->load->model('Banks');
    }

    public function index() {
        $data['business_zone'] = $this->Business_zones->select_BusinessZone();
        $data['dist_channel'] = $this->Distribution_channels->getAlldistribution_channels();
        $data['sku_layer'] = $this->Skus->getSkuHierarchy();
        //var_dump($data);
        $this->load->view('conf_view', $data);
    }

    public function db_biz_zone_layer_mapping() {
        $insert = $this->Configs->insert_config('dbhouse_biz_zone_layer_map',$this->input->post('biz_zone_layer_id'));
        if ($insert) {
            redirect('configuration');
        }
    }
    
    public function db_sku_layer_mapping() {
        $insert = $this->Configs->insert_config('dbhouse_sku_layer_map',$this->input->post('sku_layer_id'));
        if ($insert) {
            redirect('configuration');
        }
    }    
    
    public function sku_parent_mapping() {
        $insert = $this->Configs->insert_config('sku_parent_map',$this->input->post('sku_parent_layer_id'));
        if ($insert) {
            redirect('configuration');
        }
    }
    
    public function outlet_parent_mapping() {
        $insert = $this->Configs->insert_config('outlet_parent_map',$this->input->post('dist_channel_map_data'));
        if ($insert) {
            redirect('configuration');
        }
    }
    
    public function route_child_mapping() {
        $insert = $this->Configs->insert_config('route_child_map',$this->input->post('route_child_element'));
        if ($insert) {
            redirect('configuration');
        }
    }
}