<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Historys');
        $this->method_call = &get_instance();
    }


    public function getSkuCtnSize($sku_id){
        $ctn_size = $this->Historys->getSkuCtnSize($sku_id);
        return $ctn_size[0]['ctn_size'];
    }

    public function getDbSkuCurrentStock($db_id,$sku_id){
        $stock = $this->Historys->getDbSkuCurrentStock($db_id,$sku_id);
        return $stock[0]['units_available'];
    }

    public function getDbSkuBookedQty($db_id,$sku_id){
        $qty = $this->Historys->getDbSkuBookedQty($db_id,$sku_id);
        return $qty[0]['total_booked_qty'] ? $qty[0]['total_booked_qty']:0;
    }
    public function getDbSkuPrice($db_id,$sku_id){
        $price = $this->Historys->getDbSkuPrice($db_id,$sku_id);
        if(!empty($price)){
            $price = $price[0]['price'];
        }else{
            $price = 0;
        }
        return $price;
    }
    public function tblh_inventory_history($data){
        $insert_id = $this->Historys->insertData('tblh_inventory_history',$data);
        return $insert_id;
    }

}

?>