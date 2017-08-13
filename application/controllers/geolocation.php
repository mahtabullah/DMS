<?php

if( !defined('BASEPATH')) exit('No direct script access allowed');

class Geolocation extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('geolocations');
        $this->load->model('Business_zones');
        $this->method_call = &get_instance();
    }

    public function index()
    {
        $title = 'Geo Reports';
        $this->getTitle($title);
        $data['business_zone'] = $this->Business_zones->getAllBusinessZone();
        $this->load->view('geolocation/index', $data);
    }

    public function getTitle($title){
        $data['title']=$title;
        $this->load->view('header/header',$data);
    }

    public function get_geo_filter_result(){

        $db_id = $this->input->post('db_id');
        $emp_type = $this->session->userdata('emp_type');
        if($emp_type == 'distribution'){
            $db = $this->session->userdata('db_id');
            $db_id = array($db);
        }

        $sr_id = $this->input->post('sr_id');
        $route_id = $this->input->post('route_id');
        $market_id = $this->input->post('market_id');
        $outlet_id = $this->input->post('outlet_id');

        $market_ids = '';
        $route_ids = '';
        $outlet_ids = '';
        $db_ids = '';
        $sr_ids = '';

        if($outlet_id){
            $outlet_ids .= ' and t1.outlet_id IN(' . implode(",", $outlet_id) . ') ';
        }else if($market_id){
            $market_ids .= ' and t2.parent_id IN(' . implode(",", $market_id) . ') ';
        } else if($route_id){
            $route_ids .= ' and t1.route_id IN(' . implode(",", $route_id) . ') ';
        } else if($db_id){
            $db_ids .= ' IN(' . implode(",", $db_id) . ') ';
        }

        if($sr_id){
            $sr_ids .= ' AND t1.dist_emp_id IN(' . implode(",", $sr_id) . ') ';
        }


        $date = date('Y-m-d', strtotime($this->input->post('date_frm')));

        $data = $this->geolocations->get_geo_filter_result($date,$db_ids,$sr_ids,$route_ids,$market_ids,$outlet_ids);

        echo '{"map":' . json_encode($data) . '}';
    }

    public function get_geodata()
    {
        $where = '';
        $current_date = date("Y-m-d");

        $db_id = $this->input->post('db_id');
        $emp_type = $this->session->userdata('emp_type');
        if($emp_type == 'distribution'){
            $db = $this->session->userdata('db_id');
            $db_id = array($db);
        }

        $sr_id = $this->input->post('sr_id');
        $route_id = $this->input->post('route_id');
        $market_id = $this->input->post('market_id');
        $outlet_id = $this->input->post('outlet_id');

        $market_ids = '';
        $route_ids = '';
        $outlet_ids = '';
        $db_ids = '';
        $sr_ids = '';

        if($outlet_id){
            $outlet_ids .= ' AND outlet_id IN(' . implode(",", $outlet_id) . ') ';
        }else if($market_id){
            $market_ids .= ' AND market_id IN(' . implode(",", $market_id) . ') ';
        } else if($route_id){
            $route_ids .= ' AND route_id IN(' . implode(",", $route_id) . ') ';
        } else if($db_id){
            $db_ids .= ' AND db_id IN(' . implode(",", $db_id) . ') ';
        }

        if($sr_id){
            $sr_ids .= ' AND sr_id IN(' . implode(",", $sr_id) . ') ';
        }

        $date_frm = date('Y-m-d', strtotime($this->input->post('date_frm')));


        $date_range = " AND DATE(planned_visit_date) = '$date_frm'";

        $where = $market_ids.$route_ids.$db_ids.$sr_ids.$date_range.$outlet_ids;

        if($current_date==$date_frm ){
            $data = $this->geolocations->getGeoLocations_previous($where);
        }else{
            $data = $this->geolocations->getGeoLocations($where);
        }


        echo '{"map":' . json_encode($data) . '}';
    }

    public function get_geo_filter_data($sr)
    {
        $data = $this->geolocations->getGeoLocations_filter($sr);
        echo '{"map":' . json_encode($data) . '}';
    }

    public function get_geo_filter_datas()
    {
        $dbhouse = $this->input->post('dbhouse');
        $data['sr'] = $this->input->post('sr');
        $this->load->view('geolocation/filter_data', $data);
    }

}

?>