<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Custom_filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Custom_filters');
    }

    function geoLayerFilterInit() {
        $data = $this->getDB();
        $db_id = array();
        foreach ($data as $v) {
            array_push($db_id, $v['id']);
        }
        $data['db_id']=$db_id;
        $data['option'] = $this->input->post('option');
        $data['result'] = $this->getFilterData();
        $this->load->view('custom_filter/geo_filter/index', $data);
    }

    function getFilterData() {

        $user_role_code = $this->session->userdata('user_role_code');
        if ($user_role_code == 'MIS') {
            $data = $this->makingGeoList(1, 5, $user_role_code);
        } else if ($user_role_code == 'NSM') {
            $data = $this->makingGeoList(1, 5, $user_role_code);
        } else if ($user_role_code == 'USM') {
            $data = $this->makingGeoList(2, 5, $user_role_code);
        } else if ($user_role_code == 'TDM') {
            $data = $this->makingGeoList(3, 5, $user_role_code);
        } else if ($user_role_code == 'CE') {
            $data = $this->makingGeoList(4, 5, $user_role_code);
        } else if ($user_role_code == 'DB') {
            $data = $this->makingGeoList(5, 5, $user_role_code);
        }
        return $data;
    }

    function geoLayerFilterInitDB() {
        $data = $this->getDB();
        $db_id = array();
        foreach ($data as $v) {
            array_push($db_id, $v['id']);
        }
        $data['option'] = $this->input->post('option');
        $data['result'] = $this->getFilterDataDB();
        $this->load->view('custom_filter/geo_filter/index', $data);
    }

    function geoLayerFilterInitCE() {
        $data = $this->getDB();
        $db_id = array();
        foreach ($data as $v) {
            array_push($db_id, $v['id']);
        }
        $data['option'] = $this->input->post('option');
        $data['result'] = $this->getFilterDataCE();
        $this->load->view('custom_filter/geo_filter/index', $data);
    }

    function getFilterDataDB() {
        $user_role_code = $this->session->userdata('user_role_code');
        if ($user_role_code == 'MIS') {
            $data = $this->makingGeoList(1, 4, $user_role_code);
        } else if ($user_role_code == 'NSM') {
            $data = $this->makingGeoList(1, 4, $user_role_code);
        } else if ($user_role_code == 'USM') {
            $data = $this->makingGeoList(2, 4, $user_role_code);
        } else if ($user_role_code == 'TDM') {
            $data = $this->makingGeoList(3, 4, $user_role_code);
        } else if ($user_role_code == 'CE') {
            $data = $this->makingGeoList(4, 4, $user_role_code);
        } else if ($user_role_code == 'DB') {
            $data = $this->makingGeoList(4, 4, $user_role_code);
        }
        return $data;
    }

    function getFilterDataCE() {
        $user_role_code = $this->session->userdata('user_role_code');
        if ($user_role_code == 'MIS') {
            $data = $this->makingGeoList(1, 3, $user_role_code);
        }else if ($user_role_code == 'NSM') {
            $data = $this->makingGeoList(1, 3, $user_role_code);
        } else if ($user_role_code == 'USM') {
            $data = $this->makingGeoList(2, 3, $user_role_code);
        } else if ($user_role_code == 'TDM') {
            $data = $this->makingGeoList(3, 3, $user_role_code);
        }
        return $data;
    }

    /**
     * @param null $start_layer
     * @param null $end_layer
     * @param string $user_role_code
     * @return array
     */
    public function makingGeoList($start_layer = NULL, $end_layer = NULL, $user_role_code = '') {
        $layer = array();
        $geo_layer = $this->Custom_filters->getGeoLayer();
        $layer_size = sizeof($geo_layer);

        if (is_null($start_layer)) {
            $start_layer = 0;
        } else {
            if ($start_layer > $layer_size) {
                $start_layer = $layer_size;
            }
        }

        if (is_null($end_layer)) {
            $end_layer = $layer_size;
        } else {

            if ($end_layer > $layer_size) {
                $end_layer = $layer_size;
            }
        }

        if ($start_layer > $end_layer) {
            $end_layer = $start_layer;
        }

        foreach ($geo_layer as $key => $value) {
            $data = array();

            if ($key < $start_layer) {
                continue;
            }
            if ($key > $end_layer) {
                break;
            }

            if ($key == $start_layer) {
                if ($value['layer_id'] == 4) {
                    $data = $this->getDB();
                } else if ($value['layer_id'] == 5) {
                    $data = $this->getPSR();
                } else {
                    $data = $this->getGeoLayerByLayerId($value['layer_id'] + 1, $user_role_code);
                }
            }


            $result = array(
                'layer_name' => $value['layer_name'],
                'layer_id' => 'geo_filter_layer' . $value['layer_id'],
                'data' => $data
            );

            array_push($layer, $result);
        }
        return $layer;
    }

    public function getGeoLayerByLayerId($layer_id, $user_role_code) {
        $biz_zone_id = $this->session->userdata('biz_zone_id');
        $data = $this->Custom_filters->getGeoLayerByLayerId($layer_id, $biz_zone_id);
        return $data;
    }

    public function getDB(){
        $user_role_code = $this->session->userdata('user_role_code');
        if($user_role_code !='DB'){
            $biz_zone_id = $this->session->userdata('biz_zone_id');
            $data = $this->Custom_filters->getDB($biz_zone_id);            
        }elseif ($user_role_code == 'MIS' || $user_role_code == 'NSM' || $user_role_code == 'USM') {
            $data = array();
        }else {
            $db_id = $this->session->userdata('db_id');
            $data = $this->Custom_filters->getOnlyDB($db_id); 
        }
        return $data;
    }
    public function getDbIds(){
        $user_role_code = $this->session->userdata('user_role_code');
        if($user_role_code !='DB'){
            $biz_zone_id = $this->session->userdata('biz_zone_id');
            $data = $this->Custom_filters->getDB($biz_zone_id);
            echo json_encode($data);            
        }elseif ($user_role_code == 'MIS' || $user_role_code == 'NSM' || $user_role_code == 'USM') {
            $data = array();
            echo json_encode($data);
        }else {
            $db_id = $this->session->userdata('db_id');
            $data = $this->Custom_filters->getOnlyDB($db_id); 
            echo json_encode($data);
        }
        
    }

    public function getPSR() {
        $db_id = $this->session->userdata('db_id');
        $data = $this->Custom_filters->getPSR($db_id);
        return $data;
    }

    public function getSrByDb() {
        $db_id = $this->input->post('db_id');
        if ($db_id) {
            $db_ids = implode(',', $db_id);
            $data = $this->Custom_filters->getPSR($db_ids);
            echo json_encode($data);
        }
    }

    public function getGeoLayer($layer_num = NULL, $parent_layer = NULL, $user_role = NULL) {
        $geo_hierarchy = $this->Custom_filters->getGeoHierarchy();
        $get_hierarchy_size = sizeof($geo_hierarchy);
        if (!is_null($layer_num)) {
            echo 'layer_num_not_set';
        }

        if (!is_null($parent_layer)) {
            echo '$parent_layer_not_set';
        }

        if (!is_null($user_role)) {
            echo '$user_role_not_set';
        }
    }

    public function getGeoLayerByParent() {
        $parent_id = $this->input->post('parent_id');

        if ($parent_id) {
            $parent_ids = implode(',', $parent_id);
            $data = $this->Custom_filters->getGeoLayerByParent($parent_ids);
            echo json_encode($data);
        }
    }

    public function getDbByBizZone() {
        $biz_zone_id = $this->input->post('parent_id');

        if ($biz_zone_id) {
            $biz_zone_ids = implode(',', $biz_zone_id);
            $data = $this->Custom_filters->getDbByBizZone($biz_zone_ids);
            echo json_encode($data);
        }
    }

    public function makeDBListForExistingReportByGeo() {
        $parent_id = $this->input->post('parent_id');
        $layer_num = $this->input->post('layer_num');

        if ($parent_id) {
            $parent_ids = implode(',', $parent_id);
            $where = " and t" . ($layer_num + 1) . ".id in($parent_ids)";
            $data = $this->Custom_filters->makeDBListForExistingReportByGeo($where);
            echo json_encode($data);
        }
    }

    public function getSkuHierarchyFilter() {
        $this->load->view('custom_filter/sku_filter/index');
    }

}
