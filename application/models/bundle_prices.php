<?php

    class bundle_prices extends CI_Model
    {
        public function get_all_sku()
        {
            $sql = "SELECT id,sku_name,sku_code,sku_description FROM tbld_sku order by parent_id,id";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }

        public function get_mou_qty($sku_id){
            $sql = "SELECT sku_id,mou_id,quantity FROM tbli_sku_mou_price_mapping WHERE sku_id = $sku_id;";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }
        public function get_max_qty($sku_id){
            $sql = "SELECT max(quantity) as max_qty FROM tbli_sku_mou_price_mapping WHERE sku_id = $sku_id;";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }
        public function insert($table,$data)
        {
            $query= $this->db->insert( $table, $data );
            return $this->db->insert_id();
        }
        public function get_all_bundle()
        {
            $sql = "Select distinct t1.id,t1.*, count(*) as number_of_sku 
                    from `tbld_bundle_price` as t1 
                    Inner Join `tbld_bundle_price_details` as t2 
                    on t1.id=t2.bundle_price_id 
                    where t2.quantity != 1 group by t1.id";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }

        public function getAllBundleSkubyDB($db_id,$where='')
        {
            $sql = "SELECT t1.*,t2.*,t3.sku_code,t3.sku_description,t3.sku_description as sku_name, t9.sku_type_name, t3.sku_weight_id,
                    t3.sku_volume, t3.sku_launch_date,
                    GROUP_CONCAT(distinct t5.unit_name SEPARATOR '<br /><br />') AS unit, t8.sku_active_status_name,
                    GROUP_CONCAT(ROUND(t2.db_lifting_price,2) SEPARATOR '<br /><br />') as db_lifting_price,
                    GROUP_CONCAT(ROUND(t2.outlet_lifting_price,2) SEPARATOR '<br /><br />') AS outlet_lifting_price,
                    GROUP_CONCAT(ROUND(t2.mrp,2) SEPARATOR '<br /><br /> ') AS mrp_lifting_price,
                    t6.element_name, t6.element_name as product
                    FROM `tbli_db_bundle_price_mapping` as t1 
                    Inner Join `tbld_bundle_price_details` as t2 On t1.bundle_price_id=t2.bundle_price_id 
                    Inner Join `tbld_sku` as t3 on t2.sku_id=t3.id 
                    INNER JOIN tbld_unit AS t5 ON t5.id= t2.mou_id
                    INNER JOIN tbld_sku_hierarchy_elements AS t6 ON t3.parent_id = t6.id
                    left join tbld_sku_hierarchy_elements as t7 On t7.id = t6.parent_element_id
                    INNER JOIN tbld_sku_active_status AS t8 ON t3.sku_active_status_id = t8.id
                    INNER JOIN tbld_sku_type AS t9 ON t3.sku_type_id = t9.id
                    where t1.db_id=$db_id $where group by t2.sku_id ";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }



        public function getAllBundleSkubyDBIds($db_id,$where='')
        {
            $sql = "SELECT t1.*,t3.sku_code,t3.sku_description,t3.sku_description as sku_name,t3.sku_lpc, t9.sku_type_name, t3.sku_weight_id,
                     t3.sku_launch_date,
                    GROUP_CONCAT(distinct t5.unit_name SEPARATOR '<br /><br />') AS unit, t8.sku_active_status_name,
                    GROUP_CONCAT(ROUND(t2.db_lifting_price,2) SEPARATOR '<br /><br />') as db_lifting_price,
                    GROUP_CONCAT(ROUND(t2.outlet_lifting_price,2) SEPARATOR '<br /><br />') AS outlet_lifting_price,
                    GROUP_CONCAT(ROUND(t2.mrp,2) SEPARATOR '<br /><br /> ') AS mrp_lifting_price,
                    GROUP_CONCAT(ROUND(t3.sku_volume*t2.quantity,2) SEPARATOR '<br /><br /> ') AS sku_volume,
                    t6.element_name, t6.element_name as product
                    FROM `tbli_db_bundle_price_mapping` as t1
                    Inner Join `tbld_bundle_price_details` as t2 On t1.bundle_price_id=t2.bundle_price_id
                    Inner Join `tbld_sku` as t3 on t2.sku_id=t3.id
                    INNER JOIN tbld_unit AS t5 ON t5.id= t2.mou_id
                    INNER JOIN tbld_sku_hierarchy_elements AS t6 ON t3.parent_id = t6.id
                    left join tbld_sku_hierarchy_elements as t7 On t7.id = t6.parent_element_id
                    INNER JOIN tbld_sku_active_status AS t8 ON t3.sku_active_status_id = t8.id
                    INNER JOIN tbld_sku_type AS t9 ON t3.sku_type_id = t9.id
                    where t1.db_id=$db_id and t2.quantity !=1 $where group by t2.sku_id ";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }



        public function getBundleDetailbySku($sku_id, $db_id)
        {
            $sql = "SELECT t1.*,t2.id,t2.bundle_price_id,t2.sku_id,t4.sku_code,t2.mou_id,t2.quantity,
                    FORMAT(MIN(t2.outlet_lifting_price), 4)  as unit_price, t3.unit_name ,t5.qty
                    FROM `tbli_db_bundle_price_mapping` as t1 
                    Inner Join `tbld_bundle_price_details` as t2 
                    On t2.bundle_price_id=t1.bundle_price_id
                    Inner Join tbld_unit as t3 on t2.mou_id=t3.id
                    Inner Join tbld_sku as t4 on t2.sku_id=t4.id
                    inner join tbld_unit as t5 on t5.id=t4.db_default_mou_id
                    Where t2.sku_id=$sku_id and t1.db_id=$db_id";
            
            $query = $this->db->query($sql)->result_array();
            return $query;
        }
        public function getBundleDetailbySkuforStock($sku_id, $db_id)
        {
            $sql = "SELECT t1.*,t2.id,t2.bundle_price_id,t2.sku_id,t4.sku_code,t2.mou_id,t2.quantity,
                    FORMAT(MIN(t2.db_lifting_price), 4)  as unit_price, t3.unit_name ,t5.qty
                    FROM `tbli_db_bundle_price_mapping` as t1 
                    Inner Join `tbld_bundle_price_details` as t2 
                    On t2.bundle_price_id=t1.bundle_price_id
                    Inner Join tbld_unit as t3 on t2.mou_id=t3.id
                    Inner Join tbld_sku as t4 on t2.sku_id=t4.id
                    inner join tbld_unit as t5 on t5.id=t4.db_default_mou_id
                    Where t2.sku_id=$sku_id and t1.db_id=$db_id";
            
            $query = $this->db->query($sql)->result_array();
            return $query;
        }
        
        public function get_all_bundle_details($id)
        {
            $sql = "SELECT t1.*,t2.sku_code,t2.sku_name,t2.sku_description,t3.name,t3.code
                    FROM tbld_bundle_price_details as t1 LEFT JOIN tbld_sku as t2
                    on t1.sku_id = t2.id LEFT JOIN tbld_bundle_price as t3 on t1.bundle_price_id = t3.id
                    WHERE t1.bundle_price_id = $id and t1.quantity = 1 and (t1.end_date>=curdate() or t1.end_date='1970-01-01') group by t1.sku_id,t1.start_date ";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }
        public function getBundlePriceItem($id)
        {
            $sql = "SELECT t1.*,t2.sku_code,t2.sku_name,t2.sku_description,t3.name,t3.code
                     
                    FROM tbld_bundle_price_details as t1 LEFT JOIN tbld_sku as t2
                    on t1.sku_id = t2.id LEFT JOIN tbld_bundle_price as t3 on t1.bundle_price_id = t3.id
                    WHERE t1.id = $id";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }

        public function delete($id){
            $this->db->where( 'id', $id );
            $this->db->delete( 'tbld_bundle_price' );
        }
        public function delete_details($id){
            $this->db->where( 'bundle_price_id', $id );
            $this->db->delete( 'tbld_bundle_price_details' );
        }
        public function delete_bundle_price_item($id,$bundle_id){
            $this->db->where( 'id', $id );
            $this->db->where( 'bundle_price_id', $bundle_id );
            $this->db->delete( 'tbld_bundle_price_details' );
        }
        
        
        public function getNewSkuList($bundle_price_id){
            $sql = "select id,sku_name,sku_code,sku_description FROM `tbld_sku` where id not in(SELECT sku_id FROM `tbld_bundle_price_details` as t1
                    where t1.bundle_price_id=$bundle_price_id
                    group by t1.sku_id)";
            $query = $this->db->query($sql)->result_array();
            return $query;
        }
    }