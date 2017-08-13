<?php

class Distribution_houses extends CI_Model {

    public function insert_db_house_biz_zone_mapping($data) {
        return $this->db->insert('tbli_distribution_house_biz_zone_mapping', $data);
    }

    public function insert_distribution_house_employee($data) {
        $this->db->insert('tbld_distribution_employee', $data);
        return $this->db->insert_id();
    }

    public function insert_purchase_order_sequence($db_house_id) {
        $sql = "INSERT INTO `purchase_order_sequence`(`db_house_id`, `serial`) VALUES ('$db_house_id','0')";
        mysql_query($sql);
    }

    public function update_distribution_house_by_id($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbld_distribution_house', $data);
    }

    public function update_db_house_biz_zone_mapping($id, $data) {
        $this->db->where('dbhouse_id', $id);
        return $this->db->update('tbli_distribution_house_biz_zone_mapping', $data);
    }

    function delete_tbli_distribution_house_biz_zone_mapping_by_db_id($db_id) {
        $this->db->where('dbhouse_id', $db_id);
        return $this->db->delete('tbli_distribution_house_biz_zone_mapping');
    }

    public function update_tbli_user_role_mapping_by_user_id($id, $status) {
        $sql = "UPDATE `tbli_user_role_mapping` SET `user_role_status`='$status' WHERE user_id IN(SELECT `login_user_id` FROM `tbld_distribution_employee` WHERE `distribution_house_id`='$id')";
        $result = mysql_query($sql);
        return $result;
    }

    public function delete_tbli_dbhouse_product_line_mapping_by_id($id, $data) {
        $product_line_id = $data['product_line_id'];
        $sql = "DELETE FROM `tbli_dbhouse_product_line_mapping` WHERE `dbhouse_id`='$id' AND `product_line_id` NOT IN (" . implode(',', $product_line_id) . ")";

        $query = mysql_query($sql);
    }

    public function update_tbli_dbhouse_product_line_mapping_by_id($id, $data) {
        $product_line_id = $data['product_line_id'];
        $erp_dbcode = $data['erp_dbcode'];

        for ($i = 0; $i < count($product_line_id); $i++) {
            $sql = "SELECT * FROM tbli_dbhouse_product_line_mapping WHERE `dbhouse_id`='$id' AND `product_line_id` ='$product_line_id[$i]'";
            mysql_query($sql);
            $rc = mysql_affected_rows();
            if ($rc) {
                $sql1 = "UPDATE tbli_dbhouse_product_line_mapping SET `erp_dbcode`='$erp_dbcode[$i]' WHERE `dbhouse_id`='$id' AND `product_line_id` ='$product_line_id[$i]'";
                $query1 = mysql_query($sql1);
            } else {
                $sql1 = "INSERT INTO tbli_dbhouse_product_line_mapping(dbhouse_id,product_line_id,erp_dbcode) VALUES ('$id','$product_line_id[$i]','$erp_dbcode[$i]')";
                $query1 = mysql_query($sql1);
            }
        }
    }

    public function get_address_by_id($id) {
        $this->db->select('address_name');
        $this->db->from('tbld_address');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_damage_return_view() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_damage_inventory');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDbhouseByBizZoneIdArr($biz_zone_arr) {
        $sql = "select t1.id, t1.dbhouse_name from tbld_distribution_house as t1 inner join tbli_distribution_house_biz_zone_mapping as t2 on t1.id = t2.dbhouse_id where t2.biz_zone_id in (".implode(',',$biz_zone_arr).")";
        //var_dump($sql);
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getDBHouseByDistEmpUserID($user_id) {
        $sql = "select dbhouse_name from tbld_distribution_house t1 inner join tbld_distribution_employee t2 on t2.distribution_house_id = t1.id where t2.login_user_id = $user_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function select_sales_return_view() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_return_inventory');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_address() {
        $this->db->select('id,address_name');
        $this->db->from('tbld_address');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_owner_id($id) {
        $this->db->select('distributor_name');
        $this->db->from('tbld_distributor');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_bank_by_id($id) {
        $this->db->select('name');
        $this->db->from('tbld_account');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBHouseID($code) {
        $this->db->select('id');
        $this->db->from('tbld_distribution_house');
        $this->db->where('dbhouse_code', $code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBHouseByDistEmpID($id) {
        $this->db->select('distribution_house_id');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBhouseNameByID($id) {
        $this->db->select('*');
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBHouseNames($code) {
        $this->db->select('*');
        $this->db->from('tbld_distribution_house');
        $this->db->where('dbhouse_code', $code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delDbhouseById($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbld_distribution_house');
        return $query;
    }

    public function delete_tbli_dbhouse_sku_mapping_by_sku_id($id) {
        $this->db->where('sku_id', $id);
        $this->db->delete('tbli_dbhouse_sku_mapping');
        return $query;
    }

    public function delete_tbli_sr_sku_mapping_by_sku_id($id) {
        $this->db->where('sku_id', $id);
        $this->db->delete('tbli_sr_sku_mapping');
        return $query;
    }

    public function insert_db_house_product_line_mapping($data) {

        $dbhouse_id = $data['dbhouse_id'];
        $product_line_id = $data['product_line_id'];
        $erp_code = $data['erp_code'];
        $tm_id = $data['sales_emp_id'];


        for ($i = 0; $i < count($product_line_id); $i++) {
            $sql = "INSERT INTO tbli_dbhouse_product_line_mapping(dbhouse_id,product_line_id,erp_dbcode,sales_emp_id) VALUES ('$dbhouse_id','$product_line_id[$i]','$erp_code[$i]','$tm_id[$i]')";
            $query = mysql_query($sql);
        }
    }

    public function insert_db_house($data) {
        $this->db->insert('tbld_distribution_house', $data);
        return $this->db->insert_id();
    }

//    public function insert_distribution_mapping($data) {
//        return $this->db->insert('dbhouse_biz_zone_layer_mapping', $data);
//    }

    public function select_db_house() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_distribution_house');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_house_by_id($db_id) {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $db_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_house_by_db_id($db_id) {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_house_tso($db_id) {
        $this->db->select('id,dbhouse_name,dbhouse_code,distributor_id,db_house_status,db_credit_limit');
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $db_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_productline_names($id) {


        $this->db->select('id,name');
        $this->db->from('tbld_product_line');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_dbhouse_pl_by_id($id) {
        $this->db->select('*');
        $this->db->order_by("product_line_id", "ASC");
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $this->db->where('dbhouse_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_Dbhouse_productline_names($id) {


        $this->db->select('id,product_line_id');
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $this->db->where('dbhouse_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

//    public function select_business_zone_name_config($config_code) {
//        $this->db->select('id,attribute_id');
//        $this->db->from('tbld_config');
//        $this->db->where('config_code', $config_code);
//        $query = $this->db->get()->result_array();
//        return $query;
//    }

    public function Get_Business_zone_name($id) {
        $this->db->select('id,biz_zone_name');
        $this->db->from('tbld_business_zone');
        $this->db->where('biz_zone_category_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * Shuaib Vi
     * 
     */

    public function select_db_house_by_biz_zone($id) {
        $this->db->where('biz_zone_id', $id);
        $this->db->select('dbhouse_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_biz_zone_by_db_house($id) {
        $this->db->where('dbhouse_id', $id);
        $this->db->select('biz_zone_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    public function select_biz_zone_by_db_house_and_pl($id, $pl_id) {
        $this->db->where('dbhouse_id', $id);
        $this->db->where('pl_id', $pl_id);
        $this->db->select('biz_zone_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    public function select_db_by_biz_zone_and_pl($pl_id, $biz_id) {
        $this->db->where('biz_zone_id', $biz_id);
        $this->db->where('pl_id', $pl_id);
        $this->db->select('dbhouse_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_dbhouse_name_by_id($id) {
        $this->db->where('id', $id);
        $this->db->select('id,dbhouse_name');
        $this->db->from('tbld_distribution_house');
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * end
     */

    public function Get_Dbhouse_owner_names($id) {
        $this->db->select('id,distributor_name');
        $this->db->from('tbld_distributor');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_Dbhouse_Biz_zone_ids($id) {
        $this->db->select('id,biz_zone_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $this->db->where('dbhouse_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_Dbhouse_Biz_zone_names($id) {
        $this->db->select('id,biz_zone_name');
        $this->db->from('tbld_business_zone');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_Dbhouse_Statuss($id) {
        $this->db->select('id,db_house_status_name');
        $this->db->from('tbld_distribution_house_status');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_status() {
        $this->db->select('id,db_house_status_name');
        $this->db->from('tbld_distribution_house_status');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_owner() {
        $this->db->select('id,distributor_name');
        $this->db->from('tbld_distributor');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_business_zone_by_id($id) {
        $this->db->select('biz_zone_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $this->db->where('dbhouse_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_address() {
        $this->db->select('id,address_name');
        $this->db->from('tbld_address');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_bank() {
        $this->db->select('*');
        $this->db->from('tbld_account');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insert_db_house_sku_mapping($data) {
        return $this->db->insert('tbli_dbhouse_sku_mapping', $data);
    }

    public function insert_tbld_inventory($data) {
        return $this->db->insert('tbld_inventory', $data);
    }

    public function insert_db_house_sku_buffer_level($data) {
        return $this->db->insert('tbld_buffer_level_entry', $data);
    }

    public function getErpCodeOfDBhouse($dbhouse, $pl) {
        $this->db->select('erp_dbcode');
        $this->db->where('dbhouse_id', $dbhouse);
        $this->db->where('product_line_id', $pl);
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getProductLinesOfDBhouse($dbhouse) {
        $this->db->select('product_line_id, sales_emp_id');
        $this->db->where('dbhouse_id', $dbhouse);
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBhouseByProductLines($pl) {
        $this->db->select('dbhouse_id');
        $this->db->where('product_line_id', $pl);
        return $this->db->get('tbli_dbhouse_product_line_mapping')->result_array();
    }

    public function select_db_damage() {
        $this->db->select('id,damage_name');
        $querys = $this->db->get('tbld_db_damage_criteria')->result_array();
        return $querys;
    }
    public function getDBLayerList() {
        $sql = "SELECT id,dbhouse_name as name FROM `tbld_distribution_house`";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}

?>