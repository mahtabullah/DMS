<?php

class dynamic_filters extends CI_Model
{

    public function getAllBusinessZone ()
    {
        $sql = "SELECT * FROM `tbld_business_zone_hierarchy` order by parent_category_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getAllBizZoneNamesById ( $id )
    {
        $this->db->select( '*' );
        $this->db->where( 'biz_zone_category_id', $id );
//        $this->db->where("biz_zone_category_id", $id);
        $query = $this->db->get( 'tbld_business_zone' )->result_array();
        return $query;
    }
    
   

        public function getAllBusinessZonesChildren ( $id )
    {
        $this->db->select( 'id,biz_zone_name,biz_zone_category_id' );
        $this->db->where( "parent_biz_zone_id", $id );
        $query = $this->db->get( 'tbld_business_zone' )->result_array();
        return $query;
    }

    public function select_db_house_by_biz_zone($id) {
        $this->db->where('biz_zone_id', $id);
        $this->db->select('dbhouse_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_dbhouse_name_by_id($id) {
        $this->db->where('id', $id);
        $this->db->select('id,dbhouse_name');
        $this->db->from('tbld_distribution_house');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDistributionChannelByBizZoneId($id) {
        $this->db->select('id,db_channel_element_name');
        $this->db->where("biz_zone_id", $id);
        $query = $this->db->get('tbld_distribution_channel_elements')->result_array();
        return $query;
    }

}
