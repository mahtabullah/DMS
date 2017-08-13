<?php

class Skus extends CI_Model
{

    var $logical_sku_qty_calculation = array();

    public function getMaxUnit($in){
        $sql = "SELECT max(qty) as maxQty FROM tbld_unit WHERE id in($in)";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function GetSkupackaging ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbli_sku_mou_price_mapping' )->result_array();
        return $query;
    }

    public function get_sku_by_parent_id ( $parent_id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( "parent_id", $parent_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_sku_category_by_id ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbli_sku_category_mapping' );
        $this->db->where( "sku_id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_dd_price ( $sku_id )
    {
        //$sql = "SELECT db_lifting_price FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id and quantity=1";
        $sql = "SELECT db_lifting_price FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id HAVING MIN( quantity )";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }
    public function get_prices ( $sku_id )
    {
        //$sql = "SELECT db_lifting_price FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id and quantity=1";
        $sql = "SELECT * FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id Order by quantity";
        $query = $this->db->query( $sql );
        return $query->result_array();
    }

    public function getSkuCategorys ()
    {
        $this->db->select( 'id,sku_category_name' );
        $this->db->from( 'tbld_sku_category' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getCategoryNamess ( $id )
    {
        $this->db->select( 'id,sku_category_name' );
        $this->db->from( 'tbld_sku_category' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_data_sku_filters ( $where = NULL )
    {

        $sql = "SELECT * FROM `tbld_sku_log` WHERE 1 ";

        if ( $where != NULL ) {
            $sql .= $where;
        }
//echo $sql;
        $query = $this->db->query( $sql );

        return $query->result_array();
    }

    public function getInfoDiscountedPrices ( $id )
    {
        $this->db->select( 'discounted_price,discount_type_id,promo_sku_qty_start_level,promo_sku_qty_end_level,promo_id' );
        $this->db->from( 'tbld_promotion_details' );
        $this->db->where( "sku_id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getInfoDefaultPrices ( $id )
    {
        $this->db->select( 'sku_default_price' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getInfoAnotherDiscount ( $id )
    {
        $promotion_type_name = mysql_query( "SELECT t1.promotion_micro_type_name FROM tbld_promotion_type AS t1, tbld_promotion AS t2
        WHERE t1.id = t2.promo_type_id and t2.id = $id" );
        return $promotion_type_name;
    }

    public function getInfoDefaultUnits ( $id )
    {
        $this->db->select( 'sku_default_mou' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->row();
        return $query;
    }

    public function getInfoUnitsName ( $id )
    {
        $this->db->distinct();
        $this->db->select( 'id,unit_name' );
        $this->db->from( 'tbld_unit' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->row();
        return $query;
    }

    public function getInfoUnits ( $id )
    {
        $this->db->distinct();
        $this->db->select( 'mou_id' );
        $this->db->where( "sku_id", $id );
        $query = $this->db->get( 'tbli_sku_mou_price_mapping' )->result_array();
        return $query;
    }

    public function setprices ( $sku_id, $unit_id )
    {
        $this->db->select( 'db_lifting_price,mou_id' );
        $this->db->where( "sku_id", $sku_id );
        $this->db->where( "mou_id", $unit_id );
        $query = $this->db->get( 'tbli_sku_mou_price_mapping' )->result_array();
        return $query;
    }

    public function checkIfLogicalSku ( $sku_id )
    {
        $this->db->select( 'sku_logical_type_id' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( "id", $sku_id );
        $query = $this->db->get()->result_array();
        foreach ( $query as $logical ) {
            if ( $logical[ 'sku_logical_type_id' ] == 1 ) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getLogicalSkuChildren ( &$children_sku, $sku_id )
    {
        $this->db->select( 'child_sku_id,child_sku_quantity' );
        $this->db->from( 'tbli_bundle_sku_sku_mapping' );
        $this->db->where( "bundle_sku_id", $sku_id );
        $query = $this->db->get()->result_array();

        $children_sku = array();

        foreach ( $query as $sku_id_child ) {
            $logic_chck_res = $this->checkIfLogicalSku( $sku_id_child[ 'child_sku_id' ] );
            if ( $logic_chck_res == 1 ) {
                $this->logical_sku_qty_calculation = array(
                    'sku' => $sku_id_child[ 'child_sku_id' ],
                    'qty' => $sku_id_child[ 'child_sku_quantity' ]
                );
                $this->getLogicalSkuChildren( $children_sku, $sku_id_child[ 'child_sku_id' ] );
            } else {
                end( $this->logical_sku_qty_calculation );
                $x = key( $this->logical_sku_qty_calculation );
                $y = current( $this->logical_sku_qty_calculation );
                if ( !$y ) {
                    $y = 1;
                }
                $qty = $y * $sku_id_child[ 'child_sku_quantity' ];
                $children_sku[] = array(
                    'child_sku_id' => $sku_id_child[ 'child_sku_id' ],
//                    'child_sku_qty'=>$sku_id_child['child_sku_quantity']
                    'child_sku_qty' => $qty
                );
                unset( $this->logical_sku_qty_calculation[ $x ] );
                //var_dump($this->logical_sku_qty_calculation);
            }
        }
        //var_dump($children_sku);
        return $children_sku;
    }

    public function GetSkuID ( $sku_code )
    {

        $this->db->select( 'id' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( "sku_code", $sku_code );
        $query = $this->db->get()->row();
        return $query;
    }

    public function GetSKUProduct ()
    {

        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_sku_product' )->result_array();
        return $query;
    }
    /**
     *
     * sku Hierarchy start
     */
    // Gent All Sku Hierarchy  table Data //
    public function getSkuHierarchy ()
    {
        $sql = "select t1.id,t1.layer_name,t1.layer_code,t1.layer_description,t1.parent_layer_id,t2.id as parent_layer_id,"
            . " (Select b.layer_name from tbld_sku_hierarchy as b where t2.id = b.id) as parent_layer_name from tbld_sku_hierarchy as t1 left join tbld_sku_hierarchy as t2 on t2.id = t1.parent_layer_id ";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function insertIntoTbl ( $tbl, $data )
    {
        return $this->db->insert( $tbl, $data );
    }

    public function getTbldSkuHierarchyById ( $hierarchy_id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_sku_hierarchy' );
        $this->db->where( "id", $hierarchy_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    // Gent Individual Id Sku Hierarchy Code From table Data //
    public function getSkuLayerIdByCode ( $hierarchy_code )
    {
        $this->db->select( 'id' );
        $this->db->where( 'layer_code', $hierarchy_code );
        $query = $this->db->get( 'tbld_sku_hierarchy' )->result_array();
        return $query;
    }

    // Update Individual Id Sku Hierarchy  table Data //
    public function updateTbldSkuHierarchyById ( $hierarchy_id, $data )
    {
        $this->db->where( 'id', $hierarchy_id );
        return $this->db->update( 'tbld_sku_hierarchy', $data );
    }

    // Delete Individual Id Sku Hierarchy table Data //
    public function deleteTbldSkuHierarchyById ( $hierarchy_id )
    {
        $this->db->where( 'id', $hierarchy_id );
        $this->db->delete( 'tbld_sku_hierarchy' );
    }
    /*
     * sku Hierarchy end
     */


    /*
     * sku Hierarchy Element Start
     */
    public function getSkuHierarchyElements ()
{

//        $sql = "select t1.id as sku_hierarchy_element_by_id,t1.element_name,t1.element_code,t1.element_description,t1.element_category_id,t1.parent_element_id,
//                t2.id as parent_layer_id,t3.id,t3.layer_name as element_category,
//                (Select b.element_name from tbld_sku_hierarchy_elements as b where t2.id = b.id)
//                as parent_element_name from tbld_sku_hierarchy_elements
//                as t1 left join tbld_sku_hierarchy_elements as t2 on t2.id = t1.parent_element_id
//                left join tbld_sku_hierarchy as t3 on t2.element_category_id = t3.id ";
    $sql = "SELECT t1.*,t1.id as sku_hierarchy_element_by_id,t2.layer_name as element_category,t3.element_name as parent_element_name FROM `tbld_sku_hierarchy_elements` as t1
                left join `tbld_sku_hierarchy` as t2 on t1.element_category_id=t2.id
                left join `tbld_sku_hierarchy_elements` as t3 on t1.parent_element_id=t3.id";
    $query = $this->db->query( $sql )->result_array();

    return $query;

}

    public function getSkuElementIdByCode ( $code )
    {
        $this->db->select( 'id' );
        $this->db->where( 'element_code', $code );
        $query = $this->db->get( 'tbld_sku_hierarchy_elements' )->result_array();
        return $query;
    }

    public function getTbldSkuHierarchyElementsById ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_sku_hierarchy_elements' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateTbldSkuHierarchyElementsById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_sku_hierarchy_elements', $data );
    }

    public function deleteTbldSkuHierarchyElementsById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_sku_hierarchy_elements' );
    }

    /*
     * sku Hierarchy Element end
     */

    /*
     * sku Type Start
     */
    public function getSkuTypes ()
    {

        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_sku_type' )->result_array();
        return $query;
    }

    public function addSkuTypes ( $data )
    {
        return $this->db->insert( 'tbld_sku_type', $data );
    }

    public function getTbldSkuTypeById ( $sku_type_id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_sku_type' );
        $this->db->where( "id", $sku_type_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateTbldSkuType ( $sku_type_id, $data )
    {
        $this->db->where( 'id', $sku_type_id );
        return $this->db->update( 'tbld_sku_type', $data );
    }

    public function deleteTbldSkuTypeById ( $sku_type_id )
    {
        $this->db->where( 'id', $sku_type_id );
        $this->db->delete( 'tbld_sku_type' );
    }

    /*
     * sky Type End
    */

    /*
     * sku start/
     */
    public function getSkuName ()
    {
        $sql = " SELECT t1.id,sku_name,sku_description,sku_code,sku_weight_id,sku_lpc,sku_volume,sku_launch_date,t8.sku_type_name,
                GROUP_CONCAT(t5.unit_name SEPARATOR '<br /><br />') AS unit,t2.quantity,
                GROUP_CONCAT(ROUND(t2.db_lifting_price,2) SEPARATOR '<br /><br />') as db_lifting_price ,
                GROUP_CONCAT(ROUND(t2.outlet_lifting_price,2) SEPARATOR '<br /><br />') AS outlet_lifting_price,
                GROUP_CONCAT(ROUND(t2.mrp_lifting_price,2) SEPARATOR '<br /><br /> ') AS mrp_lifting_price ,
                t3.element_name,t4.sku_active_status_name,t5.unit_name,t6.element_name as product,
                t7.element_name as catagory
                FROM tbld_sku AS t1
                INNER JOIN
                `tbli_sku_mou_price_mapping` AS t2
                ON t1.id = t2.sku_id
                INNER JOIN
                tbld_sku_active_status AS t4
                ON t1.sku_active_status_id = t4.id
                INNER JOIN
                tbld_sku_hierarchy_elements AS t3
                ON t1.parent_id = t3.id
                INNER JOIN
                tbld_unit AS t5
                ON t5.id= t2.mou_id
                left join tbld_sku_hierarchy_elements as t6
                on t6.id = t3.parent_element_id
                left join tbld_sku_hierarchy_elements as t7
                on t7.id = t6.parent_element_id
                left Join `tbld_sku_type` as t8
                On t1.sku_type_id=t8.id
                GROUP BY t2.sku_id
                ORDER BY t2.sku_id,t2.quantity asc";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getSkuStatus ()
    {
        $this->db->select( 'id,sku_active_status_name' );
        $query = $this->db->get( 'tbld_sku_active_status' )->result_array();
        return $query;

    }

    public function getSkuElementsByLayerId ($layer_id)
    {
        $this->db->select( 'id,element_name' );
        $this->db->from( 'tbld_sku_hierarchy_elements' );
        $this->db->where( 'element_category_id', $layer_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSkuManufacturer ()
    {
        $this->db->select( 'id,sku_manufacturer_name' );
        $this->db->from( 'tbld_sku_manufacturer' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSkuSizeType ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_sku_size' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function addSkus ( $data )
    {
        $this->db->insert( 'tbld_sku', $data );
        return $this->db->insert_id();
    }

    public function insertSkuLog ( $data )
    {

        return $this->db->insert( 'tbld_sku_log', $data );
    }

    public function getSkuNameById ( $sku_id )
    {
        $sql = "SELECT t1.*,t2.mou_id,t2.db_lifting_price,t2.outlet_lifting_price,t2.mrp_lifting_price FROM `tbld_sku`  as t1
                left join
                `tbli_sku_mou_price_mapping` as t2
                on t1.id=t2.sku_id where t1.id=$sku_id order by t1.id,t2.quantity desc";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }
    public function getSkuMaxQtyById ( $sku_id )
    {
        $sql = "SELECT max(quantity) as qty FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }
    
    public function getSkuCategory ()
    {

        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_sku_category' )->result_array();
        return $query;
    }

    public function updateSkus ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_sku', $data );
    }

    public function deleteSkuMouId ( $id )
    {
        $this->db->where( 'sku_id', $id );
        $this->db->delete( 'tbli_sku_mou_price_mapping' );
    }

    /*
     * sku End/
     */

    /*
     * External sku start/
     */
    public function getExternalSkuData ()
    {
        $sql = "SELECT t1.id,t1.sku_name,t1.sku_creation_date,t1.sku_description,t3.sku_active_status_name,t4.unit_name FROM
                `tbld_sku` as t1 
                inner join `tbli_sku_mou_price_mapping` as t2 on t1.id=t2.sku_id
                left join `tbld_sku_active_status` as t3 on t1.sku_active_status_id=t3.id
                left join `tbld_unit` as t4 on t2.mou_id=t4.id
                where t1.sku_type_id=2";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function getSkuUnit ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_unit' )->result_array();
        return $query;

    }

    public function getSkuUnitStatus ()
    {
        $this->db->select( 'id,sku_active_status_name' );
        $query = $this->db->get( 'tbld_sku_active_status' )->result_array();
        return $query;

    }

    public function getExternalSkuBrandId ( $external_brand_code )
    {
        $sql = "SELECT id FROM `tbld_sku_hierarchy_elements` where element_code='$external_brand_code'";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function insertExternalSkuInfo ( $tbld_sku, $data )
    {
        $this->db->insert( $tbld_sku, $data );
        return $this->db->insert_id();
    }

    public function getMouQuantity ( $mou_id )
    {

        $sql = "SELECT qty FROM `tbld_unit` where id=$mou_id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function insertTbliSkuMouPriceMapping ( $tbli_sku_mou_price_mapping, $data2 )
    {
        $this->db->insert( $tbli_sku_mou_price_mapping, $data2 );
        return $this->db->insert_id();
    }

    public function getTbldExternalSkuById ( $id )
    {

        $sql = "SELECT t1.id,t1.sku_name,t1.sku_description,t1.sku_active_status_id,t1.sku_creation_date,t2.mou_id 
            FROM `tbld_sku` as t1 inner join `tbli_sku_mou_price_mapping` as t2 on t1.id=t2.sku_id where t1.sku_type_id=2 and t1.   id=$id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function updateExternalSku ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_sku', $data );
    }

    public function updateTbliSkuMouPriceMapping ( $id, $data2 )
    {
        $this->db->where( 'sku_id', $id );
        return $this->db->update( 'tbli_sku_mou_price_mapping', $data2 );
    }

    public function deleteTbldSkuById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_sku' );

    }

    public function deleteTbliSkuMouPriceMappingIdById ( $id )
    {
        $this->db->where( 'sku_id', $id );
        $this->db->delete( 'tbli_sku_mou_price_mapping' );

    }


    /*
     * External sku end/
     */


//    public function GetSkuHierarchyNameById($id) {
//        $this->db->select('layer_name');
//        $this->db->where('id', $id);
//        $query = $this->db->get('tbld_sku_hierarchy')->result_array();
//        return $query;
//    }

    public function getSkuHierarchyElementNameById ( $id )
    {
        $this->db->select( 'id,element_name' );
        $this->db->where( 'id', $id );
        $query = $this->db->get( 'tbld_sku_hierarchy_elements' )->result_array();
        return $query;
    }

//    public function getSkuStatusNameById($id) {
//        $this->db->select('id,sku_active_status_name');
//        $this->db->where('id', $id);
//        $query = $this->db->get('tbld_sku_active_status')->result_array();
//        return $query;
//    }


    public function getSkuIdByCode ( $code )
    {
        $this->db->select( 'id' );
        $this->db->where( 'sku_code', $code );
        $query = $this->db->get( 'tbld_sku' )->result_array();
        return $query;
    }

    public function get_unit_by_sku_id ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbli_sku_mou_price_mapping' );
        $this->db->where( "sku_id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete_sku_category_by_id ( $id )
    {
        $this->db->where( 'sku_id', $id );
        $result = $this->db->delete( 'tbli_sku_category_mapping' );
        return $result;
    }

    public function insert_sku_cateogy ( $sku_id, $category_id )
    {


        for ( $i = 0; $i < count( $category_id ); $i++ ) {
            $sql = "INSERT INTO `tbli_sku_category_mapping`(`sku_id`, `category_id`) "
                . "VALUES ('$sku_id','$category_id[$i]')";
            $query = mysql_query( $sql );
        }
        return $query;
    }

    public function GetSKUBrands ()
    {

        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_sku_brand' )->result_array();
        return $query;
    }

    public function sku_for_external_logicals ( $id )
    {
        $this->db->select( 'id,sku_name' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( "sku_type_id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAnotherSku ()
    {
        $this->db->select( 'id,sku_type_name' );
        $this->db->from( 'tbld_sku_type' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function add_sku_weight ( $data )
    {

        //return $this->db->insert('tbli_sku_weight_mapping', $data);
        $this->db->insert( 'tbli_sku_weight_mapping', $data );
        return $this->db->insert_id();
    }

    public function delete_tbli_sku_mou_price_mapping_by_id ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbli_sku_mou_price_mapping' );
    }

    public function update_sku_category_by_id ( $id, $data )
    {
        $this->db->where( 'sku_id', $id );
        return $this->db->update( 'tbli_sku_mou_price_mapping', $data );
    }


    public function addSKUBrand ( $data )
    {
        return $this->db->insert( 'tbld_sku_brand', $data );
    }

    public function addSKUProduct ( $data )
    {
        return $this->db->insert( 'tbld_sku_product', $data );
    }

    public function sku_for_promotion_views ()
    {
        $this->db->distinct();
        $this->db->select( 'bundle_sku_id' );
        $this->db->from( 'tbli_bundle_sku_sku_mapping' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getChildSKUs ()
    {
        $this->db->select( 'child_sku_id,child_sku_quantity' );
        $this->db->from( 'tbli_bundle_sku_sku_mapping' );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getTopLayer ()
    {
        $this->db->select( 'id,layer_name' );
        $this->db->where( 'parent_layer_id', '' );
        $query = $this->db->get( 'tbld_sku_hierarchy' )->result_array();
        return $query;
    }

    public function getAllPl ()
    {
        $this->db->select( 'id,name' );
//        $this->db->where('parent_layer_id','');
        $query = $this->db->get( 'tbld_product_line' )->result_array();
        return $query;
    }

    public function add_sku_for_promotions ( $data )
    {

        $pro_sku_id = $data[ 'pro_sku_id' ];

        $pro_sku_name = $data[ 'pro_sku_name' ];
        $sku_qty = $data[ 'sku_qty' ];

        $another_sku_name = $data[ 'another_sku_name' ];
        $another_sku_qty = $data[ 'another_sku_qty' ];


        for ( $i = 0; $i < count( $pro_sku_name ); $i++ ) {
            $sql = "INSERT INTO tbli_bundle_sku_sku_mapping (bundle_sku_id,child_sku_id,child_sku_quantity) VALUES ('$pro_sku_id','$pro_sku_name[$i]','$sku_qty[$i]')";
            $query = mysql_query( $sql );
        }
        for ( $i = 0; $i < count( $another_sku_name ); $i++ ) {
            $sqls = "INSERT INTO tbli_bundle_sku_sku_mapping (bundle_sku_id,child_sku_id,child_sku_quantity) VALUES ('$pro_sku_id','$another_sku_name[$i]','$another_sku_qty[$i]')";
            $querys = mysql_query( $sqls );
        }
        return $querys;
    }


    public function getSkuParentID ( $id )
    {
        $this->db->select( 'parent_element_id' );
        $this->db->from( 'tbld_sku_hierarchy_elements' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSkuNameByParentId ( $parent_id )
    {
        $this->db->select( 'id,sku_name' );
        $this->db->from( 'tbld_sku' );
        $this->db->where( 'parent_id', $parent_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    /*
     * DBHouse SKU Mapping
     */

    public function getDBHouseID ( $product_line_id )
    {
        $this->db->select( 'dbhouse_id' );
        $this->db->from( 'tbli_dbhouse_product_line_mapping' );
        $this->db->where( 'product_line_id', $product_line_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSkuByDBhouseId ( $db_id )
    {
        $this->db->select( 'sku_id' );
        $this->db->from( 'tbli_dbhouse_sku_mapping' );
        $this->db->where( 'dbhouse_id', $db_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getSkuByDBhouseIdAndName ( $db_id )
    {

        $sql = "SELECT sku.id as id,sku.sku_name as name FROM `tbld_sku` as sku inner join `tbli_dbhouse_sku_mapping` as mapping on mapping.sku_id = sku.id where dbhouse_id = '$db_id'";
        $query = mysql_query( $sql );
        //$result = mysql_fetch_array($query);
        while ( $row = mysql_fetch_assoc( $query ) ) {
            $data[] = $row;

        }
        return $data;
    }

//    public function insert_dbhouse_sku_mapping($dbhoue_id,$sku_id){
//    for ($i = 0; $i < count($dbhoue_id); $i++) {
//            $sql = "INSERT INTO tbli_dbhouse_sku_mapping (dbhouse_id,sku_id) VALUES ('$dbhoue_id[$i]','$sku_id[$i]')";
//            $query = mysql_query($sql);
//        }
//    }

    public function insert_data_into_tbl ( $tbl, $data )
    {
        $this->db->insert( $tbl, $data );
    }

    /*
     * SR SKU Mapping
     */

    public function getSRID ( $product_line_id )
    {
        $this->db->select( 'emp_id' );
        $this->db->from( 'tbli_db_house_emp_product_line_mapping' );
        $this->db->where( 'pl_id', $product_line_id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function insert_sr_sku_mapping ( $emp_id, $sku_id )
    {

        for ( $i = 0; $i < count( $emp_id ); $i++ ) {
            $sql = "INSERT INTO tbli_sr_sku_mapping (emp_id,sku_id) VALUES ('$emp_id[$i]','$sku_id[$i]')";
            $query = mysql_query( $sql );
        }
    }

    /*
     * buffer level
     */

    public function insert_dbhouse_wise_buffer_level_sku_mapping ( $dbhoue_id, $sku_id )
    {

        for ( $i = 0; $i < count( $dbhoue_id ); $i++ ) {
            $sql = "INSERT INTO tbld_buffer_level_entry (db_id,sku,unit,min_buffer_level) VALUES ('$dbhoue_id[$i]','$sku_id',1,0)";
            $query = mysql_query( $sql );
        }
    }


    /*
     * Add Sku Unit
     */

    public function addSkuUnits ( $data )
    {
        return $this->db->insert( 'tbld_unit', $data );
    }

    public function getAllUnits ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_unit' )->result_array();
        return $query;
    }

    public function getAllcontainer ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_container_type' )->result_array();
        return $query;
    }
    public function getAllvolume ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_volume' )->result_array();
        return $query;
    }
    public function getAllcategory ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_sku_category' )->result_array();
        return $query;
    }
public function getAllvolume_unit ()
    {
        $this->db->select( '*' );
        $query = $this->db->get( 'tbld_volume_unit' )->result_array();
        return $query;
    }

    public function getTbldUnitById ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_unit' );
        $this->db->where( 'id', $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function updateTbldUnitById ( $id, $data )
    {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tbld_unit', $data );
    }

    public function deleteTbldUnitById ( $id )
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'tbld_unit' );
    }

    /*
     * Add SKU Packaging
     * 
     */

    public function addsku_packaging ( $data )
    {
        return $this->db->insert( 'tbli_sku_mou_price_mapping', $data );
    }

    public function getCategoryNamesByCategoryType ( $id )
    {
        $this->db->select( 'id,outlet_category_name' );
        $this->db->where( 'parent_category_type_id', $id );
        $query = $this->db->get( 'tbld_outlet_category' )->result_array();
        return $query;
    }


    public function get_tbli_sku_mou_price_mapping_by_id ( $id )
    {
        $this->db->select( '*' );
        $this->db->from( 'tbli_sku_mou_price_mapping' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_sku_hierarchy_layer_name ( $id )
    {
        $this->db->select( 'layer_name' );
        $this->db->from( 'tbld_sku_hierarchy' );
        $this->db->where( "id", $id );
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete ( $tbl, $where, $id )
    {
        $this->db->where( $where, $id );
        $delete = $this->db->delete( $tbl );
        return $delete;
    }

    public function get_sku_size_type_by_id ( $id )
    {
        $sql = "select * from tbld_sku_size where id=$id";
        $query = $this->db->query( $sql )->result_array();
        return $query;
    }

    public function update_single_table ( $tbld, $where, $id, $data )
    {
        $this->db->where( $where, $id );
        return $this->db->update( $tbld, $data );
    }

    /*
     * db houses start/
     */
    public function getAllDbHouses ()
    {
        $this->db->select( '*' );
        $this->db->from( 'tbld_distribution_house' );
        $query = $this->db->get()->result_array();
        return $query;
    }
    /*
     * db houses end/
     */


    /*
     * inventory start/
     */
    public function insertInventory ( $data )
    {
        return $this->db->insert( 'tbld_inventory', $data );
    }
    /*
     *inventory end /
     */


    /*
     * unit start/
     */
    public function getUnitQtyByUnitId ( $id )
    {
        $this->db->select( 'qty' );
        $this->db->where( "id", $id );
        $query = $this->db->get( 'tbld_unit' )->result_array();
        return $query;
    }

    public function insertData ( $tbl, $data )
    {
        return $this->db->insert( $tbl, $data );
    }

    public function getUnitInformation ( $sku_id )
    {
        $sql = "SELECT t1.unit_name,t2.quantity,t2.db_lifting_price,t2.outlet_lifting_price,t2.mrp_lifting_price from `tbld_unit` as t1
                inner join
                `tbli_sku_mou_price_mapping` as t2
                on t1.id=t2.mou_id
                where t2.sku_id=$sku_id";
        $query = $this->db->query( $sql );
        $result = $query->result_array();
        return $result;
    }

    /*
     * unit end/
     */
    
    
    public function insertIntoInventory($sku_id){
        $sql = "insert into `tbld_inventory`(dbhouse_id,sku_id,units_available)
                SELECT id as dbhouse_id, $sku_id as sku_id,10000 as units_available FROM `tbld_distribution_house` where db_house_status=1";
        $query = $this->db->query($sql);
        return $query;
    }
    public function insertIntoAvailableInventory($sku_id){
        $sql = "insert into `tbls_available_inventory`(distribution_id,sku_id,quantity,foc_quantity)
                SELECT id as dbhouse_id, $sku_id as sku_id,0 as quantity,0 as foc_quantity FROM `tbld_distribution_house` where db_house_status=1";
        $query = $this->db->query($sql);
        return $query;
    }

}
