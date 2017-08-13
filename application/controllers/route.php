<?php

if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

class Route extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->model( 'Routes' );
     
    }

    //tbld_distribution_route

    public function routeView(){
        $db_id = $this->session->userdata('db_id');
        $data[ 'route' ] = $this->Routes->getRouteInfo($db_id);
      
        $this->load->view( 'route/db_route_index', $data );
    }

    public function filter_data ()
    {
        $db_id = $this->input->post( 'db_id' );
        $data[ 'dbhouse' ] = $this->Routes->select_db_house_by_db_id( $db_id );
        $data[ 'route' ] = $this->Routes->getAllRoutes_by_db_id( $db_id );
        $this->load->view( 'route/route_filter', $data );
    }

    public function route_class ()
    {
        $data[ 'route_class' ] = $this->Routes->getAllRouteClasses();
        $this->load->view( 'route/route_class', $data );
    }

    public function create_route_class ()
    {
//        $data['route_class'] = $this->Routes->getAllRouteClasses();
        $this->load->view( 'route/create_route_class' );
    }

    public function route_class_edit ( $id )
    {
        $data[ 'route_class' ] = $this->Routes->get_route_class_by_id( $id );
        $this->load->view( 'route/route_class_edit', $data );
    }

    public function route_class_edit_done ( $id )
    {
        $data = array(
            'route_class_name' => $this->input->post( 'name' ),
            'route_class_code' => $this->input->post( 'code' ),
            'route_class_description' => $this->input->post( 'description' )
        );

        $update = $this->Routes->update_tbld_route_class( $id, $data );
        if ( $update ) {
            redirect( site_url( 'route/route_class' ) );
        }


    }

    public function route_class_delete ( $id )
    {
        $del = $this->Routes->delete_tbld_route_class_by_id( $id );
        if ( $del ) {
            redirect( site_url( 'route/route_class' ) );
        }
    }

    public function get_market ()
    {
        $territory_id = $this->input->post( 'territory_id' );
        $market_info = $this->Routes->getAllMarketsById( $territory_id );
        echo json_encode( $market_info );

    }
    
 

    public function save_route_class ()
    {
        $data = array( 'route_class_name' => $this->input->post( 'name' ),
            'route_class_code' => $this->input->post( 'code' ),
            'route_class_description' => $this->input->post( 'description' ) );
        $insert = $this->Routes->insertRouteClass( $data );
        redirect( site_url( 'route/route_class' ) );
//        $this->load->view('route/create_route_class');
    }

    public function getAllOutlets ( $route_ids )
    {
        $data = $this->Routes->getAllOutletIds( $route_ids );
        $i = 0;
        foreach ( $data as $id_outlets ) {
            $data1[ $i ] = $this->Routes->getAllOutletsById( $id_outlets[ 'outlet_id' ] );
            $i++;
        }
        //var_dump($data1);
        return $data1;
    }

    public function getRouteStatus ( $status_ids )
    {
        $status_res = $this->Routes->getAllStatus( $status_ids );
        return $status_res;
    }

    public function route_build ()
    {
        
        //$data[ 'dbhouse' ] = $this->Routes->select_db_house();
        $data['dbhouse'] = $this->routePlanByDbFilter();
        $data[ 'route_class' ] = $this->Routes->getRouteClass();
        //$data['pl'] = $this->Skus->getSkuElementsByLayerId(1);
        $outlet_map = $this->Routes->mappings_route();
        foreach ( $outlet_map as $outlet_maps ) {
            $data[ 'mappings_name' ] = $this->Routes->mappings_name( $outlet_maps );
        }
        $this->load->view( 'route/route_builder', $data );
    }


    public function getErpCodeInDBhouse ()
    {
        $dbhouse_id = $this->input->post( 'dbhouse' );
        $pl_id = $this->input->post( 'pl' );
        $data[ 'count' ] = $this->Routes->getRouteNumOfDBhouse( $dbhouse_id );
        $data[ 'erp_code' ] = $this->Routes->getErpCodeOfDBhouse( $dbhouse_id, $pl_id );

        echo json_encode( $data );
    }

    public function getAllOutletsAndProductLineInDBhouse ()
    {
        $dbhouse_id = $this->input->post( 'dbhouse' );
        $db[] = $dbhouse_id;
        $data[ 'db' ] = $this->Routes->getDbchannelElementNameByDbhouseId( $db );
        $pl_id = $this->Routes->getProductLinesOfDBhouse( $dbhouse_id );
        foreach ( $pl_id as $product_line_id ) {
            $data[ 'pl' ][] = $this->Routes->get_tbld_sku_hierarchy_elements_by_id( $product_line_id[ 'product_line_id' ] );
        }

        echo json_encode( $data );
    }

    public function route_update ( $id )
    {
        $delete_route = $this->Routes->delete_route_by_id( $id );
        $delete_route_outlet = $this->Routes->delete_route_outlet_mapping_by_id( $id );
        $delete_route = $this->Routes->delete_route_market_mapping_by_id( $id );

        $this->createRouteWithExistingId($id);
        /*
        $code_rt = $this->input->post('dbhouse_code');
        $num_rt = $this->input->post('rt_number');
        $outlets = $this->input->post('outlets');
        $route_code = "RT" . $code_rt . $num_rt;
        $route_last_modification_date = date('Y-m-d');
        $data = array(
            'route_name' => $this->input->post('route_name'),
            'route_code' => $route_code,
            'route_description' => $this->input->post('route_description'),
            'route_status_id' => 1,
            'route_last_modification_date' => $route_last_modification_date,
            'route_description' => $this->input->post('route_description'),
            'dbhouse_id' => $this->input->post('dbhouse')
        );
        $update = $this->Routes->update_route($id,$data);
        $delete = $this->Routes->delete_route_outlet_mapping_by_id($id);
        if ($delete) {
                for ($i = 0; $i < count($outlets); $i++) {
                    $data1 = array(
                        'route_id' => $id,
                        'outlet_id' => $outlets[$i],
                        'sequence_no' => $i + 1,
                        'route_relation_status_id' => 1
                    );
//                    echo "<pre>";
//                    print_r($data1);
//                    echo "</pre>";
                    $insert1 = $this->Routes->insertRouteOutletMapping($data1);
                }
            }
        redirect(site_url('route'));
    */
    }


    public function createRouteWithExistingId($id){


        $mkt = $this->input->post( 'mkt' );
        $outlets = $this->input->post( 'outlets' );
        $route_creation_date = date( 'Y-m-d' );
        $data = array(
            'id' => $id,
            'route_name' => $this->input->post( 'route_name' ),
            'route_code' => $this->input->post( 'rt_number' ),
            'route_description' => $this->input->post( 'route_description' ),
            'route_class_id' => $this->input->post( 'route_class_id' ),
            'route_status_id' => 1,
            'route_creation_date' => $route_creation_date,
            'route_description' => $this->input->post( 'route_description' ),
            'dbhouse_id' => $this->input->post( 'dbhouse' )
        );
        $insert = $this->Routes->insertRoute( $data );

        if ( $insert ) {
            $route_id = $insert;

            for ($i = 0; $i < count($outlets); $i++) {
                $data1 = array(
                    'route_id' => $route_id,
                    'outlet_id' => $outlets[$i],
                    'sequence_no' => $i + 1,
                    'route_relation_status_id' => 1
                );
                $insert1 = $this->Routes->insertRouteOutletMapping($data1);
            }
            for ( $i = 0; $i < count( $mkt ); $i++ ) {
                $data2 = array(
                    'route_id' => $route_id,
                    'mkt_id' => $mkt[ $i ]
                );
                $insert2 = $this->Routes->insertRouteMarketMapping( $data2 );
            }

            redirect( site_url( 'route' ) );
        }
    }



    public function add_route()
    {

        $mkt = $this->input->post( 'mkt' );
        $outlets = $this->input->post( 'outlets' );
        $route_creation_date = date( 'Y-m-d' );
        $data = array(
            'route_name' => $this->input->post( 'route_name' ),
            'route_code' => $this->input->post( 'route_code' ),
            'route_description' => $this->input->post( 'route_description' ),
            'route_class_id' => $this->input->post( 'route_class_id' ),
            'route_status_id' => 1,
            'route_creation_date' => $route_creation_date,
            'route_description' => $this->input->post( 'route_description' ),
            'dbhouse_id' => $this->input->post( 'dbhouse' )
        );
        $insert = $this->Routes->insertRoute( $data );
        if ( $insert ) {
            $route_id = $insert;
            
                for ($i = 0; $i < count($outlets); $i++) {
                    $data1 = array(
                        'route_id' => $route_id,
                        'outlet_id' => $outlets[$i],
                        'sequence_no' => $i + 1,
                        'route_relation_status_id' => 1
                    );
                    $insert1 = $this->Routes->insertRouteOutletMapping($data1);
                }
            for ( $i = 0; $i < count( $mkt ); $i++ ) {
                $data2 = array(
                    'route_id' => $route_id,
                    'mkt_id' => $mkt[ $i ]
                );
                $insert2 = $this->Routes->insertRouteMarketMapping( $data2 );
            }

            redirect( site_url( 'route' ) );
        }
    }


    function routePlanByDbFilter(){
        $emp_type = $this->session->userdata('emp_type');
        $user_role_code = $this->session->userdata('user_role_code');

        if($emp_type=='sales' && $user_role_code !='MIS'){
            $biz_zone_id = $this->session->userdata('biz_zone_id');
            $dbhouse = $this->Route_plans->getDbByBizZoneId($biz_zone_id);
        }else if($emp_type=='distribution'){
            $db_id = $this->session->userdata('db_id');
            $dbhouse = $this->Route_plans->select_db_house_specfic_db_id($db_id);
        }else{
            $dbhouse = $this->Route_plans->select_db_house();
        }
        return $dbhouse;
    }

    public function route_edit ( $id )
    {
        $data[ 'route' ] = $this->Routes->select_route_by_id( $id );

       // $data[ 'dbhouse' ] = $this->Routes->select_db_house();
        $data['dbhouse'] = $this->routePlanByDbFilter();

        $data[ 'outlets_in_rt' ] = $this->Routes->getAllOutletIds( $id );
        foreach ( $data[ 'outlets_in_rt' ] as $key ) {
            $parent_mkts_q = $this->Routes->getMarketIdByOutletId( $key[ 'outlet_id' ] );
            foreach ( $parent_mkts_q as $q ) {
                $parent_mkts[] = $q[ 'parent_id' ];
            }
        }

        foreach ( $data[ 'route' ] as $key ) {
            $db = $key[ 'dbhouse_id' ];
            $db1[] = $key[ 'dbhouse_id' ];
        }

        $data[ 'mkts_in_rt' ] = $this->Routes->getDbchannelElementNameByDbhouseId( $db1 );

        $data[ 'parent_mkts' ] = array_unique( $parent_mkts );

        $market_ids = implode(',',$data['parent_mkts']);


        //$data[ 'outlets' ] = $this->Routes->getAllOutletInDBhouse( $db );
        $data[ 'outlets' ] = $this->Routes->getAllOutletByParentId( $market_ids );
        $outlet_map = $this->Routes->mappings_route();
        foreach ( $outlet_map as $outlet_maps ) {
            $data[ 'mappings_name' ] = $this->Routes->mappings_name( $outlet_maps );
        }
        $this->load->view( 'route/route_builder_edit', $data );
    }

    public function route_delete ( $id )
    {
        $del = $this->Routes->delete_route_by_id( $id );
        redirect( site_url( 'route/index' ) );
    }
    
    
    public function getMarketByDb(){
        $db_id = $this->input->post('db_id');
        $market = $this->Routes->getMarketByDb($db_id);
        echo json_encode($market);
    }
    public function getOutletByMarket(){
        $market_id = implode(',', $this->input->post('market_id'));
        $outlet = $this->Routes->getOutletByMarket($market_id);
        echo json_encode($outlet);
        
    }

}
