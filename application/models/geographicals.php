<?php

class Geographicals extends CI_Model
{


    /*
     * start geographical hierarchy/
     */
    public function getAllBusinessZone ()
    {
        $sql = " SELECT t1.* ,t2.id as parent_category_id,
                    (select t3.biz_zone_category_name from tbld_business_zone_hierarchy as t3 where t2.id = t3.id ) as parent_category_name
                    from tbld_business_zone_hierarchy as t1 left join tbld_business_zone_hierarchy as t2 on  t2.id = t1.parent_category_id ";

        $result = $this->db->query( $sql )->result_array();
        return $result;
    }

    public function insertBizZoneInfo($data)
    {

        return $this->db->insert( 'tbld_business_zone_hierarchy', $data );
    }

    public function getBusinessZoneLayerIdByCode ( $code )
    {
        $this->db->select( 'id' );
        $this->db->where( "biz_zone_category_code", $code );
        $query = $this->db->get( 'tbld_business_zone_hierarchy' )->result_array();
        return $query;
    }

    public function geoGraphicalHierarchyEditById ( $id )
    {
        $this->db->select( '*' );
        $this->db->where( "id", $id );
        $query = $this->db->get( 'tbld_business_zone_hierarchy' )->result_array();
        return $query;
    }

    public function geoGraphicalHierarchyUpdateById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_business_zone_hierarchy', $data );
    }

    public function geoGraphicalHierarchyDeleteById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_business_zone_hierarchy' );
    }
    public function countTableRow(){
        $this->db->from('tbld_business_zone_hierarchy');
        return $this->db->count_all_results();
    }


    /*
     * end geographical hierarchy/
     */

    public function getAllBizZoneNames ()
    {
        $sql = " SELECT t1.id,t1.biz_zone_name AS ZONE_NAME,t1.biz_zone_code,t1.biz_zone_category_id,t1.parent_biz_zone_id,t2.biz_zone_category_name,t3.biz_zone_name FROM `tbld_business_zone` as t1
                    LEFT join tbld_business_zone_hierarchy as t2
                    on t1.biz_zone_category_id=t2.id
                    left join tbld_business_zone as t3
                    on t3.id= t1.parent_biz_zone_id ";

        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getAllBizZoneNamesById ( $id )
    {
        $this->db->select( '*' );
        $this->db->where( 'biz_zone_category_id', $id );
        $query = $this->db->get( 'tbld_business_zone' )->result_array();
        return $query;
    }

    public function getGeoGraphicalMasterDataById ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_business_zone' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateGetGeoGraphicalMasterDataById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_business_zone', $data );
    }

    public function deleteGetGeoGraphicalMasterDataById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_business_zone' );
    }

    public function insertGetGeoGraphicalMasterData ( $data )
    {

        return $this->db->insert( 'tbld_business_zone', $data );
    }


}
