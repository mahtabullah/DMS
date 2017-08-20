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
        $db_id = $this->session->userdata('db_id');
        $data['Route_plan'] = $this->Route_plans->getAllRoutePlan($db_id);
        // var_dump($data);
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
        $psr = $this->Route_plans->getDbpSrList($db_id);


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
        $option .= '<option>NONE</option>';
        if (!empty($subroute)) {

            foreach ($subroute as $name) {
                $option .= '<option value="' . $name['id'] . '">[' . $name['db_channel_element_code'] . ']  ' . $name['db_channel_element_name'] . '</option>';
            }

            echo $option;
        }
    }

    public function save_route_plan() {

        $rp_name = $this->input->post('route_plan_name');
        $route_plan_description = $this->input->post('route_plan_desc');

        $psr = $this->input->post('psr');
        $db_id = $this->input->post('dbhouse');
        $code_rp = "RP-" . $db_id . "-" . $psr;
        $date_created = date('Y-m-d');

        $date_strt = date("Y-m-d", strtotime($_POST['date_frm']));
        $date_end = date("Y-m-d", strtotime($_POST['date_to']));
       // $date_strt="2017-08-16";
        $day_wise_route = array(
            '0' => $_POST['sat_routes'],
            '1' => $_POST['sun_routes'],
            '2' => $_POST['mon_routes'],
            '3' => $_POST['tue_routes'],
            '4' => $_POST['wed_routes'],
            '5' => $_POST['thu_routes'],
            '6' => $_POST['fri_routes']
        );


        //var_dump($day_wise_route);







        $route_plan = array(
            'route_plan_name' => $rp_name,
            'route_plan_code' => $code_rp,
            'route_plan_description' => $route_plan_description,
            'dbhouse_id' => $db_id,
            'dist_emp_id' => $psr,
            'creation_date' => $date_created,
            'start_date' => $date_created,
            'end_date' => $date_end,
            'created_by' => 1,
            'Modify_date' => $date_created
        );


        $insert_into_route_plan = $this->Route_plans->insertData('tbld_route_plan', $route_plan);

        // $insert_into_route_plan = 2;
        for ($z = 0; $z < 7; $z++) {
            if ($day_wise_route[$z][0] != "NONE") {
                $current_route_plan = array(
                    'route_plan_id' => $insert_into_route_plan,
                    'route_id' => $day_wise_route[$z][0],
                    'dbhouse_id' => $db_id,
                    'Psr_id' => $psr,
                    'day' => $z
                );
                $insert_current_route_plan = $this->Route_plans->insertData('tblt_current_route_plan', $current_route_plan);
            }
            //  echo'<pre>';
            //  var_dump($current_route_plan);
            //  echo'</pre>';
        }




        $date_diff = (strtotime($date_end) - strtotime($date_strt)) / 86400;
        $date = date('Y-m-d', date(strtotime("+1 day", strtotime($date_strt))));

        $i = 0;
        $date = $date_strt;
        $Deliverydate = date('Y-m-d', date(strtotime("+1 day", strtotime($date_strt))));

        for ($x = 1; $x <= $date_diff + 1; $x++) {
            if ($day_wise_route[$i][0] != 0) {
                $route_plan_details = array(
                    'route_plan_id' => $insert_into_route_plan,
                    'route_id' => $day_wise_route[$i][0],
                    'dbhouse_id' => $db_id,
                    'dist_emp_id' => $psr,
                    'planned_visit_date' => $date,
                    'delivery_date' => $Deliverydate
                );
                $insert_into_route_plan_detail = $this->Route_plans->insertData('tblt_route_plan_detail', $route_plan_details);
            }
            $i++;
            if ($i == 7) {
                $i = 0;
            }
            $date = date('Y-m-d', date(strtotime("+1 day", strtotime($date))));
            $Deliverydate = date('Y-m-d', date(strtotime("+1 day", strtotime($Deliverydate))));
        }
        redirect(site_url('route_plan'));
    }

}
