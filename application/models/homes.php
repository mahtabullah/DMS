<?php

class Homes extends CI_Model {


    /*
     * Geolocation Status
     */


    public function geolocation_status($db_id) {
        $today = date('Y-m-d');
        if($db_id == 0){
            $sql =  "SELECT
                    sum(case when planned_visit_date ='$today' and actual_visit_date = '$today' and distance_flag = 0 then 1 else 0 end) as green,
                    sum(case when planned_visit_date ='$today' and actual_visit_date = '$today' and distance_flag = 1 then 1 else 0 end) as yellow,
                    sum(case when planned_visit_date ='$today' and actual_visit_date is null then 1 else 0 end) as red
                    FROM `tblt_route_plan_detail` a
                          left join tbld_outlet c on a.outlet_id=c.id
                          where a.planned_visit_date = '$today'
                    group by planned_visit_date";
        }else{
                $sql =  "SELECT
                        sum(case when planned_visit_date ='$today' and actual_visit_date = '$today' and distance_flag = 0 then 1 else 0 end) as green,
                        sum(case when planned_visit_date ='$today' and actual_visit_date = '$today' and distance_flag = 1 then 1 else 0 end) as yellow,
                        sum(case when planned_visit_date ='$today' and actual_visit_date is null then 1 else 0 end) as red
                        FROM `tblt_route_plan_detail` a
                              left join tbld_outlet c on a.outlet_id=c.id
                              where c.dbhouse_id='$db_id' AND a.planned_visit_date = '$today'
                        group by planned_visit_date";
        }
        
        
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }
    
    public function new_order($current_date,$db_id)
    {
        $where = ($db_id !='') ? " and t1.db_id=$db_id":"";
        
        $sql = "SELECT count(t1.so_id) as t        FROM `tblt_sales_order` as t1 
        inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
        where t2.sku_order_type_id=1 and date(t1.order_date_time) = '$current_date' $where";
       
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getSrIdsByDbIds($db_id){
        $sql = "select id from tbld_distribution_employee where distribution_house_id $db_id and dist_role_id = 2 and active = 1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function get_no_of_db($db_id){
        $where = ($db_id !='') ? " and id $db_id":"";

        $sql = "SELECT count(id) as no_of_db FROM `tbld_distribution_house` 
                where db_house_status = 1 $where";
        $query = $this->db->query($sql);
        return $query->result_array();

    }
    public function get_db_operator($db_ids){
        $where = "";
        $where .= ($db_ids !='') ? " and distribution_house_id $db_ids ":"";

        $sql = "SELECT count(t1.id) as db_operator
                FROM `tbld_distribution_employee` as t1
                INNER JOIN tbld_distribution_house as t2 on t1.distribution_house_id=t2.id
                where 1 and t1.active =1 and t2.db_house_status=1 and t1.dist_role_id = 1 $where";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_no_of_outlet($db_id)
    {
        $where = ($db_id !='') ? " and t1.dbhouse_id $db_id":"";

        $sql = "SELECT count(t1.id) as no_of_outlet
        FROM `tbld_outlet` as t1
        inner join tblt_current_sr_route_outlet_mapping as t2 on t1.id=t2.outlet_id
		inner join tbld_distribution_house as t3 on t2.db_id=t3.id
        where 1 $where and t1.status=1 and t3.db_house_status=1";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_no_of_sub_route($db_id)
    {
        $where = ($db_id !='') ? " and t1.db_id $db_id":"";

//        $sql = "SELECT count(id) as no_of_sub_route FROM `tbld_route` where route_status_id=1 $where";
        $sql = "SELECT count(distinct route_id) as no_of_sub_route FROM `tblt_current_route_sr_mapping` as t1
                inner join tbld_distribution_house as t2 on t1.db_id=t2.id
                inner join tbld_distribution_employee as t3 on t1.sr_id=t3.id
                where t2.db_house_status=1 and t3.active=1 $where";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_mv($db_id)
    {
        $where = ($db_id !='') ? " and t1.db_id $db_id":"";

        $sql = "SELECT count(t1.id) as mv
        FROM `tblt_db_vehicle_mapping` as t1
        inner join tbld_distribution_house as t2 on t1.db_id=t2.id
        where t1.vehicle_type=1 and t2.db_house_status=1 $where";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_nmv($db_id)
    {
        $where = ($db_id !='') ? " and t1.db_id $db_id":"";

        $sql = "SELECT count(t1.id) as nmv
        FROM `tblt_db_vehicle_mapping` as t1
        inner join tbld_distribution_house as t2 on t1.db_id=t2.id
        where t1.vehicle_type=2 and t2.db_house_status=1 $where";

        $query = $this->db->query($sql);
        return $query->result_array();
    }    

    public function get_no_of_psr($db_id)
    {
        $where = "";
        $where .= ($db_id !='') ? " and distribution_house_id $db_id ":"";

        $sql = "SELECT count(t1.id) as no_of_psr FROM `tbld_distribution_employee` as t1
                inner join tbld_distribution_house as t2 on t1.distribution_house_id=t2.id
                where t1.active=1 and t1.dist_role_id=2 and t2.db_house_status=1 $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getTotalValueVolume($current_date,$db_id)
    {
        $where = ($db_id !='') ? " and t1.db_id=$db_id":"";
        $sql = "SELECT sum(t1.total_order) as order_value,sum(t2.quantity_ordered*t3.sku_waight_value) as volume
        FROM `tblt_sales_order` as t1 
        inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
        inner join tbld_sku as t3 on t3.id = t2.sku_id
        where t2.sku_order_type_id=1 and date(t1.order_date_time) = '$current_date' $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getPurchaseIndent($current_date,$db_id)
    {
        $where = ($db_id !='') ? " and t1.db_id=$db_id":"";
        $sql = "SELECT 
        sum(t1.db_id) as total_db, sum(t1.total_order) as total_order,sum(t2.quantity_order*t3.sku_volume) as volume
        FROM `tblt_purchase_order` as t1
        inner join `tblt_purchase_order_line` as t2 on t1.id = t2.po_id
        inner join tbld_sku as t3 on t3.id = t2.sku_id
        where (t1.order_date) = '$current_date' $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getGeoStatus($current_date)
    {
        $sql = "SELECT 
        t1.id as national_id,t1.biz_zone_name as nation_name,
        t2.id as region_id,t2.biz_zone_name as region_name,
        t3.id as area_id,t3.biz_zone_name as area_name,
        t4.id as territory_id,t4.biz_zone_name as territory_name,
        t5.id as town_id,t5.biz_zone_name as town_name,
        t6.dbhouse_id as db_id,t7.dbhouse_name as db_name,
        t10.route_name,
        SUM(CASE WHEN planned_visit_date = '$current_date'  then 1 Else 0 end) AS total_order,
        SUM(CASE WHEN planned_visit_date = '$current_date' and actual_visit_date = '$current_date' and distance_flag = 0  then 1 Else 0 end) AS success_outlet,
        SUM(CASE WHEN planned_visit_date = '$current_date' and actual_visit_date = '$current_date' and distance_flag = 1  then 1 Else 0 end) AS not_success_outlet,
        SUM(CASE WHEN planned_visit_date = '$current_date' and actual_visit_date = '0000-00-00'  then 1 Else 0 end) AS not_covered_outlet
        FROM `tbld_business_zone` as t1
        inner join `tbld_business_zone` as t2 on t1.id=t2.parent_biz_zone_id
        inner join `tbld_business_zone` as t3 on t2.id=t3.parent_biz_zone_id
        inner join `tbld_business_zone` as t4 on t3.id=t4.parent_biz_zone_id
        inner join `tbld_business_zone` as t5 on t4.id=t5.parent_biz_zone_id
        inner join `tbli_distribution_house_biz_zone_mapping` as t6 on t5.id=t6.biz_zone_id
        inner join `tbld_distribution_house` as t7 on t6.dbhouse_id=t7.id
        inner join  `tbld_outlet` as t8 on t8.dbhouse_id = t7.id
        inner join  `tblt_route_plan_detail` as t9 on t9.outlet_id = t8.id
        inner join `tbld_route` as t10 on t9.route_id = t10.id
        group by t6.dbhouse_id,t9.route_id";
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }
    
    public function getOrderedDelivered($current_date,$db_id)
    {
        /*$sql = "SELECT (t1.total_order) as order_value,(t2.quantity_ordered*t3.sku_waight_value) as ordered_volume, (t2.quantity_delivered*t3.sku_waight_value) as delivered_volume
        FROM `tblt_sales_order` as t1 
        inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
        inner join tbld_sku as t3 on t3.id = t2.sku_id
        where t2.sku_order_type_id=1 and date(t1.order_date_time) = '$current_date'";
         * 
         */
        $where = ($db_id !='') ? " and t1.db_id=$db_id":"";
        $sql = "SELECT 
sum((t1.total_order)) as order_value,sum((t2.quantity_ordered*t3.sku_waight_value)) as ordered_volume, 
(t2.quantity_delivered*t3.sku_waight_value) as delivered_volume
        FROM `tblt_sales_order` as t1 
        inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
        inner join tbld_sku as t3 on t3.id = t2.sku_id
        where t2.sku_order_type_id=1  and date(t1.delivery_date) between '2016-01-12' and '2016-01-28' $where";
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }
    
    public function getTotalOutlet($current_date,$sr_ids)
    {
        $where = ($sr_ids !='') ? " and dist_emp_id in($sr_ids)":"";
        $sql = "SELECT count(*) as total_outlet FROM `tblt_route_plan_detail` where planned_visit_date = '$current_date' $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getTotalSuccessOutlet($current_date,$sr_ids)
    {
        $where = ($sr_ids !='') ? " and dist_emp_id in($sr_ids)":"";
        $sql = "SELECT count(*) as success_outlet FROM `tblt_route_plan_detail` where planned_visit_date = '$current_date' and actual_visit_date = '$current_date' and distance_flag = '0' $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getTotalNotSuccessOutlet($current_date,$sr_ids)
    {
        $where = ($sr_ids !='') ? " and dist_emp_id in($sr_ids)":"";
        $sql = "SELECT count(*) as not_success_outlet FROM `tblt_route_plan_detail` where planned_visit_date = '$current_date' and actual_visit_date = '$current_date' and distance_flag = '1' $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getTotalNotCoveredOutlet($current_date,$sr_ids)
    {
        $where = ($sr_ids !='') ? " and dist_emp_id in($sr_ids)":"";
        $sql = "SELECT count(*) as not_covered_outlet FROM `tblt_route_plan_detail` where planned_visit_date = '$current_date' and actual_visit_date = '0000-00-00' $where";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function verify_user_pass($user, $pass) {
        $this->db->select('id');
        $this->db->from('tbld_user');
        $this->db->where('user_name = "' . $user . '" and user_password = "' . $pass . '"');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_tso_db_info($emp_id){
         $this->db->select('dbhouse_id');
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $this->db->where("sales_emp_id", $emp_id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function get_tso_pl_info($emp_id){
         $sql = "select product_line_id from tbli_dbhouse_product_line_mapping where sales_emp_id='$emp_id'";
         $query = mysql_query($sql);
        $y = array();
        while ($x = mysql_fetch_assoc($query)) {
            $y[] = $x['product_line_id'];
            
        }
        return $y;
    }
    public function get_pl_by_db($db_id){
       $sql = "select product_line_id from tbli_dbhouse_product_line_mapping where dbhouse_id='$db_id'";
         $query = mysql_query($sql);
        $y = array();
        while ($x = mysql_fetch_assoc($query)) {
            $y[] = $x['product_line_id'];
        }
        return $y; 
    }

    public function order_vs_actuals($db_id) {
        if($db_id ==0){
            $sql =  "select sum(so_line.quantity_order*so_line.actual_price) as qty_order,sum(so_line.quantity_delivered*so_line.actual_price) as qty_deli from tblt_sales_order as so_order inner join tblt_sales_order_line as so_line on so_order.id = so_line.so_id where 1 ";
        }else{
            $sql =  "select sum(so_line.quantity_order*so_line.actual_price) as qty_order,sum(so_line.quantity_delivered*so_line.actual_price) as qty_deli from tblt_sales_order as so_order inner join tblt_sales_order_line as so_line on so_order.id = so_line.so_id where sr_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
        }
        
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }

    public function getNewOrder($db_id) {
        if($db_id ==0){
            $sql =  "SELECT count(*) as total FROM `tblt_sales_order` where date_format(order_date_time,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d')";
        }else{
            $sql =  "SELECT count(*) as total FROM `tblt_sales_order` where date_format(order_date_time,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d') AND sr_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
           
        }
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
      
        
    }

    public function get_order_value($where,$db_id) {
        if($db_id ==0){
            $sql = "SELECT count(*) as new_order,sum(total_confirmed) as total_confirmed FROM `tblt_sales_order` WHERE 1";
            
        }else{
            $sql = "SELECT count(*) as new_order,sum(total_confirmed) as total_confirmed FROM `tblt_sales_order` WHERE so_sr IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
        }
        
        if ($where != NULL) {
            $sql .= $where;
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getNewOutlet($db_id) {
        if($db_id ==0){
            $sql = "SELECT count(*) total FROM `tblt_non_registered_outlet` where status = 1 and date_format(submit_date,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d')";
        }else{
            
            $sql = "SELECT count(*) total FROM `tblt_non_registered_outlet` where status = 1 and date_format(submit_date,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d') AND dist_emp_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
        }
        
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }

    public function get_new_outlets($where,$db_id) {
    if($db_id ==0){
       $sql = "SELECT count(*) total FROM `tblt_non_registered_outlet` where 1";
    }else{
        
         $sql = "SELECT count(*) total FROM `tblt_non_registered_outlet` where dist_emp_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
    }
        
        if ($where != NULL) {
            $sql .= $where;
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_purchase_indents($where,$db_id) {
        if($db_id ==0){
            $sql = "SELECT sum(total_order) total_order FROM `tblt_purchase_order` where 1";
        }else{
            
            $sql = "SELECT sum(total_order) total_order FROM `tblt_purchase_order` where dist_emp_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
        }

        
        if ($where != NULL) {
            $sql .= $where;
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getTotalRevenue($db_id) {
        if($db_id ==0){
            $sql = "SELECT sum(total_order) total_order FROM `tblt_sales_order` where date_format(order_date_time,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d')";
        }else{
           
             $sql = "SELECT sum(total_order) total_order FROM `tblt_sales_order` where date_format(order_date_time,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d') AND sr_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
        }
        
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }

    public function getTotalPurchase($db_id) {
        if($db_id ==0){
            $sql = "SELECT sum(total_order) total_order FROM `tblt_purchase_order` where date_format(order_date,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d')";
        }else{
            
            $sql = "SELECT sum(total_order) total_order FROM `tblt_purchase_order` where date_format(order_date,'%Y-%m-%d') =date_format(SYSDATE(),'%Y-%m-%d') AND dist_emp_id IN(SELECT id FROM tbld_distribution_employee WHERE distribution_house_id='$db_id')";
        }
        
        $result = mysql_query($sql);
        $results = mysql_fetch_array($result);
        return $results;
    }
    
    public function get_outlet_target($db_id){
        $to_day = date('Y-m-d');
        if($db_id ==0){
            $sql = "SELECT (SELECT name FROM tbld_product_line where tbld_product_line.id=outlet.pl_id) as pl_id,count(details.outlet_id) FROM `tblt_route_plan_detail` details
                    inner join
                    tbld_outlet outlet on 
                    details.outlet_id = outlet.id
                    where planned_visit_date between '$to_day' and '$to_day'  and outlet.pl_id !=''
                    group by 
                    outlet.pl_id
                    ";
        }else{
            $sql = "SELECT (SELECT name FROM tbld_product_line where tbld_product_line.id=outlet.pl_id) as pl_id,count(details.outlet_id) FROM `tblt_route_plan_detail` details
                    inner join
                    tbld_outlet outlet on 
                    details.outlet_id = outlet.id
                    where planned_visit_date between '$to_day' and '$to_day' AND outlet.dbhouse_id='$db_id'
                    group by 
                    outlet.pl_id
                    ";
        }
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
     public function get_outlet_achievement($db_id){
        $to_day = date('Y-m-d');
          if($db_id ==0){
            $sql = "SELECT outlet.pl_id,count(outlet_no) FROM `tblt_sales_order` orders
                    inner join
                    tbld_outlet outlet on 
                    orders.outlet_no = outlet.id
                    where order_date between '$to_day' and '$to_day'  and outlet.pl_id !=''
                    group by 
                    outlet.pl_id
                    ";
          }else{
              $sql = "SELECT outlet.pl_id,count(outlet_no) FROM `tblt_sales_order` orders
                inner join
                tbld_outlet outlet on 
                orders.outlet_no = outlet.id
                where orders.db_id='$db_id' and order_date between '$to_day' and '$to_day' 
                group by 
                outlet.pl_id
                ";
          }
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_outlet_target_filter($frm,$to,$db_id,$pl){
         if($db_id ==0){
        $sql = "SELECT (SELECT name FROM tbld_product_line where tbld_product_line.id=outlet.pl_id) as pl_id,count(details.outlet_id) FROM `tblt_route_plan_detail` details
                inner join
                tbld_outlet outlet on 
                details.outlet_id = outlet.id
                where planned_visit_date between '$frm' and '$to'  and outlet.pl_id !=''
                group by 
                outlet.pl_id
                ";
         }else{
              $sql = "SELECT (SELECT name FROM tbld_product_line where tbld_product_line.id=outlet.pl_id) as pl_id,count(details.outlet_id) FROM `tblt_route_plan_detail` details
                inner join
                tbld_outlet outlet on 
                details.outlet_id = outlet.id
                where planned_visit_date between '$frm' and '$to' AND dbhouse_id='$db_id'
                group by 
                outlet.pl_id
                ";
         }
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
     public function get_outlet_achievement_filter($frm,$to,$db_id,$pl){
        if($db_id ==0){
            $sql = "SELECT outlet.pl_id,count(outlet_no) FROM `tblt_sales_order` orders
                inner join
                tbld_outlet outlet on 
                orders.outlet_no = outlet.id
                where order_date between '$frm' and '$to'  and outlet.pl_id !=''
                group by 
                outlet.pl_id
                ";
        }else{
            $sql = "SELECT outlet.pl_id,count(outlet_no) FROM `tblt_sales_order` orders
                inner join
                tbld_outlet outlet on 
                orders.outlet_no = outlet.id
                where orders.db_id='$db_id' AND order_date between '$frm' and '$to'  and outlet.pl_id IN($pl) AND dbhouse_id='$db_id'
                group by 
                outlet.pl_id
                ";
        }
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_slow_moving_sku(){
         $sql = "SELECT (SELECT sku_name from tbld_sku where tbld_sku.id=tblt_sales_order_line.sku_id) as sku_name,sum(subtotal) as subtotal FROM `tblt_sales_order_line` group by sku_id order by subtotal ASC limit 5";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function tbld_product_line() {

        $sql = "SELECT `id` FROM tbld_product_line";
        $query = mysql_query($sql);
        while ($x = mysql_fetch_array($query)) {
            $y[] = intval($x['id']);
        }
        return $y;
    }

    public function getUserRoleByUserId($uid) {
        $this->db->select('user_role_id');
        $this->db->from('tbli_user_role_mapping');
        $this->db->where('user_id', $uid);
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * 
     */

    
    
    public function getAllDistributionEmp($id){
        $this->db->select('distribution_house_id');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    public function getSrIds($db_id){
        $where = ($db_id !='') ? " and distribution_house_id=$db_id":"";
        $sql = "SELECT group_concat(id) as sr_ids FROM `tbld_distribution_employee` where dist_role_id=2 $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    
    
    
    /**
     * new dashboard query began here
     */
    
    
    function new_order_qty($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";
        
         $sql = "SELECT count(id)as Number_of_order FROM `tblt_sales_order` 
                where 	planned_order_date 
                between '$start_date' and '$end_date' $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    function Total_Schedule_Call($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and t1.dbhouse_id $db_ids" : "";
        
         $sql = "SELECT count(t2.id) As SC FROM `tblt_route_plan_detail` as t1
                INNER join tbld_outlet as t2 on t1.route_id=t2.parent_id
                where t2.status=1 And t1.planned_visit_date 
                between '$start_date' and '$end_date' $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    function total_outlet($db_ids){
        $where = ($db_ids !='') ? " and dbhouse_id $db_ids" : "";
        
         $sql = "SELECT count(id)as Number_of_outlet FROM `tbld_outlet` 
                where status=1 $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }


    function new_regular_order_qty($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";

        $sql = "SELECT count(id) as num_of_order
                FROM `tblt_sales_order`
                where date(order_date_time)
                between '$start_date' and '$end_date' $where and sales_order_type_id=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }


    function new_others_order_qty($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";

        $sql = "SELECT count(id) as num_of_order
                FROM `tblt_sales_order`
                where date(order_date_time)
                between '$start_date' and '$end_date' $where and sales_order_type_id !=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    
    function new_order_value($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";
        $sql = "SELECT round(sum(t2.quantity_ordered*t2.unit_sale_price),2) as order_value, 
                SUM(t3.sku_volume) as volume_in_oz,
                round(sum(t2.quantity_ordered*t3.sku_volume),2) as order_volume
                FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                inner join `tbld_sku` as t3 on t2.sku_id=t3.id
                where date(t1.order_date_time) between '$start_date' and '$end_date' and t2.sku_order_type_id=1 $where";
        
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    
    function new_order_case_volume($start_date,$end_date,$db_ids){

        $where = ($db_ids !='') ? " and t3.db_id $db_ids" : "";
//        $sql = "SELECT FORMAT(SUM(((t1.quantity_confirmed/t2.pacakging_size)+(t1.quantity_confirmed/t2.pacakging_size)/t2.pacakging_size)), 2) as final_order_case
//                FROM `tblt_sales_order` as t3 Inner Join `tblt_sales_order_line` as t1 on t3.id=t1.so_id
//                Inner Join
//                (SELECT sku_id, max(quantity) as pacakging_size from tbli_sku_mou_price_mapping GROUP BY sku_id) as t2
//                On t1.sku_id=t2.sku_id
//                where date(t3.order_date_time) between '$start_date' and '$end_date' and t1.sku_order_type_id=1 $where";
        $sql = "SELECT round(SUM(t1.quantity_confirmed/t2.pacakging_size),2) as final_order_case
                        FROM `tblt_sales_order` as t3 Inner Join `tblt_sales_order_line` as t1 on t3.id=t1.so_id
                        Inner Join
                        (SELECT sku_id, max(quantity) as pacakging_size from tbli_sku_mou_price_mapping GROUP BY sku_id) as t2
                        On t1.sku_id=t2.sku_id
                        where date(t3.order_date_time) between '$start_date' and '$end_date' and t1.sku_order_type_id=1 $where";
        
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    public function getDbSrList($db_id){
        $sql = "SELECT group_concat(id) as sr_list FROM `tbld_distribution_employee` where distribution_house_id $db_id and dist_role_id=2";
        $this->db->simple_query('SET SESSION group_concat_max_len=15000000');
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    
    public function outlet_pjp_info($start_date,$end_date,$sr_list){
        $where = ($sr_list !='') ? " and t1.dist_emp_id $sr_list" : "";
        $sql = "SELECT count(t1.outlet_id) as num_of_outlet FROM `tblt_route_plan_detail` as t1
                inner join tbld_outlet as t2 on t1.outlet_id=t2.id
                where planned_visit_date between '$start_date' and '$end_date' and t2.status=1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
//    public function outlet_pjp_status($start_date,$end_date,$sr_list){
//        $where = ($sr_list !='') ? " and dist_emp_id $sr_list" : "";
//        $sql = "select sum(A.green) as green,sum(A.yellow) as yellow,sum(A.red) as red from
//                (SELECT
//                (case when actual_visit_date = planned_visit_date and distance_flag = 0 then 1 else 0 end) as green,
//                (case when actual_visit_date = planned_visit_date and distance_flag = 1 then 1 else 0 end) as yellow,
//                (case when actual_visit_date='0000-00-00' then 1 else 0 end) as red
//                FROM `tblt_route_plan_detail` as t1
//                where t1.planned_visit_date between '$start_date' and '$end_date' $where) as A";
//
//
//        $query = $this->db->query($sql)->result_array();
//        return $query;
//    }

    public function outlet_pjp_status($start_date,$end_date,$sr_list){
        $where = ($sr_list !='') ? " and t1.dist_emp_id $sr_list" : "";
        $sql = "select sum(A.green) as green,sum(A.yellow) as yellow,sum(A.red) as red,sum(A.exception_reason) as exception_reason from
                (SELECT
                (CASE WHEN actual_visit_date = planned_visit_date AND (distance_flag = 0 AND visit_exception_reason_id = 0)
                    THEN 1
                   ELSE 0 END) AS green,
                  (CASE WHEN actual_visit_date = planned_visit_date AND (distance_flag = 1 AND visit_exception_reason_id = 0)
                    THEN 1
                   ELSE 0 END) AS yellow,
                  (CASE WHEN actual_visit_date = planned_visit_date AND visit_exception_reason_id != 0
                    THEN 1
                   ELSE 0 END) AS exception_reason,
                  (CASE WHEN actual_visit_date = '0000-00-00'
                    THEN 1
                   ELSE 0 END) AS red
                FROM `tblt_route_plan_detail` as t1
                inner join tbld_outlet as t2 on t1.outlet_id=t2.id
                where t1.planned_visit_date between '$start_date' and '$end_date' and t2.status=1 $where) as A";


        $query = $this->db->query($sql)->result_array();
        return $query;
    }


    public function brand_wise_sales($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";
        $sql = "SELECT t5.id,t5.element_name,round(sum(t2.quantity_delivered/t6.case_size),2) as sales FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                inner join `tbld_sku` as t3 on t2.sku_id=t3.id
                inner join `tbld_sku_hierarchy_elements` as t4 on t3.parent_id=t4.id
                inner join `tbld_sku_hierarchy_elements` as t5 on t4.parent_element_id=t5.id
                LEFT JOIN (SELECT
                               sku_id,
                               max(quantity) AS case_size
                             FROM `tbli_sku_mou_price_mapping`
                             WHERE quantity > 1
                             GROUP BY sku_id) AS t6 ON t2.sku_id = t6.sku_id
                where date(t1.order_date_time) between '$start_date' and '$end_date' and t2.sku_order_type_id=1 $where
                group by t5.id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function slow_moving_sku($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";
        $sql = "SELECT C.* FROM
                (select B.*,A.sku_id,(A.delivered_qty/D.case_size) as delivered_qty FROM
                (SELECT t2.sku_id,round(sum(t2.quantity_delivered),2) as delivered_qty FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                where date(delivery_date) between '$start_date' and '$end_date' and t2.sku_order_type_id=1 and t1.so_status=5 $where
                group by sku_id) as A
                left join 
                (select id,sku_name from tbld_sku) as B on A.sku_id=B.id
                LEFT JOIN (SELECT
                               sku_id,
                               max(quantity) AS case_size
                             FROM `tbli_sku_mou_price_mapping`
                             WHERE quantity > 1
                             GROUP BY sku_id) AS D ON A.sku_id = D.sku_id
                order by delivered_qty asc limit 0,5) as C order by delivered_qty desc";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getOrder($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";
        $sql = "SELECT round(sum(t2.quantity_ordered/t3.case_size),2) as order_value FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                LEFT JOIN (SELECT
                               sku_id,
                               max(quantity) AS case_size
                             FROM `tbli_sku_mou_price_mapping`
                             WHERE quantity > 1
                             GROUP BY sku_id) AS t3 ON t2.sku_id = t3.sku_id
                where date(t1.order_date_time) between '$start_date' and '$end_date' and t2.sku_order_type_id=1 $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getDelivery($start_date,$end_date,$db_ids){
        $where = ($db_ids !='') ? " and db_id $db_ids" : "";
        $sql = "SELECT round(sum(t2.quantity_delivered/t3.case_size),2) as delivered_value FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                LEFT JOIN (SELECT
                               sku_id,
                               max(quantity) AS case_size
                             FROM `tbli_sku_mou_price_mapping`
                             WHERE quantity > 1
                             GROUP BY sku_id) AS t3 ON t2.sku_id = t3.sku_id
                where date(t1.delivery_date) between '$start_date' and '$end_date' and t1.so_status=5 and t2.sku_order_type_id=1 $where";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }


    function getDBIds($biz_zone_id)
    {
        $sql = "SELECT group_concat(A.dbhouse_id) as dbhouse_id FROM
                (SELECT
                t1.id AS  national_id,t1.biz_zone_name AS national_name,
                t2.id AS unit_id,t2.biz_zone_name AS unit_name,
                t3.id AS territory_id,t3.biz_zone_name as territory_name,
                t4.id as ce_area_id,t4.biz_zone_name as ce_area_name,
                t5.dbhouse_id
                from tbld_business_zone as t1
                INNER JOIN tbld_business_zone as t2 on t1.id=t2.parent_biz_zone_id
                INNER JOIN tbld_business_zone as t3 on t2.id=t3.parent_biz_zone_id
                INNER JOIN tbld_business_zone as t4 on t3.id=t4.parent_biz_zone_id
                INNER JOIN tbli_distribution_house_biz_zone_mapping as t5 on t4.id=t5.biz_zone_id) as A
                where A.national_id=$biz_zone_id or A.unit_id=$biz_zone_id or A.territory_id=$biz_zone_id or A.ce_area_id=$biz_zone_id";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getCurrentTargetInfo($date)
    {
        $sql = "SELECT * FROM `tbld_target` where '$date' between start_date and end_date";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getTargetById($target_id,$db_ids)
    {
        $where = "";
        if($db_ids !=''){
            $where = " and db_id $db_ids";
        }
        //$sql = "SELECT round(sum(total_piece/ctn_size),2) as target_case FROM `tbld_sr_wise_target_details` where target_id=$target_id $where";
        $sql = "SELECT round(sum(`case`),2) as target_case FROM `tbld_db_wise_target_details` where target_id=$target_id $where";
        
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getAchievementById($target_id,$db_ids,$target_start_date,$target_end_date)
    {
        $where = "";
        if($db_ids !=''){
            $where = " and t1.db_id $db_ids";
        }
        $sql = "select sum(t1.qty/t2.case_size) as achievement_case from
                (SELECT t2.sku_id,sum(t2.quantity_confirmed) as qty FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                where date(t1.delivery_date) between '$target_start_date' and '$target_end_date' and t1.so_status=5 $where
                group by t2.sku_id) as t1

                LEFT JOIN (SELECT sku_id,max(quantity) AS case_size FROM `tbli_sku_mou_price_mapping`
                           WHERE quantity > 1 GROUP BY sku_id) AS t2 ON t1.sku_id = t2.sku_id

                inner join (SELECT sku_id FROM `tbld_sr_wise_target_details` where target_id=$target_id
                group by sku_id) as t3 on t1.sku_id=t3.sku_id";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getScheduleCall($db_ids,$start_date,$end_date)
    {
        $where = "";
        if($db_ids !=''){
            $where = "  and t2.distribution_house_id $db_ids";
        }
        $sql = "SELECT count(t1.outlet_id) as schedule_call FROM `tblt_route_plan_detail` as t1
                  inner join tbld_distribution_employee as t2 on t1.dist_emp_id=t2.id
                  inner join tbld_outlet as t3 on t1.outlet_id=t3.id
                where t1.planned_visit_date between '$start_date' and '$end_date' $where and t3.status=1";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getProductiveMemo($db_ids,$start_date,$end_date)
    {
        $where = "";
        if($db_ids !=''){
            $where = " and t1.db_id $db_ids";
        }
        $sql = "SELECT count(distinct t1.outlet_id) as productive_memo FROM `tblt_sales_order` as t1 where t1.planned_order_date between '$start_date' and '$end_date' $where";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getMobileMemo($where)
    {
        $sql = "SELECT count(t1.id) as productive_momo FROM `tblt_sales_order` as t1
                INNER JOIN tbld_outlet as t2 on t1.outlet_id=t2.id $where and t2.status=1";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }
    function getProductiveMemoNew($where,$start_date,$end_date){
        $sql = "select sum(A.green) as green , sum(A.yellow) as yellow from ( SELECT (case when actual_visit_date = planned_visit_date and (distance_flag = 0 and visit_exception_reason_id=0) then 1 else 0 end) as green,
                 (case when actual_visit_date = planned_visit_date and (distance_flag = 1 and visit_exception_reason_id=0) then 1 else 0 end) as yellow
                 FROM `tblt_route_plan_detail` where planned_visit_date between '$start_date' and '$end_date' $where ) as A";

        $query = $this->db->query($sql)->result_array();
        return $query;

    }


    function  getTlsd($db_ids,$start_date,$end_date)
    {
        $where = "";
        if($db_ids !=''){
            $where = "  and t1.db_id $db_ids";
        }
//        $sql = "select sum(A.line_count) as line_count from (SELECT t2.so_id,count(t2.id) as line_count FROM `tblt_sales_order` as t1
//                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
//                where t1.so_status=5 and t1.planned_order_date between '$start_date' and '$end_date' $where and t2.sku_order_type_id=1
//                group by t2.so_id) as A";
        $sql = "select sum(A.line_count) as line_count from
                (SELECT t2.so_id,count(t2.id) as line_count FROM `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                inner join `tbld_sku` as t3 on t2.sku_id=t3.id
                where t1.planned_order_date between '$start_date' and '$end_date' $where and t2.sku_order_type_id=1 and t2.quantity_ordered>=t3.sku_lpc
                group by t2.so_id) as A";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function  getOrderCase($db_ids,$start_date,$end_date)
        {
            $where = "";
            if($db_ids !=''){
                $where = "  and t1.db_id $db_ids";
            }
            $sql = "select sum(t2.quantity_ordered/t3.case_size) as order_case from `tblt_sales_order` as t1
                    inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                    LEFT JOIN (SELECT
                                                   sku_id,
                                                   max(quantity) AS case_size
                                                 FROM `tbli_sku_mou_price_mapping`
                                                 WHERE quantity > 1
                                                 GROUP BY sku_id) AS t3 ON t2.sku_id = t3.sku_id
                    where t1.planned_order_date between '$start_date' and '$end_date' $where and t2.sku_order_type_id=1 and t1.so_status !=6";

            $query = $this->db->query($sql)->result_array();

            return $query;
        }
function  getWorkingDay($db_ids,$start_date,$end_date)
        {
            $where = "";
            if($db_ids !=''){
                $where = "  and t1.db_id $db_ids";
            }
            $sql = "select c.*
                    FROM
                        ( SELECT
                            count( a.id ) AS total_day,
                            a.id          AS target_id
                          FROM
                            ( SELECT
                                *,
                                1 AS joint_id
                              FROM `tbld_target` AS t1
                              WHERE CURDATE() BETWEEN t1.start_date AND t1.end_date ) AS a
                            INNER JOIN
                            ( SELECT
                                1 AS joint_id,
                                date
                              FROM `tbli_calender` AS t1
                              WHERE t1.holiday_type = 0 ) AS b ON a.joint_id = b.joint_id
                          WHERE b.date BETWEEN a.start_date AND a.end_date ) AS c";
    
    
            $query = $this->db->query($sql)->result_array();

            return $query;
        }


function user_info_log($user_id,$biz_zone_id,$emp_id,$user_role_id){
    $sql="insert into  user_login_info(user_id,biz_zone_id,emp_id,user_role_id,date,date_time) 
            VALUES ($user_id,$biz_zone_id,$emp_id,$user_role_id,date(now()),now())";
    $this->db->query($sql);
}


}