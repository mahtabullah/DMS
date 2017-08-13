<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Skus');
        $this->load->model('Configs');
        $this->load->model('Bundle_prices');
        $this->load->helper('tree_data_functions_helper');
    }
    /**
     * sku Hierarchy start
     */

    // sku Hierarchy Index Page Open Function//
    public function skuHierarchyIndex()
    {
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();
        $this->load->view('sku/sku_hierarchy/sku_hierarchy_index', $data);
    }

    //Sku Hierarchy Create Page Open Function//
    public function createSkuHierarchy()
    {
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();
        $this->load->view('sku/sku_hierarchy/sku_hierarchy_create', $data);
    }

    //Sku Hierarchy Save Function //
    public function saveSkuHierarchy()
    {
        $name = $this->input->post('name');
        $hierarchy_code = $this->input->post('code');
        $description = $this->input->post('description');
        $parent_layer = $this->input->post('parent_layer');

        $data = array(
            'layer_name' => $name,
            'layer_code' => $hierarchy_code,
            'layer_description' => $description,
            'parent_layer_id' => $parent_layer
        );
        $insert = $this->Skus->insertIntoTbl('tbld_sku_hierarchy', $data);
        if ($insert) {
            $get_data = $this->Skus->getSkuLayerIdByCode($hierarchy_code);
            foreach ($get_data as $layer_id) {
                $res = tree_data('tree_sku_hierarchy', 'sku_hierarchy_id', $layer_id['id'], $parent_layer, 'below');
            }
            redirect(site_url('sku/skuHierarchyIndex'));
        }
    }

    //Sku Hierarchy  Individual Edit Function //
    public function skuHierarchyEditById($hierarchy_id)
    {
        $data['sku_hierarchy_data_by_id'] = $this->Skus->getTbldSkuHierarchyById($hierarchy_id);
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();

        $this->load->view('sku/sku_hierarchy/sku_hierarchy_index_edit', $data);
    }
    
    public function skuHierarchyDetailById($hierarchy_id)
    {
        $data['sku_id']=$hierarchy_id;
        $data['sku_hierarchy_data_by_id'] = $this->Skus->getTbldSkuHierarchyById($hierarchy_id);
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();

        $this->load->view('sku/sku_hierarchy/sku_hierarchy_detail', $data);
    }

    //Sku Hierarchy  Individual Update Function //
    public function skuHierarchyUpdateById($hierarchy_id)
    {
        $data = array(
            'layer_name' => $this->input->post('name'),
            'layer_code' => $this->input->post('code'),
            'layer_description' => $this->input->post('description'),
            'parent_layer_id' => $this->input->post('parent_layer'),
        );
        $update = $this->Skus->updateTbldSkuHierarchyById($hierarchy_id, $data);
        if ($update) {
            redirect(site_url('sku/skuHierarchyIndex'));
        }
    }

    //Sku Hierarchy  Individual Delete Function //
    public function skuHierarchyDeleteById($hierarchy_id)
    {
        
        $del = $this->Skus->deleteTbldSkuHierarchyById($hierarchy_id);
        redirect(site_url('sku/skuHierarchyIndex'));
    }

    /**
     * sku Hierarchy end
     */

    /**
     * sku Hierarchy Element Start
     */
    public function skuHierarchyElementIndex()
    {
        $data['sku_hierarchy_elements'] = $this->Skus->getSkuHierarchyElements();
        //var_dump($data);
        $this->load->view('sku/sku_hierarchy_element/sku_hierarchy_element_index', $data);
    }

    public function createSkuHierarchyElement()
    {
        $data['sku_hierarchy_elements'] = $this->Skus->getSkuHierarchyElements();
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();
//        var_dump($data);
        $this->load->view('sku/sku_hierarchy_element/sku_hierarchy_element_create', $data);
    }

    public function saveSkuHierarchyElement()
    {
        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $description = $this->input->post('description');
        $sku_layer = $this->input->post('sku_layer');
        $parent_element = $this->input->post('parent_element');
        $rename_file = '';

        /**
         * upload attachment
         */
        if (!empty($_FILES['upload_files']['name'])) {
            $ext = pathinfo($_FILES['upload_files']['name'], PATHINFO_EXTENSION);
            $rename_file = date('YmdHis') . '_' . $name . "." . $ext;
            move_uploaded_file($_FILES["upload_files"]["tmp_name"], "uploads/product_hierarchy_element/" . $rename_file);
        }

        $data = array(
            'element_name' => $name,
            'element_code' => $code,
            'element_description' => $description,
            'element_category_id' => $sku_layer,
            'parent_element_id' => $parent_element,
            'image' => $rename_file
        );
        $insert = $this->Skus->insertIntoTbl('tbld_sku_hierarchy_elements', $data);
        if ($insert) {

            $get_data = $this->Skus->getSkuElementIdByCode($code);
            foreach ($get_data as $element_id) {
                $res = tree_data('tree_sku_hierarchy_elements', 'sku_hierarchy_element_id', $element_id['id'], $parent_element, 'below');
            }
            redirect(site_url('sku/skuHierarchyElementIndex'));
        }
    }

    public function skuHierarchyElementEditById($id)
    {
        $data['tbld_sku_hierarchy_elements'] = $this->Skus->getTbldSkuHierarchyElementsById($id);
        $data['sku_hierarchy_elements'] = $this->Skus->getSkuHierarchyElements();
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();
        $this->load->view('sku/sku_hierarchy_element/sku_hierarchy_element_edit', $data);
    }

    public function skuHierarchyElementDetailtById($id)
    {
        $data['element_id']=$id;
        $data['tbld_sku_hierarchy_elements'] = $this->Skus->getTbldSkuHierarchyElementsById($id);
        $data['sku_hierarchy_elements'] = $this->Skus->getSkuHierarchyElements();
        $data['sku_hierarchy'] = $this->Skus->getSkuHierarchy();
        $this->load->view('sku/sku_hierarchy_element/sku_hierarchy_element_detail', $data);
    }

    public function skuHierarchyElementUpdateById($id)
    {
        $data = array(
            'element_name' => $this->input->post('name'),
            'element_code' => $this->input->post('code'),
            'element_description' => $this->input->post('description'),
            'element_category_id' => $this->input->post('sku_layer'),
            'parent_element_id' => $this->input->post('parent_element')
        );
        $update = $this->Skus->updateTbldSkuHierarchyElementsById($id, $data);
        if ($update) {
            redirect(site_url('sku/skuHierarchyElementIndex'));
        }
    }

    public function skuHierarchyElementDeleteById($id)
    {
        $del = $this->Skus->deleteTbldSkuHierarchyElementsById($id);
        redirect(site_url('sku/skuHierarchyElementIndex'));
    }

    /**
     * sku Hierarchy Element End
     */


    /**
     * sku Type Start
     */

    public function skuTypeIndex()
    {
        $data['sku_type'] = $this->Skus->getSkuTypes();
        $this->load->view('sku/sku_type/sku_type_index', $data);
    }

    public function createSkuType()
    {
        $this->load->view('sku/sku_type/sku_type_create');
    }

    public function saveSkuType()
    {
        $data = array(
            'sku_type_name' => $this->input->post('sku_type_name'),
            'sku_type_code' => $this->input->post('sku_type_code'),
            'sku_type_description' => $this->input->post('sku_type_description')
        );

        $insert = $this->Skus->addSkuTypes($data);
        if ($insert) {
            redirect(site_url('sku/skuTypeIndex'));
        }
    }

    public function skuTypeEditById($sku_type_id)
    {
        $data['tbld_sku_type'] = $this->Skus->getTbldSkuTypeById($sku_type_id);
        $this->load->view('sku/sku_type/sku_type_index_edit', $data);
    }

    public function skuTypeDetailById($sku_type_id)
    {
        $data['sku_type_id']=$sku_type_id;
        $data['tbld_sku_type'] = $this->Skus->getTbldSkuTypeById($sku_type_id);
        $this->load->view('sku/sku_type/sku_type_index_detail', $data);
    }

    public function skuTypeUpdateById($sku_type_id)
    {
        $data = array(
            'sku_type_name' => $this->input->post('sku_type_name'),
            'sku_type_code' => $this->input->post('sku_type_code'),
            'sku_type_description' => $this->input->post('sku_type_description')
        );
        $update = $this->Skus->updateTbldSkuType($sku_type_id, $data);
        if ($update) {
            redirect(site_url('sku/skuTypeIndex'));
        }
    }

    public function skuTypeDeleteById($sku_type_id)
    {
        $del = $this->Skus->deleteTbldSkuTypeById($sku_type_id);
        redirect(site_url('sku/skuTypeIndex'));
    }

    /**
     * sku Type End
     */


    /**
     * sku Start
     */
    public function skuIndex()
    {
        $this->load->view('sku/all_sku/sku_index');
    }
    public function get_sku_detail_view()
    {
        $db_id=$this->input->post('db_id');

        if($db_id == ''){
            $data['sku_info'] = $this->Skus->getSkuName();
        }else{
            $data['sku_info'] = $this->Bundle_prices->getAllBundleSkubyDBIds($db_id);
        }
        $data['user_role_code'] = $this->session->userdata('user_role_code');
        $this->load->view('sku/all_sku/sku_detail_view', $data);
    }

    public function createSku()
    {
        $data['status'] = $this->Skus->getSkuStatus();
        $data['unit'] = $this->Skus->getAllUnits();
        $data['container'] = $this->Skus->getAllcontainer();
        //$data['volume'] = $this->Skus->getAllvolume();
        $data['volume_unit'] = $this->Skus->getAllvolume_unit();
        $data['category'] = $this->Skus->getAllcategory();
        $sku_parent = $this->Configs->selectConfigParam('sku_parent_map');

        foreach ($sku_parent as $parent_layer_id) {
            $sku_elem[] = $this->Skus->getSkuElementsByLayerId($parent_layer_id['attribute_id']);
        }
        $data['sku_category'] = $sku_elem;

        $data['sku_type'] = $this->Skus->getSkuTypes();
        $data['tbld_sku_manufacturer'] = $this->Skus->getSkuManufacturer();
        $data['sku_size_type'] = $this->Skus->getSkuSizeType();
        $this->load->view('sku/all_sku/sku_create', $data);
    }

    public function getMaxUnit()
    {
        $arr = $this->input->post('unit');
        $in = implode(",", $arr);
        $maxQty = $this->Skus->getMaxUnit($in);
        echo $maxQty[0]['maxQty'];
    }

    public function saveSku()
    {

        $data = array(

            'parent_id' => $this->input->post('parent_id'),
            'sku_name_b' => $this->input->post('sku_name_b'),
            'sku_name' => $this->input->post('sku_name'),
            'sku_description' => $this->input->post('sku_description'),
            'sku_code' => str_replace(" ", "_", $this->input->post('sku_code')),
            'sku_type_id' => $this->input->post('sku_type_id'),
            'sku_active_status_id' => $this->input->post('sku_active_status_id'),
            'sku_creation_date' => date("Y-m-d", strtotime($this->input->post('sku_creation_date'))),
            'sku_launch_date' => date("Y-m-d", strtotime($this->input->post('sku_launch_date'))),
            'sku_expiry_date ' => date("Y-m-d", strtotime($this->input->post('sku_expiry_date'))),
            'sku_weight_id' => $this->input->post('weight_unit'),
            'sku_waight_value' => $this->input->post('volume'),
            'sku_volume' => $this->input->post('sku_waight_value'),
            'outlet_default_mou_id' => $this->input->post('outlet_default_pack_size'),
            'db_default_mou_id' => $this->input->post('db_default_pack_size'),
            'sku_container_type_id' => $this->input->post('container_type'),
            'sku_lpc' => $this->input->post('lpc_unit'),
            'sku_category_id' => $this->input->post('sku_category_id'),

            /*'sku_default_price_case' => $this->input->post('sku_default_price_case'),
            'trade_price_case' => $this->input->post('trade_price_case'),
            'sku_mrp_price_case' => $this->input->post('sku_mrp_price_case'),*/

        );
        $insert_id = $this->Skus->addSkus($data);

        $insert_to_inventory = $this->Skus->insertIntoInventory($insert_id);
        $insert_to_available_inventory = $this->Skus->insertIntoAvailableInventory($insert_id);

        /*
         * MOU Calculations
         */
        $qty_q = $this->input->post('unit');
        for ($i = 0; $i < sizeof($qty_q); $i ++) {
            $qty_id = $qty_q[$i];
            $qty = $this->Skus->getUnitQtyByUnitId($qty_id);
            $qtys[$qty_id] = $qty[0]['qty'];
        }
        $qty_value = max($qtys);

        $db_lifting_price = $this->input->post('sku_default_price');
        $outlet_lifting_price = $this->input->post('trade_price') ;
        $mrp_lifting_price = $this->input->post('sku_mrp_price') ;

        foreach ($qtys as $key => $value) {
            $qty_values = $value;
            $qty_ids = $key;
            $data_mou_1 = array(
                'sku_id' => $insert_id,
                'mou_id' => $qty_ids,
                'quantity' => $qty_values,
                'db_lifting_price' => $db_lifting_price * $qty_values,
                'outlet_lifting_price' => $outlet_lifting_price * $qty_values,
                'mrp_lifting_price' => $mrp_lifting_price * $qty_values
            );
            $insert_mou1 = $this->Skus->insertData('tbli_sku_mou_price_mapping', $data_mou_1);
            $sku_def_MoU= array(
                'sku_id' => $insert_id,
                'db_mou_id' => $qty_ids,
                'outlet_mou_id' => $qty_ids
            );
            $insert_sku_def_MoU = $this->Skus->insertData('tbli_sku_default_mou', $sku_def_MoU);
            $insert_mou2 = $this->Skus->insertData('tbli_sku_mou_price_mapping_log', $data_mou_1);
        }
        /*
         * Sku log
         */
        $time_log = date("Y-m-d H:i:s");
        $user_id = $this->session->userdata('emp_id');
        $data['sku_id'] = $insert_id;
        $data['user_id'] = $user_id;
        $data['time_log'] = $time_log;
        $price_log = $this->Skus->insertSkuLog($data);
        /*
         * End log
         */
        if ($price_log) {
            redirect(site_url('sku/skuIndex'));
        }
    }

    public function skuEditById($sku_id)
    {   
        $data['sku_id'] = $sku_id;
        $data['category'] = $this->Skus->getAllcategory();
        $data['volume_unit'] = $this->Skus->getAllvolume_unit();
        $data['container'] = $this->Skus->getAllcontainer();
        $data['sku_price'] = $this->Skus->get_prices($sku_id);        
        $data['sku_info'] = $this->Skus->getSkuNameById($sku_id);
        $data['status'] = $this->Skus->getSkuStatus();
        $data['unit'] = $this->Skus->getAllUnits();
        $data['max_qty'] = $this->Skus->getSkuMaxQtyById($sku_id);
     

        $data['sku_category_type'] = $this->Skus->getSkuCategory();
        $sku_parent = $this->Configs->selectConfigParam('sku_parent_map');
        foreach ($sku_parent as $parent_layer_id) {
            $sku_elem[] = $this->Skus->getSkuElementsByLayerId($parent_layer_id['attribute_id']);
        }
        $data['sku_category'] = $sku_elem;
        $data['sku_type'] = $this->Skus->getSkuTypes();
        $data['tbld_sku_manufacturer'] = $this->Skus->getSkuManufacturer();
        $data['sku_size_type'] = $this->Skus->getSkuSizeType();
        $this->load->view('sku/all_sku/sku_edit', $data);

    }

    public function skuUpdateById($sku_id)
    {

        $data = array(
            'sku_name' => $this->input->post('sku_name'),
            'sku_code' => str_replace(" ", "_", $this->input->post('sku_code')),
            'sku_description' => $this->input->post('sku_description'),
            'sku_type_id' => $this->input->post('sku_type_id'),
            'sku_active_status_id' => $this->input->post('sku_active_status_id'),
            'sku_creation_date' => date("Y-m-d", strtotime($this->input->post('sku_creation_date'))),
            'sku_launch_date' => date("Y-m-d", strtotime($this->input->post('sku_launch_date'))),
            'sku_expiry_date ' => date("Y-m-d", strtotime($this->input->post('sku_expiry_date'))),
            'parent_id' => $this->input->post('parent_id'),
            'sku_ins_price' => $this->input->post('sku_ins_price'),
            'sku_weight_id' => $this->input->post('weight_unit'),
            'sku_waight_value' => $this->input->post('sku_waight_value'),
            'sku_manufacturer_id' => $this->input->post('SBU'),
            'sku_size_id' => $this->input->post('sku_size_type'),
            'sku_logical_type_id' => 2,
            'ins_default_mou_id' => $this->input->post('ins_unit'),
            'outlet_default_mou_id' => $this->input->post('outlet_default_pack_size'),
            'db_default_mou_id' => $this->input->post('db_default_pack_size'),
            'sku_name_b' => $this->input->post('sku_name_b')
        );
        $update = $this->Skus->updateSkus($sku_id, $data);
        if ($update) {
            $mou_delete = $this->Skus->deleteSkuMouId($sku_id);

            /*
             * MOU Calculations
             */
            $qty_q = $this->input->post('unit');

            for ($i = 0; $i < sizeof($qty_q); $i ++) {
                $qty_id = $qty_q[$i];
                $qty = $this->Skus->getUnitQtyByUnitId($qty_id);
                $qtys[$qty_id] = $qty[0]['qty'];
            }

            $qty_value = max($qtys);
            $db_lifting_price = $this->input->post('bulk_purchase_price') / $qty_value;
            $outlet_lifting_price = $this->input->post('sku_default_price') / $qty_value;
            $mrp_lifting_price = $this->input->post('sku_mrp_price') / $qty_value;

            foreach ($qtys as $key => $value) {
                $qty_values = $value;
                $qty_ids = $key;

                $data_mou_1 = array(
                    'sku_id' => $sku_id,
                    'mou_id' => $qty_ids,
                    'quantity' => $qty_values,
                    'db_lifting_price' => $db_lifting_price * $qty_values,
                    'outlet_lifting_price' => $outlet_lifting_price * $qty_values,
                    'mrp_lifting_price' => $mrp_lifting_price * $qty_values
                );
                $insert_mou1 = $this->Skus->insertData('tbli_sku_mou_price_mapping', $data_mou_1);
                $insert_mou2 = $this->Skus->insertData('tbli_sku_mou_price_mapping_log', $data_mou_1);
            }
            /*
             * END
             */

            /*
             * Sku log
             */
            $time_log = date("Y-m-d H:i:s");
            $user_id = $this->session->userdata('emp_id');
            $data['sku_id'] = $sku_id;
            $data['user_id'] = $user_id;
            $data['time_log'] = $time_log;

            $price_log = $this->Skus->insertSkuLog($data);
            /*
             * End log
             */
            if ($price_log) {
                redirect(site_url('sku/skuIndex'));
            }
        }
    }

    /**
     * sku End
     */

    /*
     * External Sku Start/
     */

    public function externalSkuIndex()
    {
        $data['external_sku_info'] = $this->Skus->getExternalSkuData();
        $this->load->view('sku/sku_external/sku_external_index', $data);

    }

    public function createExternalSku()
    {
        $data['sku_unit_info'] = $this->Skus->getSkuUnit();
        $data['sku_unit_status'] = $this->Skus->getSkuUnitStatus();
        $this->load->view('sku/sku_external/sku_external_create', $data);
    }

    public function saveExternalSku()
    {
        $name = $this->input->post('name');
        $date = $this->input->post('date');
        $description = $this->input->post('description');
        $unit = $this->input->post('unit');
        $status = $this->input->post('status');

        $external_sku_info = $this->Skus->getExternalSkuBrandId('EB');
        $external_sku_brand_id = $external_sku_info[0]['id'];

        $data = array(
            'sku_name' => $name,
            'sku_code' => $name,
            'sku_creation_date' => $date,
            'sku_description' => $description,
            'sku_type_id' => 99,
            'sku_active_status_id' => $status,
            'parent_id' => $external_sku_brand_id,
            'mis_default_mou_id' => $unit,
            'db_default_mou_id' => $unit,
            'outlet_default_mou_id' => $unit,
            'ins_default_mou_id' => $unit,
            'parent_id' => 0 // can't be null **ghapla   thik kora lagbe

        );
        $insert = $this->Skus->insertExternalSkuInfo('tbld_sku', $data);

        $mou_qauntity_info = $this->Skus->getMouQuantity($unit);
        $mou_quantity = $mou_qauntity_info[0]['qty'];

        $data2 = array(
            'sku_id' => $insert,
            'mou_id' => $unit,
            'quantity' => $mou_quantity
        );

        $insert_1 = $this->Skus->insertTbliSkuMouPriceMapping('tbli_sku_mou_price_mapping', $data2);

        redirect(site_url('sku/externalSkuIndex'));


    }

    public function externalSkuEditById($id)
    {

        $data['external_sku'] = $this->Skus->getTbldExternalSkuById($id);
        $data['tbld_unit'] = $this->Skus->getSkuUnit();
        $data['status'] = $this->Skus->getSkuStatus();
        $this->load->view('sku/sku_external/sku_external_edit', $data);
    }

    public function externalSkuUpdateById($id)
    {

        $name = $this->input->post('name');
        $date = $this->input->post('date');
        $description = $this->input->post('description');
        $unit = $this->input->post('unit');
        $status = $this->input->post('status');

        $data = array(
            'sku_name' => $name,
            'sku_code' => $name,
            'sku_creation_date' => $date,
            'sku_description' => $description,
            'sku_active_status_id' => $status
        );

        $update = $this->Skus->updateExternalSku($id, $data);

        $data2 = array(
            'mou_id' => $unit
        );

        $update = $this->Skus->updateTbliSkuMouPriceMapping($id, $data2);

        if ($update) {
            redirect(site_url('Sku/externalSkuIndex'));
        }

    }

    public function externalSkuDeleteById($id)
    {
        $del = $this->Skus->deleteTbldSkuById($id);
        $del = $this->Skus->deleteTbliSkuMouPriceMappingIdById($id);
        redirect(site_url('Sku/externalSkuIndex'));
    }
    /*
     * External Sku End/
     */


    /*
     * Product Configuration sku unit start/
     */

    public function SkuUnitIndex()
    {
        $data['sku_unit'] = $this->Skus->getSkuUnit();

        $this->load->view('sku/sku_unit/sku_unit_index', $data);
    }

    public function createSkuUnit()
    {
        $this->load->view('sku/sku_unit/sku_unit_create');
    }

    public function saveSkuUnit()
    {
        $data = array(
            'unit_name' => $this->input->post('unit_name'),
            'unit_short_name' => $this->input->post('unit_short_name'),
            'unit_code' => $this->input->post('unit_code'),
            'unit_description' => $this->input->post('unit_description'),
            'height' => $this->input->post('height'),
            'width' => $this->input->post('width'),
            'length' => $this->input->post('length'),
            'weight' => $this->input->post('weight'),
            'qty' => $this->input->post('qty')
        );

        $insert = $this->Skus->addSkuUnits($data);
        if ($insert) {
            redirect(site_url('sku/SkuUnitIndex'));
        }
    }

    public function skuUnitEditById($id)
    {
        $data['sku_unit'] = $this->Skus->getTbldUnitById($id);
        $this->load->view('sku/sku_unit/sku_unit_edit', $data);
    }

    public function skuUnitUpdateById($id)
    {
        $data = array(
            'unit_name' => $this->input->post('unit_name'),
            'unit_short_name' => $this->input->post('unit_short_name'),
            'unit_code' => $this->input->post('unit_code'),
            'unit_description' => $this->input->post('unit_description'),
            'height' => $this->input->post('height'),
            'width' => $this->input->post('width'),
            'length' => $this->input->post('length'),
            'weight' => $this->input->post('weight'),
            'qty' => $this->input->post('qty')
        );
        $update = $this->Skus->updateTbldUnitById($id, $data);
        if ($update) {
            redirect(site_url('sku/SkuUnitIndex'));
        }
    }

    public function skuUnitDeleteById($id)
    {
        $del = $this->Skus->deleteTbldUnitById($id);
        redirect(site_url('sku/SkuUnitIndex'));
    }

    /*
     * Product Configuration sku unit End/
     */


}
