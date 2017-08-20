<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stocks');
        //$this->load->model('Sales_orders');
    }
 public function index() {
     
     $db_ids=$this->getDbIds();
    
     $data["current_stock"]=$this->stocks->current_stock($db_ids);
     
     
       $this->load->view('stock/Current_stock',$data);
    }
    
     public function getDbIds() {

        $user_role_code = $this->session->userdata('user_role_code');
        $biz_zone_id = $this->session->userdata('biz_zone_id');

        if ($user_role_code == 'DB') {
            $db_id = $this->session->userdata('db_id');
            $db_ids = "$db_id";
        } else {
            if ($user_role_code == 'MIS') {
                $db_ids = "";
            } else {
                if ($user_role_code == 'TM' || $user_role_code == 'RSM' ||
                        $user_role_code == 'TDM' || $user_role_code == 'CE' || $user_role_code == 'USM' || $user_role_code == 'NSM'
                ) {
                    $db_ids = $this->Homes->getDBIds($biz_zone_id);
                    $db_ids = "" . $db_ids[0]['dbhouse_id'] . "";
                }
            }
        }

        return $db_ids;
    }

}