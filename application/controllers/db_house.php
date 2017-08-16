<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DB_house extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Outlets');
        $this->load->model('db_houses');
        $this->load->model('Configs');
        $this->load->model('Bundle_prices');
        $this->load->helper('tree_data_functions_helper');
    }

    /*
     * Start Distribution House /
     */

    public function distributionHouseIndex() {
        $data['db_house'] = $this->db_houses->selectDbHouse();
        $data['business_zone'] = $this->db_houses->getAllBusinessZone();
        $this->load->view('db_house/distribution_house/distribution_house_index', $data);
    }

    public function Day_end() {
        $db_id = $this->session->userdata('db_id');


        $System_date = $this->session->userdata('System_date');
        $current_date = date('Y-m-d');
        if ($System_date < $current_date) {
            $NewDate = Date('Y-m-d', strtotime("+1 days", strtotime($System_date)));
            $this->db_houses->Day_end($System_date,$NewDate, $db_id);
            $data['incorrectLogin_flag'] = 20;
            redirect(site_url('login/user_logout/20'));
        }else{
          $data['incorrectLogin_flag'] = 21;
         redirect(site_url('login/user_logout/21'));
        }
      
       
    }

    public function distributor_profile() {
        $db_id = $this->session->userdata('db_id');
        $data['db_info'] = $this->db_houses->getDistributionHouseProfileInfo($db_id);
        $this->load->view('db_house/distribution_house/distribution_house_info', $data);
    }

    public function getBusinessZoneName() {
        $id = $this->input->post('business_zone_layer');
        $data = $this->db_houses->getAllBusinessZonesName($id);
        echo json_encode($data);
    }

    public function getTerritoryName() {
        $biz_zone_str = $this->input->post('business_zone_name');
        //$biz_zone_id = explode( ',', $biz_zone_str );
        $data = $this->db_houses->getAllTerritoryID($biz_zone_str);

        //$datas = $this->db_houses->getAllTerritoryName( $data );
        //echo $biz_zone_str;
        echo json_encode($data);
    }

    public function createDistributionHouse() {
        $data = $this->get_data();
        $data['business_zone'] = $this->db_houses->getAllBusinessZoneRegion();
        $data['division'] = $this->db_houses->getDivision();
        $data['cluster'] = $this->db_houses->getCluster();
        $data['db_type'] = $this->db_houses->getDbType();
        $data['bundle_prices'] = $this->Bundle_prices->get_all_bundle();
        $data['outlet_category'] = $this->db_houses->allOutletCategoryType();
        $this->load->view('db_house/distribution_house/distribution_house_create', $data);
    }

    public function add_po_row() {
        $count = $this->input->post('count');

        $new_line = '';
        $new_line .= '<tr>';
        $new_line .= '<td><input type="text" class="form-control date" id="asset_name' . $count . '" name="asset_name[]" value="" ></td>';
        $new_line .= '<td><input type="text" class="form-control integer-input"  id="asset_amount' . $count . '" name="asset_amount[]" ></td>';
        $new_line .= '<td><input type="text" class="form-control integer-input"  id="asset_qty' . $count . '" name="asset_qty[]" ></td>';
        $new_line .= '<td><span class="btn red delete"><i class="fa fa-times"></i>delete</span></td>';
        $new_line .= '</tr>';
        echo $new_line;
    }

    public function addVehicleRow() {
        //        $readonly = '';
        //$user_role_code = $this->session->userdata('user_role_code');
        $count = $this->input->post('count');
        $vehicle_type = $this->db_houses->getVehicleType();
        $vehicle_type_dropdown = '<option></option>';
        foreach ($vehicle_type as $vehicle_types) {
            $vehicle_type_dropdown .= '<option value="' . $vehicle_types['id'] . '">' . $vehicle_types['name'] . '</option>';
        }
        $new_line = '';
        $new_line .= '<tr>';
        $new_line .= '<td><input type="text" class="form-control " id="vehicle_code' . $count . '" name="vehicle_code[]" value="" ></td>';
        $new_line .= '<td><input type="text" class="form-control " id="vehicle_name' . $count . '" name="vehicle_name[]" value="" ></td>';
        $new_line .= '<td style="min-width:200px;"><select name="vehicle_type[]"  id="vehicle_type' . $count . '" class="form-control" >' .
                $vehicle_type_dropdown . '</select></td>';
        $new_line .= '<td><input type="text" class="form-control integer-input"  id="reg_no' . $count . '" name="reg_no[]" ></td>';
        $new_line .= '<td><input type="text" class="form-control date" id="driver_name' . $count . '" name="driver_name[]" value="" ></td>';
        $new_line .= '<td><input type="text" class="form-control integer-input"  id="contact_no' . $count . '" name="contact_no[]" ></td>';
        $new_line .= '<td><input type="text" class="date_range form-control"  id="exp_date' . $count . '" name="exp_date[]" ></td>';
        $new_line .= '<td><span class="btn red delete"><i class="fa fa-times"></i>delete</span></td>';
        $new_line .= '</tr>';
        echo $new_line;
    }

    public function bankInfoRowAdd() {
        $count = $this->input->post('count');

        $account_type_dropdown = '<option></option>' . '<option value="1">Bank</option><option value="2">Mobile Banking</option>';

        $new_line = '';
        $new_line .= '<tr>';
        $new_line .= '<td><input type="text" class="form-control " id="acc_holder_name' . $count . '" name="acc_holder_name[]" value="" ></td>';
        $new_line .= '<td><input type="text" class="form-control " id="acc_no' . $count . '" name="acc_no[]" value=""  ></td>';
        $new_line .= '<td><input type="text" class="form-control "  id="bank_name' . $count . '" name="bank_name[]"  ></td>';
        $new_line .= '<td><input type="text" class="form-control date" id="branch_name' . $count . '" name="branch_name[]" value=""  ></td>';
        $new_line .= '<td style="min-width:200px;"><select name="bank_type[]"  id="bank_type' . $count . '" class="form-control" >' .
                $account_type_dropdown . '</select></td>';
        $new_line .= '<td><input type="text" class="form-control integer-input"  id="mobile_no_bank' . $count . '" name="mobile_no_bank[]" ></td>';
        $new_line .= '<td><span class="btn red delete"><i class="fa fa-times"></i>Delete</span></td>';
        $new_line .= '</tr>';
        echo $new_line;
    }

    public function saveDbHouse() {
        $stk = array();

        $cluster = $this->input->post('cluster');
        $office_address = $this->input->post('office_address');
        $warehouse_address = $this->input->post('warehouse_address');
        $wh_manager_name = $this->input->post('wh_manager_name');
        $wh_manager_contruct_no = $this->input->post('wh_manager_contruct_no');
        $delivery_module_status = $this->input->post('delivery_module_status');

        $dbAddressdata = array(
            'address_name' => $this->input->post('dbhouse_address'),
            'street1' => $this->input->post('road'),
            'street2' => $this->input->post('village'),
            'union_id' => $this->input->post('union'),
            'thana_id' => $this->input->post('thana'),
            'district_id' => $this->input->post('district'),
            'mobile1' => $this->input->post('mobile1'),
            'mobile2' => $this->input->post('mobile2'),
            'division_id' => $this->input->post('division')
        );

        $address_id = $this->db_houses->InsertDBHAddress($dbAddressdata);

        $distributor_address = array(
            'address_name' => $this->input->post('distributor_address'),
            'street2' => $this->input->post('distributor_village'),
            'division_id' => $this->input->post('distributor_division'),
            'district_id' => $this->input->post('distributor_district'),
            'thana_id' => $this->input->post('distributor_thana'),
            'union_id' => $this->input->post('distributor_union'),
            'mobile1' => $this->input->post('mobile1'),
            'mobile2' => $this->input->post('mobile2')
        );
        $distributor_address_id = $this->db_houses->InsertDBHAddress($distributor_address);



        $acc_holder_name = $_POST['acc_holder_name'];
        $acc_no = $_POST['acc_no'];
        $bank_name = $_POST['bank_name'];
        $branch_name = $_POST['branch_name'];
        $bank_type = $_POST['bank_type'];
        $mobile_no_bank = $_POST['mobile_no_bank'];



        $distributor = array(
            'distributor_name' => $this->input->post('distributor_name'),
            'distributor_code' => $this->input->post('distributor_code'),
            'distributor_address_id' => $distributor_address_id
        );

        $distributor_id = $this->db_houses->insertDistributor($distributor);

        $creation_date = $this->input->post('creation_date');
        $create_date = date("Y-m-d", strtotime($creation_date));

        $dbdata = array('dbhouse_name' => $this->input->post('dbhouse_name'),
            'dbhouse_code' => $this->input->post('dbhouse_code'),
            'dbhouse_description' => $this->input->post('dbhouse_description'),
            'db_house_status' => $this->input->post('db_house_status'),
            'type' => $this->input->post('db_type'),
            'dbhouse_address_id' => $address_id,
            'category' => 0, //$this->input->post( 'category' ),
            'db_point' => 0, //$this->input->post( 'db_point' ),
            'distributor_id' => $distributor_id,
            'email' => $this->input->post('db_email'),
            'distributor_email' => $this->input->post('distributor_email'),
            'vat_no' => $this->input->post('db_vat_no'),
            'tin_no' => $this->input->post('db_tin_no'),
            'db_credit_limit' => $this->input->post('db_credit_limit'),
            'create_date' => $create_date,
            'cluster_id' => $cluster,
            'office_address' => $office_address,
            'warehouse_address' => $warehouse_address,
            'wh_manager_name' => $wh_manager_name,
            'wh_manager_contruct_no' => $wh_manager_contruct_no,
            'delivery_module_status' => $delivery_module_status
        );

        $dbhouse_id = $this->db_houses->insertDbHouse($dbdata);

        if ($this->input->post('db_type') == "6") {
            $spoke_mapping = array(
                'hub_id' => $this->input->post('hub'),
                'spoke_id' => $dbhouse_id
            );
            $spoke_mapping_id = $this->db_houses->insertSpokeMapping($spoke_mapping);
        }

        $dbzonedata = array(
            'dbhouse_id' => $dbhouse_id,
            'biz_zone_id' => $this->input->post('territory')
        );
        $dbhousezone_id = $this->db_houses->insertDbHouseZone($dbzonedata);

        $asset_name = $_POST['asset_name'];
        $asset_market_value = $_POST['asset_amount'];
        $asset_qty = $_POST['asset_qty'];
        for ($i = 0; $i < count($asset_name); $i ++) {
            $assets = array(
                'db_id' => $dbhouse_id,
                'name' => $asset_name[$i],
                'market_value' => $asset_market_value[$i],
                'qty' => $asset_qty[$i]
            );
            $assets_insert = $this->db_houses->insert('tblt_db_asset_mapping', $assets);
        }


        /*
         * bank info
         */

        for ($i = 0; $i < count($_POST['acc_holder_name']); $i ++) {
            $bank_info = array(
                'db_id' => $dbhouse_id,
                'name' => $acc_holder_name[$i],
                'account_no' => $acc_no[$i],
                'bank_name' => $bank_name[$i],
                'branch_name' => $branch_name[$i],
                'bank_type' => $bank_type[$i],
                'mobile_no' => $mobile_no_bank[$i]
            );
            $insert_id = $this->db_houses->insertWithLastInsertId('tbld_account', $bank_info);
        }


        /* Bank info End */

        $vehicle_code = $_POST['vehicle_code'];
        $vehicle_name = $_POST['vehicle_name'];
        $vehicle_type = $_POST['vehicle_type'];
        $reg_no = $_POST['reg_no'];
        $driver_name = $_POST['driver_name'];
        $contact_no = $_POST['contact_no'];
        $exp_date = $_POST['exp_date'];

        for ($i = 0; $i < count($vehicle_code); $i ++) {
            $vehicle = array(
                'db_id' => $dbhouse_id,
                'vehicle_code' => $vehicle_code[$i],
                'vehicle_name' => $vehicle_name[$i],
                'vehicle_type' => $vehicle_type[$i],
                'reg_no' => $reg_no[$i],
                'driver_name' => $driver_name[$i],
                'contact_no' => $contact_no[$i],
                'exp_date' => date('Y-m-d', strtotime($exp_date[$i]))
            );
            $vehicle_insert = $this->db_houses->insert('tblt_db_vehicle_mapping', $vehicle);
        }

        $bundle_price = array(
            'bundle_price_id' => $this->input->post('sku_bundle_price'),
            'db_id' => $dbhouse_id
        );
        $this->db_houses->insert('tbli_db_bundle_price_mapping', $bundle_price);
        $this->insertBundleSkuIntoInventory($dbhouse_id);

        redirect(site_url('db_house/distributionHouseIndex'));
    }

    public function insertBundleSkuIntoInventory($db_id) {
        $update = $this->db_houses->insertBundleSkuIntoInventory($db_id);

        return $update;
    }

    public function UpdateDbHouseById($db_id) {
        $cluster = $this->input->post('cluster');
        $office_address = $this->input->post('office_address');
        $warehouse_address = $this->input->post('warehouse_address');
        $wh_manager_name = $this->input->post('wh_manager_name');
        $wh_manager_contruct_no = $this->input->post('wh_manager_contruct_no');
        $db_address_id = $this->input->post('db_address_id');
        $distributor_address_id = $this->input->post('distributor_address_id');
        $distributor_id = $this->input->post('distributor_id');
        $delivery_module_status = $this->input->post('delivery_module_status');

        //address start
        $dbAddressdata = array(
            'address_name' => $this->input->post('dbhouse_address'),
            'street1' => $this->input->post('road'),
            'street2' => $this->input->post('village'),
            'union_id' => $this->input->post('union'),
            'thana_id' => $this->input->post('thana'),
            'district_id' => $this->input->post('district'),
            'mobile1' => $this->input->post('mobile1'),
            'mobile2' => $this->input->post('mobile2'),
            'division_id' => $this->input->post('division')
        );

        $address_id = $this->db_houses->updateTable('tbld_address', $db_address_id, $dbAddressdata);
        //address end

        $distributor_address = array(
            'address_name' => $this->input->post('distributor_address'),
            'street2' => $this->input->post('distributor_village'),
            'division_id' => $this->input->post('distributor_division'),
            'district_id' => $this->input->post('distributor_district'),
            'union_id' => $this->input->post('distributor_union'),
            'thana_id' => $this->input->post('distributor_thana'),
            'mobile1' => $this->input->post('mobile1'),
            'mobile2' => $this->input->post('mobile2')
        );
        $distributor_adrs_id = $this->db_houses->updateTable('tbld_address', $distributor_address_id, $distributor_address);

        $distributor = array(
            'distributor_name' => $this->input->post('distributor_name'),
            'distributor_code' => $this->input->post('distributor_code')
        );

        $distributor_info = $this->db_houses->updateTable('tbld_distributor', $distributor_id, $distributor);

        $dbdata = array(
            'dbhouse_name' => $this->input->post('dbhouse_name'),
            'dbhouse_code' => $this->input->post('dbhouse_code'),
            'dbhouse_description' => $this->input->post('dbhouse_description'),
            'db_house_status' => $this->input->post('db_house_status'),
            'type' => $this->input->post('db_type'),
            'category' => 0, //$this->input->post( 'category' ),
            'db_point' => 0, //$this->input->post( 'db_point' ),
            'email' => $this->input->post('db_email'),
            'distributor_email' => $this->input->post('distributor_email'),
            'vat_no' => $this->input->post('db_vat_no'),
            'tin_no' => $this->input->post('db_tin_no'),
            'db_credit_limit' => $this->input->post('db_credit_limit'),
            'cluster_id' => $cluster,
            'office_address' => $office_address,
            'warehouse_address' => $warehouse_address,
            'wh_manager_name' => $wh_manager_name,
            'wh_manager_contruct_no' => $wh_manager_contruct_no,
            'delivery_module_status' => $delivery_module_status
        );

        $distribution_house = $this->db_houses->updateTable('tbld_distribution_house', $db_id, $dbdata);

        if ($this->input->post('db_type') == "6") {
            $deleted_db_type_mapping = $this->db_houses->deleteDBType('tbli_hub_spoke_mapping', $db_id);

            $spoke_mapping = array(
                'hub_id' => $this->input->post('hub'),
                'spoke_id' => $db_id
            );
            $assets_insert = $this->db_houses->insert('tbli_hub_spoke_mapping', $spoke_mapping);
        }

        $dbzonedata = array(
            'biz_zone_id' => $this->input->post('territory')
        );

        $dbh_zone = $this->db_houses->updateZoneTable('tbli_distribution_house_biz_zone_mapping', $db_id, $dbzonedata);

        //account info start

        $acc_holder_name = $_POST['acc_holder_name'];
        $acc_no = $_POST['acc_no'];
        $bank_name = $_POST['bank_name'];
        $branch_name = $_POST['branch_name'];
        $bank_type = $_POST['bank_type'];
        $mobile_no_bank = $_POST['mobile_no_bank'];

        $delete_account_info = $this->db_houses->deleteBankInfo('tbld_account', $db_id);

        for ($i = 0; $i < count($_POST['acc_holder_name']); $i ++) {
            $bank_info = array(
                'db_id' => $db_id,
                'name' => $acc_holder_name[$i],
                'account_no' => $acc_no[$i],
                'bank_name' => $bank_name[$i],
                'branch_name' => $branch_name[$i],
                'bank_type' => $bank_type[$i],
                'mobile_no' => $mobile_no_bank[$i]
            );
            $insert_id = $this->db_houses->insert('tbld_account', $bank_info);
        }

        //account info end
        //asset info start
        $deleted_asset = $this->db_houses->deleteAssetVehicle('tblt_db_asset_mapping', $db_id);

        $asset_name = $_POST['asset_name'];
        $asset_market_value = $_POST['asset_amount'];
        $asset_qty = $_POST['asset_qty'];
        for ($i = 0; $i < count($asset_name); $i ++) {
            $assets = array(
                'db_id' => $db_id,
                'name' => $asset_name[$i],
                'market_value' => $asset_market_value[$i],
                'qty' => $asset_qty[$i]
            );
            $assets_insert = $this->db_houses->insert('tblt_db_asset_mapping', $assets);
        }

        //asset info end
        //delete vehicle start
        $deleted_vehicle = $this->db_houses->deleteAssetVehicle('tblt_db_vehicle_mapping', $db_id);

        $vehicle_code = $_POST['vehicle_code'];
        $vehicle_name = $_POST['vehicle_name'];
        $vehicle_type = $_POST['vehicle_type'];
        $reg_no = $_POST['reg_no'];
        $driver_name = $_POST['driver_name'];
        $contact_no = $_POST['contact_no'];
        $exp_date = $_POST['exp_date'];

        for ($i = 0; $i < count($vehicle_code); $i ++) {
            $vehicle = array(
                'db_id' => $db_id,
                'vehicle_code' => $vehicle_code[$i],
                'vehicle_name' => $vehicle_name[$i],
                'vehicle_type' => $vehicle_type[$i],
                'reg_no' => $reg_no[$i],
                'driver_name' => $driver_name[$i],
                'contact_no' => $contact_no[$i],
                'exp_date' => date('Y-m-d', strtotime($exp_date[$i]))
            );

            $vehicle_insert = $this->db_houses->insert('tblt_db_vehicle_mapping', $vehicle);
        }

        //delete vehicle end
        //bundle price calculation
        $bundle_price_id = $this->input->post('sku_bundle_price');

        //if exist nothing to do
        //else insert
        $bundle_price = $this->db_houses->getBundlePrice($db_id);
        if (!empty($bundle_price)) {
            $bundle_price = $bundle_price[0]['bundle_price_id'];
            if ($bundle_price != $bundle_price_id) {
                $bundle_id = array(
                    'bundle_price_id' => $bundle_price_id
                );
                $update_bundle_price_mapping = $this->db_houses->update_tbli_db_bundle_price_mapping('tbli_db_bundle_price_mapping', $db_id, $bundle_id);
            }
        } else {
            $bundle_id = array('bundle_price_id' => $bundle_price_id, 'db_id' => $db_id);
            $bundle_price_insert = $this->db_houses->insert('tbli_db_bundle_price_mapping', $bundle_id);
        }
        redirect(site_url('db_house/distributionHouseIndex'));
    }

    public function getDbhouseEditData($id) {
        $data['outlet_category'] = $this->db_houses->allOutletCategoryType();
        $data['db_type'] = $this->db_houses->getDbType();
        $data['status'] = $this->db_houses->select_status();
        $data['dbhouse'] = $this->db_houses->getDBhouseInfoByID($id);
        $data['business_zone'] = $this->db_houses->getAllBusinessZoneRegion();

        //address start
        $division_id = ($data['dbhouse'][0]['division_id'] != '') ? $data['dbhouse'][0]['division_id'] : 0;
        $district_id = ($data['dbhouse'][0]['district_id'] != '') ? $data['dbhouse'][0]['district_id'] : 0;
        $thana_id = ($data['dbhouse'][0]['thana_id'] != '') ? $data['dbhouse'][0]['thana_id'] : 0;
        $union_id = ($data['dbhouse'][0]['union_id'] != '') ? $data['dbhouse'][0]['union_id'] : 0;
        $data['division'] = $this->db_houses->getDivision();
        $data['district'] = $this->Outlets->getGeoByParent($division_id);
        $data['thana'] = $this->Outlets->getGeoByParent($district_id);
        $data['union'] = $this->Outlets->getGeoByParent($thana_id);
        $data['village'] = $this->Outlets->getGeoByParent($union_id);
        //address end
        //Owner Information start

        $distributor_division_id = ($data['dbhouse'][0]['distributor_division_id'] != '') ? $data['dbhouse'][0]['distributor_division_id'] : 0;
        $distributor_district_id = ($data['dbhouse'][0]['distributor_district_id'] != '') ? $data['dbhouse'][0]['distributor_district_id'] : 0;
        $distributor_thana_id = ($data['dbhouse'][0]['distributor_thana_id'] != '') ? $data['dbhouse'][0]['distributor_thana_id'] : 0;
        $data['distributor_district'] = $this->Outlets->getGeoByParent($distributor_division_id);
        $data['distributor_thana'] = $this->Outlets->getGeoByParent($distributor_district_id);
        $data['distributor_union'] = $this->Outlets->getGeoByParent($distributor_thana_id);

        //Owner Information end


        $data['cluster'] = $this->db_houses->getCluster();
        $data['bundle_prices'] = $this->Bundle_prices->get_all_bundle();
        $assign_ce_area = $this->db_houses->get_assign_ce_area($id);
        $data['assign_ce_area'] = $assign_ce_area[0]['biz_zone_id'];
        $data['ce_area'] = $this->db_houses->get_ce_area($id);
        $assign_territory = $this->db_houses->get_assign_territory($data['assign_ce_area']);
        $data['assign_territory'] = $assign_territory[0]['parent_biz_zone_id'];
        $data['territory'] = $this->db_houses->get_territory($data['assign_territory']);
        $assign_unit = $this->db_houses->get_assign_unit($data['assign_territory']);
        $data['assign_unit'] = $assign_unit[0]['unit_id'];
        return $data;
    }

    public function dbHouseEditById($id) {
        $data = $this->getDbhouseEditData($id);
        $this->load->view('db_house/distribution_house/distribution_house_edit', $data);
    }

    public function getBankInfobyDbId() {
        $db_id = $this->input->post('db_id');
        $assets = $this->db_houses->getBankInfobyDbId($db_id);

        echo json_encode($assets);
    }

    public function getAssetsbyDbId() {
        $db_id = $this->input->post('db_id');
        $assets = $this->db_houses->get_assets_by_id($db_id);

        echo json_encode($assets);
    }

    public function getVehiclesbyDbId() {
        $db_id = $this->input->post('db_id');
        $vehicles = $this->db_houses->get_vehicles_by_id($db_id);

        echo json_encode($vehicles);
    }

    public function getDBHbyterritory() {
        $territory = $this->input->post('territory');
        $dbh = $this->db_houses->getDbhbyterritory($territory);

        echo json_encode($dbh);
    }

    public function dbhouseUpdateById($id) {
        $data1 = array('address_name' => $this->input->post('dbhouse_address_name'), 'village_id' => $this->input->post('village'), 'union_id' => $this->input->post('union'), 'thana_id' => $this->input->post('thana'), 'district_id' => $this->input->post('district'), 'division_id' => $this->input->post('division'));
        $address_id = $this->input->post('dbhouse_address_id');
        $update_distributor_address = $this->db_houses->updateAddressById($address_id, $data1); //ok ->edit shuvo

        $data = array('dbhouse_name' => $this->input->post('dbhouse_name'), 'dbhouse_code' => $this->input->post('dbhouse_code'), 'dbhouse_description' => $this->input->post('dbhouse_description'), 'distributor_id' => $this->input->post('distributor_id'), 'dbhouse_address_id' => $this->input->post('dbhouse_address_id'), 'db_point' => $this->input->post('db_point'), 'bank_account_id' => $this->input->post('bank_acount_id'), 'db_credit_limit' => $this->input->post('db_credit_limit'), 'db_house_status' => $this->input->post('db_house_status'), 'type' => $this->input->post('db_type'), 'email' => $this->input->post('db_email'), 'vat_no' => $this->input->post('db_vat_no'), 'tin_no' => $this->input->post('db_tin_no'), 'category' => $this->input->post('category'));
        $update_distribution_house = $this->db_houses->updateDistributionHouseById($id, $data);

        $data3 = array('mobile1' => $this->input->post('mobile1'), 'mobile2' => $this->input->post('mobile2'), 'street1' => $this->input->post('road'), 'street2' => $this->input->post('village'), 'division_id' => $this->input->post('division'), 'district_id' => $this->input->post('district'), 'thana_id' => $this->input->post('thana')
        );
        $insert = $this->db_houses->insertIntoAddress($data3);
        $data4 = array('distributor_name' => $this->input->post('distributor_name'), 'distributor_code' => $this->input->post('distributor_code'), 'distributor_address_id' => $insert);

        $insert_id = $this->db_houses->insertOwner($data4);

        $datas = array('biz_zone_id' => $this->input->post('biz_zone_id'));
        $update_tbli_user_role_mapping = $this->db_houses->updateTbliUserRoleMappingByUserId($id, $this->input->post('db_house_status'));
        $update_db_house_biz_zone_mapping = $this->db_houses->updateDbHouseBizZoneMapping($id, $datas);
        redirect(site_url('db_house/distributionHouseIndex'));
    }

    public function dbh_category() {
        $data['category'] = $this->db_houses->getAllDbhCategory();
        $this->load->view('db_house/dbh_category/view_dbh_category', $data);
    }

    public function dbh_category_add() {
        $this->load->view('db_house/dbh_category/add_dbh_category');
    }

    public function dbh_category_add_done() {
        $data = array(
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'description' => $this->input->post('description')
        );
        $insert = $this->db_houses->insertDbhCategory('tbld_distribution_category', $data);
        redirect(site_url('db_house/dbh_category/view_dbh_category'));
    }

    public function dbh_category_delete($id) {
        $del = $this->db_houses->deleteDbhCategory('tbld_distribution_category', $id);
        redirect(site_url('db_house/dbh_category/view_dbh_category'));
    }

    public function dbh_category_edit($id) {

        $data['category'] = $this->db_houses->getDbhCategoryByID($id);
        $this->load->view('db_house/dbh_category/edit_dbh_category', $data);
    }

    public function dbh_category_edit_done($id) {
        $data = array('name' => $this->input->post('name'), 'code' => $this->input->post('code'), 'description' => $this->input->post('description')
        );
        $insert = $this->db_houses->updateDbhCategory($id, $data);
        redirect(site_url('db_house/dbh_category/view_dbh_category'));
    }

    public function get_data() {
        $data['status'] = $this->db_houses->select_status();
        $data['owner'] = $this->db_houses->select_owner();
        //$data['address'] = $this->db_houses->selectAddress();
        $data['bank'] = $this->db_houses->select_bank();
        $business_zone = $this->Configs->selectConfigParam('dbhouse_biz_zone_layer_map');
        $skus = $this->Configs->selectConfigParam('dbhouse_sku_layer_map');
        foreach ($business_zone as $biz_zone_names) {
            $biz_zone_id = $biz_zone_names['attribute_id'];
        }
        foreach ($skus as $sku) {
            $sku_hierarchy_data = $sku['attribute_id'];
        }
        $data['biz_zone_name'] = $this->db_houses->GetBusinessZoneName($biz_zone_id);
        $data['sku_element_names'] = $this->db_houses->getSkuElementsByLayerId($sku_hierarchy_data);

        return $data;
    }

    //Start saveDistributorAndBankAccount
    public function saveDistributorAndBankAccount() {

        parse_str($_POST['form_data'], $elems);
        $type = $this->input->post('type');

        if ($type == 'add_distributor') {
            $data = array('mobile1' => $elems['mobile1'], 'mobile2' => $elems['mobile2'], 'address_name' => $elems['address_name']);
            $insert = $this->db_houses->insertIntoAddress($data);
            $datas = array('distributor_name' => $elems['distributor_name'], 'distributor_code' => $elems['distributor_code'], 'distributor_address_id' => $insert);

            $insert_id = $this->db_houses->insertOwner($datas);
            if ($insert_id) {
                $distributor_info = $this->db_houses->getDistributorInfoById($insert_id);
                foreach ($distributor_info as $key) {
                    echo '<option value="' . $key['id'] . '">' . $key['distributor_name'] . '</option>';
                }
            }
        }

        if ($type == 'add_bank_account') {
            $insert = $this->db_houses->insertIntoBank($elems);
            if ($insert) {
                $bank = $this->db_houses->getBankInfoById($insert);

                foreach ($bank as $key) {
                    echo '<option value="' . $key['id'] . '">' . $key['name'] . '(' . $key['account_no'] . ')</option>';
                }
            }
        }
    }

    //End saveDistributorAndBankAccount

    /*
     * End Distribution House /
     */

    /*
     * Start distributor /
     */
    public function distributorIndex() {
        $data['distributor'] = $this->db_houses->getDistributor();

        $this->load->view('db_house/distributor/distributor_index', $data);
    }

    public function createDistributor() {
        $this->load->view('db_house/distributor/distributor_create');
    }

    public function saveDistributor() {
        $data1 = array('address_name' => $this->input->post('distributor_address'), 'mobile1' => $this->input->post('mobile_no'));
        $insert1 = $this->db_houses->insertIntoAddress($data1);

        $data = array('distributor_name' => $this->input->post('distributor_name'), 'distributor_code' => $this->input->post('distributor_code'), 'distributor_description' => $this->input->post('distributor_description'), 'distributor_address_id' => $insert1);

        $insert = $this->db_houses->insertDistributorInfo($data);
        if ($insert) {
            redirect(site_url('db_house/distributorIndex'));
        }
    }

    public function distributorEditById($id) {
        $data['distributor'] = $this->db_houses->getDistributorInfoById($id);

        $data['address'] = $this->db_houses->getAddress();
        $this->load->view('db_house/distributor/distributor_edit', $data);
    }

    public function distributorUpdateById($id) {
        $data = array('distributor_name' => $this->input->post('distributor_name'), 'distributor_code' => $this->input->post('distributor_code'), 'distributor_description' => $this->input->post('distributor_description'), 'distributor_address_id' => $this->input->post('distributor_address_id'));
        $update_distributor = $this->db_houses->updateDistributorInfoById($id, $data);
        $data1 = array('address_name' => $this->input->post('distributor_address_name'), 'mobile1' => $this->input->post('mobile_no'),
        );

        $address_id = $this->input->post('distributor_address_id');
        $update_distributor_address = $this->db_houses->updateAddressById($address_id, $data1);
        if ($update_distributor_address) {
            redirect(site_url('db_house/distributorIndex'));
        }
    }

    public function distributorDeleteById($id) {
        $del = $this->db_houses->deleteDistributorInfoById($id);
        redirect(site_url('db_house/distributorIndex'));
    }

    /*
     * End distributor /
     */

    /*
     * Start Bank Info/
     */

    public function bankIndex() {
        $data['bank'] = $this->db_houses->getBankInfo();
        $this->load->view('db_house/bank_info/bank_index', $data);
    }

    public function createBank() {
        $this->load->view('db_house/bank_info/bank_create');
    }

    public function saveBank() {
        $insert = $this->db_houses->insertIntoBank($_POST);
        if ($insert) {
            redirect(site_url('db_house/bankIndex'));
        }
    }

    public function bankEditById($id) {
        $data['bank'] = $this->db_houses->GetBankInfoById($id);
        $this->load->view('db_house/bank_info/bank_edit', $data);
    }

    public function bankUpdateById($id) {

        $update = $this->db_houses->updateTbldAccountById($id, $_POST);
        if ($update) {
            redirect(site_url('db_house/bankIndex'));
        }
    }

    public function bankDeleteById($id) {
        $del = $this->db_houses->deleteAccountById($id);
        redirect(site_url('db_house/bankIndex'));
    }

    /*
     * End Bank Info/
     */

    /*
     * Start DB Type/
     */

    public function dbTypeIndex() {
        $data['type'] = $this->db_houses->getTypeInfo();
        $this->load->view('db_house/db_type/db_type_index', $data);
    }

    public function createDbType() {
        $this->load->view('db_house/db_type/db_type_create');
    }

    public function saveDbType() {
        $insert = $this->db_houses->insertDbType($_POST);
        if ($insert) {
            redirect(site_url('db_house/dbTypeIndex'));
        }
    }

    public function dbTypeEditById($id) {
        $data['type'] = $this->db_houses->getDbTypeInfoById($id);
        $this->load->view('db_house/db_type/db_type_edit', $data);
    }

    public function dbTypeUpdateById($id) {

        $update = $this->db_houses->updateTbldTypeById($id, $_POST);
        if ($update) {
            redirect(site_url('db_house/dbTypeIndex'));
        }
    }

    public function dbTypeDeleteById($id) {
        $del = $this->db_houses->deleteTypeById($id);
        redirect(site_url('db_house/dbTypeIndex'));
    }

    /*
     * End DB Type/
     */

    /*
     * Start Distribution Employee Hierarchy/
     */

    public function distributionEmployeeHierarchyIndex() {
        $data['dist_role_name'] = $this->db_houses->getAllDistributionHierarchys();
        $this->load->view('db_house/distribution_employee_hierarchy/distribution_employee_hierarchy_index', $data);
    }

    public function createDistributionEmployeeHierarchy() {
        $data['dist_role_name'] = $this->db_houses->getAllDistributionHierarchys();

        $this->load->view('db_house/distribution_employee_hierarchy/distribution_employee_hierarchy_create', $data);
    }

    public function saveDistributionEmployeeHierarchy() {

        $insert = $this->db_houses->insertDistributionEmployeeHierarchy($_POST);
        if ($insert) {
            redirect(site_url('db_house/distributionEmployeeHierarchyIndex'));
        }
    }

    public function distributionEmployeeHierarchyEditById($id) {
        $data['distributionEmployeeHierarchyInFoById'] = $this->db_houses->editDistributionEmployeeHierarchyById($id);
        $data['all_dist_role_name'] = $this->db_houses->getAllDistributionHierarchys();

        $this->load->view('db_house/distribution_employee_hierarchy/distribution_employee_hierarchy_edit', $data);
    }

    public function distributionEmployeeHierarchyUpdateById($id) {

        $update = $this->db_houses->updateDistributionEmployeeHierarchyById($id, $_POST);
        if ($update) {
            redirect(site_url('db_house/distributionEmployeeHierarchyIndex'));
        }
    }

    public function distributionEmployeeHierarchyDeleteById($id) {

        $this->db_houses->deleteDistributionEmployeeHierarchyById($id);
        redirect(site_url('db_house/distributionEmployeeHierarchyIndex'));
    }

    /*
     * End Distribution Employee  Hierarchy/
     */

    /*
     * Start Distribution Employee/
     */

    public function distributionEmployeeIndex() {
        $user_role_code = $this->session->userdata('user_role_code');
        if ($user_role_code == 'DB') {
            $emp_id = $this->session->userdata('emp_id');
            $dbh_id = $this->db_houses->getDBId($emp_id);
            $dbhouse_id = $dbh_id[0]['distribution_house_id'];
        } else {
            $dbhouse_id = '';
        }


        $data['dist_emp'] = $this->db_houses->getAllDistEmp($dbhouse_id);
        if ($user_role_code == 'MIS') {
            $this->load->view('db_house/distribution_employee/distribution_employee_index_for_mis');
        } else {
            $this->load->view('db_house/distribution_employee/distribution_employee_index_for_all', $data);
        }
    }

    public function createDistributionEmployee() {
        //        $data['dist_role_id'] = $this->db_houses->getAllDistributionHierarchys();
        $data['dist_role_id'] = $this->db_houses->get_role_list();
        $data['user_id'] = $this->db_houses->getAllUser();
        $data['manager_id'] = $this->db_houses->getAllDistEmp();
        $data['sales_manager_id'] = $this->db_houses->getAllSalesEmp();
        $data['dbhouse_name'] = $this->db_houses->getAllDbHouses();

        //$data[ 'point_name' ] = $this->db_houses->getAllPoint();
        $this->load->view('db_house/distribution_employee/distribution_employee_create', $data);
    }

    public function saveDistributionEmployee() {
        $photo = $this->input->post('photo');

        if (isset($photo)) {
            $config['upload_path'] = 'images/db_employee_photos/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '20000';
            $config['max_width'] = '2056';
            $config['max_height'] = '1000';
            $error = '';
            $fdata = array();
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $error = $this->upload->display_errors();
            } else {
                $fdata = $this->upload->data();
                $db_photo = $config['upload_path'] . $fdata['file_name'];
            }
        }

        /* image uploading end */

        $emp_code = $this->input->post('dist_emp_code');
        $manager = $this->input->post('manager_id');
        $dbhouse_id = $this->input->post('dbhouse_id');

        //        $distribution_point = $this->input->post( 'distribution_point' );
        //        $db_id = $this->db_houses->getDistributionHouseId( $distribution_point );
        //        foreach ( $db_id as $db_ids ) {
        //            $dbhouse_id = $db_ids[ 'dbhouse_id' ];
        //        }
        $data2 = array('address_name' => $this->input->post('dist_address'), 'owner_image' => $db_photo);
        $insert1 = $this->db_houses->insertIntoAddress($data2);

        $j_date = $this->input->post('joining_date');
        $joining_date = date("Y-m-d", strtotime($j_date));

        $d_o_b = $this->input->post('d_o_b');
        $date_of_birth = date("Y-m-d", strtotime($d_o_b));

        $data = array('dist_emp_code' => $emp_code, 'first_name' => $this->input->post('dist_first_name'), 'middle_name' => $this->input->post('dist_middle_name'), 'last_name' => $this->input->post('dist_last_name'), 'dist_emp_address' => $insert1, 'dist_role_id' => $this->input->post('dist_role_id'), 'login_user_id' => $this->input->post('login_user_id'), 'manager_id ' => $manager, 'contact_no ' => $this->input->post('contact_no'), 'joining_date' => $joining_date, 'designation' => $this->input->post('designation'), 'performance_grade' => $this->input->post('performance_grade'), 'd_o_b' => $date_of_birth, 'email' => $this->input->post('email'), 'experience' => $this->input->post('experience'), 'emergency_contact_person' => $this->input->post('emergency_contact_person'), 'emergency_contact_number' => $this->input->post('emergency_contact_number'), 'educational_qualification' => $this->input->post('educational_qualification'), 'distribution_house_id' => $dbhouse_id, 'active' => 1);
//        print_r($data);
//        die();
        $insert_id = $this->db_houses->insertDistributionHouseEmployee($data);

        $inserts = $this->db_houses->getDistEmpIdByCode($emp_code);
        foreach ($inserts as $inserts_value) {
            $e_id = $inserts_value['id'];
        }
        $data1 = array('dist_emp_id' => $insert_id, 'so_serial' => '1',
        );
        $insert_serial = $this->db_houses->insertSrSoSerialData($data1);

        $get_data = $this->db_houses->getDistEmpIdByCode($emp_code);
        foreach ($get_data as $emp_id) {
            $res = tree_data('tree_distribution_employee', 'dist_emp_id', $emp_id['id'], $manager, 'below');
        }

        if ($res) {
            redirect(site_url('db_house/distributionEmployeeIndex'));
        }
    }

    public function edit_dist_emp_done($id) {
        $address_id = $this->input->post('address_id');

        $photo = $this->input->post('photo');
        $pre_photo = $this->input->post('previous_photo');
        if (empty($photo)) {
            $update_photo = $pre_photo;
        }
        if (isset($photo)) {
            $config['upload_path'] = 'images/db_employee_photos/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '20000';
            $config['max_width'] = '2056';
            $config['max_height'] = '1000';
            $error = '';
            $fdata = array();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $error = $this->upload->display_errors();
            } else {
                $file = $pre_photo;

                if (file_exists($file)) {
                    unlink($file);
                }

                $fdata = $this->upload->data();
                $update_photo = $config['upload_path'] . $fdata['file_name'];
            }
        }

        $emp_code = $this->input->post('dist_emp_code');
        $manager = $this->input->post('manager_id');
        $dbhouse_id = $this->input->post('dbhouse_id');

        //        $distribution_point = $this->input->post( 'distribution_point' );
        //        $db_id = $this->db_houses->getDistributionHouseId( $distribution_point );
        //        foreach ( $db_id as $db_ids ) {
        //            $dbhouse_id = $db_ids[ 'dbhouse_id' ];
        //        }
        $data2 = array(
            'address_name' => $this->input->post('address'),
            'owner_image' => $update_photo
        );
        $insert1 = $this->db_houses->updateTbl('tbld_address', $address_id, $data2);

        $j_date = $this->input->post('joining_date');
        $joining_date = date("Y-m-d", strtotime($j_date));

        $d_o_b = $this->input->post('d_o_b');
        $date_of_birth = date("Y-m-d", strtotime($d_o_b));

        $data = array(
            'dist_emp_code' => $emp_code,
            'first_name' => $this->input->post('first_name'),
            'middle_name' => '',
            'last_name' => $this->input->post('last_name'),
            'dist_role_id' => $this->input->post('dist_role_id'),
            'login_user_id' => $this->input->post('login_user_id'),
            'manager_id ' => $manager,
            'sales_manager_id ' => $this->input->post('sales_manager_id'),
            'contact_no ' => $this->input->post('contact_no'),
            'joining_date' => $joining_date,
            'designation' => $this->input->post('designation'),
            'performance_grade' => $this->input->post('performance_grade'),
            'd_o_b' => $date_of_birth,
            'email' => $this->input->post('email'),
            'experience' => $this->input->post('experience'),
            'emergency_contact_person' => $this->input->post('emergency_contact_person'),
            'emergency_contact_number' => $this->input->post('emergency_contact_number'),
            'educational_qualification' => $this->input->post('educational_qualification'),
            'distribution_house_id' => $dbhouse_id
        );

        $this->db_houses->updateTbl('tbld_distribution_employee', $id, $data);

        redirect(site_url('db_house/distributionEmployeeIndex'));
    }

    //    public function edit_dist_emp_done($id)
    //    {
    //        $address = array('address_name' => $this->input->post('address')
    //
    //        );
    //
    //        $this->db_houses->updateTbl('tbld_address', $this->input->post('emp_address_id'), $address);
    //        $employee = array('dist_emp_code' => $this->input->post('dist_emp_code'), 'first_name' => $this->input->post('first_name'), 'middle_name' => $this->input->post('middle_name'), 'last_name' => $this->input->post('last_name'), 'dist_role_id' => $this->input->post('dist_role_id'), 'manager_id' => $this->input->post('manager_id'), 'sales_manager_id' => $this->input->post('sales_manager_id'), 'distribution_house_id' => $this->input->post('dbhouse_id'), 'login_user_id' => $this->input->post('login_user_id'));
    //
    //        $this->db_houses->updateTbl('tbld_distribution_employee', $id, $employee);
    //
    //        redirect(site_url('db_house/distributionEmployeeIndex'));
    //    }

    public function distributionEmployeeEditById($id) {

        $data['dbhouse_name'] = $this->db_houses->getAllDbHouses();

        $data['business_zone'] = $this->db_houses->getAllBusinessZone();
        $data['distribution_employee'] = $this->db_houses->getDistEmpNameById($id);
        foreach ($data['distribution_employee'] as $k) {
            $dist_emp_address = $k['dist_emp_address'];
        }
        $data['address'] = $this->db_houses->getEmpAddress($dist_emp_address);

        //$data['dist_role_ids'] = $this->db_houses->getAll_Distribution_hierarchys();
        $data['dist_role_ids'] = $this->db_houses->get_role_list();
        $data['user_id'] = $this->db_houses->getAllUser();
        $data['manager_ids'] = $this->db_houses->getAllDistEmp();
        $data['sales_manager_ids'] = $this->db_houses->getAllSalesEmp();

        //        $skus = $this->Configs->selectConfigParam('dbhouse_sku_layer_map');
        //        foreach ($skus as $sku) {
        //            $sku_hierarchy_data = $sku['attribute_id'];
        //        }
        //        $data['sku_element_names'] = $this->db_houses->getSkuElementsByLayerId($sku_hierarchy_data);
        //        $data['zone_info'] = $this->db_houses->getZoneInfo($id);
        //        $data['pl'] = $this->db_houses->getSrPl($id)[0]['pl_id'];
        //

        //        echo '<pre>';
        //        print_r($data['distribution_employee']);
        //        die();
        $this->load->view('db_house/distribution_employee/distribution_employee_edit', $data);
    }

    public function distributionEmployeeDetailById($id) {
        $data['db_emp_id'] = $id;
        $data['dbhouse_name'] = $this->db_houses->getAllDbHouses();

        $data['business_zone'] = $this->db_houses->getAllBusinessZone();
        $data['distribution_employee'] = $this->db_houses->getDistEmpNameById($id);
        foreach ($data['distribution_employee'] as $k) {
            $dist_emp_address = $k['dist_emp_address'];
        }
        $data['address'] = $this->db_houses->getEmpAddress($dist_emp_address);

        $data['dist_role_ids'] = $this->db_houses->getAll_Distribution_hierarchys();
        $data['user_id'] = $this->db_houses->getAllUser();
        $data['manager_ids'] = $this->db_houses->getAllDistEmp();

        $data['sales_manager_ids'] = $this->db_houses->getAllSalesEmp();

        //        $skus = $this->Configs->selectConfigParam('dbhouse_sku_layer_map');
        //        foreach ($skus as $sku) {
        //            $sku_hierarchy_data = $sku['attribute_id'];
        //        }
        //        $data['sku_element_names'] = $this->db_houses->getSkuElementsByLayerId($sku_hierarchy_data);
        //        $data['zone_info'] = $this->db_houses->getZoneInfo($id);
        //        $data['pl'] = $this->db_houses->getSrPl($id)[0]['pl_id'];
        //

        $this->load->view('db_house/distribution_employee/distribution_employee_detail', $data);
    }

    public function distributionEmployeeDeleteById($id) {
        $del = $this->db_houses->deleteTbldDistributionEmployeeById($id);
        if ($del) {
            redirect(site_url('db_house/distributionEmployeeIndex'));
        }
    }

    /*
     * End Distribution Employee Hierarchy/
     */

    /*
     * Start Business area/
     */

    public function getDistricts() {
        $division = $this->input->post('division');
        $district = $this->input->post('district');
        $data = $this->db_houses->getDistrict($division, $district);

        echo json_encode($data);
    }

    public function getThana() {
        $district = $_POST ['district'];
        $data = $this->db_houses->getThana($district);
        echo json_encode($data);
    }

    public function getUnion() {
        $thana = $_POST ['thana'];
        $data = $this->db_houses->getUnion($thana);
        echo json_encode($data);
    }

    public function getVillage() {
        $union = $_POST ['union'];
        $data = $this->db_houses->getVillage($union);
        echo json_encode($data);
    }

    public function get_user_id() {
        $role_id = $this->input->post('dist_role_id');
        $data = $this->db_houses->get_user_list_by_role($role_id);
        echo json_encode($data);
    }

    public function getFilterData() {
        $db_id = $this->input->post('db_id');
        $db_ids = implode(',', $db_id);
        $data['dist_emp'] = $this->db_houses->getAllDistEmp($db_ids);
        $this->load->view('db_house/distribution_employee/db_employee_filter', $data);
    }

    /*
     * End Business area/
     */
}
