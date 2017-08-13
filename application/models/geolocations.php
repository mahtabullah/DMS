<?php

class Geolocations extends CI_Model
{

    public function getGeoLocations_previous1($where)
    {

        $arr = array();
        $current_date = date("Y-m-d");
        $sql = "SELECT
                  c.outlet_name,
                  c.lat,
                  c.lon,
                  sum(t1.total_order)    AS order_amount,
                  sum(t1.total_delivered) AS delivery_amount,
                  CASE WHEN planned_visit_date = '$current_date' AND actual_visit_date = '$current_date' AND distance_flag = 0
                    THEN 1
                  WHEN planned_visit_date = '$current_date' AND actual_visit_date = '$current_date' AND distance_flag = 1
                    THEN 3
                  WHEN planned_visit_date = '$current_date' AND actual_visit_date != '$current_date'
                    THEN 5
                  ELSE 0 END       sales_stat
                FROM `tblt_route_plan_detail` AS a
                  LEFT JOIN tbld_outlet c ON a.outlet_id = c.id

                  LEFT JOIN tblt_sales_order AS t1 ON t1.outlet_id = a.outlet_id
                  LEFT JOIN tblt_sales_order_line AS t2 ON t1.id = t2.so_id

                WHERE 1 = 1 AND a.planned_visit_date = '$current_date' $where
                      AND DATE(t1.order_date_time) = '$current_date'
                      AND a.route_id IN (
                  SELECT route_id
                  FROM tblt_route_sr_schedule_mapping
                  WHERE 1 = 1
                        AND route_activity_date = '$current_date'
                ) GROUP BY t1.outlet_id;";
        $query = mysql_query($sql);
        while($obj = mysql_fetch_object($query)){
            $arr[] = $obj;
        }

        return $arr;
    }


    public function getGeoLocations_previous($where)
    {
        $sql = "SELECT
                  outlet_id,
                  outlet_name,
                  sum(total_order)    AS order_amount,
                  sum(total_delivered) AS delivery_amount,
                  lat,
                  lon,
                  CASE WHEN green = 1
                    THEN 1
                  WHEN yellow = 1
                    THEN 3
                  WHEN red = 1
                    THEN 5
                  ELSE 0 END                sales_stat
                FROM
                  today_market_pjp_view as t1
                WHERE 1 $where
                GROUP BY outlet_id;";

        $query = $this->db->query($sql)->result_array();
        return $query;

    }

    public function getGeoLocations($where)
    {
        $sql = "SELECT
                  t1.outlet_id,
                  t1.outlet_name,
                  sum(t1.order_value)    AS order_amount,
                  sum(t1.delivery_value) AS delivery_amount,
                  t1.lat,
                  t1.lon,
                  CASE WHEN t2.green = 1
                    THEN 1
                  WHEN t2.yellow = 1
                    THEN 3
                  WHEN t2.red = 1
                    THEN 5
                  ELSE 0 END                sales_stat
                FROM
                  sales_report AS t1 LEFT JOIN today_market_pjp_view AS t2 ON t1.outlet_id = t2.outlet_id
                WHERE 1 $where
                GROUP BY t1.outlet_id;";

        $query = $this->db->query($sql)->result_array();
        return $query;

    }




    public function getGeoLocations_filter($sr)
    {

        $arr = array();
        $current_date = date("Y-m-d");

        $sql = "SELECT  distinct a.outlet_id,c.outlet_name,c.timestamp,c.lat,c.lon,
                case when planned_visit_date ='$current_date' and actual_visit_date = '$current_date' and distance_flag = 0 then 1
                when planned_visit_date ='$current_date' and actual_visit_date = '$current_date' and distance_flag = 1 then 3
                when planned_visit_date ='$current_date' and actual_visit_date != '$current_date' then 5
                else 0 end sales_stat
                FROM `tblt_route_plan_detail` a
                left join tbld_outlet c on a.outlet_id=c.id
                where 1=1 and a.planned_visit_date = '$current_date'
    and route_id in (
                select route_id
                from tblt_route_sr_schedule_mapping
                where 1=1 and dist_emp_id = '$sr'
                and route_activity_date='$current_date'
                )";

        $query = mysql_query($sql);
        while($obj = mysql_fetch_object($query)){
            $arr[] = $obj;
        }

        return $arr;
    }

    public function getGeoLayerList()
    {
        $sql = "SELECT * FROM `tbld_business_zone_hierarchy`";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getGeoLayer($biz_zone_category_id)
    {
        $sql = "SELECT id,biz_zone_name as name FROM `tbld_business_zone` where biz_zone_category_id=$biz_zone_category_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getGeoLayerByParent($parent_biz_zone_id)
    {
        $parent_biz_zone_ids = implode(',', $parent_biz_zone_id);
        $sql = "SELECT id,biz_zone_name as name FROM `tbld_business_zone` where parent_biz_zone_id in ($parent_biz_zone_ids)";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getProductLayerList()
    {
        $sql = "SELECT id,layer_name as name FROM `tbld_sku_hierarchy`";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getProductLayer($element_category_id)
    {
        $sql = "SELECT id,element_name as name FROM `tbld_sku_hierarchy_elements` where element_category_id=$element_category_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getProductLayerByParent($parent_element_id)
    {
        $parent_element_ids = implode(',', $parent_element_id);
        $sql = "SELECT id,element_name as name FROM `tbld_sku_hierarchy_elements` where parent_element_id in($parent_element_ids)";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }


    public function get_geo_filter_result($date,$db_ids,$sr_ids,$route_ids,$market_ids,$outlet_ids){
        $sql = "SELECT

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
                   ELSE 0 END) AS red,
                  t2.outlet_name,t2.lat,t2.lon,
                  if(ISNULL(t3.order_amount),0,round(t3.order_amount,2)) as order_amount,
                  if(ISNULL(t3.order_case),0,round(t3.order_case,2)) as order_case


                FROM `tblt_route_plan_detail` AS t1
                  JOIN tbld_distribution_employee as t5 on t1.dist_emp_id=t5.id
                  left join tbld_outlet as t2 on t1.outlet_id=t2.id
                  left join (select t1.outlet_id,t1.total_confirmed as order_amount,round(sum(t2.quantity_confirmed/t3.ctn_size),2) as order_case from tblt_sales_order as t1
                  inner join tblt_sales_order_line as t2 on t1.id=t2.so_id
                  inner join (SELECT sku_id,max(quantity) as ctn_size FROM `tbli_sku_mou_price_mapping` group by sku_id) as t3 on t2.sku_id=t3.sku_id
                  where t1.planned_order_date='$date' and t1.db_id $db_ids GROUP by t1.outlet_id) as t3 on t1.outlet_id=t3.outlet_id
                WHERE t1.planned_visit_date = '$date' and t5.distribution_house_id $db_ids $sr_ids $route_ids $market_ids $outlet_ids";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}
