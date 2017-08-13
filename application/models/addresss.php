<?php

class Addresss extends CI_Model {

    public function getAllDivision() {
        $this->db->select('division_id,division_code,division_name');
        $this->db->from('tbld_division');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_address_names($id) {
        $this->db->select('id,address_name,mobile1,division_id,district_id,union_id,village_id');
        $this->db->from('tbld_address');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertIntoAddress($data)
    {
        $this->db->insert('tbld_address', $data);
        return $this->db->insert_id();
    }

    public function get_address_by_id($id)
    {
        $this->db->select('id,address_name');
        $this->db->from('tbld_address');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateAddressById($id,$data)
    {
        $this->db->where('id',$id);
        return $this->db->update('tbld_address',$data);
    }

    public function getAllAddressNames() {
        $this->db->select('id,address_name');
        $this->db->from('tbld_address');
//        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getThanaById($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $querys = $this->db->get('tbld_thana')->result_array();
        return $querys;
    }

    public function insertAddress($id,$data) {
        $this->db->where('id',$id);
        return $this->db->update('tbld_address',$data);
    }

}

?>