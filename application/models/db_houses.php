<?php

class DB_houses extends CI_Model
{
    public function insert ( $table,$data )
    {
        return $this->db->insert( $table, $data );
    }
    public function insertWithLastInsertId ( $table,$data )
    {
        $this->db->insert( $table, $data );
        return $this->db->insert_id();
    }

    public function insertDbHouseBizZoneMapping ( $data )
    {
        return $this->db->insert( 'tbli_distribution_house_biz_zone_mapping', $data );
    }

    public function insertPurchaseOrderSequence ( $db_house_id )
    {
        $sql = "INSERT INTO `purchase_order_sequence`(`db_house_id`, `serial`) VALUES ('$db_house_id','0')";
        mysql_query( $sql );
    }
    public function Day_end($previousDate,$newDate,$db_house_id )
    {
        echo $sql = 'update tbld_distribution_house set System_date="'.$newDate.'",Previous_System_date="'.$previousDate.'" where id='.$db_house_id;
        mysql_query( $sql );
        return true;
    }
    
    
    public function getDistributionHouseProfileInfo ($db_id) {
        $query = mysql_query("SELECT t1.*, t2.address_name, t5.street1 as db_road, 
                            t5.street2 as db_village, t3.name as cluster_name, 
                            t4.distributor_name, t5.address_name as distributor_address,
                            t5.street1 as owner_road, t5.street2 as owner_village, 
                            t6.name as owner_division, t7.name as owner_district,
                            t8.name as owner_thana, t9.name as db_division, 
                            t10.name as db_district, t11.name as db_thana, t12.name as db_union, 
                            t5.mobile1 as owner_mobile, t5.mobile2 as owner_telephone,
                            t13.id, t13.dbhouse_id, t13.biz_zone_id, t14.biz_zone_name as ce_area, 
                            t15.biz_zone_name as territory, t16.biz_zone_name as business_unit
                            FROM `tbld_distribution_house` as t1 
                            left Join `tbld_address` as t2 On t1.dbhouse_address_id=t2.id 
                            left Join `tbld_cluster` as t3 On t1.cluster_id = t3.id
                            left Join `tbld_distributor` as t4 On t1.distributor_id=t4.id
                            left Join `tbld_address` as t5 On t4.distributor_address_id=t5.id
                            left Join `tbld_geo` as t6 On t5.division_id=t6.id
                            left Join `tbld_geo` as t7 On t5.district_id=t7.id
                            left Join `tbld_geo` as t8 On t5.thana_id=t8.id
                            left Join `tbld_geo` as t9 On t2.division_id=t9.id
                            left Join `tbld_geo` as t10 On t2.district_id=t10.id
                            left Join `tbld_geo` as t11 On t2.thana_id=t11.id
                            left Join `tbld_geo` as t12 On t2.union_id=t12.id
                            left Join `tbli_distribution_house_biz_zone_mapping` as t13 On t1.id=t13.dbhouse_id 
                            left Join `tbld_business_zone` as t14 On t13.biz_zone_id=t14.id
                            left Join `tbld_business_zone` as t15 On t15.id=t14.parent_biz_zone_id
                            left Join `tbld_business_zone` as t16 On t16.id=t15.parent_biz_zone_id
                            where t1.id=$db_id");
        $result = mysql_fetch_array($query);
        return $result;
    }
    
    public function getAllBusinessZonesName ($id)
    {
        $this->db->select('id,biz_zone_name');
        $this->db->where("parent_biz_zone_id", $id);
        $this->db->where("biz_zone_category_id", 3);
        $query = $this->db->get('tbld_business_zone')->result_array();

        return $query;
    }
    
    public function getAllTerritoryID ($id)
    {
        $this->db->select('id,biz_zone_name');
        $this->db->where("parent_biz_zone_id", $id);
        $query = $this->db->get('tbld_business_zone')->result_array();

        return $query;
    }

    public function insertTbliDbhouseCreditMapping ( $db_house_id )
    {
        $sql = "INSERT INTO `tbli_dbhouse_credit_mapping`(`dbhouse_id`,`credit_amount`) VALUES ('$db_house_id','0')";
        $query = mysql_query( $sql );
        return $query;
    }

    public function updateDistributionHouseById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_distribution_house', $data );
    }

    public function updateDemarkationById ( $id, $data )
    {
        $this->db->where( 'db_id', $id );
        return $this->db->update( 'tbli_db_demarcation', $data );
    }

    public function updateDbHouseBizZoneMapping ( $id, $data )
    {
        $this->db->where( 'dbhouse_id', $id );
        return $this->db->update( 'tbli_distribution_house_biz_zone_mapping', $data );
    }

    public function updateTbliUserRoleMappingByUserId ( $id, $status )
    {
        $sql = "UPDATE `tbli_user_role_mapping` SET `user_role_status`='$status' WHERE user_id IN(SELECT `login_user_id` FROM `tbld_distribution_employee` WHERE `distribution_house_id`='$id')";
        $result = mysql_query( $sql );
        return $result;
    }

    public function delete_tbli_dbhouse_product_line_mapping_by_id ( $id, $data )
    {
        $product_line_id = $data[ 'product_line_id' ];
        $sql = "DELETE FROM `tbli_dbhouse_product_line_mapping` WHERE `dbhouse_id`='$id' AND `product_line_id` NOT IN (" . implode( ',', $product_line_id ) . ")";

        $query = mysql_query( $sql );

    }

    public function update_tbli_dbhouse_product_line_mapping_by_id ( $id, $data )
    {
        $product_line_id = $data[ 'product_line_id' ];
        $erp_dbcode = $data[ 'erp_dbcode' ];

        for ( $i = 0; $i < count( $product_line_id ); $i++ ) {
            $sql = "SELECT * FROM tbli_dbhouse_product_line_mapping WHERE `dbhouse_id`='$id' AND `product_line_id` ='$product_line_id[$i]'";
            mysql_query( $sql );
            $rc = mysql_affected_rows();
            if ( $rc ) {
                $sql1 = "UPDATE tbli_dbhouse_product_line_mapping SET `erp_dbcode`='$erp_dbcode[$i]' WHERE `dbhouse_id`='$id' AND `product_line_id` ='$product_line_id[$i]'";
                $query1 = mysql_query( $sql1 );
            } else {
                $sql1 = "INSERT INTO tbli_dbhouse_product_line_mapping(dbhouse_id,product_line_id,erp_dbcode) VALUES ('$id','$product_line_id[$i]','$erp_dbcode[$i]')";
                $query1 = mysql_query( $sql1 );
            }

        }
    }

    public function get_address_by_id ( $id )
    {
        $this->db->select( 'address_name' );
        $this->db->from( 'tbld_address' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_damage_return_view ()
    {
        $this->db->select( '*' );
        $this->db->order_by( "id", "desc" );
        $this->db->from( 'tbld_damage_inventory' );

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_sales_return_view ()
    {
        $this->db->select( '*' );
        $this->db->order_by( "id", "desc" );
        $this->db->from( 'tbld_return_inventory' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_all_db_id ()
    {
        $this->db->select( 'id' );
        $this->db->from( 'tbld_distribution_house' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_owner_id ( $id )
    {
        $this->db->select( 'distributor_name' );
        $this->db->from( 'tbld_distributor' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_bank_by_id ( $id )
    {
        $this->db->select( 'name' );
        $this->db->from( 'tbld_account' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBHouseID ( $code )
    {
        $this->db->select( 'id' );
        $this->db->from( 'tbld_distribution_house' );
        $this->db->where( 'dbhouse_code', $code );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getBankInfobyDbId($db_id)
    {
        $sql = "SELECT * FROM `tbld_account` where db_id=$db_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function get_assets_by_id($db_id)
    {
        $sql = "SELECT * FROM `tblt_db_asset_mapping` where db_id=$db_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function get_vehicles_by_id($db_id)
    {
        $sql = "SELECT * FROM `tblt_db_vehicle_mapping` where db_id=$db_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getDBHouseByDistEmpID ( $id )
    {
        $sql = "SELECT `distribution_house_id` FROM `tbld_distribution_employee` where id=$id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getDBhouseInfoByID ( $id )
    {
        /*$sql = "SELECT t1.*,t2.db_id,t2.east,t2.west,t2.north,t2.south,t3.address_name,t3.village_id,t3.union_id,t3.thana_id,t3.district_id,t3.division_id,t3.mobile1 FROM tbld_distribution_house AS t1
                    LEFT JOIN tbli_db_demarcation AS t2 ON  t1.id=t2.db_id
                    INNER JOIN tbld_address AS t3 ON t1.dbhouse_address_id = t3.id WHERE t1.id=$id; "; */

        /*  $sql=" select t1.id,t1.dbhouse_name,t1.dbhouse_code,t1.dbhouse_description ,t1.db_point,t1.db_credit_limit,t1.email,t1.vat_no,t1.tin_no,t2.db_house_status_name,t3.name,t4.distributor_name,t5.address_name,t6.name,t6.account_no,t7.north,t7.south,t7.east,t7.west from tbld_distribution_house as t1
                      left join  tbld_distribution_house_status  as t2
                      on t2.id = t1.db_house_status
                      left join tbld_db_type as t3
                      on t1.type = t3.id
                      LEFT JOIN tbld_distributor AS t4
                      ON t1.distributor_id = t4.id
                      left join tbld_address as t5
                      on t1.dbhouse_address_id = t5.id
                      left join tbld_account as t6
                      on t1.bank_account_id = t6.id
                      left join tbli_db_demarcation as t7
                      on t1.id = t7.db_id
                      WHERE t1.id= $id ";
          <<--raju -->>
          */
        $sql = "SELECT t1.*,t2.db_id,t2.east,t2.west,t2.north,t3.street1, t3.street2, t2.south,t3.address_name,t3.village_id,t3.union_id,t3.thana_id,
                t3.district_id,t3.division_id,t3.mobile1,t4.name,t4.account_no, t7.biz_zone_id,t8.name as district_name,t9.name as
                thana_name,t10.name as union_name,t11.name as village_name,t1.category,
                t12.bundle_price_id,t13.distributor_name,t13.distributor_address_id,t14.address_name as distributor_address,
                t14.street2 as distributor_village,t14.division_id as distributor_division_id,
                t14.district_id as distributor_district_id,t14.thana_id as distributor_thana_id,
                t14.union_id as distributor_union_id,
                t14.mobile1 as distributor_mobile_number, t14.mobile2 as telephone_number
                FROM tbld_distribution_house AS t1
                LEFT JOIN tbli_db_demarcation AS t2 ON  t1.id=t2.db_id
                LEFT JOIN tbld_account  AS t4 ON t1.bank_account_id = t4.id
                INNER JOIN tbld_address AS t3 ON t1.dbhouse_address_id = t3.id
                left join tbli_distribution_house_biz_zone_mapping as t7
                on t1.id = t7.dbhouse_id
                left join tbld_geo as t8
                on t3.district_id = t8.id
                left join tbld_geo as t9
                on t3.thana_id = t9.id
                left join tbld_geo as t10
                on t3.union_id = t10.id
                left join tbld_geo as t11
                on t3.village_id = t11.id
                left join `tbli_db_bundle_price_mapping` as t12 On t1.id=t12.db_id
                left join `tbld_distributor` as t13 On t1.distributor_id=t13.id
                left join `tbld_address` as t14 On t13.distributor_address_id=t14.id
                WHERE t1.id=$id";

        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getDBHouseNames ( $code )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_distribution_house' );
        $this->db->where( 'dbhouse_code', $code );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllDbHouses ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_distribution_house' );
        $query = $this->db->get()->result_array();
        return $query;
    }

/////////////////////////////////////////////////////////
    /////////////// //////////// ////////////////// /////


    public function getAllDbhCategory ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_distribution_category' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDbhCategoryByID ($id)
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_distribution_category' );
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertDbhCategory($tbl_name, $data)
    {
        $this->db->insert($tbl_name, $data);

        return $this->db->insert_id();
    }

    public function deleteDbhCategory($tbl,$id)
    {
        $this->db->where('id', $id);
        $this->db->delete($tbl);
    }

    public function deleteDBType($tbl,$id)
    {
        $this->db->where('spoke_id', $id);
        $this->db->delete($tbl);
    }

    public function updateDbhCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbld_distribution_category', $data);
    }

    public function deleteAssetVehicle($tbl, $db_id)
    {
        $this->db->where('db_id', $db_id);
        $this->db->delete($tbl);
    }

    public function deleteBankInfo($tbl, $db_id)
    {
        $this->db->where('db_id', $db_id);
        $this->db->delete($tbl);
    }

    public function updateTable($tbl, $id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($tbl, $data);
    }
    public function update_tbli_db_bundle_price_mapping($tbl, $id, $data)
    {
        $this->db->where('db_id', $id);
        $this->db->update($tbl, $data);
    }
    
    public function updateHubMappingTable($tbl, $id, $data)
    {
        $this->db->where('spoke_id', $id);
        $this->db->update($tbl, $data);
    }
    
    public function updateZoneTable($tbl, $id, $data)
    {
        $this->db->where('dbhouse_id', $id);
        $this->db->update($tbl, $data);
    }

/////////////////////////////////////////////////////////
    /////////////// //////////// ////////////////// /////
    public function allOutletCategoryType ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_outlet_category' );

        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete_tbli_dbhouse_sku_mapping_by_sku_id ( $id )
    {
        $this->db->where( 'sku_id', $id );
        $this->db->delete( 'tbli_dbhouse_sku_mapping' );
        return $query;
    }

    public function delete_tbli_sr_sku_mapping_by_sku_id ( $id )
    {
        $this->db->where( 'sku_id', $id );
        $this->db->delete( 'tbli_sr_sku_mapping' );
        return $query;
    }

    public function insert_db_house_product_line_mapping ( $data )
    {

        $dbhouse_id = $data[ 'dbhouse_id' ];
        $product_line_id = $data[ 'product_line_id' ];
        $erp_code = $data[ 'erp_code' ];


        for ( $i = 0; $i < count( $product_line_id ); $i++ ) {
            $sql = "INSERT INTO tbli_dbhouse_product_line_mapping(dbhouse_id,product_line_id,erp_dbcode) VALUES ('$dbhouse_id','$product_line_id[$i]','$erp_code[$i]')";
            $query = mysql_query( $sql );
        }
    }

    public function insertDbHouse ( $data )
    {
        $this->db->insert( 'tbld_distribution_house', $data );

        return $this->db->insert_id();
    }
    public function insertDbHouseZone( $dbzonedata )
    {
        $this->db->insert( 'tbli_distribution_house_biz_zone_mapping', $dbzonedata );

        return $this->db->insert_id();
    }

    public function selectDbHouse ()
    {

//        $sql = "SELECT t1.id,t5.biz_zone_name as region,t4.biz_zone_name area, t3.biz_zone_name as point,
//                t1.dbhouse_name,t1.distributor_id,t1.db_credit_limit,t1.dbhouse_code,t2.biz_zone_id,
//                t1.create_date,t6.db_house_status_name,
//                t7.distributor_name, t8.address_name, t8.mobile1 FROM `tbld_distribution_house` as t1
//                inner join `tbli_distribution_house_biz_zone_mapping` as t2
//                on t1.id=t2.dbhouse_id
//                inner join `tbld_business_zone` as t3
//                on t2.biz_zone_id=t3.id
//                inner join `tbld_business_zone` as t4
//                on t3.parent_biz_zone_id=t4.id
//                inner join `tbld_business_zone` as t5
//                on t4.parent_biz_zone_id=t5.id
//                left join tbld_distribution_house_status as t6
//                on t1.db_house_status = t6.id
//                left join tbld_distributor as t7
//                on t1.distributor_id = t7.id
//                inner join `tbld_address` as t8
//                on t2.biz_zone_id=t8.id
//                ";
        
        $sql="Select t1.id, t1.create_date, t4.db_house_status_name, t1.dbhouse_name, 
                t1.dbhouse_code, t2.distributor_name, t3.address_name, t3.mobile1 
                FROM tbld_distribution_house as t1 
                JOIN tbld_distributor as t2 ON t1.distributor_id=t2.id 
                JOIN tbld_address as t3 ON t1.dbhouse_address_id=t3.id
                JOIN tbld_distribution_house_status as t4 ON t1.db_house_status=t4.id";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    
    public function getAllFixedDisplay(){
        $this->db->select( '*' );
        $this->db->from( 'tbld_fixed_display' );
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function getAllFixedDisplayClass(){
        $this->db->select( '*' );
        $this->db->from( 'tbld_fixed_display_class' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_house_by_db_id ( $db_id )
    {
        $this->db->select( '*' );
        $this->db->order_by( "id", "desc" );
        $this->db->from( 'tbld_distribution_house' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_db_house_tso ( $db_id )
    {
        $this->db->select( 'id,dbhouse_name,dbhouse_code,distributor_id,db_house_status,db_credit_limit' );
        $this->db->from( 'tbld_distribution_house' );
        $this->db->where( 'id', $db_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_productline_names ( $id )
    {


        $this->db->select( 'id,name' );
        $this->db->from( 'tbld_product_line' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;

    }

    public function get_dbhouse_pl_by_id ( $id )
    {
        $this->db->select( '*' );
        $this->db->order_by( "product_line_id", "ASC" );
        $this->db->from( 'tbli_dbhouse_product_line_mapping' );
        $this->db->where( 'dbhouse_id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function Get_Dbhouse_productline_names ( $id )
    {


        $this->db->select( 'id,product_line_id' );
        $this->db->from( 'tbli_dbhouse_product_line_mapping' );
        $this->db->where( 'dbhouse_id', $id );
        $query = $this->db->get()->result_array();
        return $query;

    }

//    public function select_business_zone_name_config($config_code) {
//        $this->db->select('id,attribute_id');
//        $this->db->from('tbld_config');
//        $this->db->where('config_code', $config_code);
//        $query = $this->db->get()->result_array();
//        return $query;
//    }

    public function GetBusinessZoneName ( $id )
    {
        $sql = "SELECT t1.id,t1.biz_zone_name,t2.biz_zone_name as area,t3.biz_zone_name as region FROM `tbld_business_zone` as t1
                inner join
                `tbld_business_zone` as t2
                on t1.parent_biz_zone_id=t2.id
                inner join
                `tbld_business_zone` as t3
                on t2.parent_biz_zone_id=t3.id
                where t1.biz_zone_category_id=$id";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    /*
     * Shuaib Vi
     *
     */

    public function select_db_house_by_biz_zone ( $id )
    {
        $this->db->where( 'biz_zone_id', $id );
        $this->db->select( 'dbhouse_id' );
        $this->db->from( 'tbli_distribution_house_biz_zone_mapping' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_biz_zone_by_db_house ( $id )
    {
        $this->db->where( 'dbhouse_id', $id );
        $this->db->select( 'biz_zone_id' );
        $this->db->from( 'tbli_distribution_house_biz_zone_mapping' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * end
     */

    public function Get_Dbhouse_owner_names ( $id )
    {
        $this->db->select( 'id,distributor_name' );
        $this->db->from( 'tbld_distributor' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_status ()
    {
        $this->db->select( 'id,db_house_status_name' );
        $this->db->from( 'tbld_distribution_house_status' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_owner ()
    {
        $this->db->select( 'id,distributor_name' );
        $this->db->from( 'tbld_distributor' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_business_zone_by_id ( $id )
    {
        $this->db->select( 'biz_zone_id' );
        $this->db->from( 'tbli_distribution_house_biz_zone_mapping' );
        $this->db->where( 'dbhouse_id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function selectAddress ()
    {
        $this->db->select( 'id,address_name' );
        $this->db->from( 'tbld_address' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function select_bank ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_account' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insert_db_house_sku_mapping ( $data )
    {
        return $this->db->insert( 'tbli_dbhouse_sku_mapping', $data );
    }

    public function insert_db_house_sku_buffer_level ( $data )
    {
        return $this->db->insert( 'tbld_buffer_level_entry', $data );
    }

    public function getErpCodeOfDBhouse ( $dbhouse, $pl )
    {
        $this->db->select( 'erp_dbcode' );
        $this->db->where( 'dbhouse_id', $dbhouse );
        $this->db->where( 'product_line_id', $pl );
        $this->db->from( 'tbli_dbhouse_product_line_mapping' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getProductLinesOfDBhouse ( $dbhouse )
    {
        $this->db->select( 'product_line_id' );
        $this->db->where( 'dbhouse_id', $dbhouse );
        $this->db->from( 'tbli_dbhouse_product_line_mapping' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getDBhouseByProductLines ( $pl )
    {
        $this->db->select( 'dbhouse_id' );
        $this->db->where( 'product_line_id', $pl );
        return $this->db->get( 'tbli_dbhouse_product_line_mapping' )->result_array();
    }

    public function select_db_damage ()
    {
        $this->db->select( 'id,damage_name' );
        $querys = $this->db->get( 'tbld_db_damage_criteria' )->result_array();
        return $querys;
    }

    public function getDbType ()
    {
        $sql = "SELECT id,name FROM tbld_db_type";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getDbhbyterritory($territory)
    {
        $sql = "SELECT t1.*,t2.id,t2.dbhouse_name 
                FROM `tbli_distribution_house_biz_zone_mapping` as t1 
                Inner Join `tbld_distribution_house` as t2 
                On t1.dbhouse_id=t2.id where biz_zone_id=$territory";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function insertDemarcation ( $data )
    {
        $this->db->insert( 'tbli_db_demarcation', $data );
        return $this->db->insert_id();
    }

    public function insertSpokeMapping($spoke_mapping)
    {
        $this->db->insert( 'tbli_hub_spoke_mapping', $spoke_mapping );
        return $this->db->insert_id();
    }

    public function getDistributorAddressId ( $id )
    {
        $this->db->select( 'distributor_address_id' );
        $this->db->from( 'tbld_distributor' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     *
     * start sku/
     */
    public function getSkuElementsByLayerId ( $layer_id )
    {
        $this->db->select( 'id,element_name' );
        $this->db->from( 'tbld_sku_hierarchy_elements' );
        $this->db->where( 'element_category_id', $layer_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     *
     * end sku/
     */

    /*
     * start address/
     */

    public function insertDistributor( $distributor )
    {
        $this->db->insert( 'tbld_distributor', $distributor );

        return $this->db->insert_id();
    }
    
    public function InsertBankAccount( $bank_account )
    {
        $this->db->insert( 'tbld_account', $bank_account );

        return $this->db->insert_id();
    }
    
        public function InsertDBHAddress ( $data )
    {
        
        $this->db->insert( 'tbld_address', $data );

        return $this->db->insert_id();
    }

    public function insertIntoAddress ( $data )
    {
        
        $this->db->insert('tbld_address', $data );
        return $this->db->insert_id();
    }

    public function getAddress ()
    {
        $this->db->select('id,address_name,mobile1' );
        $this->db->from('tbld_address');
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * end address/
     */

    public function getdivision ()
    {
        $sql = "SELECT * FROM tbld_geo WHERE category_id =1";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getCluster ()
    {
        $sql = "SELECT * FROM tbld_cluster ";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getDistrict ( $division, $district )
    {
        $sql = "SELECT id,name FROM tbld_geo WHERE category_id =2 AND parent_id=$division";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getThana ( $district )
    {
        $sql = "SELECT id,name FROM tbld_geo WHERE category_id =3 AND parent_id=$district";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getUnion ( $thana )
    {
        $sql = "SELECT id,name FROM tbld_geo WHERE category_id =4 AND parent_id=$thana";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getVillage ( $village )
    {
        $sql = "SELECT id,name FROM tbld_geo WHERE category_id =5 AND parent_id=$village";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    /*
     *start distributor /
     */
    public function getDistributor ()
    {
        $sql = " SELECT t1.id,distributor_address_id,distributor_name, t2.address_name,t2.mobile1 FROM tbld_distributor AS t1
                    INNER JOIN tbld_address AS t2
                    ON t2.id = t1. distributor_address_id ";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function insertDistributorInfo ( $data )
    {
        $this->db->insert('tbld_distributor', $data );
        return $this->db->insert_id();
    }

    public function getDistributorInfoById ( $id )
    {
        $this->db->select( '*' );

        $this->db->from( 'tbld_distributor' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateDistributorInfoById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_distributor', $data );
    }

    public function deleteDistributorInfoById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_distributor' );
    }

    /*
     * end distributor/
     */

    public function insertOwner ( $data )
    {
        $this->db->insert( 'tbld_distributor', $data );
        return $this->db->insert_id();
    }

    /*
     * start bank/
     */

    public function insertIntoBank ( $data )
    {
        $this->db->insert('tbld_account', $data );
        return $this->db->insert_id();

    }

    public function GetBankInfoById ( $id )
    {
        $this->db->select('*');
        $this->db->from( 'tbld_account' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateTbldAccountById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_account', $data );
    }

    public function deleteAccountById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_account' );
    }

    public function getBankInfo ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_account' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * end bank/
     */

    /*
     * start db type/
     */

    public function getTypeInfo ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_db_type' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertDbType ( $data )
    {
        return $this->db->insert( 'tbld_db_type', $data );
    }

    public function getDbTypeInfoById ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_db_type' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateTbldTypeById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_db_type', $data );
    }

    public function deleteTypeById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_db_type' );
    }

    /*
     * end db type/
     */

    /*
     * start Distribution Employee/
     */
    
    public function getDBId($emp_id)
    {
        $sql = "SELECT distribution_house_id FROM `tbld_distribution_employee` where id=$emp_id";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getAllDistEmp ($dbhouse_id)
    {
        if($dbhouse_id != '')
        {
            $where = " where t1.distribution_house_id in($dbhouse_id)";
        }else{
            $where = " ";
        }
            
        $sql = "SELECT t1.id, t1.first_name as distributor_employee_name, t1.last_name as distributor_employee_nick_name,t2.user_name,
                t3.dbhouse_name, t4.user_role_name as employee_type, 
                t6.biz_zone_name as ce_area, t7.first_name as ce_name 
                FROM `tbld_distribution_employee` as t1 
                left Join `tbld_user` as t2 on t1.login_user_id=t2.id 
                left Join `tbld_distribution_house` as t3 On t3.id=t1.distribution_house_id
                left Join `tbld_user_role` as t4 On t4.id = t1.dist_role_id
                left Join `tbli_distribution_house_biz_zone_mapping` as t5 On t5.dbhouse_id = t1.distribution_house_id
                left Join `tbld_business_zone` as t6 On t6.id=t5.biz_zone_id
                left Join `tbld_sales_employee` as t7 On t7.biz_zone_id=t5.biz_zone_id 
                $where";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getAllUser ()
    {
        $this->db->select( 'id,user_name' );
        $this->db->from( 'tbld_user' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllSalesEmp ()
    {
        $this->db->select( '*' );
        $this->db->order_by( "id", "desc" );
        return $this->db->get( 'tbld_sales_employee' )->result_array();
    }

    public function getAllPoint ()
    {
        $this->db->select( 'id,biz_zone_name' );
        $this->db->where( "biz_zone_category_id ", 5 );
        $query = $this->db->get( 'tbld_business_zone' )->result_array();
        return $query;
    }

    public function getDistributionHouseId ( $id )
    {
        $sql = "SELECT * FROM  `tbli_distribution_house_biz_zone_mapping` WHERE biz_zone_id =  '$id'";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function insertDistributionHouseEmployee ( $data )
    {
        $this->db->insert( 'tbld_distribution_employee', $data );
        return $this->db->insert_id();
    }

    public function getDistEmpIdByCode ( $code )
    {
        $this->db->select( 'id' );
        $this->db->from( 'tbld_distribution_employee' );
        $this->db->where( 'dist_emp_code', $code );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insertSrSoSerialData ( $data )
    {
        return $this->db->insert( 'tblp_sales_order_serial', $data );
    }

    public function deleteTbldDistributionEmployeeById ( $id )
    {
        $this->db->where( 'id', $id );
        $result = $this->db->delete( 'tbld_distribution_employee' );
        return $result;
    }

    /*
     * End Distribution Employee/
     */

    /*
     * start  Distribution Employee Hierarchy/
     */
    public function getAllDistributionHierarchys ()
    {
        $sql = " SELECT t1.id,t1.dist_role_name,t1.dist_role_code,t1.parent_role_id,t2.id as parent_role_id,
                (select t3.dist_role_name from tbld_distribution_hierarchy as t3 where t2.id = t3.id) as parent_role_name
                FROM tbld_distribution_hierarchy as t1 left join tbld_distribution_hierarchy as t2 on t2.id = t1.parent_role_id  ";


        $query = $this->db->query( $sql )->result_array();
        return $query;

    }

    public function insertDistributionEmployeeHierarchy ( $data )
    {
        $query = $this->db->insert( 'tbld_distribution_hierarchy', $data );
        return $query;
    }

    public function editDistributionEmployeeHierarchyById ( $id )
    {
        $this->db->select( '*' );
        $this->db->where( "id", $id );
        $query = $this->db->get( 'tbld_distribution_hierarchy' )->result_array();
        return $query;

    }

    public function updateDistributionEmployeeHierarchyById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_distribution_hierarchy', $data );
    }

    public function deleteDistributionEmployeeHierarchyById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_distribution_hierarchy' );
    }

    /*
     * End  Distribution Employee Hierarchy/
     */

    public function getAllBusinessZonesChildren ( $id )
    {
        $this->db->select( 'id,biz_zone_name' );
        $this->db->where( "parent_biz_zone_id", $id );
        $query = $this->db->get( 'tbld_business_zone' )->result_array();
        return $query;
    }

    public function getEmpAddress($address_id)
    {
        $sql = "select id, address_name, owner_image from tbld_address as t1
                where t1.id=$address_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

        public function getDistEmpNameById ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_distribution_employee' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllAddressNames ()
    {
        $this->db->select( 'id,address_name' );
        $this->db->from( 'tbld_address' );
//        $this->db->where("id", $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAll_Distribution_hierarchys ()
    {

        $this->db->select( 'id,dist_role_name,dist_role_code,parent_role_id' );
        $this->db->from( 'tbld_distribution_hierarchy' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllDBHouseNameWithOutID ()
    {
        $this->db->select( 'id,dbhouse_name' );
        $query = $this->db->get( 'tbld_distribution_house' )->result_array();
        return $query;
    }

//    public function select_config_param ( $config_code )
//    {
//        $this->db->select( 'id,attribute_id' );
//        $this->db->from( 'tbld_config' );
//        $this->db->where( 'config_code', $config_code );
//        $query = $this->db->get()->result_array();
//        return $query;
//    }
    public function getAllBusinessZone ()
    {
        $sql = "SELECT * FROM `tbld_business_zone_hierarchy` order by parent_category_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }
    public function getAllBusinessZoneRegion ()
    {
        $sql = "SELECT * FROM `tbld_business_zone` where `biz_zone_category_id`=2";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getZoneInfo($id){
        $sql = "SELECT t1.distribution_house_id as db_id,t2.biz_zone_id,t2.pl_id,t3.name as pl_name FROM `tbld_distribution_employee` as t1
                left join tbli_distribution_house_biz_zone_mapping as t2 on t1.distribution_house_id=t2.dbhouse_id
                left join tbld_product_line as t3 on t2.pl_id=t3.id
                where t1.id=$id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSrPl($id){
        $sql = "SELECT pl_id FROM `tbli_db_house_emp_product_line_mapping`
                where emp_id=$id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function insertIntoInventory($dbhouse_id){
        $sql = "insert into `tbld_inventory`(dbhouse_id,sku_id,units_available)
                SELECT $dbhouse_id as dbhouse_id,id as sku_id,10000 as units_available FROM `tbld_sku` where sku_active_status_id=1";
        $query = $this->db->query($sql);
        return $query;
    }
    public function insertIntoAvailableInventory($dbhouse_id){
        $sql = "insert into `tbls_available_inventory`(distribution_id,sku_id,quantity,foc_quantity)
                SELECT $dbhouse_id as dbhouse_id,id as sku_id,0 as units_available,0 as foc_quantity FROM `tbld_sku` where sku_active_status_id=1";
        $query = $this->db->query($sql);
        return $query;
    }
    
    
    /*--------------------------------------------------------------------------
     * Update Table By column_name and set the data
     * @param string $tbl
     * @param int $id
     * @param array $data
     * @return boolearn
     *-------------------------------------------------------------------------*/
    public function updateTbl($tbl,$id,$data){
        $this->db->where('id', $id);
        $query = $this->db->update($tbl, $data); 
        return $query;
    }
    
    public function getVehicleType(){
        $this->db->select('*');
        $query = $this->db->get( 'tbld_vehicle_type' )->result_array();
        return $query;
    }
    public function getBundlePrice($db_id){
        $sql = "SELECT bundle_price_id FROM `tbli_db_bundle_price_mapping` where db_id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    
    public function get_user_list_by_role($role_id){
        $sql = "SELECT t2.* FROM `tbli_user_role_mapping` as t1 
                inner join tbld_user as t2 on t1.user_id=t2.id
                where user_role_id=$role_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function get_role_list(){
        $sql = "SELECT * FROM `tbld_user_role`";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    public function insertBundleSkuIntoInventory($db_id){
        $sql = "insert into tbld_inventory(dbhouse_id,sku_id)
                (SELECT t1.db_id as dbhouse_id,t2.sku_id FROM `tbli_db_bundle_price_mapping` as t1
                inner join tbld_bundle_price_details as t2 on t1.bundle_price_id=t2.bundle_price_id
                where t1.db_id=$db_id
                group by t1.db_id,t2.sku_id)";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_ce_area($db_id){
        $sql = "select id,biz_zone_name as name from `tbld_business_zone` where parent_biz_zone_id in(SELECT t2.parent_biz_zone_id FROM `tbli_distribution_house_biz_zone_mapping` as t1
                inner join `tbld_business_zone` as t2 on t1.biz_zone_id=t2.id
                where t1.dbhouse_id=$db_id)";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function get_assign_ce_area($db_id){
        $sql = "SELECT biz_zone_id FROM `tbli_distribution_house_biz_zone_mapping` where dbhouse_id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function get_assign_territory($ce_area_id){
        $sql = "SELECT parent_biz_zone_id FROM `tbld_business_zone` where id=$ce_area_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function get_territory($territory_id){
        $sql = "select id,biz_zone_name as name from `tbld_business_zone` where parent_biz_zone_id in(SELECT parent_biz_zone_id FROM `tbld_business_zone` where id=$territory_id)";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function get_assign_unit($territory_id){
        $sql = "select id as unit_id  from `tbld_business_zone` where id in(SELECT parent_biz_zone_id FROM `tbld_business_zone` where id=$territory_id)";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getBankAccountInfoByDb($db_id){
        $sql = "SELECT * FROM `tbld_account` where id in(
                SELECT bank_account_id FROM `tbld_distribution_house` where id=$db_id)";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}