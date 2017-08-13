<?php

class Historys extends CI_Model {

    public function getSkuCtnSize($sku_id) {
        $sql = "SELECT max(quantity) as ctn_size FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getDbSkuCurrentStock($db_id,$sku_id){
        $sql = "SELECT units_available FROM `tbld_inventory` where dbhouse_id=$db_id and sku_id=$sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDbSkuBookedQty($db_id,$sku_id){
        $sql = "SELECT t1.sku_id,sum(t1.total_qty) as total_booked_qty FROM `tbld_booked_inventory` as t1
            inner join tblt_challan as t2 on t1.challan_id=t2.id
            where t1.db_id=$db_id and t1.sku_id=$sku_id and t2.challan_status=1
            group by sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDbSkuPrice($db_id,$sku_id){
        $sql = "SELECT sku_id,ifnull(outlet_lifting_price,0) as price FROM `tbli_db_bundle_price_mapping` as t1
                inner join `tbld_bundle_price_details` as t2 on t1.bundle_price_id=t2.bundle_price_id
                where t1.db_id=$db_id and t2.sku_id=$sku_id and t2.quantity=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function insertData($tbl, $data) {
        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }

}
