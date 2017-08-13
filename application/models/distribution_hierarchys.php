<?php

class Distribution_hierarchys extends CI_Model {

    public function getHierarchyNameById($id) {
        
        $this->db->select('id,dist_role_name');
        $this->db->from('tbld_distribution_hierarchy');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAll_Distribution_hierarchys() {
        
        $this->db->select('id,dist_role_name,dist_role_code,parent_role_id');
        $this->db->from('tbld_distribution_hierarchy');        
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function insertDistribution_Hierarchy($tbl,$data) {
        return $this->db->insert($tbl, $data);
    }
    public function getDistributionHierarchyNames($id) {
        $this->db->select('id,dist_role_name');
        $this->db->where("id", $id);
        $query = $this->db->get('tbld_distribution_hierarchy')->result_array();
        //var_dump($query);
        return $query;
    }
    public function getDistHierarchyIdByCode($code) {
        $this->db->select('id');
        $this->db->where("dist_role_code", $code);
        $query = $this->db->get('tbld_distribution_hierarchy')->result_array();
        return $query;
    }
    
   
}
