<?php

if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Config extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->model( 'Configs' );
        $this->load->model('Promotion_m');
        $this->load->model('Promotion_builders');
    }
    
    public function priority_message()
    {
        $data['promo_macro_type_name'] = $this->Promotion_m->getAllPromo_macro_type_name();
        $data['business_zone'] = $this->Promotion_m->getAllBusinessZone();
        $data[ 'channel_layer_one' ] = $this->Promotion_m->getAllChannelLayer();
        $data['promotion_unit'] = $this->Promotion_m->getPromotionUnit();
        $this->load->view('priority_message/create_priority_message', $data);
    }
    
    public function create_market_tracking()
    {
        $data['get_compititors']=$this->Configs->getCompititors();
        $this->load->view('market_sight_tertiary_tracking/create', $data);
    }
    
    // tanvir start
    
    public function create_must_sell_dbh_wise_sku_program(){
        $data['get_dbhouse']=$this->Configs->getDBhouse();
        $this->load->view('must_sell_dbh_wise_sku_program/create', $data);
    }
    
    public function must_sell_dbh_wise_sku_program(){
        $title='Must Sell-Distribution House Wise SKU Program Index';
        $this->getTitle ($title);
        $data['mustSell'] = $this->Configs->getMustSellDBHWiseSKUPrograms();
        $this->load->view('must_sell_dbh_wise_sku_program/index', $data);
    }
    
    public function sku_select_by_DB_house()
    {
       $db_house=  $this->input->post('db_house');
       $data['get_sku']= $this->Configs->getSkuElementBydb_houseId($db_house);
       $this->load->view('must_sell_dbh_wise_sku_program/sku_select',$data);
    }
    
    public function add_must_sell_dbh_wise_sku_program(){


        $dt_frm = $this->input->post('date_frm');
        $start_date=  date("Y-m-d", strtotime($dt_frm)); 
        
        $dt_to = $this->input->post('date_to');
        $end_date=  date("Y-m-d", strtotime($dt_to));
        
        $db_house = $this->input->post('db_house');
        $sku_id = $this->input->post('sku_id');
        $checked = $this->input->post('checked');
        
            foreach ($sku_id as $key =>$value){
                if (is_null($checked[$key])){
                    $is_checked = 0;
                }  else {
                    $is_checked = $checked[$key];
                }
                $data = array(
                'db_id' =>$db_house,
                'sku_id' =>$value,
                'is_checked' =>$is_checked,
                'start_date' =>$start_date,
                'end_date' =>$end_date
                );
                $insert_id = $this->Configs->insert_tbl('tbli_must_sell_sku', $data);
            }
            redirect(site_url('config/must_sell_dbh_wise_sku_program'));
        
    }
    
    public function update_must_sell_dbh_wise_sku_program(){
               
        $dt_frm = $this->input->post('date_frm');
        $start_date=  date("Y-m-d", strtotime($dt_frm)); 
        
        $dt_to = $this->input->post('date_to');
        $end_date=  date("Y-m-d", strtotime($dt_to));
        
        $db_house = $this->input->post('db_id');
        $sku_id = $this->input->post('sku_id');
        $checked = $this->input->post('checked');
        
        
        $this->Configs->delete_must_sell_ByDBH($db_house);
        
            foreach ($sku_id as $key =>$value){
                if (is_null($checked[$key])){
                    $is_checked = 0;
                }  else {
                    $is_checked = $checked[$key];
                }
                $data = array(
                'db_id' =>$db_house,
                'sku_id' =>$value,
                'is_checked' =>$is_checked,
                'start_date' =>$start_date,
                'end_date' =>$end_date
                );
                $insert_id = $this->Configs->insert_tbl('tbli_must_sell_sku', $data);
            }
            redirect(site_url('config/must_sell_dbh_wise_sku_program'));
        
    }
    
    public function mustSellEditById($db_id){
        $data['must_sell'] = $this->Configs->getMust_Sell_By_DBH($db_id);
        $this->load->view('must_sell_dbh_wise_sku_program/edit',$data);
    }
    public function mustSellViewById($db_id){
        $data['must_sell'] = $this->Configs->getMust_Sell_By_DBH_View($db_id);
        $this->load->view('must_sell_dbh_wise_sku_program/view',$data);
    }
    
    public function mustSellDeleteById($db_id){
        $del = $this->Configs->delete_must_sell_ByDBH($db_id);
        redirect(site_url('config/must_sell_dbh_wise_sku_program'));
    }

    // tanvir end
    public function createProductFss()
    {
        $data['sku_hierarchy'] = $this->Configs->getSkuHierarchy();
        $this->load->view('product_fss/create', $data);
    }
    
    public function createChannelWiseProgram()
    {
        $data['outlet_channels']=$this->Configs->getOutletChannels();
        $data['sku_hierarchy']=$this->Configs->getSkuHierarchy();
        $this->load->view('channelwiseprogram/create', $data);
    }
    
    
    public function getSkuElementByCompany()
    {
        $company=  $this->input->post('company');
        $skus=  $this->Configs->getSkuElementByCompanyId($company);
        echo '<option></option>';
        foreach($skus as $k=>$v){
            echo '<option value="'.$v['id'].'">'.$v['element_name'].'</option>';
        }
    }
    
    
    public function sku_select()
    {
       $sku=  $this->input->post('sku');
       $company_id=  $this->input->post('company_id');
       $data['get_sku']=$this->Configs->getSkutoSelect($sku,$company_id);
       $this->load->view('market_sight_tertiary_tracking/sku_select',$data);
    }
    
    public function sku_select_by_hierarchy()
    {
       $sku_hierarchy=  $this->input->post('sku_hierarchy');
       $data['get_sku']=$this->Configs->getSkuByHierarchy($sku_hierarchy);
       $this->load->view('channelwiseprogram/sku_select',$data);
    }
    
    public function get_sku_by_hierarchy()
    {
       $sku=  $this->input->post('sku');
       $data['get_sku']=$this->Configs->getSkuByHierarchy($sku);
       
       $this->load->view('product_fss/select_sku',$data);
    }
    
    public function priority_message_index()
    {
         $title='Priority Message';
        $this->getTitle ($title);
        $data['messages'] = $this->Configs->getPriorityMessages();
        $this->load->view('priority_message/priority_message_index', $data);
    }
      public function getTitle ($title)
    {
        $data['title']=$title;
        $this->load->view( 'header/header', $data );
    }
    
    public function viewChannelWiseProgram()
    {
        $title='PoS-Outlet Channel Wise SKU Program Index';
        $this->getTitle ($title);
        $data['channelwise_program'] = $this->Configs->getChannelWiseProgram();
        $this->load->view('channelwiseprogram/view', $data);
    }
    
    public function market_tracking_index()
    {
         $title='Market Insight Tertiary Tracking Program Index';
        $this->getTitle ($title);
        $data['programs'] = $this->Configs->getMarketTrackingPrograms();
        $this->load->view('market_sight_tertiary_tracking/view', $data);
    }
    
    public function viewProductFss()
    {
        $title='Product FSS Index';
        $this->getTitle ($title);
        $data['product_fss'] = $this->Configs->getProductFss();
        $this->load->view('product_fss/view', $data);
    }
    
    public function addProductFss()
    {
        $product_fss=$this->input->post('product_fss');
        $description=$this->input->post('description');
        $status=$this->input->post('status');
        $sku=$this->input->post('sku');
        $sku_id=$this->input->post('sku_id');
        $share_space=$this->input->post('share_space');
        
        $dt_frm = $this->input->post('date_frm');
        $start_date=  date("Y-m-d", strtotime($dt_frm)); 
        
        $dt_to = $this->input->post('date_to');
        $end_date=  date("Y-m-d", strtotime($dt_to));
        
        $data = array(
            'name' =>$product_fss,
            'description' =>$description,
            'start_date' =>$start_date,
            'end_date' =>$end_date,
            'status' =>$status
        );
        
        $insert_id = $this->Configs->insert_tbl('tbld_product_fss', $data);
        
        
        foreach ($sku_id as $key =>$value)
        {
            if($share_space[$key] != '')
            {
            $data_1 = array(
                'product_fss_id' =>$insert_id,
                'product_hierarchy_id' =>$sku_id[$key],
                'share_space' =>$share_space[$key]
            );
           $this->Configs->insert_tbl('tbld_product_fss_details', $data_1); 
            }
        }
   
        redirect(site_url('config/viewProductFss'));
    }

    public function addChannelWiseProgram()
    {
        $outlet_channel=$this->input->post('outlet_channel');
        $min_sku=$this->input->post('min_sku');
        $point_count=$this->input->post('point_count');
        $sku_id=$this->input->post('sku_id');
        $status=$this->input->post('status');
        
        $dt_frm = $this->input->post('date_frm');
        $start_date=  date("Y-m-d", strtotime($dt_frm)); 
        
        $dt_to = $this->input->post('date_to');
        $end_date=  date("Y-m-d", strtotime($dt_to));
        
        $sku_hierarchy=$this->input->post('sku_hierarchy');
        
        $data = array(
            'outlet_channel_id' =>$outlet_channel,
            'min_sku_qty' =>$min_sku,
            'point_count' =>$point_count,
            'start_date' =>$start_date,
            'end_date' =>$end_date,
            'status' =>$status
        );
        
        $insert_id = $this->Configs->insert_tbl('tbli_outlet_channel_wise_point_count', $data);
        
        
        foreach ($sku_id as $key =>$value)
        {
            $data_1 = array(
                'sku_id' =>$sku_id[$key],
                'outlet_channel_wise_point_count_id' =>$insert_id
            );
           $this->Configs->insert_tbl('tbli_outlet_channel_wise_sku_mapping', $data_1); 
        }
        redirect(site_url('config/viewChannelWiseProgram'));
        
    }


    public function add_market_tracking_program()
    {
        $program_name = $this->input->post('program_name');
        $status = $this->input->post('status');
        
        $dt_frm = $this->input->post('date_frm');
        $start_date=  date("Y-m-d", strtotime($dt_frm)); 
        
        $dt_to = $this->input->post('date_to');
        $end_date=  date("Y-m-d", strtotime($dt_to));
        
        $company = $this->input->post('company');
        $brand = $this->input->post('sku');
        $sku_id = $this->input->post('sku_id');
        
        $data = array(
            'name' =>$program_name,
            'company_id' =>$company,
            'start_date' =>$start_date,
            'end_date' =>$end_date,
            'status' =>$status
        );
        
        $insert_id = $this->Configs->insert_tbl('tbli_market_insight_tertiary_tracking_program', $data);
        
        foreach ($sku_id as $key =>$value)
        {
            $data_1 = array(
                'sku_id' =>$sku_id[$key],
                'market_insight_tertiary_track_id' =>$insert_id,
                'brand_id' =>$brand
            );
           $this->Configs->insert_tbl('tbli_market_insight_tertiary_sku_mapping', $data_1); 
        }
        redirect(site_url('config/market_tracking_index'));
    }

    public function add_message_done()
    {
//        print_r($_POST);
//        die();
        $priority_message = $this->input->post('priority_message');
        $status = $this->input->post('status');
        $description = $this->input->post('description');
        $outlet = $this->input->post('outlet');
        $mkt = $this->input->post('mkt');
        $dbhouse = $this->input->post('dbhouse');
        $business_zone = $this->input->post('business_zone_layer');
        
        $dt_frm = $this->input->post('date_frm');
        $date_frm=  date("Y-m-d", strtotime($dt_frm)); 
        
        $dt_to = $this->input->post('date_to');
        $date_to=  date("Y-m-d", strtotime($dt_to)); 
        
        $data=array(
            'name' =>$priority_message,
            'description' =>$description,
            'status' =>$status,
            'start_date' =>$date_frm,
            'end_date' =>$date_to
        );
        
        $insert_id = $this->Configs->insert_tbl('tbld_priority_message', $data);
        $limit = 1000;
        $offset = 0;
        
        if($outlet !=0){
           //specific outlet promotion
           
            for ($i = 0; $i < count($outlet); $i++) {
                if ($outlet[$i] != 0) {
                    $data_outlet = array('pri_mess_id' => $insert_id, 'outlet_id' => $outlet[$i]);
                    $insert_outlets = $this->Configs->insert_into_tbl($data_outlet, 'tbli_priority_message_outlet_mapping');
                }
            }
            //end
            
       }elseif($mkt !=0){
           //marketwise outlet promotion            
            for ($i = 0; $i < count($mkt); $i++) {
                $outlets = $this->Configs->getOutletByMarketId($mkt[$i]);
                foreach ($outlets as $o) {
                    $data_outlet = array('pri_mess_id' => $insert_id, 'outlet_id' => $o['id']);
                    $insert_outlets = $this->Configs->insert_into_tbl($data_outlet, 'tbli_priority_message_outlet_mapping');
                }
            }
            //end
            
       }elseif($dbhouse !=0){
           //dbhousewise outlet promotion           
            for ($i = 0; $i < count($dbhouse); $i++) {
                $outlets = $this->Configs->getAllOutletInDBhouse($dbhouse[$i]);
                foreach ($outlets as $o) {
                    $data_outlet = array('pri_mess_id' => $insert_id, 'outlet_id' => $o['id']);
                    $insert_outlets = $this->Configs->insert_into_tbl($data_outlet, 'tbli_priority_message_outlet_mapping');
                }
            }
            //end            
       }elseif($business_zone !=0){
            //natinoalwise outlet promotion
            $outlet_count = $this->Configs->getOutletCount();
            $count_outlet = $outlet_count[0]['count'];            
            for ($i = 0; $i < $outlet_count[0]['count']; $i += $limit) {
                $outlets = $this->Configs->all_outlet_lists_limit($limit, $offset);
                $count_outlet -= $limit;
                if ($count_outlet < 0) {
                    $i -= $limit;
                    $count_outlet += $limit * 2;
                }
                foreach ($outlets as $o) {
                    $data_outlet = array('pri_mess_id' => $insert_id, 'outlet_id' => $o['id']);
                    $insert_outlets = $this->Configs->insert_into_tbl($data_outlet, 'tbli_priority_message_outlet_mapping');
                }
                $offset = $offset + $limit;
            } 
            //end            
       }
       redirect(site_url('config/priority_message_index'));
    }

}