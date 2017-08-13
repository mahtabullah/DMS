<?php
ini_set('memory_limit', '-1');

if( !defined('BASEPATH')){
    exit('No direct script access allowed');
}

class Outlet extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Outlets');
        
    }

    public function DbOutletIndex()
    {
        $db_ids = $this->getDbIds();
        $data['db'] = $this->Outlets->getDbInfoByDbIds($db_ids);
        $data['outlet']=$this->Outlets->getOutletDbId($db_ids);
        
        
    //    var_dump($data);
               
               
        $this->load->view('outlet/Dboutlet_index',$data);
    }

    public function getDbIds(){
        $user_role_code = $this->session->userdata('user_role_code');
        $biz_zone_id = $this->session->userdata('biz_zone_id');
        if($user_role_code == 'DB'){
            $db_id = $this->session->userdata('db_id');
            $db_ids = "$db_id";
        } else if($user_role_code == 'MIS'){
            $db_ids = "";
        } else if($user_role_code == 'NSM' || $user_role_code == 'USM' || $user_role_code == 'TDM' || $user_role_code == 'CE'){
            $db_ids = $this->Outlets->getDBIds($biz_zone_id);
            $db_ids = " IN (".$db_ids[0]['dbhouse_id'].")";
        }
        return $db_ids;
    }



}
