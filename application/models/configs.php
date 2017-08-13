<?php

class Configs extends CI_Model {

    public function insert_config($code, $data) {
        $this->db->where('config_code', $code);
        $this->db->set('attribute_id', $data, FALSE);
        return $this->db->update('tbld_config');
    }

    public function selectConfigParam($config_code) {
        $this->db->select('id,attribute_id');
        $this->db->from('tbld_config');
        $this->db->where('config_code', $config_code);
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    
    public function getSkuElementByCompanyId($company)
    {
        $sql = "SELECT * FROM `tbld_competitor_sku_hierarchy_elements` where company_id=$company and element_category_id=3";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    public function getSkutoSelect($sku, $company_id)
    {
        $sql = "SELECT t1.*, t2.id as sku_id, t2.parent_id, t2.company_id,t2.sku_full_name 
                FROM `tbld_competitor_sku_hierarchy_elements` as t1 
                Inner Join `tbld_competitor_sku` as t2 
                On t1.id=t2.parent_id where t2.company_id=$company_id and t2.parent_id= $sku";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    public function getCompititors(){
        $this->db->select('*');
        $this->db->from('tbld_competitor');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    // tanvir start
    
    public function getDBhouse(){
        $this->db->select('*');
        $this->db->from('tbld_distribution_house');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    public function getSkuElementBydb_houseId($dh_house){
        
        $sql = "SELECT DISTINCT t1.id as sku_id, t1.sku_description as sku_name 
                FROM `tbld_sku` as t1 
                INNER JOIN `tbld_bundle_price_details` as t2 on t1.id = t2.sku_id 
                INNER JOIN `tbli_db_bundle_price_mapping` as t3 on t2.bundle_price_id = t3.bundle_price_id 
                WHERE t3.db_id = $dh_house";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    public function getMustSellDBHWiseSKUPrograms()
    {
        $sql = "SELECT DISTINCT t1.db_id, t2.dbhouse_name  as dbhouse_name, count(t1.sku_id) as sku_count, t1.start_date, t1.end_date   
                FROM `tbli_must_sell_sku` as t1
                INNER JOIN `tbld_distribution_house` as t2 on t1.db_id = t2.id 
                WHERE t1.is_checked = 1
                group by t2.dbhouse_name 
                ";
        
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    public function delete_must_sell_ByDBH($db_id){
        $this->db->where( 'db_id', $db_id );
        $this->db->delete( 'tbli_must_sell_sku' );
    }

    public function getMust_Sell_By_DBH($db_id){
        
        $sql = "SELECT DISTINCT t1.db_id, t2.dbhouse_name as dbhouse_name, t1.sku_id, t3.sku_description as sku_name,t1.is_checked, t1.start_date, t1.end_date
                FROM `tbli_must_sell_sku` as t1 
                LEFT JOIN `tbld_distribution_house` as t2 on t1.db_id = t2.id 
                LEFT JOIN `tbld_sku` as t3 on t1.sku_id = t3.id 
                WHERE t1.db_id = $db_id
                GROUP BY t1.sku_id";
        
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    public function getMust_Sell_By_DBH_View($db_id){
        
        $sql = "SELECT DISTINCT t1.db_id, t2.dbhouse_name as dbhouse_name, t1.sku_id, t3.sku_description as sku_name,t1.is_checked, t1.start_date, t1.end_date
                FROM `tbli_must_sell_sku` as t1 
                LEFT JOIN `tbld_distribution_house` as t2 on t1.db_id = t2.id 
                LEFT JOIN `tbld_sku` as t3 on t1.sku_id = t3.id 
                WHERE t1.db_id = $db_id and t1.is_checked = 1
                GROUP BY t1.sku_id";
        
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    // tanvir end

    public function getMarketTrackingPrograms()
    {
        $sql = "SELECT t1.*, t2.name as company_name 
                FROM `tbli_market_insight_tertiary_tracking_program` as t1 
                Inner Join `tbld_competitor` as t2 
                On t1.company_id=t2.id";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    
    public function insert_tbl($tbl_name, $data) {
        $this->db->insert($tbl_name, $data);
        return $this->db->insert_id();
    }

}