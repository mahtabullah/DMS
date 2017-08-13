<?php

class Distribution_employees extends CI_Model {

    public function getDistEmpNameById($id) {
        $this->db->select('*');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    public function update_distribution_employee_by_id($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbld_distribution_employee',$data);
    }
    public function get_db_name($db_id){
        $this->db->select('dbhouse_name');
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $db_id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    

    public function getEmpNameByIdSRs($db_id) {
        if(!$db_id){
            $db_id=0;
        }
//        $this->db->select('*');
//        $this->db->from('tbld_distribution_employee');
//        $this->db->where('distribution_house_id', $db_id);
//        $this->db->where('dist_role_id', 2);
//        $query = $this->db->get()->result_array();
//        return $query;
        $sql ="SELECT id,
            CASE WHEN emp_status = 0 THEN concat(first_name,' (Inactive)') ELSE first_name END AS first_name
            FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2 order by emp_status desc";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    public function getEmpInfoByDbId($db_id) {
//        $db = explode(",",$db_id);
//        echo $db;
        return $this->db->query("select * from tbld_distribution_employee where distribution_house_id in ($db_id) and dist_role_id = 2")->result_array();
    }
    public function getEmpInfoByDb($db_id) {
//        $db = explode(",",$db_id);
//        echo $db;
        return $this->db->query("select id,first_name from tbld_distribution_employee where distribution_house_id in ($db_id) and dist_role_id = 2")->result_array();
    }
    
    
    public function getDistEmpNameUserId($id) {
        $this->db->select('*');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('login_user_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function get_product_lines($id) {
//        $this->db->select('product_line_id');
//        $this->db->from('tbli_dbhouse_product_line_mapping');
//        $this->db->where('dbhouse_id', $id);
//        $query = $this->db->get()->result_array();
        $sql = mysql_query("select t2.id, t2.element_name from tbld_sku_hierarchy_elements as t2 inner join tbli_dbhouse_product_line_mapping as t1 on t1.product_line_id = t2.id where t1.dbhouse_id = '$id'");
        //var_dump($sql);
        while($ret = mysql_fetch_array($sql)){
            //var_dump($ret);
            $q[] = array('id' => $ret['id'], 'name' => $ret['element_name']);
        }
        //var_dump($q);
        return $q;
    }

    public function getCMByIdSRs($id) {
//        $this->db->select('*');
//        $this->db->from('tbld_outlet');
//        $this->db->where('dbhouse_id', $id);
//        $this->db->where('parent_id', "-1");
//
//        $query = $this->db->get()->result_array();
//        return $query;
//        $sql = "select * from tbld_outlet where dbhouse_id = '$id' and (parent_id = '-1' OR outlet_type_id = '4')";
        return $this->db->query("select * from tbld_outlet where dbhouse_id = '$id' and (parent_id = '-1' OR outlet_type_id = '4')")->result_array();
    }

    public function insert_db_house_emp_product_line_mapping($distribution_house_id, $inserts, $product_line_id) {
        $query = array();
        $j = 0;
        for ($i = 0; $i < count($product_line_id); $i++) {
            $sql = "INSERT INTO `tbli_db_house_emp_product_line_mapping`(`dbhouse_id`, `emp_id`, `pl_id`) "
                    . "VALUES ('$distribution_house_id','$inserts','$product_line_id[$i]')";
            $query = mysql_query($sql);
        }
        return $query;
    }
    
    public function update_db_house_emp_product_line_mapping($emp_id,$pl_id){
        $sql = "UPDATE tbli_db_house_emp_product_line_mapping set pl_id=$pl_id where emp_id=$emp_id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getDistEmpIdByCode($code) {
        $this->db->select('id');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('dist_emp_code', $code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllDistEmp() {
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->from('tbld_distribution_employee');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete_tbld_distribution_employee_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('tbld_distribution_employee'); 
        return $result;
    }

    public function getDistEmpByDbhouse($dbhouse) {
        $this->db->select('id,dist_emp_code,first_name');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('distribution_house_id', $dbhouse);
        return $this->db->get()->result_array();
    }
    
//    public function getDistEmpByDbhouseArr($db_arr) {
//        $sql = "select id,dist_emp_code,first_name from tbld_distribution_employee where distribution_house_id in (".implode(',',$db_arr).")";
//        $query = $this->db->query($sql);
//        return $query->result_array();
//    }
    
    public function getDbhouseByDistEmpId($emp) {
        $this->db->select('distribution_house_id');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('id', $emp);
        return $this->db->get()->result_array();
    }

    public function getDistEmpByRole($id) {
        $this->db->select('id,first_name');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('dist_role_id', $id);
        return $this->db->get()->result_array();
    }
    
    public function getDistEmpByRoleCodeAndDb($code,$db) {
        $sql = mysql_query("SELECT t1.id, t1.first_name FROM `tbld_distribution_employee` as t1 inner join `tbld_distribution_hierarchy` as t2 on t1.dist_role_id=t2.id where t2.dist_role_code = '$code' and distribution_house_id = '$db' and t1.emp_status = 1");
        while($retval = mysql_fetch_array($sql)){
            $sr[] = array('id' => $retval['id'], 'name' => $retval['first_name']);
        }
        //var_dump($sr);
        return $sr;
    }
    

//    public function getSalesManagerByEmpId($id) {
//        $this->db->select('sales_manager_id');
//        $this->db->where('id', $id);
//        $q = $this->db->get('tbld_distribution_employee')->result_array();
//        foreach ($q as $query1) {
//            $this->db->select('id, first_name');
//            $this->db->where('id', $query1['sales_manager_id']);
//            $q = $this->db->get('tbld_sales_employee')->result_array();
//        }
//        return $q;
//    }
    
    public function getSalesManagerByDbhouseId($db_id) {
        $this->db->select('sales_emp_id');
        $this->db->where('dbhouse_id', $db_id);
        $q = $this->db->get('tbli_dbhouse_product_line_mapping')->result_array();
//        foreach ($q as $query1) {
//            $this->db->select('id');
//            $this->db->where('id', $query1['sales_emp_id']);
//            $q[] = $this->db->get('tbld_sales_employee')->result_array();
//        }
        return $q;
    }

    public function getDistEmpPlById($emp_id) {
        $this->db->select('pl_id');
        $this->db->where('emp_id', $emp_id);
        return $this->db->get('tbli_db_house_emp_product_line_mapping')->result_array();
    }
    
    public function getDistEmpPlByIdStr($emp_id) {
        $emp_str = implode(",",$emp_id);
//        $this->db->select('pl_id');
//        $this->db->where('emp_id', $emp_id);
        return $this->db->query("select * from tbli_db_house_emp_product_line_mapping where emp_id in ($emp_str)")->result_array();
    }
    
    public function getSkuBySrId($sr_id) {
        $this->db->select('sku_id');
        $this->db->where('emp_id', $sr_id);
        return $this->db->get('tbli_sr_sku_mapping')->result_array();
    }
    
    public function getDbNameBySrId($sr_id) {
        $sql="select dbhouse_name from tbld_distribution_house as t1 inner join tbld_distribution_employee as t2 on t1.id=t2.distribution_house_id where t2.id='$sr_id'";
        return $this->db->query($sql)->result_array();
    }

    public function insert_sr_sku_mapping($data) {
        return $this->db->insert('tbli_sr_sku_mapping', $data);
    }

    public function insert_sr_so_serial_data($data) {
        return $this->db->insert('tblp_sales_order_serial', $data);
    }
    public function getDbList(){
        $sql = "SELECT id,dbhouse_name as name FROM `tbld_distribution_house`";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getZoneInfo($id){
        $sql = "SELECT t1.distribution_house_id as db_id,t2.biz_zone_id,t2.pl_id,t3.name as pl_name FROM `tbld_distribution_employee` as t1 
                left join tbli_distribution_house_biz_zone_mapping as t2 on t1.distribution_house_id=t2.dbhouse_id
                left join tbld_product_line as t3 on t2.pl_id=t3.id
                where t1.id=$id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getSrPl($id){
        $sql = "SELECT pl_id FROM `tbli_db_house_emp_product_line_mapping`
                where emp_id=$id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function insert_into_db_sr_mapping($sr_id,$dbs){
        foreach($dbs as $db){
            $sql = "INSERT INTO `tbli_db_sr_mapping` (`db_id`,`sr_id`) values($db,$sr_id)";
            $query = $this->db->query($sql);
        }
        return 1;
    }

}
