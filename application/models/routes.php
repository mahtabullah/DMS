<?php

class Routes extends CI_Model {

    public function insertRoute($data) {
        $this->db->insert('tbld_route', $data);
        return $this->db->insert_id();
    }

    public function update_route($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbld_route', $data);
    }

    public function insertRouteMarketMapping($data) {
        return $this->db->insert('tbli_route_market_mapping', $data);
    }

    public function getRouteId($code) {
        $this->db->select('id');
        $this->db->from('tbld_route');
        $this->db->where("route_code", $code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllMarketsById($id) {
        $sql = mysql_query("SELECT `id`,`db_channel_element_name` FROM `tbld_distribution_channel_elements` where `db_channel_parent_element_id` IN(" . implode(',', $id) . ")");

        while ($ret = mysql_fetch_array($sql)) {
            $q[] = array('id' => $ret['id'], 'name' => $ret['db_channel_element_name']);
        }
        return $q;
    }

    public function delete_tbld_route_class_by_id($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('tbld_route_class');
        return $result;
    }

    public function update_tbld_route_class($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbld_route_class', $data);
    }

    public function get_route_class_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_route_class');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete_route_outlet_mapping_by_id($id) {
        $this->db->where('route_id', $id);
        $query = $this->db->delete('tblt_route_outlet_mapping');
        return $query;
    }

    public function delete_route_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbld_route');
    }

    public function delete_route_market_mapping_by_id($id) {
        $this->db->where('route_id', $id);
        $this->db->delete('tbli_route_market_mapping');
    }

    public function select_route_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_route');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertRouteOutletMapping($mapping_data) {
        $this->db->insert('tblt_route_outlet_mapping', $mapping_data);
        return $this->db->insert_id();
    }

    public function getAllRoutes($pagination_per_page, $offset, $search) {
        $this->db->select('tbld_route.id,tbld_route.route_name,tbld_route.route_code,
            tbld_route_class.route_class_name,tbld_route.route_status_id,db.dbhouse_name');
        if ($search != '') {
            $this->db->like('route_name', $search);
        }
        //Active Record Join Query START....

        $this->db->join('tbld_route_class', 'tbld_route_class.id = tbld_route.route_class_id', 'left');
        $this->db->join('tbld_distribution_house as db', 'tbld_route.dbhouse_id = db.id', 'left');

        //Active Record Join Query END....

        $query = $this->db->get('tbld_route', $pagination_per_page, $offset)->result_array();
        return $query;
    }

    public function total($search) {
        if ($search != '') {
            $where = "where route_name  LIKE '%$search%'";
        } else {
            $where = "";
        }
        $sql = "select * from tbld_route $where";
        $query = $this->db->query($sql)->num_rows();
        return $query;
    }

    public function getAllRoutes_by_db_id($db_id) {
        $this->db->select('id,route_name,route_code,route_status_id');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_route');
        $this->db->where("dbhouse_id", $db_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllRouteClasses() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_route_class');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertRouteClass($data) {
        return $this->db->insert('tbld_route_class', $data);
    }

    public function getRouteNumOfDBhouse($id) {
        $query = mysql_query("select max(id) from tbld_route where dbhouse_id = '$id'");
        while ($q = mysql_fetch_row($query)) {
            $qu[] = $q[0];
        }
        return $qu;
        //var_dump($query);
        //return $query;
    }

    public function getAllOutletsInRoute() {
        $this->db->select('outlet_id');
        $this->db->from('tblt_route_outlet_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getMinDateForOutletForSrFromRoute($date, $outlet, $sr_id, $type) {
        $this->db->select_min('planned_visit_date');
        $this->db->where('outlet_id', $outlet);
        $this->db->where('dist_emp_id', $sr_id);
        if ($type == 1) {
            $this->db->where('planned_visit_date >= "' . $date . '"');
        }
        if ($type == 2) {
            $this->db->where('planned_visit_date > "' . $date . '"');
        }
        $query = $this->db->get('tblt_route_plan_detail')->result_array();
//        var_dump($query);
        return $query;
    }

    public function getRouteByDbhouseId($dbhouse) {
        $ret = array();
        $j = 0;
        for ($i = 0; $i < count($dbhouse); $i++) {
            $this->db->select('id,route_name');
            $this->db->from('tbld_route');
            $this->db->where("dbhouse_id", $dbhouse[$i]);
            $query = $this->db->get()->result_array();
            foreach ($query as $route) {
                $ret[$j] = array('id' => $route['id'], 'route_name' => $route['route_name']);
                $j++;
            }
        }
        //var_dump($ret);
        return $ret;
    }

    public function getOutletCategoryByRouteIds($route) {
        $ret = array();
        $j = 0;
        $this->db->select('outlet_id');
        $this->db->from('tblt_route_outlet_mapping');
        $this->db->where("route_id", $route);
        $query = $this->db->get()->result_array();
        foreach ($query as $outlet_id) {
            $this->db->select('id,outlet_name');
            $this->db->from('tbld_outlet');
            $this->db->where("id", $outlet_id['outlet_id']);
            $query1 = $this->db->get()->result_array();
            foreach ($query1 as $outlets) {
                //$ret_unique[$j] = array_map("unserialize", array_unique(array_map("serialize", $outlets)));
                $ret[$j] = array('id' => $outlets['id'], 'outlet_name' => $outlets['outlet_name']);
                $j++;
            }
        }
        return $ret;
    }

    public function getOutletCategoryByRouteId($route) {
        //$ret_unique = array();
        $ret = array();
        $j = 0;
        for ($i = 0; $i < count($route); $i++) {
            $this->db->select('outlet_id');
            $this->db->from('tblt_route_outlet_mapping');
            $this->db->where("route_id", $route[$i]);
            $query = $this->db->get()->result_array();
            foreach ($query as $outlet_id) {
                $this->db->select('id,outlet_name');
                $this->db->from('tbld_outlet');
                $this->db->where("id", $outlet_id['outlet_id']);
                $query1 = $this->db->get()->result_array();
                foreach ($query1 as $outlets) {
                    //$ret_unique[$j] = array_map("unserialize", array_unique(array_map("serialize", $outlets)));
                    $ret[$j] = array('id' => $outlets['id'], 'outlet_name' => $outlets['outlet_name']);
                    $j++;
                }
            }
        }
        //making unique dictionary of outlets
        $ret_unique = array_map("unserialize", array_unique(array_map("serialize", $ret)));
        $ret_unique_arr = array();
        $ret_val = array();
        $p = 0;
        foreach ($ret_unique as $x) {
            $ret_unique_arr[$p] = $x['id'];
            $p++;
        }
        $k = 0;
        for ($i = 0; $i < count($ret_unique_arr); $i++) {
            $this->db->select('outlet_category_id');
            $this->db->from('tbld_outlet');
            $this->db->where("id", $ret_unique_arr[$i]);
            $query_result = $this->db->get()->result_array();
            foreach ($query_result as $outlet_category_id) {
                $this->db->select('id,outlet_category_name');
                $this->db->from('tbld_outlet_category');
                $this->db->where("id", $outlet_category_id['outlet_category_id']);
                $query_result1 = $this->db->get()->result_array();
                foreach ($query_result1 as $outlet_category_name) {
                    $ret_val[$k] = array('id' => $outlet_category_name['id'], 'outlet_category_name' => $outlet_category_name['outlet_category_name']);
                    $k++;
                }
            }
        }
        $ret_val_unique = array_map("unserialize", array_unique(array_map("serialize", $ret_val)));
        $ret_val_unique_arr = array();
        //$ret_val_arr=array();
        $p = 0;
        foreach ($ret_val_unique as $x) {
            $ret_val_unique_arr[$p] = $x;
            $p++;
        }
        return $ret_val_unique_arr;
    }

    public function getAllStatus($status_id) {
        $this->db->select('route_status_name');
        $this->db->from('tbld_route_status');
        $this->db->where("id", $status_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllOutletIds($route_id) {
        $sql = "SELECT t1.outlet_id FROM `tblt_route_outlet_mapping` as t1
                inner join tbld_outlet as t2 on t1.outlet_id=t2.id
                where t1.route_id=$route_id and t2.status=1";
        return $this->db->query($sql)->result_array();
    }

    public function getAllOutlets($outlet_id) {
        $this->db->select('outlet_name');
        $this->db->from('tbld_outlet');
        $this->db->where("id", $outlet_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_route_class_name_by_id($route_id) {
        $sql = "SELECT 
t2.id,t2.route_class_name


FROM 
`tblt_route_plan_detail` as t1
inner join
tbld_route_class as t2
on
t1.route_class_id = t2.id
where t1.route_id = '$route_id'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRouteClassId($id) {
        $sql = "SELECT route_class_id FROM `tblt_route_plan_detail` where route_plan_instance_id=$id
                group by route_plan_instance_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRouteClass() {
        $sql = "SELECT * FROM `tbld_route_class`";
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

    public function getAllOutletsById($id) {
        $this->db->select('id,outlet_name,outlet_code');
        $this->db->from('tbld_outlet');
        $this->db->where("parent_id", $id);
        $query = $this->db->get()->result_array();
        //var_dump($query);
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

    public function mappings_route() {
        $sql = "SELECT t2.id as t FROM `tbld_config` as t1 inner join
                tbld_distribution_channel_hierarchy as t2
                on t1.attribute_id = t2.id
                where config_code = 'route_child_map'";
        $query = mysql_query($sql);
        $querys = mysql_fetch_row($query);

        return $querys;
    }

    public function mappings_name($id) {
        $this->db->select('id,db_channel_element_name');
        $this->db->where("db_channel_element_category_id", $id);
        $query = $this->db->get('tbld_distribution_channel_elements')->result_array();
        return $query;
    }

    public function getErpCodeOfDBhouse($dbhouse, $pl) {
        $this->db->select('erp_dbcode');
        $this->db->where('dbhouse_id', $dbhouse);
        $this->db->where('product_line_id', $pl);
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDbchannelElementNameByDbhouseId($db_id) {
        foreach ($db_id as $db) {
            $this->db->select('biz_zone_id');
            $this->db->where("dbhouse_id", $db);
            $query = $this->db->get('tbli_distribution_house_biz_zone_mapping')->result_array();
            foreach ($query as $q) {
                $biz_zone = $q['biz_zone_id'];
                $this->db->select('id, db_channel_element_name,db_channel_element_code');
                $this->db->where("biz_zone_id", $biz_zone);
                $query1[] = $this->db->get('tbld_distribution_channel_elements')->result_array();
            }
        }
        return $query1;
    }

    public function getProductLinesOfDBhouse($dbhouse) {
        $this->db->select('product_line_id');
        $this->db->where('dbhouse_id', $dbhouse);
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_tbld_sku_hierarchy_elements_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbld_sku_hierarchy_elements');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getMarketIdByOutletId($outlet_id) {
        $this->db->select('parent_id');
        $this->db->from('tbld_outlet');
        $this->db->where("id", $outlet_id);
        $query = $this->db->get()->result_array();
        //var_dump($query);
        return $query;
    }

    public function getAllOutletInDBhouse($dbhouse_id) {
        $this->db->select('biz_zone_id');
        $this->db->where("dbhouse_id", $dbhouse_id);
        $query = $this->db->get('tbli_distribution_house_biz_zone_mapping')->result_array();
        foreach ($query as $q) {
            $biz_zone = $q['biz_zone_id'];
            $this->db->select('id');
            $this->db->where("biz_zone_id", $biz_zone);
            $query1 = $this->db->get('tbld_distribution_channel_elements')->result_array();
            //var_dump($query1);
            foreach ($query1 as $q1) {
                $mkt_id = $q1['id'];
                $this->db->select('id, outlet_name,outlet_code');
                $this->db->where("parent_id", $mkt_id);
                $this->db->order_by('outlet_name');
                $query2[] = $this->db->get('tbld_outlet')->result_array();
            }
        }
        foreach ($query2 as $q2) {
            for ($i = 0; $i < count($q2); $i++) {
                $qq[] = $q2[$i];
            }
        }
        return $qq;
    }

    public function getAllOutletByParentId($market_ids) {
        $sql = "select id,outlet_name,outlet_code from tbld_outlet where parent_id in($market_ids)";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getMarketByDb($db_id) {
        $sql = "SELECT t2.id,t2.db_channel_element_name as name,db_channel_element_code as code FROM `tbli_distribution_house_biz_zone_mapping` as t1
                inner join tbld_distribution_channel_elements as t2 on t1.biz_zone_id=t2.biz_zone_id
                where t1.dbhouse_id=$db_id and db_channel_element_category_id <> 1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOutletByMarket($market_id) {
        $sql = "SELECT id,concat('[',outlet_code,']-',outlet_name) as name FROM `tbld_outlet` where parent_id in($market_id)";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRouteInfo($db_id) {
         $sql = "SELECT t1.id, t1.db_channel_element_name,t1.db_channel_element_code,t1.db_channel_element_description,t1.db_channel_element_category_id,t2.dbhouse_name,t3.db_channel_element_name As Parent_Route,t1.status FROM `tbld_distribution_route` as t1
                left join tbld_distribution_house as t2 on t1.db_id=t2.id
                left join tbld_distribution_route as t3 on t1.db_channel_parent_element_id=t3.id              
                where t1.db_id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}
