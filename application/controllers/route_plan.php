<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Route_plan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Route_plans');
        $this->load->model('Outlets');
        $this->load->model('orders');
    }

    public function index() {

        $this->load->view('route_plan/index', $data);
    }

    public function makeRoutePlan() {
        $db_id = $this->session->userdata('db_id');
        $data['dbhouse'] = $this->Outlets->getDbInfoByDbIds($db_id);
        //var_dump($data);
        $this->load->view('route_plan/Add_route_plan', $data);
    }

    public function getDbIds() {
        $user_role_code = $this->session->userdata('user_role_code');
        $biz_zone_id = $this->session->userdata('biz_zone_id');
        if ($user_role_code == 'DB') {
            $db_id = $this->session->userdata('db_id');
            $db_ids = "$db_id";
        } else if ($user_role_code == 'MIS') {
            $db_ids = "";
        } else if ($user_role_code == 'NSM' || $user_role_code == 'USM' || $user_role_code == 'TDM' || $user_role_code == 'CE') {
            $db_ids = $this->Outlets->getDBIds($biz_zone_id);
            $db_ids = " IN (" . $db_ids[0]['dbhouse_id'] . ")";
        }
        return $db_ids;
    }

    public function getPSRbyDBid() {
        $db_id = $this->input->post('db_id');
        $psr = $this->orders->getDbpSrList($db_id);


        if (!empty($psr)) {

            foreach ($psr as $name) {
                $option .= '<option value="' . $name['id'] . '">' . $name['name'] . '</option>';
            }

            echo $option;
        }
    }

    public function getSubRoutebyDBid() {
        $db_id = $this->input->post('db_id');
        $subroute = $this->orders->getAllsubroute($db_id);
        $option .= '<option></option>';
        if (!empty($subroute)) {

            foreach ($subroute as $name) {
                $option .= '<option value="' . $name['id'] . '">[' . $name['db_channel_element_code'] . ']  ' . $name['db_channel_element_name'] . '</option>';
            }

            echo $option;
        }
    }
    public function save_route_plan(){
        
        echo $rp_name = $this->input->post('route_plan_name');
        echo  $psr = $this->input->post('PSR');
       echo   $db_id = $this->input->post('dbhouse');
        echo  $code_rp = "RP" . $db_id . $psr;
        echo  $date_created = date('Y-m-d');
      
        echo  $date_strt = date("Y-m-d", strtotime($_POST['date_frm']));
         echo  $date_strt = date("Y-m-d", strtotime($_POST['date_to']));
        
         $day_wise_route = array(
            'saturday' => $_POST['sat_routes'],
            'sunday' => $_POST['sun_routes'],
            'monday' => $_POST['mon_routes'],
            'tuesday' => $_POST['tue_routes'],
            'wednesday' => $_POST['wed_routes'],
            'thursday' => $_POST['thu_routes'],
            'friday' => $_POST['fri_routes']
        );
         echo"<pre>";
        var_dump($day_wise_route);
         echo"</pre>";
    }
}
