<?php

class Logins extends CI_Model
{

    public function verify_user_pass($user, $pass)
    {
        $this->db->select('id');
        $this->db->from('tbld_user');
        $this->db->where('user_id = "' . $user . '" and user_password = "' . $pass . '"');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function verify_user_pass_by_id($user, $pass)
    {
        $this->db->select('id');
        $this->db->from('tbld_user');
        $this->db->where('id = "' . $user . '" and user_password = "' . $pass . '"');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function verify_user_status($id)
    {
        $this->db->select('user_role_status');
        $this->db->from('tbli_user_role_mapping');
        $this->db->where('user_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getUserIdByUser($user)
    {
        $this->db->select('id');
        $this->db->from('tbld_user');
        $this->db->where('user_id', $user);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getUserRoleByUserId($uid){
        $this->db->select('user_role_id');
        $this->db->from('tbli_user_role_mapping');
        $this->db->where('user_id', $uid);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getUserRoleNameByUserId($uid)
    {
        $this->db->select('*');
        $this->db->from('tbld_user_role');
        $this->db->where('id', $uid);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getWebServiceName(){
        $this->db->select('config_code');
        $this->db->from('tbld_config');
        $this->db->where('id', 7);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_validation_info($time, $user_id)
    {
        $sql = "SELECT t1.login_user_id,t2.time_frm,t2.time_to FROM `tbld_pri_production_employee` as t1 left join `tbld_pri_shifting_type` as t2 on t1.shifting_type_id=t2.id where login_user_id=$user_id and '$time' between time_frm and time_to";
        $query = mysql_num_rows(mysql_query($sql));
        return $query;
    }


}