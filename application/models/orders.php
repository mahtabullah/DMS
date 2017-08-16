<?php

class orders extends CI_Model {

    /**
     *
     * @param string $where
     *
     * @return array
     */
    function getAllsubroute($db_id) {
        $sql = "SELECT id,db_channel_element_name,db_channel_element_code FROM `tbld_distribution_route`  where `db_channel_element_category_id`=2 AND db_id=$db_id Order By db_channel_parent_element_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getOutletBySubroute($sub_routes_id, $SystemDate) {

        $sql = 'SELECT t1.id,t1.outlet_name as name FROM `tbld_outlet` as t1 where t1.parent_id=' . $sub_routes_id . ' and t1.status=1 and id  not in (SELECT DISTINCT(outlet_id) FROM `tblt_sales_order`where `planned_order_date` ="' . $SystemDate . '")';
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getRoutebByPSR($psr_id, $SystemDate) {

        $sql = 'SELECT t2.id,t2.db_channel_element_name as route,t2.db_channel_element_code FROM `tblt_route_plan_detail` As t1
INNER join tbld_distribution_route as t2 on t1.route_id=t2.id
where t1.dist_emp_id=' . $psr_id . ' AND t1.planned_visit_date="' . $SystemDate . '"';
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderInfo($where) {
       $sql = "SELECT t2.outlet_name,t3.first_name As PSR,t4.db_channel_element_name As sub_route,t6.Total_qty,t1.* FROM `tblt_sales_order` as t1
                Inner join ( SELECT so_id,sum(quantity_ordered/Pack_size) as Total_qty FROM `tblt_sales_order_line` group by so_id ) As t6 on t6.so_id=t1.id
                Inner join tbld_outlet as t2 on t1.outlet_id=t2.id
                Inner join tbld_distribution_employee AS t3 on t3.id=t1.Psr_id
                Inner join tbld_distribution_route as t4 on t4.id=t1.route_id
                where 1 $where"
               . " order by t1.Psr_id ";
        //echo $sql;die();
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    //////////////


    public function getOrderQty($db_id, $so_id) {
        $sql = "SELECT $db_id as db_id,sku_id,unit_sale_price,sum(quantity_confirmed) as qty FROM `tblt_sales_order_line` where so_id=$so_id
                group by db_id,sku_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getInventoryDetailsQty($db_id, $sku_id, $unit_sale_price, $method) {
        $orderBy = '';
        if ($method == 'fifo') {
            $orderBy = ' ORDER BY challan_date ASC';
        } else {
            if ($method == 'lifo') {
                $orderBy = ' ORDER BY challan_date DESC';
            }
        }
        $sql = "SELECT id,db_id,sku_id,remain_qty as inventory_qty,challan_date FROM `tbld_inventory_details` where db_id=$db_id and is_active =1 and sku_id=$sku_id and price=$unit_sale_price $orderBy";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function updateInventoryDetailsIsActive() {
        $sql = "update `tbld_inventory_details` set is_active=0 where remain_qty=0";
        $query = $this->db->query($sql);

        return $query;
    }

    public function updateInventoryDetails($id, $reset_qty) {
        $sql = "update `tbld_inventory_details` set remain_qty=$reset_qty where id=$id";
        $query = $this->db->query($sql);

        return $query;
    }

    public function completeSalesOrder($so_id) {
        $sql = "update `tblt_sales_order` as t1
                inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
                set t1.so_status=5,t2.quantity_delivered=t2.quantity_confirmed,t1.cash_received=t1.total_order-t1.manual_discount
                where t1.id=$so_id";
        $query = $this->db->query($sql);

        return $query;
    }

    public function getSalesOrderNotification() {
        $db_id = $this->session->userdata('db_id');
        $delivery_date = date('Y-m-d', strtotime("-1 days"));
        $order_date = date('Y-m-d', strtotime("-2 days"));

        $sql = "SELECT count(*) as t FROM `tblt_sales_order`
                where date(order_date_time) = '$order_date' 
                and delivery_date not between '$order_date' and '$delivery_date'
                and sales_order_type_id = 1 and (so_status!=5) and db_id = $db_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function changeStatus($so_id, $data) {

        $so_status = $data['so_status'];
        $shipping_date = $data['shipping_date'];
        $delivery_date = $data['delivery_date'];
        $shipping_dates = '';
        $delivery_dates = '';

        if ($shipping_date) {
            $shipping_dates = ',shipping_date="' . $shipping_date . '"';
        }
        if ($delivery_date) {
            $delivery_dates = ',delivery_date="' . $delivery_date . '"';
        }

        $sql = " UPDATE tblt_sales_order set so_status=$so_status $shipping_dates $delivery_dates
                        where id=$so_id and so_status<=$so_status ";

        $query = $this->db->query($sql);
        $result = $this->db->affected_rows();

        //$update = $this->deliveryDamageBySoId($so_id);

        return $result;
    }

    public function cancelOrder($so_id, $data) {
        $so_status = $data['so_status'];
        $sql = "UPDATE tblt_sales_order set so_status=$so_status where id=$so_id and so_status=2";
        $query = $this->db->query($sql);
        $result = $this->db->affected_rows();

        return $result;
    }

    public function isPossible($so_ids, $status) {
        $sql = "select * from tblt_sales_order where id in($so_ids) and so_status <> $status";
        $query = $this->db->query($sql);
        $result = $this->db->affected_rows();

        return $result;
    }

    public function getSalesOrderInfoById($so_id) {
        $sql = "SELECT date_format(t1.order_date_time,'%d-%m-%Y') as order_date,t5.so_status_name,t1.so_id,
                t2.outlet_name,t3.db_channel_element_name as market,t4.first_name as sr_name
                
                FROM `tblt_sales_order` as t1
                left join tbld_outlet as t2 on t1.outlet_id=t2.id
                left join tbld_distribution_channel_elements as t3 on t2.parent_id=t3.id
                left join tbld_distribution_employee as t4 on t1.sr_id=t4.id
                left join tbld_sales_order_status as t5 on t1.so_status=t5.id
                where t1.id=$so_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOutletIdBySoId($so_id) {
        $sql = "select outlet_id from tblt_sales_order where id = $so_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getDamageOrderByOutletNo($outlet_no) {
        $sql = "SELECT t1.id,t1.do_id as damage_id,t1.order_date,t2.sku_id,t2.damage_order_type_id,t2.quantity_order,t2.quantity_delivered,t3.sku_name,t4.damage_name FROM `tblt_damage_order` as t1
                inner join
                `tblt_damage_order_line` as t2
                on t1.id=t2.do_id
                inner join
                `tbld_sku` as t3
                on t2.sku_id=t3.id
                left join
                `tbld_outlet_damage_criteria` as t4
                on t2.damage_order_type_id=t4.id
                where t1.outlet_no=$outlet_no and t2.do_status not in(2,4)";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderDetailsById($so_id) {

        $sql = "select C.*,D.* from (select A.*,floor(A.quantity_confirmed/B.ctn_qty) as ctn_qty,A.quantity_confirmed%B.ctn_qty as piece_qty,B.ctn_qty as original_qty
     from
       (SELECT t1.id,t1.total_confirmed,t1.manual_discount,t1.total_due,t1.total_order,t1.cash_received,t1.outlet_id,
         t1.total_grb,t1.total_grb_due,t1.total_crate,t1.total_crate_due,t1.grb_received,t1.crate_received,
         t2.quantity_grb_ordered,t2.quantity_grb_confirmed,t2.quantity_grb_delivered,t2.quantity_crate_ordered,t2.quantity_crate_confirmed,t2.quantity_crate_delivered,
          t2.sku_id,t2.promotion_id,t3.sku_description as sku_name,t4.mou_id,t5.unit_name as 'unit',t2.id as so_line_id,t2.so_id,t2.unit_sale_price,t2.total_sale_price,t2.quantity_ordered,t2.quantity_confirmed,t2.quantity_delivered,t2.total_billed_amount,t2.total_discount_amount,t6.promo_title
        FROM `tblt_sales_order` as t1
          inner join tblt_sales_order_line as t2 on t1.id=t2.so_id
          left join tbld_sku as t3 on t2.sku_id=t3.id
          left join tbli_sku_mou_price_mapping as t4 on t2.sku_id=t4.sku_id
          left join tbld_unit as t5 on t4.mou_id=t5.id
          left join `tbld_promotion_details` as t6 on t2.promotion_id=t6.promo_id
        where t1.id=$so_id and t4.quantity=1 and t2.sku_order_type_id=1 order by t2.id) as A
       left join
       (SELECT t1.sku_id,max(t2.qty) as ctn_qty FROM `tbli_sku_default_mou` as t1
         inner join tbld_unit as t2 on t1.db_mou_id=t2.id
       group by t1.sku_id) as B on A.sku_id=B.sku_id) as C

  left join

  (select so_id,sku_id as free_sku_id,promotion_id,quantity_confirmed as free_sku_qty,sku_order_type_id from tblt_sales_order_line where so_id=$so_id and sku_order_type_id=2 ) as D
    on C.so_id=D.so_id and C.promotion_id=D.promotion_id
                    ";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSoBySoId($so_id) {
        $sql = "SELECT * FROM `tblt_sales_order` where id=$so_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSkuListBySr($sr_id) {
        $sql = "SELECT t2.id,t2.sku_name FROM `tbli_sr_sku_mapping` as t1
                inner join `tbld_sku` as t2 on t1.sku_id=t2.id 
                where t1.emp_id=$sr_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getFilteredSkuList($db_id, $block_sku_list) {

        if ($block_sku_list != '') {

            $where = " and t2.sku_id not in(" . implode(',', $block_sku_list) . ")";
        } else {
            $where = "";
        }
        $sql = "SELECT t1.*,t2.*,t3.sku_code,t3.sku_description as sku_name
                FROM `tbli_db_bundle_price_mapping` as t1 
                Inner Join `tbld_bundle_price_details` as t2 
                On t1.bundle_price_id=t2.bundle_price_id 
                Inner Join `tbld_sku` as t3 on t2.sku_id=t3.id
                where t1.db_id=$db_id $where group by t2.sku_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getUnit($sku_id) {
        $sql = "SELECT t1.quantity,t1.outlet_lifting_price as price,t2.id,t2.unit_name
                FROM `tbli_sku_mou_price_mapping` as t1
                inner join tbld_unit as t2 on t1.mou_id=t2.id
                where sku_id=$sku_id and t1.quantity=1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOtherOutlet($db_id) {
        $sql = "SELECT id,name FROM `tbld_sales_other_outlet` where db_id=$db_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getsalesTypes() {


        $sql = "Select * from tbld_outlet_type";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSrListByDbId($db_id) {
        $sql = "SELECT id,first_name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSpokeByDbId($db_id) {
        $sql = "SELECT t1.*, t2.dbhouse_name
                FROM `tbli_hub_spoke_mapping` as t1 
                Inner Join `tbld_distribution_house` as t2 
                on t1.spoke_id=t2.id where t1.hub_id=$db_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getAllOutletByTypeCode($code, $db) {
        $sql = "SELECT t1.id,t1.outlet_name, t1.outlet_description FROM `tbld_outlet` as t1 inner join tbld_outlet_type as t2 on t1.outlet_type_id = t2.id WHERE outlet_type_code = '$code' and t1.dbhouse_id = '$db'";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSkuName() {
        $this->db->select('*');
        $this->db->where("sku_type_id", 1);
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_sku');
        $query = $this->db->get()->result_array();

        return $query;
    }

    function getRouteBySr($sr_id) {
        $data = date('Y-m-d');
        $sql = "SELECT t1.route_id as id,t2.route_name as name FROM `tblt_route_plan_detail` as t1
                left join tbld_route as t2 on t1.route_id=t2.id
                where t1.dist_emp_id=$sr_id and t1.planned_visit_date='$data'
                group by t1.route_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getAllRouteBySr($sr_id) {
        $sql = "SELECT t2.id,t2.route_name as name FROM `tblt_route_plan_detail` as t1
                inner join tbld_route as t2 on t1.route_id=t2.id
                where t1.dist_emp_id=$sr_id
                group by route_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getMarketByRoute($route_id) {
        $sql = "SELECT t2.id,t2.db_channel_element_name as name FROM `tbli_route_market_mapping` as t1
                inner join tbld_distribution_channel_elements as t2 on t1.mkt_id=t2.id
                where t1.route_id=$route_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getOutletByMarket($market_id) {
        $sql = "SELECT t1.id,t1.outlet_name as name FROM `tbld_outlet` as t1 where t1.parent_id=$market_id and t1.status=1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * get available sku list
     * @table: tbld_sku
     * ------------------------------------------------------------------------- */

    public function getAvailableSku() {
        $sql = "SELECT id,sku_name as name FROM `tbld_sku`";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * get Filtered sku list
     * @table: tbld_sku
     * ------------------------------------------------------------------------- */

    public function getFilteredSku($block_sku_list) {

        if ($block_sku_list != '') {

            $where = "where id not in(" . implode(',', $block_sku_list) . ")";
        } else {
            $where = "";
        }
        $sql = "SELECT id,sku_code,sku_description as sku_name FROM `tbld_sku` $where";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * get data from `tbli_sku_mou_price_mapping`, by sku id and mou_id
     * ------------------------------------------------------------------------- */

    public function getDdPrice($unit_id, $product_id) {
        $this->db->select('outlet_lifting_price as price');
        $this->db->from('tbli_sku_mou_price_mapping');
        $this->db->where('mou_id', $unit_id);
        $this->db->where('sku_id', $product_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function isPromotionPosible($sales_order_type) {
        $sql = "SELECT promotion FROM `tbli_other_sales_conf` where code='$sales_order_type'";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function isDiscountPosible($sales_order_type) {
        $sql = "SELECT count(id) as count FROM `tbli_other_sales_conf` where discount=1 and reconcile=0 and code='$sales_order_type'";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function isReconcilePosible($sales_order_type) {
        $sql = "SELECT reconcile FROM `tbli_other_sales_conf` where code='$sales_order_type'";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * Insert data to given table
     * @param_1 = table name
     * @param_2 = table data
     * @return last insert id
     * ------------------------------------------------------------------------- */

    public function insertData($tbl, $data) {
        $this->db->insert($tbl, $data);

        return $this->db->insert_id();
    }

    /* --------------------------------------------------------------------------
     * get outlet due by db_id and outlet_id
     * @param_1 = $db_id
     * @param_2 = $outlet_id
     * @return total outlet due
     * ------------------------------------------------------------------------- */

    public function getDueByOutletId($distribution_house_ids, $outlet_id) {
        $this->db->select('*');
        $this->db->from('tbli_outlet_due_mapping');
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("db_id", $distribution_house_ids);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function getActualQtyAndPrice($sku_id, $qty, $unit_id) {
        $sql = "SELECT ((quantity/quantity)*$qty) as order_qty,(outlet_lifting_price/quantity) as single_unit_pirce,((outlet_lifting_price/quantity)*$qty) as total_price FROM `tbld_bundle_price_details` where sku_id=$sku_id and mou_id=$unit_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * Update Table By column_name and set the data
     * @param string $tbl
     * @param int $id
     * @param array $data
     * @return boolearn
     * ------------------------------------------------------------------------- */

    public function updateTbl($tbl, $id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update($tbl, $data);

        return $query;
    }

    public function updateInventoryBySpoke($tbl, $sku_id, $data, $db_id) {
        $sql = "update $tbl set units_available = units_available+$data where sku_id=$sku_id and dbhouse_id = $db_id ";
        $query = $this->db->query($sql);

        return $query;
    }

    public function check_inventory_availability($db_id, $sku_id, $qty) {
        $sql = "SELECT id FROM `tbld_inventory` where dbhouse_id=$db_id and sku_id =$sku_id and units_available>=$qty";
        $this->db->query($sql);
        $result = $this->db->affected_rows();

        return $result;
    }

    public function getInventoryQtyByDbAndSku($db_id, $sku_id) {
        $sql = "SELECT t1.sku_id,t2.sku_name,t1.units_available FROM `tbld_inventory` as t1
                left join tbld_sku as t2 on t1.sku_id=t2.id
                where t1.dbhouse_id=$db_id and t1.sku_id = $sku_id";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getRouteNameBySo($route_id) {
        $sql = "SELECT route_name FROM `tbld_route` where id=$route_id";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * deduct sku qty from tbld_inventory
     * @param_1 = $db_id
     * @param_2 = $so_id
     * @return boolean
     * ------------------------------------------------------------------------- */

    public function deductFromMainInventory($db_id, $so_id) {
        $sql = "update tbld_inventory as a
                        inner join
                        (SELECT $db_id as db_id,sku_id,sum(quantity_confirmed) as qty FROM `tblt_sales_order_line` where so_id=$so_id
                        group by db_id,sku_id) as b
                        on a.dbhouse_id=b.db_id and a.sku_id=b.sku_id
                        set a.units_available=a.units_available-b.qty";
        $query = $this->db->query($sql);
        return $query;
    }

    public function deductFromInventory($db_id, $challan_id, $sku_id, $qty) {
        $sql = "update `tbld_booked_inventory` set total_qty=total_qty-$qty where db_id=$db_id and challan_id=$challan_id and sku_id=$sku_id";
        $query = $this->db->query($sql);
        return $query;
    }

    /* --------------------------------------------------------------------------
     * update outlet due by db_id and outlet_id
     * @table = tbli_outlet_due_mapping
     * @param_1 = $db_id
     * @param_2 = $sku_id
     * @param_3 = $qty_piece
     * @return boolean
     * ------------------------------------------------------------------------- */

    public function updateOutletDue($db_id, $outlet_id, $due) {
        $sql = "update `tbli_outlet_due_mapping` set due_amount=$due where db_id=$db_id and outlet_id=$outlet_id";
        $query = $this->db->query($sql);

        return $query;
    }

    public function updateGrbAndCrateDue($db_id, $outlet_id, $total_grb_due, $total_crate_due) {
        $sql = "update `tbli_outlet_due_mapping` set grb=$total_grb_due , crate =$total_crate_due  where db_id=$db_id and outlet_id=$outlet_id";
        $query = $this->db->query($sql);

        return $query;
    }

    public function getInvoiceSalesOrderBySoId($so_id) {
        //        $sql = "select a.promotion_id,a.so_id,a.sku_id,a.sku_name,floor(a.quantity_confirmed/b.ctn_qty) as ctn_qty,
        //                (a.quantity_confirmed%b.ctn_qty) as piece_qty,
        //                a.unit_sale_price,a.total_sale_price,a.so_id as invoice_no,
        //                a.total_discount_amount,a.total_billed_amount
        //                FROM
        //                (SELECT t1.id as so_id,t2.sku_id,t3.sku_name_b as sku_name,t2.promotion_id,t2.quantity_confirmed,t2.unit_sale_price,t2.total_sale_price,t2.total_discount_amount,t2.total_billed_amount FROM `tblt_sales_order` as t1
        //                left join `tblt_sales_order_line` as t2 on t1.id=t2.so_id
        //                left join tbld_sku as t3 on t2.sku_id=t3.id
        //                where t1.id=$so_id and t2.sku_order_type_id=1) as a
        //                left join
        //                (SELECT t1.sku_id,max(t2.qty) as ctn_qty FROM `tbli_sku_default_mou` as t1
        //                inner join tbld_unit as t2 on t1.db_mou_id=t2.id
        //                group by t1.sku_id) as b on a.sku_id=b.sku_id
        //                ";
        $sql = "select a.promotion_id, a.so_id, a.sku_id, a.sku_name, a.sku_code, a.route_name, a.sub_route_name, a.first_name as sr_name, a.psr_mobile, a.sales_order_type_name, floor(a.quantity_confirmed/b.ctn_qty) as ctn_qty,
                (a.quantity_confirmed%b.ctn_qty) as piece_qty, 
                round(a.unit_sale_price,2) as unit_sale_price,a.total_sale_price,a.so_id as invoice_no,
                a.total_discount_amount,a.total_billed_amount,b.pack_size
                FROM 
                (SELECT t1.id AS so_id,t2.sku_id,t3.sku_name_b AS sku_name, t3.sku_code, t2.promotion_id,t2.quantity_confirmed,t2.unit_sale_price,t2.total_sale_price, t2.total_discount_amount,t2.total_billed_amount,t4.route_name, t5.first_name,t6.sales_order_type_name,t7.db_channel_element_name AS sub_route_name, t8.mobile1 AS psr_mobile FROM `tblt_sales_order` AS t1
                LEFT JOIN `tblt_sales_order_line` AS t2 ON t1.id=t2.so_id
                LEFT JOIN tbld_sku AS t3 ON t2.sku_id=t3.id
                LEFT JOIN tbld_route AS t4 ON t1.route_id=t4.id
                LEFT JOIN tbld_distribution_employee AS t5 ON t5.id=t1.sr_id
                LEFT JOIN tbld_sales_order_type AS t6 ON t6.id = t1.sales_order_type_id
                LEFT JOIN tbld_distribution_channel_elements AS t7 ON t7.id=t1.market_id
                LEFT JOIN tbld_address AS t8 ON t8.id=t5.dist_emp_address
                WHERE t1.id= $so_id AND t2.sku_order_type_id =1  AND t7.db_channel_element_category_id = 2) as a
                left join
                (SELECT t1.sku_id,max(t2.qty) as ctn_qty, max(t2.qty) as pack_size FROM `tbli_sku_default_mou` as t1
                inner join tbld_unit as t2 on t1.db_mou_id=t2.id
                group by t1.sku_id) as b on a.sku_id=b.sku_id";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOutletAndDbInfoBySoId($so_id) {

        $sql = "SELECT date_format(t1.order_date_time,'%m-%d-%Y %h:%i') AS order_date, date(t1.order_date_time) as delivery_date, t1.outlet_id, IF(t2.outlet_name_b !='', t2.outlet_name_b, t2.outlet_name) AS outlet_name ,IF(t3.address_bn !='',t3.address_bn,t3.address_name) AS outlet_address, t4.dbhouse_name, t5.address_name AS db_address, t5.mobile1 AS db_mobile FROM `tblt_sales_order` AS t1
                LEFT JOIN tbld_outlet AS t2 ON t1.outlet_id=t2.id
                LEFT JOIN tbld_address AS t3 ON t2.outlet_address_id=t3.id
                LEFT JOIN tbld_distribution_house AS t4 ON t1.db_id=t4.id
                LEFT JOIN tbld_address AS t5 ON t4.dbhouse_address_id=t5.id
                WHERE t1.id=$so_id ";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getDamageOrderBySoId($so_id) {

        $sql = " SELECT t4.sku_name_b as sku_name,t3.sku_id,t3.quantity_delivered as qty FROM `tblt_sales_order` as t1
                     inner join `tblt_outlet_damage_order` as t2 on t1.outlet_id=t2.outlet_id
                     inner join `tblt_outlet_damage_order_line` as t3 on t2.id=t3.do_id
                     left join `tbld_sku` as t4 on t3.sku_id=t4.id
                     where t1.id=$so_id and t2.stage='END' and t2.so_id = 0  ";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getDbpSrList($db_id) {
        $sql = "SELECT id,first_name as name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOrderStatus() {
        $sql = "SELECT id,so_status_name as name FROM `tbld_sales_order_status` where id not in(3)";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getRouteBySrAndDateRange($sr_id, $date_frm, $date_to) {
        $sql = "SELECT t2.id,t2.route_name as name FROM `tblt_route_sr_schedule_mapping` as t1
                      inner join tbld_route as t2 on t1.route_id=t2.id
                      where dist_emp_id=$sr_id and route_activity_date between '$date_frm' and '$date_to'";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOutletByRoute($route_id) {
        $sql = "SELECT GROUP_CONCAT(t2.id) as outlet_id FROM `tbli_route_market_mapping` as t1
                inner join tbld_outlet as t2 on t1.mkt_id=t2.parent_id
                where t1.route_id=$route_id
                group by t2.parent_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOutletListByMarket($market_id) {
        $sql = "SELECT GROUP_CONCAT(id) as outlet_id FROM `tbld_outlet`
                where parent_id=$market_id
                group by parent_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function get_unit_price($sku_id) {
        //      $sql = "SELECT outlet_lifting_price as price FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id and quantity=1";
        $sql = "SELECT t1.outlet_lifting_price as price, t2.sku_code, t2.sku_description
              FROM `tbli_sku_mou_price_mapping` as t1 
              Inner JOIN `tbld_sku` as t2 On t1.sku_id=t2.id
              where sku_id=$sku_id and quantity=1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function get_sku_info($sku_id) {
        $sql = "SELECT * FROM `tbld_sku` where sku_id=$sku_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getDefaultMou($sku_id) {
        $sql = "SELECT t3.sku_code,t2.qty,t4.code FROM `tbli_sku_default_mou` as t1
              left join tbld_unit as t2 on t1.outlet_mou_id=t2.id
              LEFT JOIN tbld_sku as t3 on t1.sku_id = t3.id
              LEFT JOIN tbld_container_type as t4 on t3.sku_container_type_id = t4.id
              where t1.sku_id=$sku_id
              order by t2.qty desc";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getNextSalesOrderBySoId($so_id, $so_status, $type) {
        if ($type == 'mobile') {
            $where = "and t2.sales_order_type_id = 1";
        } else {
            if ($type == 'others') {
                $where = "and t2.sales_order_type_id>1";
            }
        }


        $sql = "SELECT t2.id FROM `tblt_sales_order` as t1
                        inner join `tblt_sales_order` as t2 on date(t1.order_date_time)=date(t2.order_date_time) and t1.sr_id=t2.sr_id
                        where t1.id=$so_id and t1.id!=t2.id and t2.so_status=$so_status $where";



        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getFreeSku($so_id, $promo_id) {
        $sql = "SELECT t2.sku_name_b as sku_name,t1.quantity_confirmed as qty,t3.ctn_size,t3.price FROM `tblt_sales_order_line` as t1
               left join tbld_sku as t2 on t1.sku_id=t2.id
               left join (SELECT t1.sku_id,max(t1.quantity) as ctn_size,round(max(db_lifting_price),2) as price FROM `tbli_sku_mou_price_mapping` as t1 group by t1.sku_id) as t3 on t2.id=t3.sku_id
                
               where t1.so_id=$so_id and t1.promotion_id=$promo_id and t1.sku_order_type_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function deleteExistingFreeSku($so_id, $promotion_id) {
        $sql = "delete FROM `tblt_sales_order_line` where so_id=$so_id and promotion_id=$promotion_id and sku_order_type_id=2";
        $query = $this->db->query($sql);

        return $query;
    }

    public function checkFreeSkuExistOrNot($so_id, $promotion_id, $sku_id) {
        $sql = "SELECT id FROM `tblt_sales_order_line` where so_id=$so_id and sku_id=$sku_id and promotion_id=$promotion_id and sku_order_type_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function checkInventoryBySo($so_id, $db_id) {
        $sql = "select c.so_id,c.sku_id,c.units_available,c.qty as required_qty,d.sku_name from (select a.sku_id,a.units_available,b.qty,b.so_id from  tbld_inventory as a
                inner join 
                (SELECT $db_id as db_id,sku_id,sum(quantity_confirmed) as qty,so_id FROM `tblt_sales_order_line` where so_id=$so_id 
                group by db_id,sku_id) as b 
                on a.dbhouse_id=b.db_id and a.sku_id=b.sku_id) as c 
                left join tbld_sku as d on c.sku_id=d.id
                where c.units_available<c.qty";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getCrateQty($sku_id, $qty) {
        $sql = "SELECT max(quantity) as qty FROM tbli_sku_mou_price_mapping WHERE sku_id = $sku_id;";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSkyContainerType($sku_id) {
        $sql = "SELECT t2.code  FROM tbld_sku AS t1
                INNER JOIN tbld_container_type as t2 on t1.sku_container_type_id = t2.id
                WHERE t1.id = $sku_id;";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function salesOrderWiseDue($so_id) {
        $sql = "select * from
                (SELECT id as so_id,outlet_id,date(order_date_time) as due_date,db_id,total_order-(cash_received+manual_discount) as due_amount FROM `tblt_sales_order` where id=$so_id) as A
                ";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderById($so_id) {
        $sql = "select * from `tblt_sales_order` where id=$so_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderInfoWithPromotion($so_id) {
        $sql = "select D.sku_id,D.sku_code,D.sku_name_b as sku_name,D.ctn_size as pack_size,(D.unit_sale_price) as price,D.ctn_qty,D.piece_qty,
                '' as free_sku,sum(D.free_qty) as free_qty,'' as damage,
                D.total_sale_price as total_amount
                ,D.total_discount_amount as discount,D.total_billed_amount as netAmount,D.manual_discount
                from
                (select * from
                (select A.*,B.ctn_size,B.db_lifting_price,floor(A.quantity_confirmed/B.ctn_size) as ctn_qty,
                                (A.quantity_confirmed%B.ctn_size) as piece_qty,0 as free_qty  from
                (SELECT t1.sku_id,t2.sku_code,if(t2.sku_name_b='',t2.sku_name,t2.sku_name_b) as sku_name_b ,t1.quantity_confirmed,t1.unit_sale_price,t1.total_sale_price,t1.total_discount_amount,t1.total_billed_amount,t3.manual_discount FROM `tblt_sales_order_line` as t1
                left join tbld_sku as t2 on t1.sku_id=t2.id
                inner join tblt_sales_order as t3 on t1.so_id=t3.id
                where t1.so_id=$so_id and t1.sku_order_type_id=1) as A
                inner join
                (SELECT t1.sku_id,max(t1.quantity) as ctn_size,t1.db_lifting_price FROM `tbli_sku_mou_price_mapping` as t1

                group by t1.sku_id) as B on A.sku_id=B.sku_id) as C
                union all
                (select A.*,B.ctn_size,B.db_lifting_price,0 as ctn_qty,
                                0 as piece_qty,A.quantity_confirmed as free_qty  from
                (SELECT t1.sku_id,t2.sku_code,if(t2.sku_name_b='',t2.sku_name,t2.sku_name_b) as sku_name_b,t1.quantity_confirmed,t1.unit_sale_price,t1.total_sale_price,t1.total_discount_amount,t1.total_billed_amount,t3.manual_discount FROM `tblt_sales_order_line` as t1
                left join tbld_sku as t2 on t1.sku_id=t2.id
                inner join tblt_sales_order as t3 on t1.so_id=t3.id
                where t1.so_id=$so_id and t1.sku_order_type_id=2) as A
                inner join
                (SELECT t1.sku_id,max(t1.quantity) as ctn_size,t1.db_lifting_price FROM `tbli_sku_mou_price_mapping` as t1

                group by t1.sku_id) as B on A.sku_id=B.sku_id)) as D
                group by D.sku_id
                ";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderInfoHeader($id) {
        $sql = " SELECT t2.first_name AS sr_name,t3.db_channel_element_name AS sub_route_name, t2.contact_no AS psr_mobile FROM tblt_sales_order AS t1
                 INNER JOIN tbld_distribution_employee AS t2 ON t1.sr_id = t2.id
                 INNER JOIN tbld_distribution_channel_elements AS t3 ON t1.market_id = t3.id
                 INNER JOIN tbld_address AS t4 ON t2.dist_emp_address = t4.id where t1.id = $id ";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getChallanIdBySoId($so_id) {
        $sql = "SELECT challan_id FROM `tbli_challan_sales_order_mapping` where so_id=$so_id and challan_status=1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function isAvailableBookedInventory($challan_id, $sku_id, $qty) {
        $sql = "SELECT t1.*,t2.sku_name FROM `tbld_booked_inventory` as t1
                      LEFT JOIN tbld_sku as t2 on t1.sku_id=t2.id
                      where t1.challan_id=$challan_id and t1.sku_id=$sku_id and t1.total_qty<$qty";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    /* Edit From MD:Rabius Sani Raju
     * ...............Business Requiremtn Where Codition...........
     * Not Allow External Product
     */

    public function getSoInfo($so_id) {
        $sql = "SELECT t2.sku_id,t2.quantity_confirmed as qty,t2.quantity_delivered,t2.unit_sale_price,t1.so_status FROM `tblt_sales_order` as t1
                      inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id 
                      left join `tbld_sku` as t3 on t3.id = t2.sku_id
                      where t1.id=$so_id and t3.sku_type_id !=99 ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isNewSku($challan_id, $sku_id) {
        $sql = "SELECT t1.* FROM `tbld_booked_inventory` as t1
                      where t1.challan_id=$challan_id and t1.sku_id=$sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSkuQtyInfo($sku_id) {
        $sql = "select sku_name ,0 as qty_case,0 as qty_piece from tbld_sku where id=$sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDbCode($db_id) {
        $sql = "SELECT dbhouse_code FROM `tbld_distribution_house` where id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRouteCode($route_id) {
        $sql = "SELECT route_code FROM `tbld_route` where id=$route_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSoSerial($sr_id) {
        $sql = "SELECT count(id)+1 as serial FROM `tblt_sales_order` where sr_id=$sr_id and planned_order_date=curdate()";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getInvoiceNo($so_id) {
        $sql = "SELECT so_id FROM `tblt_sales_order` where id=$so_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function deliveryDamageBySoId($so_id) {
        $sql = "update `tblt_outlet_damage_order` AS t1
                    inner join (select id as so_id,outlet_id from tblt_sales_order where id= $so_id) as t2 
                    on t1.outlet_id=t2.outlet_id
                    set t1.so_id=t2.so_id
                    where t1.so_id = 0 and t1.stage ='END' ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}
