<?php

class Distribution_channel extends CI_Controller {
    public function __construct() {
        parent::__construct();
       
        
        $this->load->model('distribution_channels');
        $this->load->model('Configs');
        $this->load->model('audit_logs');
        $this->load->helper('tree_data_functions_helper');
        $this->load->library('pagination');
    }

/*
 *  Start DB channel Hierarchy /
 */        
    public function dbChannelHierarchyIndex(){
        $data['distribution_channel'] = $this->distribution_channels->getAllDistributionChannels();
        $this->load->view('distribution_channel/db_channel_hierarchy/db_channel_hierarchy_index', $data);
    }
    
    public function dbChannelHierarchyLogData(){
        
       $data['db_channel_hierarchy_log_data'] = $this->audit_logs->getAuditData();        
       $this->load->view('distribution_channel/db_channel_hierarchy/db_channel_hierarchy_log_data',$data);
 
    }
    public function dbChannelHierarchyLogDataDetails(){
       $id = $_POST ['id'];
       $data= $this->audit_logs->getAuditDataById($id);
       echo json_encode($data);      
    }

    public function createDbChannelHierarchy(){
        $data['distribution_channel'] = $this->distribution_channels->getAllDistributionChannels();
        $this->load->view('distribution_channel/db_channel_hierarchy/db_channel_hierarchy_create', $data);
    }
    public function saveDbChannelHierarchy(){
        $name = $this->input->post('name');
        $code = str_replace(" ", "_", $this->input->post('code'));
        $description = $this->input->post('description');
        $parent_layer = $this->input->post('parent_layer');

        $data = array(
            'distribution_channel_name' => $name,
            'distribution_channel_code' => $code,
            'distribution_channel_description' => $description,
            'parent_channel_id' => $parent_layer
        );
       $insert = $this->distribution_channels->insertDistributionChannelHierarchy($data);
        
        /*Code for the audit log
        
        
//        echo'<pre/>';
//        print_r($parent_layer_name_insert);
//        die();
//        $parent_layer_name= json_encode($parent_layer_name_insert);
//        
    
        $status = 'Save';
        $object_name= 'Distribution Channel Hierarchy';        
        
        $previous_data['distribution_channel_name'] = null;
        $previous_data['distribution_channel_code'] = null;
        $previous_data['distribution_channel_description'] = null;
        $previous_data['parent_channel_id'] = null;
        
        $existing_data = array();
        
        $parent_layer_name =  $this->distribution_channels->getDistributionChannelNameByParentLayerId($parent_layer);

        $existing_data['current']['distribution_channel_name'] =$name;
        $existing_data['current']['distribution_channel_code'] =$code;
        $existing_data['current']['distribution_channel_description'] =$description;
        $existing_data['current']['parent_channel_id'] =$parent_layer_name[0]['distribution_channel_name']; //$parent_layer
        
        
        $existing_data['existing']['distribution_channel_name'] = $previous_data['distribution_channel_name'];
        $existing_data['existing']['distribution_channel_code'] = $previous_data['distribution_channel_code'];
        $existing_data['existing']['distribution_channel_description'] = $previous_data['distribution_channel_description'];
        $existing_data['existing']['parent_channel_id'] = $previous_data['parent_channel_id'];
        
        $this->load->library('../controllers/audit_log');
        $this->audit_log->AuditData($existing_data, $status ,$object_name);        
      
        
        /*Code for the audit log*/
        
        if ($insert){
            $get_data = $this->distribution_channels->getDistChannelHierarchyIdByCode($code);          
            foreach ($get_data as $dist_channel_id) {
                $res = tree_data('tree_distribution_channel_hierarchy', 'dist_channel_id', $dist_channel_id['id'], $parent_layer, 'below');
            }
            redirect(site_url('distribution_channel/dbChannelHierarchyIndex'));
        }
    }
    public function distributionChannelEditById($id){        
        $data['distribution_channel_info_by_id'] = $this->distribution_channels->getDistributionChannelById($id);
        
        $data['distribution_channel'] = $this->distribution_channels->getAllDistributionChannels();  
        $this->load->view('distribution_channel/db_channel_hierarchy/db_channel_hierarchy_edit', $data);
        
    }
    public function distributionChannelUpdateById($id){ 
        
        $previous_data = $this->distribution_channels->getDistributionChannelById($id);
        
        $name = $this->input->post('name');
        $code = str_replace(" ", "_", $this->input->post('code'));
        $description = $this->input->post('description');
        $parent_layer = $this->input->post('parent_layer');
     
        $data = array(
            'distribution_channel_name' => $name,
            'distribution_channel_code' => $code,
            'distribution_channel_description' => $description,
            'parent_channel_id' => $parent_layer
        );
        $update = $this->distribution_channels->updateDistributionChannelHierarchyById($data,$id);  
        
        /*Code Audit Log Table
        
        $status = 'Update';
        $object_name= 'Distribution Channel Hierarchy';              
        
        $existing_data = array();
        
        $existing_data['current']['distribution_channel_name'] =$name;
        $existing_data['current']['distribution_channel_code'] =$code;
        $existing_data['current']['distribution_channel_description'] =$description;
        $existing_data['current']['parent_channel_id'] =$parent_layer;
        
        
        $existing_data['existing']['distribution_channel_name'] = $previous_data[0]['distribution_channel_name'];
        $existing_data['existing']['distribution_channel_code'] = $previous_data[0]['distribution_channel_code'];
        $existing_data['existing']['distribution_channel_description'] = $previous_data[0]['distribution_channel_description'];
        $existing_data['existing']['parent_channel_id'] = $previous_data[0]['parent_channel_id'];
        
        $a1=$existing_data['current'];
        $a2=$existing_data['existing'];
        
        if($id !=''){
            $existing_data['current'] = array_diff_assoc($a1, $a2);
            $existing_data['existing'] = array_diff_assoc($a2, $a1);
        }
        
        $this->load->library('../controllers/audit_log');
        $this->audit_log->AuditData($existing_data, $status ,$object_name);
        
        /*Code Audit Log Table*/
        
        if ($update) {            
            redirect(site_url('distribution_channel/dbChannelHierarchyIndex'));
        }
        
    }    
    public function distributionChannelDeleteById($id){
        
        $previous_data = $this->distribution_channels->getDistributionChannelById($id);
        
        $delete = $this->distribution_channels->deleteDistributionChannelHierarchyById($id);
        
        /*audit Log Table
        $status = 'Delete';
        $object_name= 'Distribution Channel Hierarchy';     
        
        $existing_data = array();
        
        $existing_data['current']['distribution_channel_name'] = null ;
        $existing_data['current']['distribution_channel_code'] = null;
        $existing_data['current']['distribution_channel_description'] = null;
        $existing_data['current']['parent_channel_id'] = null;
        
        
        $existing_data['existing']['distribution_channel_name'] = $previous_data[0]['distribution_channel_name'];
        $existing_data['existing']['distribution_channel_code'] = $previous_data[0]['distribution_channel_code'];
        $existing_data['existing']['distribution_channel_description'] = $previous_data[0]['distribution_channel_description'];
        $existing_data['existing']['parent_channel_id'] = $previous_data[0]['parent_channel_id'];
        
        $this->load->library('../controllers/audit_log');
        $this->audit_log->AuditData($existing_data, $status ,$object_name);
        
        /*audit Log Table*/
        
        if ($delete) {            
            redirect(site_url('distribution_channel/dbChannelHierarchyIndex'));
        }
    }
    

/*
 *  End DB channel Hierarchy /
 */    
    
    
/*
 *  Start DB channel Hierarchy Elements/
 */
       //Start filter Business Zone
    
    
        public function load(){
            $type = $this->input->post('type');
            $target = $this->input->post('target');
            if ($type == 'geography') {
                $data['frst_layer'] = $this->distribution_channels->getAllBusinessZone();
                $data['frst_layer_index'] = 'biz_zone_category_name';
                $data['type'] = $type;
                $data['target'] = $target;
                $data['filter_text_main'] = 'Business Area Layer';
                $data['filter_text_secondary'] = 'Business Area';
                $this->load->view('distribution_channel/db_channel_hierarchy_element/dynamic_filter_2_layers', $data);
            }
        }
        public function filter_layer1() {
            $type = $this->input->post('type');
            if ($type == 'geography') {
                $arr = array();
                $biz_zone_layer = $this->input->post('id');
                $biz_zone = $this->distribution_channels->getAllBizZoneNamesById($biz_zone_layer);
                foreach ($biz_zone as $biz) {
                    $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => 'Business Zone');
                }
                echo json_encode($arr);
            }
        }
        public function filter_layer2() {
            $type = $this->input->post('type');
            if ($type == 'geography') {
                $arr = array();
                $biz_zone_layer = $this->input->post('id');
                $biz_zone = $this->distribution_channels->getAllBusinessZonesChildren($biz_zone_layer);
                foreach ($biz_zone as $biz) {
                    $arr[] = array('id' => $biz['id'], 'name' => $biz['biz_zone_name'], 'text' => 'Business Zone');
                }
                echo json_encode($arr);
            }
        }
        public function getParentsAndChildren(){
            $category_id = $this->input->post('category_id');
            $db_id = $this->input->post('db_id');
//            $elements_parents = array();
//            $elements_children = array();
//
//            $parent_layer = $this->distribution_channels->getParentId('tbld_distribution_channel_hierarchy', 'parent_channel_id', 'distribution_channel_name', $category_id);
//            foreach ($parent_layer as $parent_layers) {
//                $elements_parents[] = $this->distribution_channels->getDbChannelElementNameByCategoryId($parent_layers['id']);
//            }
//            $child_layer = $this->distribution_channels->getChildId('tbld_distribution_channel_hierarchy', 'distribution_channel_name', 'parent_channel_id', $category_id);
//            foreach ($child_layer as $child_layers) {         
//                $elements_children[] = $this->distribution_channels->getDbChannelElementNameByCategoryId($child_layers['id']);         
//
//            }
//            if (count($elements_children) == 0) {
//                $elements_children[] = $this->distribution_channels->getAllNoParentOutlets();
//            }
//            $elements = array('element_parents' => $elements_parents, 'element_children' => $elements_children);
//            echo json_encode($elements);
            
            $elements = $this->distribution_channels->getRouteList($db_id);
            echo json_encode($elements);
        }
        
        
        
        public function getDbhouseById() {
            $biz_zone_id = $this->input->post('id');        
            $dbhouse = $this->distribution_channels->selectDbHouseByBizZone($biz_zone_id);
            foreach ($dbhouse as $db) {
                $dbhouse_name = $this->distribution_channels->selectDbhouseNameById($db['dbhouse_id']);
                foreach($dbhouse_name as $dbh){
                    $dbhouse_names[]=array('id'=>$dbh['id'],'name'=>$dbh['db_point']);
                }
            }
            echo json_encode($dbhouse_names);
        }
        public function getDbChannelById() {
            $biz_zone_id = $this->input->post('id');        
            $dist_channel_element = $this->distribution_channels->getDistributionChannelByBizZoneId($biz_zone_id);
            foreach ($dist_channel_element as $element) {
                    $elem_names[]=array('id'=>$element['id'],'name'=>$element['db_channel_element_name']);

            }
            echo json_encode($elem_names);
        }
        
      //end filter Business Zone  
    
    
    public function dbChannelHierarchyElementIndex(){
//        $search = $this->input->post('searchterm');
//        $data['searchterm']=$search;
//        $data['base']=$this->config->item('base_url');
//	    $config['base_url'] = $data['base'].'distribution_channel/dbChannelHierarchyElementIndex/';
//	    $config['per_page'] = 25;
//	    $config['num_links'] = 3;
//        $config['uri_segment'] = 3;
//	    $config['full_tag_open'] = '<div style="text-align: center;">';
//	    $config['full_tag_close'] = '</div>';
//        $config['total_rows'] = $this->distribution_channels->total($search);
//        $data['distribution_channel_elements'] = $this->distribution_channels->getAllDistributionChannelElements($config['per_page'], $this->uri->segment(3),$search);
//        $this->pagination->initialize($config);
        $this->load->view('distribution_channel/db_channel_hierarchy_element/db_channel_hierarchy_element_index');
    }

    public function getFilterData(){

        $db_id = $this->input->post('db_id');
        $db_ids = implode(',', $db_id);
        $data['result'] = $this->distribution_channels->getFilterData($db_ids);
        $this->load->view('distribution_channel/db_channel_hierarchy_element/filter_data',$data);
    }
    public function createDbChannelHierarchyElement(){
        $data['business_zone'] = $this->distribution_channels->getBusinessZone();
        $data['distribution_channel'] = $this->distribution_channels->getAllDistributionChannels();
        $this->load->view('distribution_channel/db_channel_hierarchy_element/db_channel_hierarchy_element_create', $data);
    }
    public function savedbChannelHierarchyElement() {
//        echo '<pre>';
//        print_r($_POST);
//        die();
        $name = $this->input->post('name');
        $code = str_replace(" ", "_", $this->input->post('code'));
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $parent_layer = $this->input->post('parent_layer');
        $business_zone_id = $this->input->post('business_zone_id');
        $distribution_house_id = $this->input->post('distribution_house_id');
        
        $data = array(
            'db_channel_element_name' => $name,
            'db_channel_element_code' => $code,
            'db_channel_element_description' => $description,
            'db_channel_element_category_id' => $category,
            'db_channel_parent_element_id' => $parent_layer,
            'biz_zone_id' => $business_zone_id,
            'db_id' => $distribution_house_id
        );        
        $insert_id = $this->distribution_channels->insertDistributionChannelElements($data);
        $res = tree_data('tree_db_channel_hierarchy_elements', 'db_channel_hierarchy_element_id', $insert_id, $parent_layer, 'below');
        redirect(site_url('distribution_channel/dbChannelHierarchyElementIndex'));
    }
    public function channelHierarchyElementEditById($id){
        $business_zone = $this->Configs->selectConfigParam('dbhouse_biz_zone_layer_map');
        $biz_zone_names = 0;
        $biz_zone_id = $biz_zone_names[0]['attribute_id'];
        $data['db_houses'] = $this->distribution_channels->getAllDbHouses();
        $data['business_zone'] = $this->distribution_channels->getBusinessZone();
        $data['distribution_channel'] = $this->distribution_channels->getAllDistributionChannels();
        $data['territory_name'] = $this->distribution_channels->getAllTerritory();
        $data['distribution_channel_elements'] = $this->distribution_channels->getDistributionChannelElementsById($id);
        $this->load->view('distribution_channel/db_channel_hierarchy_element/db_channel_hierarchy_element_edit',$data);
    }
    public function channelHierarchyElementUpdateById($id){      

        $name = $this->input->post('name');
        $code = str_replace(" ", "_", $this->input->post('code'));
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $parent_layer = $this->input->post('parent_layer');
        $biz_zone_id = $this->input->post('biz_zone_id');

        $data = array(
            'db_channel_element_name' => $name,
            'db_channel_element_code' => $code,
            'db_channel_element_description' => $description,
            'db_channel_element_category_id' => $category,
            'db_channel_parent_element_id' => $parent_layer,
            'biz_zone_id' => $biz_zone_id
        );        
        $update = $this->distribution_channels->updateDistributionChannelElementsById($id,$data);
        if($update){
        $res = tree_data('tree_db_channel_hierarchy_elements', 'db_channel_hierarchy_element_id', $id, $parent_layer, 'below');
        redirect(site_url('distribution_channel/dbChannelHierarchyElementIndex'));
        }
       
    }
    public function channelHierarchyElementDeleteById($id){
        $del = $this->distribution_channels->deleteDistributionChannelElementById($id);
        if($del){
        redirect(site_url('distribution_channel/dbChannelHierarchyElementIndex'));
        }
    }
    


/*
 *  End DB channel Hierarchy Elements/
 */    







    /*
public function dbChannelHierarchy() {
        $data['distribution_channel'] = $this->Distribution_channels->getAllDistribution_channels();
        $this->load->view('distribution_channel/index_db_channel_hierarchy', $data);
    }
    
    
    public function get_search_data(){
        $search = $this->input->post('search');
        $data['distribution_channel_elements'] = $this->Distribution_channels->get_distribution_channel_elements_by_search($search);
        $this->load->view('distribution_channel/search_data', $data);
    }

    
    
    

    public function add_db_channel_element() {
//        $data['distribution_channel_elements'] = $this->Distribution_channels->getAllDistributionChannelElements();
        $data['distribution_channel'] = $this->Distribution_channels->getAllDistribution_channels();
        $this->load->view('distribution_channel/add_db_channel_elements', $data);
    }

    

    

    

    

    public function getDbChannelParentName($parent_id) {
        $data = $this->Distribution_channels->getDbchannelElementNameById($parent_id);
        return $data;
    }

    

     * 
     *      */
}
