<?php

class Hierarchys extends CI_Model {

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
    
    public function getIdByCategoryId($tbl, $col, $col_condition, $id) {
        $this->db->select('id, '. $col);
        $this->db->where($col_condition, $id);
        $query = $this->db->get($tbl)->result_array();
        return $query;
    }
}
