<?php

class Users extends CI_Model {

    public function getAllUser() {
        $this->db->select('id,user_name');
        $this->db->from('tbld_user');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getUserIdById($id) {
        $this->db->select('user_name');
        $this->db->where('id', $id);
        return $this->db->get('tbld_user')->result_array();
    }

    public function getEmpInfoByUserId($id) {
        $this->db->select('*');
        $this->db->from('tbld_sales_employee');
        $this->db->where('login_user_id', $id);
        $query = $this->db->get()->result_array();
        $emp_type = 'sales';
        if (count($query) == 0) {
            $this->db->select('*');
            $this->db->from('tbld_distribution_employee');
            $this->db->where('login_user_id', $id);
            $query = $this->db->get()->result_array();


//            $sql = "SELECT t1.*,t2.biz_zone_id FROM `tbld_distribution_employee` as t1
//                    left join `tbli_distribution_house_biz_zone_mapping` as t2 on t1.distribution_house_id=t2.dbhouse_id
//                    where t1.login_user_id=$id";
//            $query = $this->db->query($sql)->result_array();

            $emp_type = 'distribution';
            if (count($query) == 0) {
//                $this->db->select('*');
//                $this->db->from('tbld_pri_production_employee');
//                $this->db->where('login_user_id', $id);
//                $query = $this->db->get()->result_array();
//                $emp_type = 'production';
                $sql = " select name as first_name, id from tbld_pri_production_employee where login_user_id = $id ";
                $query = $this->db->query($sql)->result_array();
                if (count($query) == 0) {
                    echo "mara kaho!!";
                }
            }
        }
        $result = array('query' => $query, 'emp_type' => $emp_type);
        return $result;
    }

    public function get_tbld_user_role(){
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_user_role');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_tbld_user_group() {
        $this->db->select('*');
        $this->db->from('tbld_user_group');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function save_user_role($data) {
        return $this->db->insert('tbld_user_role', $data);
    }

    public function user_group_save($data) {
        return $this->db->insert('tbld_user_group', $data);
    }

    public function user_save($data) {
       
       $user_name = $data['user_name'];
       $user_id = $data['user_id']; 
       $user_password = $data['user_password'];
       
       $query = $this->db->query("SELECT user_id,user_password FROM tbld_user WHERE user_name = '".$user_name."' and user_id = '".$user_id."' ");
       
        if (sizeof($query->row_array()) == 0){
            
            $this->db->insert('tbld_user', $data);
            return $this->db->insert_id();

        }else{
            $message = 'already exists';
           $error_mg['message']= $this->session->user_set($message);
            return $error_mg;   
        }
    }

    public function user_group_mapping_save($data_g) {
        return $this->db->insert('tbld_user_group_mapping', $data_g);
    }

    public function user_role_mapping_save($data_r) {
        return $this->db->insert('tbli_user_role_mapping', $data_r);
    }

    public function get_tbld_user() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_user');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_user_group_by_id($id) {
        $query = mysql_query("SELECT `user_group_name` FROM tbld_user_group WHERE `id` IN(SELECT `user_group_id` FROM tbld_user_group_mapping WHERE `user_id`='$id')");
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function getNameInfobyDbId($db_id) {
        $query = mysql_query("SELECT t1.*, t2.address_name FROM `tbld_distribution_house` as t1 Left Join `tbld_address` as t2 On t1.dbhouse_address_id=t2.id where t1.id=$db_id");
        $result = mysql_fetch_array($query);
        return $result;
    }
    
    public function getDBHouseBySpokeId ($id){
        $sql = "SELECT `spoke_id` FROM `tbli_hub_spoke_mapping` where hub_id=$id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function get_user_role_by_id($id) {
        // $this->db->select('*');
        // $this->db->from('tbld_user_role');
        // $this->db->where("id", $id);
        // $query = $this->db->get()->result_array();
        // return $query;
        $query = mysql_query("SELECT `user_role_name` FROM tbld_user_role WHERE `id` IN(SELECT `user_role_id` FROM tbli_user_role_mapping WHERE `user_id`='$id')");
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function get_tbld_user_role_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_user_role');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function update_tbld_user_role($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbld_user_role', $data);
    }

    public function delete_tbld_user_role_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbld_user_role');
    }

    public function get_tbld_user_group_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_user_group');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function update_tbld_user_group($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbld_user_group', $data);
    }

    public function updatePassByUser($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('tbld_user', $data);
    }

    public function delete_tbld_user_group_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbld_user_group');
    }

    public function get_tbld_user_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_user');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_tbld_role_by_id($id) {
        // $this->db->select('*');
        // $this->db->from('tbld_user_role');
        // $this->db->where("id", $id);
        // $query = $this->db->get()->result_array();
        // return $query;
        $query = mysql_query("SELECT `id`,`user_role_name` FROM tbld_user_role WHERE `id` IN(SELECT `user_role_id` FROM tbli_user_role_mapping WHERE `user_id`='$id')");
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function get_tbld_group_by_id($id) {
        // $this->db->select('*');
        // $this->db->from('tbld_user_group');
        // $this->db->where("id", $id);
        // $query = $this->db->get()->result_array();
        // return $query;
        $query = mysql_query("SELECT `id`,`user_group_name` FROM tbld_user_group WHERE `id` IN(SELECT `user_group_id` FROM tbld_user_group_mapping WHERE `user_id`='$id')");
        $result = mysql_fetch_array($query);
        return $result;
    }

    public function update_tbld_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbld_user', $data);
    }

    public function update_tbld_user_group_mapping_by_id($id, $data) {
        $this->db->where('user_id', $id);
        return $this->db->update('tbld_user_group_mapping', $data);
    }

    public function update_tbli_user_role_mapping_by_id($id, $data) {
        $this->db->where('user_id', $id);
        return $this->db->update('tbli_user_role_mapping', $data);
    }

    public function delete_tbld_user_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbld_user');
    }

    public function get_user_profile ($id){
        $sql = "SELECT t1.user_id,t1.user_name,t3.user_role_name FROM tbld_user as t1
                LEFT JOIN tbli_user_role_mapping as t2 on t1.id = t2.user_id
                LEFT JOIN tbld_user_role as t3 on t2.user_role_id = t3.id WHERE t1.id = 1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function dbInfoByDbId($db_id){
        $sql = "select * from tbld_distribution_house where id=$db_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

}

?>