<?php

class Sales_employees extends CI_Model
{

    public function getAllSalesEmp ()
    {
        $this->db->select( '*' );
        $this->db->order_by( "id", "desc" );
        return $this->db->get( 'tbld_sales_employee' )->result_array();
    }

    public function getUnUsedUserList()
    {
        $sql = "SELECT t1.id,t1.user_name FROM `tbld_user` as t1
                left join `tbld_distribution_employee` as t2 on t1.id=t2.login_user_id
                left join `tbld_sales_employee` as t3 on t1.id=t3.login_user_id
                where t2.id is null and t3.id is null";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }



    public function Save_edited_info($data, $id){
        $this->db->where('id', $id);
        $this->db->update('tbld_sales_employee', $data);
    }

    
    public function getManagers($sales_role_id)
    {
        $sql = "SELECT t2.id,t2.first_name as name FROM `tbld_sales_hierarchy` as t1
                inner join `tbld_sales_employee` as t2 on t1.parent_role_id=t2.sales_role_id
                where t1.id=$sales_role_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
        public function getHierarchyNameById ( $id )
    {
        $this->db->select( 'sales_role_name' );
        $this->db->where( 'id', $id );
        return $this->db->get( 'tbld_sales_hierarchy' )->result_array();
    }

    public function getSalesEmpIdByCode ( $code )
    {
        $this->db->select( 'id' );
        $this->db->where( 'sales_emp_code', $code );
        return $this->db->get( 'tbld_sales_employee' )->result_array();
    }

    public function getSalesEmpIdByUserId ( $login )
    {
        $this->db->select( 'id' );
        $this->db->where( 'login_user_id', $login );
        return $this->db->get( 'tbld_sales_employee' )->result_array();
    }

    public function get_tbld_sales_employee_by_id ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_sales_employee' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSalesEmpNameById ( $id )
    {
        $this->db->select( '*' );
        $this->db->where( 'id', $id );
        return $this->db->get( 'tbld_sales_employee' )->result_array();
    }

    public function getSalesEmpByRole ( $id )
    {
        $this->db->select( 'id,first_name' );
        $this->db->where( 'sales_role_id', $id );
        return $this->db->get( 'tbld_sales_employee' )->result_array();
    }

    public function insert_sales_employee ( $data )
    {
        return $this->db->insert( 'tbld_sales_employee', $data );
    }

    public function delete_tbld_sales_employee_by_id ( $id )
    {
        $this->db->where( 'id', $id );
        $result = $this->db->delete( 'tbld_sales_employee' );
        return $result;
    }

    public function getAll_Sales_hierarchys() {
        $this->db->select('*');
        return $this->db->get('tbld_sales_hierarchy')->result_array();
    }

    public function getAllUser() {
        $this->db->select('id,user_name');
        $this->db->from('tbld_user');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_address_by_id($id)
    {
        $this->db->select('id,address_name');
        $this->db->from('tbld_address');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllAddressNames() {
        $this->db->select('id,address_name');
        $this->db->from('tbld_address');
        //->db->where("id", $id);
        //$sql = "select id,address_name form tbld_address ";
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_address_names($id) {
        $this->db->select('id,address_name,mobile1');
        $this->db->from('tbld_address');
        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getUserIdById($id) {
        $this->db->select('user_name');
        $this->db->where('id', $id);
        return $this->db->get('tbld_user')->result_array();
    }

    public function getDistEmpNameById ( $id )
    {
        $sql = "SELECT t1.*,t2.territory_id,t3.db_channel_element_name as territory FROM `tbld_distribution_employee` as t1
                left join
                `tbld_tso_territory_mapping` as t2
                on t1.id=t2.tso_id
                left join
                `tbld_distribution_channel_elements` as t3
                on t2.territory_id=t3.id where t1.id=$id";
        //return $sql;
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function insert_into_address($data)
    {
        $this->db->insert('tbld_address', $data);
        return $this->db->insert_id();
    }

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


    public function getGeoLayer()
    {
        $sql = "SELECT id,biz_zone_category_name as name FROM `tbld_business_zone_hierarchy` order by id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getGeoLayerElement($id)
    {
        $sql = "SELECT id,biz_zone_name as name FROM `tbld_business_zone` where biz_zone_category_id=$id order by id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getBizZoneElement($id)
    {
        $sql = "select id,biz_zone_name as name from `tbld_business_zone` where biz_zone_category_id in(SELECT biz_zone_category_id FROM `tbld_business_zone` where id=$id)";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getBizZone($biz_zone_id)
    {
        $sql = "SELECT id,biz_zone_category_name as name FROM `tbld_business_zone_hierarchy` where id in(SELECT biz_zone_category_id FROM `tbld_business_zone` where id=$biz_zone_id)";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }



}
