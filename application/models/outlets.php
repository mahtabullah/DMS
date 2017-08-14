<?php

class Outlets extends CI_Model {

    function getDbInfoByDbIds($db_ids) {
        $sql = "SELECT id,dbhouse_name as name FROM `tbld_distribution_house` where id in ($db_ids)";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getOutletDbId($db_id) {
        $sql = "SELECT A.id As outlet_id,A.outlet_code,A.outlet_name,B.address_name,A.outlet_owner,B.mobile1,A.visicooler,A.status,C.db_channel_element_name 
                FROM `tbld_outlet` As A 
                left JOIN tbld_address As B On A.outlet_address_id=B.id 
                INNER join tbld_distribution_route As C on A.Parent_id=C.id
                where A.dbhouse_id IN ($db_id)";
        
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

}
