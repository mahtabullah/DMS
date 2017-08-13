<?php

class Geographical extends CI_Controller
{
    public function __construct ()
    {
        parent::__construct();

        $this->load->model( 'Geographicals' );
        $this->load->helper( 'tree_data_functions_helper' );
    }

    /*
     * Start Graphical Hierarchy /
     */

    public function geoGraphicalHierarchyIndex ()
    {
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $this->load->view( 'GEO_Configuration/geographical_hierarchy/geographical_hierarchy_index', $data );
    }

    public function createGeoGraphicalHierarchy ()
    {
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $data['count_row'] = $this->Geographicals->countTableRow();
        
        $this->load->view( 'GEO_Configuration/geographical_hierarchy/geographical_hierarchy_create', $data );
    }

    public function saveGeoGraphicalHierarchy()
    {
        $name = $this->input->post( 'name' );
        $code = $this->input->post( 'code' );
        $description = $this->input->post( 'description' );
        $parent_layer = $this->input->post( 'parent_layer' );
        $data = array(
            'biz_zone_category_name' => $name,
            'biz_zone_category_code' => $code,
            'biz_zone_category_description' => $description,
            'parent_category_id' => $parent_layer
        );
        $insert = $this->Geographicals->insertBizZoneInfo( $data );
        if ( $insert ) {
            $get_data = $this->Geographicals->getBusinessZoneLayerIdByCode( $code );
            foreach ( $get_data as $biz_zone_id ) {
                $res = tree_data( 'tree_business_zone_hierarchy', 'biz_zone_hierarchy_id', $biz_zone_id[ 'id' ], $parent_layer, 'below' );
            }
            redirect( site_url( 'geographical/geoGraphicalHierarchyIndex' ) );
        }
    }

    public function geoGraphicalHierarchyEditById ($id)
    {
        $data[ 'geoGraphicalHierarchyInfoById' ] = $this->Geographicals->geoGraphicalHierarchyEditById( $id );
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $this->load->view( 'GEO_Configuration/geographical_hierarchy/geographical_hierarchy_edit', $data );
    }

    public function geoGraphicalHierarchyUpdateById ( $id )
    {
        $data = array(
            'biz_zone_category_name' => $this->input->post( 'biz_zone_category_name' ),
            'biz_zone_category_code' => $this->input->post( 'biz_zone_category_code' ),
            'biz_zone_category_description' => $this->input->post( 'biz_zone_category_description' ),
            'parent_category_id' => $this->input->post( 'parent_category_id' )
        );
        $update = $this->Geographicals->geoGraphicalHierarchyUpdateById( $id, $data );
        if ( $update ) {
            redirect( site_url( 'geographical/geoGraphicalHierarchyIndex' ) );
        }
    }

    public function geoGraphicalHierarchyDeleteById ( $id )
    {
        $del = $this->Geographicals->geoGraphicalHierarchyDeleteById( $id );
        redirect( site_url( 'geographical/geoGraphicalHierarchyIndex' ) );
    }

    /*
     * End Graphical Hierarchy /
     */


    /*
     * Start  Graphical Master  /
     */
    public function getFilterData ()
    {
        $geo_id = $this->input->post( 'geo_id' );
        if ( $geo_id != '' ) {
            $data[ 'biz_zone_name' ] = $this->Geographicals->getAllBizZoneNamesById( $geo_id );
        } else {
            $data[ 'biz_zone_name' ] = $this->Geographicals->getAllBizZoneNames();
        }

        $this->load->view( 'GEO_Configuration/geographical_master/filter_data', $data );
    }

    public function geoGraphicalMasterIndex ()
    {
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $data[ 'biz_zone_name' ] = $this->Geographicals->getAllBizZoneNames();
        $this->load->view( 'GEO_Configuration/geographical_master/geographical_master_index', $data );
    }

    public function createGeoGraphicalMaster ()
    {
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $data[ 'biz_zone_names' ] = $this->Geographicals->getAllBizZoneNames();
        $this->load->view( 'GEO_Configuration/geographical_master/geographical_master_create', $data );
    }

    public function saveGeoGraphicalMaster ()
    {
        $name = $this->input->post( 'name' );
        $code = $this->input->post( 'code' );
        $description = $this->input->post( 'description' );
        $geo_layer = $this->input->post( 'geo_layer' );
        $parent_zone = $this->input->post( 'parent_zone' );

        $data = array(
            'biz_zone_name' => $name,
            'biz_zone_code' => $code,
            'biz_zone_description' => $description,
            'biz_zone_category_id' => $geo_layer,
            'parent_biz_zone_id' => $parent_zone
        );
        $insert = $this->Geographicals->insertGetGeoGraphicalMasterData( $data );
        if ( $insert ) {
            redirect( site_url( 'geographical/geoGraphicalMasterIndex' ) );
        }
    }

    public function geoGraphicalMasterEditById ( $id )
    {
        $data[ 'tbld_business_zone' ] = $this->Geographicals->getGeoGraphicalMasterDataById( $id );
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $data[ 'biz_zone_names' ] = $this->Geographicals->getAllBizZoneNames();
        $this->load->view( 'GEO_Configuration/geographical_master/geographical_master_edit', $data );
    }

    public function geoGraphicalMasterDetailById ( $id )
    {
        $data['geo_master_id']=$id;
        $data[ 'tbld_business_zone' ] = $this->Geographicals->getGeoGraphicalMasterDataById( $id );
        $data[ 'biz_zone' ] = $this->Geographicals->getAllBusinessZone();
        $data[ 'biz_zone_names' ] = $this->Geographicals->getAllBizZoneNames();
        $this->load->view( 'GEO_Configuration/geographical_master/geographical_master_detail', $data );
    }

    public function geoGraphicalMasterUpdateById ( $id )
    {
        $data = array(
            'biz_zone_name' => $this->input->post( 'biz_zone_name' ),
            'biz_zone_code' => $this->input->post( 'biz_zone_code' ),
            'biz_zone_description' => $this->input->post( 'biz_zone_description' ),
            'biz_zone_category_id' => $this->input->post( 'biz_zone_category_id' ),
            'parent_biz_zone_id' => $this->input->post( 'parent_biz_zone_id' )
        );
        $update = $this->Geographicals->updateGetGeoGraphicalMasterDataById( $id, $data );
        if ( $update ) {
            redirect( site_url( 'geographical/geoGraphicalMasterIndex' ) );
        }
    }

    public function geoGraphicalMasterDeleteById ( $id )
    {
        $del = $this->Geographicals->deleteGetGeoGraphicalMasterDataById( $id );
        redirect( site_url( 'geographical/geoGraphicalMasterIndex' ) );
    }

    /*
     * End Graphical Master /
     */
}
