<?php

class Route_plans extends CI_Model {

    
    public function getAllRoutePlan($db_id){
        $sql = "SELECT t1.id,t1.route_plan_name,t1.route_plan_code,t4.dbhouse_name,t3.first_name,t1.Modify_date,t1.start_date,end_date FROM `tbld_route_plan` as t1
                    inner join tbld_distribution_employee as t3 on t1.dist_emp_id = t3.id 
                left join tbld_distribution_house as t4 on t1.dbhouse_id=t4.id
                where t1.dbhouse_id=$db_id ";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
    public function getRoutebByPSR($psr_id){
        $sql = "SELECT t1.id,t1.route_plan_name,t1.route_plan_code,t4.dbhouse_name,t3.first_name,t1.Modify_date,t1.start_date,end_date FROM `tbld_route_plan` as t1
                    inner join tbld_distribution_employee as t3 on t1.dist_emp_id = t3.id 
                left join tbld_distribution_house as t4 on t1.dbhouse_id=t4.id
                where t1.dbhouse_id=$db_id ";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
    
     public function getDbpSrList($db_id)
        {
            $sql   = "SELECT id,first_name as name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
            $query = $this->db->query($sql)->result_array();

            return $query;
        }

    public function total($search) {
        if ($search != '') {
            $where = "where t4.first_name  LIKE '%$search%'  or t3.db_channel_element_name LIKE '%$search%'";
        } else {
            $where = "";
        }
        $sql = "select t1.*,t3.db_channel_element_name as territory,t4.first_name from `tbld_route_plan_instance` as t1 
                left join `tbld_tso_territory_mapping` as t2 
                on t1.dist_emp_id=t2.tso_id 
                inner join `tbld_distribution_channel_elements` as t3 
                on t2.territory_id=t3.id 
                inner join `tbld_distribution_employee` as t4 
                on t1.dist_emp_id=t4.id 
                $where
                order by t1.id desc";
        $query = $this->db->query($sql)->num_rows();
        return $query;
    }

    public function getAllRoutePlanInstances_by_db_id($db_id) {
//        $this->db->select('id,route_plan_instance_code,route_plan_id,dist_emp_id,start_date,end_date,route_plan_instance_status');
//        $this->db->order_by("id","desc");
//        $this->db->from('tbld_route_plan_instance');
//        $query = $this->db->get()->result_array();
//        return $query;
        $sql = "SELECT * FROM tbld_route_plan_instance where dist_emp_id IN(SELECT id FROM `tbld_distribution_employee` where distribution_house_id='$db_id')";
        $query = mysql_query($sql);
        while ($x = mysql_fetch_assoc($query)) {
            $y[] = $x;
        }
        return $y;
    }

    public function get_route_by_date($id) {
        $this->db->select('DISTINCT(`route_id`),`planned_visit_date`,`route_class_id`');
        $this->db->from('tblt_route_plan_detail');
        $this->db->where("route_plan_instance_id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_previout_route_by_id($id) {
//        $sql = "SELECT route_activity_date,route_id FROM `tblt_route_sr_schedule_mapping` where instance_number=$id group by route_id";
//        $query = $this->db->query($sql);
//        return $query->result_array($query);
        
        $sql1 = "SELECT route_id,max(planned_visit_date) as visit_date FROM `tblt_route_plan_detail` where route_plan_instance_id=$id";
          
        $query1 = $this->db->query($sql1)->result_array();
        
        $to_date = $query1[0]['visit_date'];
        $from_date = date('Y-m-d',(strtotime ( '-10 day' , strtotime($to_date))));
        
          $sql =    "SELECT route_id,DATE_FORMAT(planned_visit_date,'%a') as day,route_class_id  FROM `tblt_route_plan_detail` 
                    where route_plan_instance_id=$id
                    and planned_visit_date between '$from_date' and '$to_date'
                    group by day,route_id";
          $query = $this->db->query($sql)->result_array();
          return $query;
    }

    public function getAllStatus($status_id) {
        $this->db->select('route_status_name');
        $this->db->from('tbld_route_status');
        $this->db->where("id", $status_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_route_plan_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_route_plan');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete_tbld_route_plan_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbld_route_plan');
        $this->db->where('route_plan_instance_id', $id);
        $this->db->where('planned_visit_date  >=', date('Y-m-d'));
        $this->db->delete('tblt_route_plan_detail');
        $this->db->where('route_plan_instance_id', $id);
        $this->db->delete('tblt_route_plan_route_mapping');
        $this->db->where('instance_number', $id);
        $this->db->delete('tblt_route_sr_schedule_mapping');

        $this->db->where('route_id', $id);
        $this->db->delete('tblt_route_distribution_employee_mapping');

        $this->db->where('route_plan_id', $id);
        $result = $this->db->delete('tbld_route_plan_instance');
        return $result;
    }

    public function getRpCode($rp_code) {
        //var_dump($rp_code);
        $this->db->select('id');
        $this->db->from('tbld_route_plan');
        $this->db->where("route_plan_code", $rp_code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getRpIns($id) {
        //var_dump($id);
        $this->db->select('instance_number');
        $this->db->from('tbld_route_plan_instance');
        $this->db->where("route_plan_id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getRouteId($dbhouse_id) {
        //var_dump($id);
        $this->db->select('id,route_name');
        $this->db->from('tbld_route');
        $this->db->where("dbhouse_id", $dbhouse_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getRoutePlanId($rp_code) {
        //var_dump($id);
        $this->db->select('id');
        $this->db->from('tbld_route_plan');
        $this->db->where("route_plan_code", $rp_code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getRoutePlanInsId($rpi_code) {
        //var_dump($id);
        $this->db->select('id');
        $this->db->from('tbld_route_plan_instance');
        $this->db->where("route_plan_instance_code", $rpi_code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDay($date) {
        //var_dump($id);
        $this->db->select('day');
        $this->db->from('tbld_calendar');
        $this->db->where("date", $date);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getOutletIds($sat_rt) {
        //var_dump($id);
        $this->db->select('outlet_id');
        $this->db->from('tblt_route_outlet_mapping');
        $this->db->where("route_id", $sat_rt);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertRoutePlan($data) {
        $this->db->insert('tbld_route_plan', $data);
        return $this->db->insert_id();
    }

    public function insertRoutePlanIns($data) {
        $this->db->insert('tbld_route_plan_instance', $data);
        return $this->db->insert_id();
    }

    public function insertRoutePlanRouteMapping($data) {
        return $this->db->insert('tblt_route_plan_route_mapping', $data);
    }

    public function insertRoutePlanSrMapping($data) {
        return $this->db->insert('tblt_route_distribution_employee_mapping', $data);
    }

    public function insertRoutePlanDetails($data) {
        return $this->db->insert('tblt_route_plan_detail', $data);
    }

    public function insertRoutePlanSrScheduleMapping($data) {
        return $this->db->insert('tblt_route_sr_schedule_mapping', $data);
    }

    public function getAllRouteClasses() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_route_class');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_house() {

        $sql = "SELECT t5.biz_zone_name as region,t4.biz_zone_name area,t3.biz_zone_name as point,t1.id,t1.dbhouse_name,t1.distributor_id,t1.db_credit_limit,t1.dbhouse_code,t2.biz_zone_id,t1.business_opening_date,t1.db_house_status FROM `tbld_distribution_house` as t1
                inner join
                `tbli_distribution_house_biz_zone_mapping` as t2
                on t1.id=t2.dbhouse_id
                inner join
                `tbld_business_zone` as t3
                on t2.biz_zone_id=t3.id
                inner join
                `tbld_business_zone` as t4
                on t3.parent_biz_zone_id=t4.id
                inner join
                `tbld_business_zone` as t5
                on t4.parent_biz_zone_id=t5.id
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function select_db_house_specfic_db_id($db_id) {

        $sql = "SELECT t5.biz_zone_name as region,t4.biz_zone_name area,t3.biz_zone_name as point,
                t1.id,t1.dbhouse_name,t1.distributor_id,t1.db_credit_limit,t1.dbhouse_code,
                t2.biz_zone_id,t1.business_opening_date,t1.db_house_status 
                FROM `tbld_distribution_house` as t1
                inner join
                `tbli_distribution_house_biz_zone_mapping` as t2
                on t1.id=t2.dbhouse_id
                inner join
                `tbld_business_zone` as t3
                on t2.biz_zone_id=t3.id
                inner join
                `tbld_business_zone` as t4
                on t3.parent_biz_zone_id=t4.id
                inner join
                `tbld_business_zone` as t5
                on t4.parent_biz_zone_id=t5.id where t1.id = '$db_id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
    public function getDbByBizZoneId($biz_zone_id){
        $sql = "SELECT t5.biz_zone_name as region,t4.biz_zone_name area,t3.biz_zone_name as point,
                t1.id,t1.dbhouse_name,t1.distributor_id,t1.db_credit_limit,t1.dbhouse_code,
                t2.biz_zone_id,t1.business_opening_date,t1.db_house_status 
                FROM `tbld_distribution_house` as t1
                inner join
                `tbli_distribution_house_biz_zone_mapping` as t2
                on t1.id=t2.dbhouse_id
                inner join
                `tbld_business_zone` as t3
                on t2.biz_zone_id=t3.id
                inner join
                `tbld_business_zone` as t4
                on t3.parent_biz_zone_id=t4.id
                inner join
                `tbld_business_zone` as t5
                on t4.parent_biz_zone_id=t5.id where t2.biz_zone_id = '$biz_zone_id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    public function getRouteClassId($id) {
        $sql = "SELECT route_class_id FROM `tblt_route_plan_detail` where route_plan_instance_id=$id
                group by route_plan_instance_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function select_db_house_by_db_id($db_id) {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $db_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDistEmpNameById($id) {
        $sql = "SELECT t1.*,t2.territory_id,t3.db_channel_element_name as territory FROM `tbld_distribution_employee` as t1
                left join
                `tbld_tso_territory_mapping` as t2
                on t1.id=t2.tso_id
                left join
                `tbld_distribution_channel_elements` as t3
                on t2.territory_id=t3.id where t1.id=$id";
        //return $sql;
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getEmpNameByIdSRs($db_id) {
        if (is_array($db_id)) {
           /* $sql = "SELECT t1.id,t1.first_name,t1.dist_emp_code,t2.territory_id,t3.db_channel_element_name as territory FROM `tbld_distribution_employee` as t1
                inner join
                `tbld_tso_territory_mapping` as t2
                on t1.id=t2.tso_id
                inner join
                `tbld_distribution_channel_elements` as t3
                on t2.territory_id=t3.id where t1.distribution_house_id in (" . implode(',', $db_id) . ") and t1.dist_role_id=2";
            * 
            */
            $sql = "SELECT t1.id,t1.first_name,t1.dist_emp_code
FROM `tbld_distribution_employee` as t1
where
t1.distribution_house_id=1 and t1.dist_role_id=2";
        } else {

            /* $sql = "SELECT t1.id,t1.first_name,t1.dist_emp_code,t2.territory_id,t3.db_channel_element_name as territory FROM `tbld_distribution_employee` as t1
              inner join
              `tbld_tso_territory_mapping` as t2
              on t1.id=t2.tso_id
              inner join
              `tbld_distribution_channel_elements` as t3
              on t2.territory_id=t3.id where t1.distribution_house_id=$db_id and t1.dist_role_id=2";
             * 
             */
            $sql = "SELECT t1.id,t1.first_name,t1.dist_emp_code
FROM `tbld_distribution_employee` as t1
where
t1.distribution_house_id=$db_id and t1.dist_role_id=2";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getDistEmpPlById($emp_id) {
        $this->db->select('pl_id');
        $this->db->where('emp_id', $emp_id);
        return $this->db->get('tbli_db_house_emp_product_line_mapping')->result_array();
    }

    public function getErpCodeOfDBhouse($dbhouse, $pl) {
        $this->db->select('erp_dbcode');
        $this->db->where('dbhouse_id', $dbhouse);
        $this->db->where('product_line_id', $pl);
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }



    public function delete_tblt_route_plan_detail_by_date($id,$date_start){
        $sql = "DELETE t2 FROM `tbld_route_plan_instance` as t1
                inner join
                `tblt_route_plan_detail` as t2
                on t1.id=t2.route_plan_instance_id
                where t1.route_plan_id=$id and planned_visit_date >='$date_start'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function delete_tblt_route_sr_schedule_mapping_by_date($id,$date_start){
        $sql = "DELETE t2 FROM `tbld_route_plan_instance` as t1
                inner join
                `tblt_route_sr_schedule_mapping` as t2
                on t1.id=t2.instance_number
                where t1.route_plan_id=$id and t2.route_activity_date>='$date_start'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_tbld_route_plan_instance($id,$date_end){
        $sql = "UPDATE `tbld_route_plan_instance` SET end_date='$date_end' where id=$id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_tbld_route_plan($id,$rp_name,$rp_description){
        $sql = "UPDATE `tbld_route_plan` SET route_plan_name='$rp_name',route_plan_description='$rp_description' where id=$id";
        $query = $this->db->query($sql);
        return $query;
    }

    /*--------------------------------------------------------------------------
         * Insert data to given table
         * @param_1 = table name
         * @param_2 = table data
         * @return last insert id
         *-------------------------------------------------------------------------*/
    public function insertData($tbl, $data)
    {
        $this->db->insert($tbl, $data);

        return $this->db->insert_id();
    }

    public function insert_into_tblt_current_sr_route_outlet_mapping($db_id,$sr_id,$route_plan_instance_id,$route_id_list){
        $sql = "insert into `tblt_current_sr_route_outlet_mapping`(`db_id`,`sr_id`,`route_plan_instance_id`,`route_id`,`outlet_id`)
                SELECT $db_id as db_id,$sr_id as sr_id,$route_plan_instance_id as instance_id, route_id,outlet_id FROM `tblt_route_outlet_mapping` where route_id in($route_id_list)";
        $result = $this->db->query($sql);
        return $result;
    }


    public function delete_sr_previous_route_info($sr_id){
        $this->db->where('sr_id', $sr_id);
        $this->db->delete('tblt_current_sr_route_outlet_mapping');
        $this->db->where('sr_id', $sr_id);
        $result = $this->db->delete('tblt_current_route_sr_mapping');
        return $result;
    }

    public function delete_sr_previous_route_info_by_instance_no($instance_id){
        $this->db->where('route_plan_instance_id', $instance_id);
        $this->db->delete('tblt_current_sr_route_outlet_mapping');
        $this->db->where('route_plan_instance_id', $instance_id);
        $result = $this->db->delete('tblt_current_route_sr_mapping');
        return $result;
    }

    public function callProcedure_1(){
        $sql = "call tsync_todays_routes(now());";
        $this->db->query($sql);
    }

    public function callProcedure_2(){
        $sql = "call tsync_outlet(now());";
        $this->db->query($sql);

    }

    public function callProcedure_3(){
        $sql= "call tsync_outlet_verification(now());";
        $this->db->query($sql);
    }
}
