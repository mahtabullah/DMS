<?php

class Distribution_channels  extends CI_Model{
/*
 * Start Distribution Channel Hierarchy/
 */
    public function getAllDistributionChannels() {        
        $sql=" SELECT t1.*,t2.id AS  parent_channel_id,
                (SELECT t3.distribution_channel_name FROM tbld_distribution_channel_hierarchy AS t3 WHERE t2.id = t3.id ) AS parent_channel_name
                FROM tbld_distribution_channel_hierarchy AS t1 LEFT JOIN tbld_distribution_channel_hierarchy AS t2 ON t2.id = t1.parent_channel_id ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function insertDistributionChannelHierarchy($data){
        $this->db->insert('tbld_distribution_channel_hierarchy', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getDistChannelHierarchyIdByCode($code) {
        $this->db->select('id');
        $this->db->from('tbld_distribution_channel_hierarchy');
        $this->db->where("distribution_channel_code", $code);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getDistributionChannelById($id){
        $this->db->select('*');
        $this->db->where("id", $id);
        $query = $this->db->get('tbld_distribution_channel_hierarchy')->result_array();
        return $query;
    }
    public function updateDistributionChannelHierarchyById($data,$id){        
        $this->db->where('id',$id);
        return $this->db->update('tbld_distribution_channel_hierarchy',$data);
    }
    public function deleteDistributionChannelHierarchyById($id){
        $this->db->where('id',$id);
        return $this->db->delete('tbld_distribution_channel_hierarchy');
    }

    
/*
 * End Distribution Channel Hierarchy/    
 */
    
    
    /*
     *  Start data search /
     */
    public function total($search){
       if($search !=''){
            $where = " WHERE db_channel_element_name like '%$search%'";
        }else{
            $where = "";
        } 
        $sql = "select * from tbld_distribution_channel_elements $where";
        
        $query = $this->db->query($sql)->num_rows();
        return $query;
    }
    public function getAllDistributionChannelElements($pagination_per_page, $offset,$search) {
        if($offset ==''){
            $offset = 0;
        }
        if($search !=''){
            $where = " WHERE t1.db_channel_element_name like '%$search%' || t3.dbhouse_name like '%$search%' || concat(t2.db_channel_element_name,' [',t2.db_channel_element_code,'] ') like '%$search%' || t1.db_channel_element_code like '%$search%'";
        }else{
            $where = "";
        } 
        
        $sql = "SELECT t1.*,concat(t2.db_channel_element_name,' [',t2.db_channel_element_code,'] ')  as distribution_channel_name,t3.dbhouse_name
                    FROM tbld_distribution_channel_elements AS t1
                    LEFT JOIN tbld_distribution_channel_elements AS t2 ON t1.db_channel_parent_element_id = t2.id
                    left join tbld_distribution_house as t3 on t1.db_id=t3.id
                    $where
                    LIMIT $offset, $pagination_per_page";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getFilterData($db_ids){

        $sql = "SELECT t1.*,concat(t2.db_channel_element_name,' [',t2.db_channel_element_code,'] ')  as distribution_channel_name,t3.dbhouse_name,CASE t1.db_channel_element_category_id WHEN 1 THEN 'Route' WHEN 2 THEN 'Sub Route' END as element_type
                    FROM tbld_distribution_channel_elements AS t1
                    LEFT JOIN tbld_distribution_channel_elements AS t2 ON t1.db_channel_parent_element_id = t2.id
                    left join tbld_distribution_house as t3 on t1.db_id=t3.id where t3.id in($db_ids) ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    /*
     * end data search/
     */
    
    
    /*
     * Start Business Zone/
     */
    public function getParentId($tbl, $col, $sel_col, $id) {
        $this->db->select($col);
        $this->db->where('id', $id);
        $query = $this->db->get($tbl)->result_array();
        foreach ($query as $q) {
            $this->db->select('id,'.$sel_col);
            $this->db->where('id', $q[$col]);
            $query1 = $this->db->get($tbl)->result_array();
        }
        return $query1;
    }
    public function getChildId($tbl, $col, $col_condition, $id) {
        $this->db->select('id, '. $col);
        $this->db->where($col_condition, $id);
        $query = $this->db->get($tbl)->result_array();
        return $query;
    }
    public function getDbChannelElementNameByCategoryId($id) {
        $this->db->select('id,db_channel_element_name');
        $this->db->where("db_channel_element_category_id", $id);
        $query = $this->db->get('tbld_distribution_channel_elements')->result_array();
        return $query;
    }
    public function getAllNoParentOutlets(){
        $this->db->select('*');
        $this->db->where("parent_id", 0);
        $querys = $this->db->get('tbld_outlet')->result_array();
        return $querys;
    }
    public function getAllBusinessZone() {
        $sql = "select * from tbld_business_zone_hierarchy order by parent_category_id";
        
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
    public function getAllBizZoneNamesById($id) {
        $this->db->select('*');
        $this->db->where('biz_zone_category_id', $id);
        $query = $this->db->get('tbld_business_zone')->result_array();
        return $query;
    }
    public function getAllBusinessZonesChildren($id) {
        $this->db->select('id,biz_zone_name');
        $this->db->where("parent_biz_zone_id", $id);
        $query = $this->db->get('tbld_business_zone')->result_array();
        return $query;
    }
    public function selectDbHouseByBizZone($id){
        $this->db->where('biz_zone_id', $id);
        $this->db->select('dbhouse_id');
        $this->db->from('tbli_distribution_house_biz_zone_mapping');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function selectDbhouseNameById($id){
        $this->db->select('*');
        $this->db->from('tbld_distribution_house');
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getDistributionChannelByBizZoneId($id) {
        $this->db->select('id,db_channel_element_name');
        $this->db->where("biz_zone_id", $id);
        $query = $this->db->get('tbld_distribution_channel_elements')->result_array();
        return $query;
    }
    public function getAllTerritory(){
        $sql = "SELECT id,db_channel_element_name as name FROM `tbld_distribution_channel_elements` where db_channel_element_category_id=1";
        $query = $this->db->query($sql)->result_array();
        return $query;
          
    }
    public function getAllDbHouses(){
        $sql = "SELECT id, dbhouse_name from tbld_distribution_house";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getDistributionChannelElementsById($id){
        $this->db->select('*');
        $this->db->from('tbld_distribution_channel_elements');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function GetBusinessZoneName($id){
        $sql = "SELECT t1.id,t1.biz_zone_name,t2.biz_zone_name as area,t3.biz_zone_name as region FROM `tbld_business_zone` as t1
                inner join
                `tbld_business_zone` as t2
                on t1.parent_biz_zone_id=t2.id
                inner join
                `tbld_business_zone` as t3
                on t2.parent_biz_zone_id=t3.id
                where t1.biz_zone_category_id=5";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /*
     * End Business Zone/
     */

/*
 * Start Distribution Channel Elements/
 */
    public function insertDistributionChannelElements($data) {
        $this->db->insert('tbld_distribution_channel_elements', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function deleteDistributionChannelElementById($id){
        $this->db->where('id', $id);
        $result = $this->db->delete('tbld_distribution_channel_elements'); 
        return $result;
    }
    public function updateDistributionChannelElementsById($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbld_distribution_channel_elements',$data);
    }

/*
 * End Distribution Channel Elements/
 */
    
 /*
  * Audit log user this function/   
  */
   public function getDistributionChannelNameByParentLayerId($parent_layer_id){
       $this->db->select('distribution_channel_name');
       $this->db->where('id',$parent_layer_id);
        $query = $this->db->get('tbld_distribution_channel_hierarchy')->result_array();
        return $query;
       
   }
   
    public function getBusinessZone(){
        $sql = "SELECT id, biz_zone_name FROM `tbld_business_zone` where biz_zone_category_id = 4 ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function getRouteList($db_id){
        $sql = "SELECT * FROM `tbld_distribution_channel_elements` where db_channel_element_category_id=1 and db_id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
}
//<?php
//
//class Distribution_channels extends CI_Model {
//
//    public function getAllDistribution_channel_names($id) {

//        $this->db->select('id,distribution_channel_name');
//        $this->db->from('tbld_distribution_channel_hierarchy');
//        $this->db->where("id", $id);
//        $query = $this->db->get()->result_array();
//        return $query;
//    }
//
//    
//
//    
//   
//    
//    
//    
//    
//   
//
//       
//    
//   
//    
//    public function get_distribution_channel_elements_by_search($search){
//        $sql = "SELECT * FROM tbld_distribution_channel_elements WHERE db_channel_element_name like '%$search%'";
//        $query = $this->db->query($sql)->result_array();
//        return $query;
//    }
//
//   
//
//    public function getDistChannelElementIdByCode($code) {
//        $this->db->select('id');
//        $this->db->from('tbld_distribution_channel_elements');
//        $this->db->where("db_channel_element_code", $code);
//        $query = $this->db->get()->result_array();
//        return $query;
//    }
//
//    
//
//    public function getDbchannelElementNameById($id) {
//        $this->db->select('id,db_channel_element_name');
//        $this->db->from('tbld_distribution_channel_elements');
//        $this->db->where("id", $id);
//        $query = $this->db->get()->result_array();
//        return $query;
//    }
//
//  
//   
//    
//    public function getDistributionChannelByBizZoneArr($id_arr) {
//        $ids = implode(',',$id_arr);
//        $this->db->select('id,db_channel_element_name');
//        $this->db->where("biz_zone_id in (". $ids.")");
//        $query = $this->db->get('tbld_distribution_channel_elements')->result_array();
//        return $query;
//    }
//
////    public function getDbchannelElementNameByDbhouseId($db_id) {
////        $mkt_ids = array();
////        for ($i = 0; $i < count($db_id); $i++) {
////            $this->db->select('parent_id');
////            $this->db->where("dbhouse_id", $db_id[$i]);
////            $query = $this->db->get('tbld_outlet')->result_array();
////            foreach ($query as $q) {
////                $this->db->select('id, db_channel_element_name');
////                $this->db->where("id", $q['parent_id']);
////                $query1 = $this->db->get('tbld_distribution_channel_elements')->result_array();
////                foreach ($query1 as $q1) {
////                    $mkt = $q1['id'];
////                    $mkt_name = $q1['db_channel_element_name'];
////                    if (!in_array($mkt, $mkt_ids)) {
////                        $mkt_ids[] = $mkt;
////                        $mkts['id'][] = $mkt;
////                        $mkts['mkt_name'][] = $mkt_name;
////                    }
////                }
////            }
////        }
////        return $mkts;
////    }
//
//    public function getDbchannelElementNameByDbhouseId($db_id) {
//        foreach ($db_id as $db) {
//            $this->db->select('biz_zone_id');
//            $this->db->where("dbhouse_id", $db);
//            $query = $this->db->get('tbli_distribution_house_biz_zone_mapping')->result_array();
//            foreach ($query as $q) {
//                $biz_zone = $q['biz_zone_id'];
//                $this->db->select('id, db_channel_element_name');
//                $this->db->where("biz_zone_id", $biz_zone);
//                $query1[] = $this->db->get('tbld_distribution_channel_elements')->result_array();
//            }
//        }
//        return $query1;
//    }
//
//}
