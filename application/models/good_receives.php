<?php

class Good_receives extends CI_Model {

    public function insert_sales_return_dbh($data) {
        $db_house_id = $data['db_house_id'];
        $sku = $data['sku'];
        $return = $data['return'];
        $batch = $data['batch'];
        $comments = $data['comments'];
        $date = $data['date'];
        for ($i = 0; $i < count($batch); $i++) {
            $sql = "INSERT INTO `tbld_return_inventory`" . "(`dbhouse_id`, `sku_id`, `batch_no`, `quantity`,`comments`,`date`) " . "VALUES " . "($db_house_id,$sku,$batch[$i],$return[$i],'$comments[$i]','$date')";
            $query = mysql_query($sql);
        }

        return $query;
    }

    public function damage_criterias() {
        $this->db->select('*');
        $this->db->from('tbld_db_damage_criteria');
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function get_damage_critaria_names($id) {
        $this->db->select('*');
        $this->db->from('tbld_db_damage_criteria');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function getPurchaseIndentIDs($db_house_id) {
        $this->db->select('distinct(indent_id)');
        //$this->db->distinct('indent_id');
        $this->db->from('tbli_raw_chalan');
        $this->db->where("db_id", $db_house_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function getchalan_ids($indent_id) {
        $this->db->select('id,chalan_date,chalan_id');
        $this->db->distinct();
        $this->db->from('tbli_raw_chalan');
        $this->db->where("indent_id", $indent_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function getChalan_sku_infos($chalan_id) {
        $this->db->select('*');
        $this->db->from('tbli_raw_chalan');
        $this->db->where("chalan_id", $chalan_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

//    public function save_good_receives ($data)
//    {
//        $dbhouse_id = $data['dbhouse_id'];
//        $sku_id = $data['sku_id'];
//        $units_available = $data['received_qty'];
//        $batch_no = $data['batch_no'];
//        $chalan_id = $data['chalan_id'];
//        $chalan_date = $data['lifting_date'];
//        for($i = 0; $i < count($sku_id); $i++) {
//            $sql = "INSERT INTO `tbld_inventory`(`dbhouse_id`, `sku_id`, `units_available`, `batch_no`, `chalan_no`, `chalan_date`)
//                VALUES
//                ('$dbhouse_id','$sku_id[$i]','$units_available[$i]','$batch_no[$i]','$chalan_id','$chalan_date')";
//            $query = mysql_query($sql);
//        }
//        //return $this->db->insert_id();
//    }

    public function save_good_receive_manuallys($data) {
        //return $this->db->insert('tbld_inventory', $data);
        $sku = $data['sku_id'];
        $db = $data['dbhouse_id'];
        $units = $data['units_available'];
        $batch_no = $data['batch_no'];
        $chalan_no = $data['chalan_no'];
        $chalan_date = $data['chalan_date'];
        $free_qty = $data['free_qty'];
        /*
         * Start tbli_db_inventory_detail
         */
        $sql = "SELECT units_available FROM tbld_inventory WHERE sku_id = '$sku' and dbhouse_id = '$db'";
        $result = mysql_query($sql);
        $units_available = mysql_fetch_array($result);
        $units_available_qty = $units_available['units_available'];
        $close_stock = $units_available_qty + $units;
        $new_change = $units;
        $sql = "INSERT INTO
            `tbli_db_inventory_detail`
            (`db_id`, `sku_id`, `open_stock`, `close_stock`, `new_change`, `tx_type`, `tx_id`, `tx_date`, `tx_indent`, `tx_batch`, `tx_challan`)
            VALUES
            ('$db','$sku','$units_available_qty',$close_stock,$new_change,'in','6','$chalan_date','','$batch_no','$chalan_no')";
        $result = mysql_query($sql);
        /*
         * End tbli_db_inventory_detail
         */
        /*
         * Start tbld_db_inventory
         */
        $q = $this->db->query("SELECT id FROM tbld_inventory WHERE sku_id = '$sku' and dbhouse_id = '$db'");
        if ($q->num_rows() == 0) {
            return $this->db->insert('tbld_inventory', $data);
        } else {
            $q1 = $this->db->query("UPDATE tbld_inventory SET units_available = units_available + '$units',free_qty=$free_qty WHERE sku_id = '$sku' and dbhouse_id = '$db'");

            return $q1;
        }
        /*
         * End tbld_db_inventory
         */
    }

    public function get_tbld_return_inventory_by_id($db_house_id, $sku_id) {
        $this->db->select('*');
        $this->db->from('tbld_return_inventory');
        $this->db->where("dbhouse_id", $db_house_id);
        $this->db->where("sku_id", $sku_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function get_tbld_inventory_by_id($db_house_id, $sku_id) {
        $this->db->select('*');
        $this->db->from('tbld_inventory');
        $this->db->where("dbhouse_id", $db_house_id);
        $this->db->where("sku_id", $sku_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function insert_sales_return_ho($data) {
        $db_house_id = $data['db_house_id'];
        $sku_id = $data['sku_id'];
        $return = $data['return'];
        $batch = $data['batch'];
        $comments = $data['comments'];
        $date = $data['date'];
        for ($i = 0; $i < count($return); $i++) {
            $sql = "UPDATE `tblt_central_inventory` SET `qty`=`qty`+$return[$i] WHERE sku_id='$sku_id'";
            $query = mysql_query($sql);
        }

        return $query;
    }

    public function insert_damage_return_dbh($data) {
        $db_house_id = $data['db_house_id'];
        $sku_id = $data['sku_id'];
        $damage_quantity = $data['damage_quantity'];
        $batch = $data['batch'];
        $damage_criteria = $data['damage_criteria'];
        $date = $data['date'];
        for ($i = 0; $i < count($sku_id); $i++) {
            $sql = "INSERT INTO `tbld_damage_inventory`" . "(`dbhouse_id`, `sku_id`, `batch_no`, `quantity`,`damage_critaria`,`date`) " . "VALUES " . "('$db_house_id','$sku_id[$i]','$batch[$i]','$damage_quantity[$i]','$damage_criteria[$i]','$date')";
            $query = mysql_query($sql);
        }

        return $query;
    }

    public function insert_damage_return_ho($data) {
        $db_house_id = $data['db_house_id'];
        $sku_id = $data['sku_id'];
        $batch = $data['batch'];
        $damage_quantity = $data['damage_quantity'];
        $damage_criteria = $data['damage_criteria'];
        $date = $data['date'];
        for ($i = 0; $i < count($sku_id); $i++) {
            if ($damage_quantity[$i] != "") {
                $sql = "UPDATE `tblt_central_inventory` SET `qty`=`qty`+$damage_quantity[$i] WHERE sku_id='$sku_id[$i]'";
                $query = mysql_query($sql);
            }
        }

        return $query;
    }

    public function Update_tbld_inventory_by_id($db_house_id, $sku_id, $batch_no, $data) {
        $db_house_id = $data['db_house_id'];
        $sku_id = $data['sku_id'];
        $batch = $data['batch'];
        $return = $data['return'];
        $date = $data['date'];
        for ($i = 0; $i < count($sku_id); $i++) {
            $sql = "UPDATE `tbld_inventory` SET `units_available`=`units_available`-$return[$i] WHERE `sku_id`='$sku_id[$i]' AND `dbhouse_id`='$db_house_id' AND `batch_no`='$batch[$i]'";
            $query = mysql_query($sql);
        }

        return $query;
    }

    public function Update_tblt_central_inventory_by_id($sku_id) {
        # code...
    }

    public function delete_tbld_damage_inventory_by_id($sku_id, $db_house_id) {
        for ($i = 0; $i < count($sku_id); $i++) {
            $sql = "DELETE FROM `tbld_damage_inventory` WHERE `sku_id` ='$sku_id[$i]' AND `dbhouse_id` = '$db_house_id'";
            $query = mysql_query($sql);
        }

        return $query;
    }

    public function delete_tbld_return_inventory_by_id($sku_id, $db_house_id) {
        for ($i = 0; $i < count($sku_id); $i++) {
            $sql = "DELETE FROM `tbld_return_inventory` WHERE `sku_id` ='$sku_id[$i]' AND `dbhouse_id` = '$db_house_id'";
            $query = mysql_query($sql);
        }

        return $query;
    }

    public function get_return_inventroy($db_house_id, $sku_id) {
        $this->db->select('*');
        $this->db->from('tbld_return_inventory');
        $this->db->where("dbhouse_id", $db_house_id);
        $this->db->where("sku_id", $sku_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function get_return_damge($db_house_id, $sku_id) {
        $this->db->select('*');
        $this->db->from('tbld_damage_inventory');
        $this->db->where("dbhouse_id", $db_house_id);
        $this->db->where("sku_id", $sku_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function get_tbld_user_role() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_user_role');
        $query = $this->db->get()->result_array();

        return $query;
    }
    
    public function getDBHouseInfo($where) {
        $sql = "SELECT * FROM `tbld_distribution_house` as t1  $where ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    public function getDbIdByChallanNo($challan_no) {
        $sql = "SELECT t1.db_id FROM `tblt_primary_indent_data` as t1 where t1.challan_no = $challan_no ";
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

    public function getPrimaryIndentData($where) {
        $sql = " SELECT t1.id, t1.challan_no, t1.date as challan_date, sum(t1.price) as total_amount, t1.status, t2.sku_name,
                floor(t1.qty/t3.ctn_size) as ctn , t1.qty % t3.ctn_size as piece,
                sum(((t1.qty*1.0)/t3.ctn_size)) as total_qty, t4.dbhouse_name FROM `tblt_primary_indent_data` AS t1
                Inner join `tbld_sku` as t2 on t1.product_id = t2.id
                inner join (SELECT t1.sku_id,max(t1.quantity) as ctn_size FROM `tbli_sku_mou_price_mapping` as t1
                group by t1.sku_id) as t3 on t2.id=t3.sku_id
                INNER join tbld_distribution_house as t4 on t1.db_id = t4.id
                $where group by t1.challan_no ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function checkStatus($id) {
        $sql = " SELECT status From tblt_primary_indent_data WHERE challan_no = $id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    public function change_stage($id) {
        $sql = "Update tblt_primary_indent_data SET status = 3
                where challan_no=$id";
        $this->db->query($sql);
    }

    public function getPrimaryIndentDataById($challan_no) {
        $sql = "SELECT t1.status, t1.challan_no, t1.product_id,t1.qty,t1.price,t2.*,
                floor(t1.qty/t2.ctn_size) as ctn , t1.qty % t2.ctn_size as piece
                FROM `tblt_primary_indent_data` as t1 
                left join (select sku_id,max(quantity) as ctn_size from tbli_sku_mou_price_mapping  group by sku_id) as t2 on t1.product_id=t2.sku_id
                where t1.challan_no=$challan_no";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updatePrimaryIndentDataById($challan_no) {
        $sql = "Update tblt_primary_indent_data SET status = 2
                where challan_no=$challan_no";
        $this->db->query($sql);
    }

    public function getChallanNumber($DeliveryChallanNumber) {
        $sql = "SELECT count(challan_no) as count  From tblt_primary_indent_data  where challan_no = $DeliveryChallanNumber";
//        echo $sql;
//        die();
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    public function getPorductId($product_code) {
        $sql = "SELECT id From tbld_sku  where sku_code=$product_code";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDBId($CustomerID) {
        $sql = "SELECT id From tbld_distribution_house  where dbhouse_code=$CustomerID";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBundleDetailbySku($sku_id, $db_id) {

        $sql = "SELECT t1.*,t2.id,t2.bundle_price_id,t2.sku_id,t4.sku_code,t2.mou_id,t2.quantity,
                    FORMAT(MIN(t2.outlet_lifting_price), 2)  as unit_price, t3.unit_name 
                    FROM `tbli_db_bundle_price_mapping` as t1 
                    Inner Join `tbld_bundle_price_details` as t2 
                    On t2.bundle_price_id=t1.bundle_price_id
                    Inner Join tbld_unit as t3 on t2.mou_id=t3.id
                    Inner Join tbld_sku as t4 on t2.sku_id=t4.id
                    Where t2.sku_id=$sku_id and t1.db_id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getFilteredSku($db_ids, $block_sku_list) {
        if ($block_sku_list != '') {
            $where = " and t2.sku_id not in(" . implode(',', $block_sku_list) . ")  ";
        } else {
            $where = "  ";
        }
        $sql = "SELECT t1.*,t2.*,t3.sku_code,t3.sku_description as sku_name
                FROM `tbli_db_bundle_price_mapping` as t1 
                Inner Join `tbld_bundle_price_details` as t2 
                On t1.bundle_price_id=t2.bundle_price_id 
                Inner Join `tbld_sku` as t3 on t2.sku_id=t3.id
                $db_ids $where and t3.sku_type_id !=99  group by t2.sku_id"; 
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

//    
//    public function getFilteredSku($block_sku_list){
//        if($block_sku_list !=''){
//            $where = "where id not in(".implode(',', $block_sku_list).")";
//        }else{
//            $where = "";
//        }
//        $sql = "SELECT id,sku_name, sku_description as name FROM `tbld_sku` $where";
//        $query = $this->db->query($sql)->result_array();
//        return $query;
//    }

    public function getSkuTpPrice($sku_id) {
        $sql = "SELECT outlet_lifting_price as price FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id and quantity=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDamageTypes() {
        $sql = "SELECT * FROM `tbld_db_damage_criteria`";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function save_purchase_order($tbl, $data) {
        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }

    public function save_purchase_order_line($tbl, $data) {
        $this->db->insert($tbl, $data);
    }

    public function save_transport_order($tbl, $data) {
        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }

    public function save_transport_order_line($tbl, $data) {
        $this->db->insert($tbl, $data);
    }

    public function sapFileFormate() {
        $sql = " SELECT * from (SELECT  'DeliveryChallanNumber' as 'DeliveryChallanNumber', 'DeliveryChallanDate' AS DeliveryChallanDate, 
                'CustomerID' as CustomerID, 'ProductID' as ProductID, 'ConversionFactor' as ConversionFactor,
                'Quantity' as Quantity ) as H ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function save_good_receives($data) {

        $sku_id = $data['sku_id'];
        $price = $data['price'];
        $batch_no = $data['batch_no'];
        $db_id = $data['dbhouse_id'];
        $units = $data['units_available'];
        $chalan_no = $data['chalan_no'];
        $vat_chalan_no = $data['vat_chalan_no'];
        $chalan_date = $data['chalan_date'];
        $indent_id = $data['indent_id'];


        $sql_1 = "SELECT units_available FROM tbld_inventory WHERE sku_id = $sku_id and dbhouse_id = $db_id";
        $query_1 = $this->db->query($sql_1)->result_array();
        $units_available_qty = $query_1[0]['units_available'];
        if ($units_available_qty == NULL) {
            $units_available_qty = 0;
        }
        $close_stock = $units_available_qty + $units;
        $new_change = $units;
        $data_1 = array(
            'db_id' => $db_id,
            'sku_id' => $sku_id,
            'price' => $price,
            'open_stock' => $units_available_qty,
            'close_stock' => $close_stock,
            'new_change' => $new_change,
            'tx_type' => 'in',
            'tx_id' => '6',
            'tx_date' => $chalan_date,
            'tx_indent' => $indent_id,
            'tx_batch' => $batch_no,
            'tx_challan' => $chalan_no
        );
        /* insert tbli_db_inventory_detail sku individual (START) */

        $this->db->insert('tbli_db_inventory_detail', $data_1);

        /* insert tbli_db_inventory_detail sku individual (END) */
        $data_2 = array(
            'dbhouse_id' => $db_id,
            'sku_id' => $sku_id,
            'units_available' => $units_available_qty,
            'batch_no' => $batch_no,
            'chalan_no' => $chalan_no,
            'vat_chalan_no' => $vat_chalan_no,
            'chalan_date' => $chalan_date
        );


        $select_query = $this->db->query("SELECT id FROM tbld_inventory WHERE sku_id = $sku_id and dbhouse_id = $db_id ")->result_array();


        if (empty($select_query)) {
            /* insert tbld_inventory sku individual (START) */
            return $this->db->insert('tbld_inventory', $data_2);

            /* insert tbld_inventory sku individual (END) */
        } else {
            /* update tbld_inventory sku individual (START) */
            $update_query = $this->db->query("UPDATE tbld_inventory SET units_available = $close_stock, chalan_no = '$chalan_no', batch_no = '0', vat_chalan_no = '$vat_chalan_no' WHERE sku_id = $sku_id and dbhouse_id = $db_id ");
            return $update_query;

            /* update tbld_inventory sku individual (END) */
        }
    }

    public function insertData($tbl, $data) {
        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }

    public function select_sales_return_view() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_return_inventory');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllDBHouse($id) {

        $this->db->select('*');
        $this->db->from('tbli_dbhouse_product_line_mapping');
        $this->db->where('sales_emp_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_damage() {
        $this->db->select('id,damage_name');
        $querys = $this->db->get('tbld_db_damage_criteria')->result_array();
        return $querys;
    }

    public function select_db_damage_return_view() {
        $this->db->select('*');
        $this->db->order_by("id", "desc");
        $this->db->from('tbld_damage_inventory');

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSkuNameById($id) {
        $sql = "SELECT t1.*,t2.mou_id,t2.db_lifting_price,t2.outlet_lifting_price,t2.mrp_lifting_price FROM `tbld_sku`  as t1
                left join
                `tbli_sku_mou_price_mapping` as t2
                on t1.id=t2.sku_id where t1.id=$id order by t1.id,t2.quantity desc";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getProductLineByDbhouseId($id) {
        $this->db->select('*');
        $this->db->where('dbhouse_id', $id);
        $query = $this->db->get('tbli_dbhouse_product_line_mapping')->result_array();
        return $query;
    }

    public function getProductLineNameById($id) {
        $this->db->select('id,name,code,description');
        $this->db->where('id', $id);
        $query = $this->db->get('tbld_product_line')->result_array();
        return $query;
    }

    public function getProduct($id) {
        $this->db->select('id,element_name');
        $this->db->where('parent_element_id', $id);
        $query = $this->db->get('tbld_sku_hierarchy_elements')->result_array();
        return $query;
    }

    public function getSku($id) {
        $this->db->select('*');
        $this->db->where('parent_id', $id);
        $query = $this->db->get('tbld_sku')->result_array();
        return $query;
    }

    public function setStockAvailableQtys($dbhouse_id, $sku_id) {
        $this->db->select('units_available');
        $this->db->where('dbhouse_id', $dbhouse_id);
        $this->db->where('sku_id', $sku_id);
        $query = $this->db->get('tbld_inventory')->result_array();
        return $query;
    }

    public function getdistributionid($id) {

        $this->db->select('distribution_house_id');
        $this->db->from('tbld_distribution_employee');
        $this->db->where('login_user_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getdistributionName($id) {

        $this->db->select('id,dbhouse_name,dbhouse_code');
        $this->db->where('id', $id);
        $this->db->from('tbld_distribution_house');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function DeductDamageQtyFromInv($db, $sku, $qty) {



        /*
         * Start tbli_db_inventory_detail
         */
        $sql = "SELECT units_available FROM tbld_inventory WHERE sku_id = '$sku' and dbhouse_id = '$db'";
        $result = mysql_query($sql);
        $units_available = mysql_fetch_array($result);
        $units_available_qty = $units_available['units_available'];



        $close_stock = $units_available_qty + $qty;
        $new_change = $qty;

        $today = date("Y-m-d");
        $sql = "INSERT INTO
            `tbli_db_inventory_detail`
            (`db_id`, `sku_id`, `open_stock`, `close_stock`, `new_change`, `tx_type`, `tx_id`, `tx_date`, `tx_indent`, `tx_batch`, `tx_challan`)
            VALUES
            ('$db','$sku','$units_available_qty',$close_stock,$new_change,'outlet_damage','7','$today','','','')";
        $result = mysql_query($sql);

        /*
         * End tbli_db_inventory_detail
         */

        $sql = "UPDATE tbld_inventory SET units_available = units_available - '$qty' WHERE sku_id = '$sku' and dbhouse_id = '$db'";
        $q1 = $this->db->query($sql);
        return $q1;
    }

    public function getUnitQtyByUnitId($id) {
        $this->db->select('qty');
        $this->db->where("id", $id);
        $query = $this->db->get('tbld_unit')->result_array();
        return $query;
    }

    public function getFlowIdByCode($code) {
        $sql = "SELECT id FROM `tbld_flow` where code='$code'";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    /* --------------------------------------------------------------------------
     * get source role code by flow_id_fk. 
     * Table: tbld_flow_sequence
     * ------------------------------------------------------------------------- */

    public function getSourceRoleCodeByFlowId($flow_id_fk) {
        $sql = "SELECT source_role_code FROM `tbld_flow_sequence` where flow_id_fk=$flow_id_fk
                group by source_role_code";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }


}
