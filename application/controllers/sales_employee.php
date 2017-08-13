<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_employee extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Sales_employees');

        $this->method_call = & get_instance();
        $this->load->helper('tree_data_functions');
    }

    public function sales_emp_index() {
        $data['sales_emp'] = $this->Sales_employees->getAllSalesEmp();
        $this->load->view('sales_employee/sales_emp_index', $data);
    }

    public function sales_emp_index_edit($id)
    {
        $data['geo_layer'] = $this->Sales_employees->getGeoLayer();

        $data['sales_emp'] = $this->Sales_employees->get_tbld_sales_employee_by_id($id);
        
        $data['sales_role'] = $this->Sales_employees->getAll_sales_hierarchys();
        
        $data['user_id'] = $this->Sales_employees->getAllUser();
        
        $data['manager_id'] = $this->Sales_employees->getAllSalesEmp();
        $biz_zone_id = $data['sales_emp'][0]['biz_zone_id'];
        $data['biz_zone']= $this->Sales_employees->getBizZone($biz_zone_id);
        $data['biz_zone_element'] = $this->Sales_employees->getBizZoneElement($biz_zone_id);
        $this->load->view('sales_employee/sales_emp_index_edit', $data);
    }
    public function sales_emp_index_edit_done($id)
    {
        $data=array();
        $data['sales_emp_code']=$this->input->post('sales_emp_code', true);
        $data['first_name']=$this->input->post('first_name', true);
        $data['middle_name']='';
        $data['last_name']=$this->input->post('last_name', true);
        $data['sales_emp_address']=$this->input->post('address', true);
        
        $data['sales_role_id']=$this->input->post('sales_role_id', true);
        $data['login_user_id']=$this->input->post('login_user_id', true);
        $data['sales_manager_id']=$this->input->post('manager_id', true);
        $data['biz_zone_id']=$this->input->post('business_zone_element');
       
        $this->Sales_employees->Save_edited_info($data, $id);
        
            redirect(site_url('sales_employee/sales_emp_index'));
        
            
        
    }

    public function get_address_by_id($id)
    {
        $data = $this->Sales_employees->get_address_by_id($id);
        return $data;
    }
    
    public function getManager()
    {
        $sales_role_id = $this->input->post('sales_role_id');

        $managers = $this->Sales_employees->getManagers($sales_role_id);
        
        echo '<option></option>';
        foreach($managers as $k => $v){
            echo '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
        }
    }

    public function create_sales_emp() {

        $data['geo_layer'] = $this->Sales_employees->getGeoLayer();

        //$data['address'] = $this->Sales_employees->getAllAddressNames();

        $data['sales_role_id'] = $this->Sales_employees->getAll_sales_hierarchys();
        $data['user_id'] = $this->Sales_employees->getUnUsedUserList();
        $this->load->view('sales_employee/create_sales_emp', $data);
    }

    public function getEmpAddressById($id) {
        $address = $this->Sales_employees->Get_address_names($id);
        return $address;
    }
    
    public function getSalesEmpNameById($id) {
        $address = $this->Sales_employees->getSalesEmpNameById($id);
        return $address;
    }
    
    public function getEmpRoleById($id) {
        $role = $this->Sales_employees->getHierarchyNameById($id);
        return $role;
    }
    
    public function getUserById($user_id) {
        $user = $this->Sales_employees->getUserIdById($user_id);
        return $user;
    }

    public function getRoleParents() {
        $role_id = $this->input->post('id');
        $parents = tree_get_all_parents('tree_distribution_hierarchy', 'distribution_hierarchy_id', $role_id);
        foreach ($parents as $ids) {
            $names = $this->Sales_employees->getDistEmpNameById($ids[0]);
        }
        echo json_encode($names);
    }

    public function getGeoLayerElement() {
        $business_zone_id = $this->input->post('business_zone');
        $busines_zone = $this->Sales_employees->getGeoLayerElement($business_zone_id);
        $html = "<option></option>";
        foreach($busines_zone as $v){
            $html .='<option value="'.$v['id'].'">'.$v['name'].'</option>';
        }
        echo $html;
    }

    public function add_sales_emp() {

        $emp_code = $this->input->post('sales_emp_code');
        $manager = $this->input->post('manager_id');

        $data = array(
            'sales_emp_code' => $emp_code,
            'first_name' => $this->input->post('first_name'),
            'middle_name' => $this->input->post('middle_name'),
            'last_name' => $this->input->post('last_name'),
            'sales_emp_address' => $this->input->post('address'),
            'sales_role_id' => $this->input->post('sales_role_id'),
            'login_user_id' => $this->input->post('login_user_id'),
            'sales_manager_id ' => $manager,
            'biz_zone_id' => $this->input->post('business_zone_element')
        );

        $insert = $this->Sales_employees->insert_sales_employee($data);
        if ($insert) {
            redirect(site_url('sales_employee/sales_emp_index'));
        }
    }

    public function sales_emp_index_delete($id)
    {
        $del = $this->Sales_employees->delete_tbld_sales_employee_by_id($id);
        if($del){
        redirect(site_url('sales_employee/sales_emp_index'));
        }
    }
    
    public function getParents() {
        $id = $this->input->post('id');
//        echo $id;
        $layer = $this->Sales_employees->getParentId('tbld_sales_hierarchy','parent_role_id','sales_role_name',$id);
        foreach($layer as $parent_layer){
            $elements[] = $this->Sales_employees->getSalesEmpByRole($parent_layer['id']);
        }
        echo json_encode($elements);
    }

}
