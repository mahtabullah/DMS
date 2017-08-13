<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<?php
foreach ($dbhouse as $key) {
    $id = $key['id'];
    $dbhouse_name = $key['dbhouse_name'];
    $dbhouse_code = $key['dbhouse_code'];
    $dbhouse_description = $key['dbhouse_description'];
    $dbhouse_address_id = $key['dbhouse_address_id'];
    $distributor_address_id = $key['distributor_address_id'];
    $dbhouse_address_name = $key['address_name'];
    $distributor_id = $key['distributor_id'];
    $distributor_name = $key['distributor_name'];
    $db_house_status = $key['db_house_status'];
    $delivery_module_status = $key['delivery_module_status'];
    $bundle_price_id = $key['bundle_price_id'];
    $wh_manager_name = $key['wh_manager_name'];
    $telephone_number = $key['telephone_number'];
    $office_address = $key['office_address'];
    $warehouse_address = $key['warehouse_address'];
    $distributor_address = $key['distributor_address'];
    $distributor_division_id = $key['distributor_division_id'];
    $distributor_district_id = $key['distributor_district_id'];
    $distributor_thana_id = $key['distributor_thana_id'];
    $distributor_union_id = $key['distributor_union_id'];
    $distributor_village = $key['distributor_village'];
    $distributor_mobile_number = $key['distributor_mobile_number'];
    $wh_manager_contruct_no = $key['wh_manager_contruct_no'];
    $db_point = $key['db_point'];
    $cluster_id = $key['cluster_id'];
    $business_zone_id = $key['biz_zone_id'];
    $bank_account_id = $key['bank_account_id'];
    $db_type_id = $key['type'];
    $db_email = $key['email'];
    $distributor_email = $key['distributor_email'];
    $db_credit_limit = $key['db_credit_limit'];
    $db_vat = $key['vat_no'];
    $db_tin = $key['tin_no'];
    $creation_date = $key['create_date'];
    $east = $key['east'];
    $west = $key['west'];
    $north = $key['north'];
    $south = $key['south'];
    $road = $key['street1'];
    $village = $key['street2'];
    $village_id = $key['village_id'];
    $union_id = $key['union_id'];
    $thana_id = $key['thana_id'];
    $district_id = $key['district_id'];
    $division_id = $key['division_id'];
    $village_name = $key['village_name'];
    $union_name = $key['union_name'];
    $thana_name = $key['thana_name'];
    $district_name = $key['district_name'];
    $category = $key['category'];
    if ($key['business_opening_date'] == '0000-00-00') {
        $business_opening_date = '';
    } else {
        $business_opening_date = date('d-m-Y', strtotime($key['business_opening_date']));
    }
}
?> 

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    DB House Configuration
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/distributionHouseIndex'); ?>">Distribution House</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Edit
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Edit
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('db_house', 'UpdateDbHouseById', $id);
echo site_url($segments); ?>" method="post" onsubmit="return validateStandard(this);">
                            <div class="form-body">
                                <h3>Distributor Information</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_name">Distributor Name</label>
                                        <input type="text" class="form-control" placeholder="Distribution House Name"
                                               id="dbhouse_name"
                                               name="dbhouse_name" value="<?php echo $dbhouse_name; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dbhouse_code">Distributor Code</label>
                                        <input type="text" class="form-control" placeholder="Distribution House Code"
                                               id="dbhouse_code"
                                               name="dbhouse_code" value="<?php echo $dbhouse_code; ?>">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_description">Description</label>
                                        <input type="text" class="form-control" rows="4"
                                               placeholder="Distribution House Description"
                                               id="dbhouse_description" name="dbhouse_description"
                                               value="<?php echo $dbhouse_description; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="db_house_status">Status </label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="db_house_status"
                                                name="db_house_status">
                                            <option value=""></option>
                                            <?php
                                            foreach ($status as $key) {

                                                $selected_owner = ($key['id'] == $db_house_status) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['db_house_status_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="db_type">Type </label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="db_type"
                                                name="db_type" onchange="get_dbh_type()">
                                            <option value=""></option>
                                            <?php
                                            foreach ($db_type as $key) {
                                                $selected_owner = ($key['id'] == $db_type_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sku_bundle_price">SKU Bundle Price<span style="color: red">*</span> </label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="sku_bundle_price"
                                                name="sku_bundle_price" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($bundle_prices as $key) {
                                                $selected_owner = ($key['id'] == $bundle_price_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>

                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="db_email"> Email</label>
                                        <input type="email" class="form-control " placeholder="Enter DB Email"
                                               id="db_email"
                                               name="db_email" err="Please Enter Valid DB Email Address"
                                               regexp="JSVAL_RX_EMAIL" value="<?php echo $db_email ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="db_house_status">Cluster </label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="cluster"
                                                name="cluster">
                                            <option value=""></option>
                                            <?php
                                            foreach ($cluster as $key) {
                                                $selected_owner = ($key['id'] == $cluster_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="db_vat_no"> VAT No:</label>
                                        <input type="text" class="form-control " placeholder="Enter VAT No"
                                               id="db_vat_no"
                                               name="db_vat_no" value="<?php echo $db_vat; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="db_tin_no"> TIN No:</label>
                                        <input type="text" class="form-control " placeholder="Enter DB Tin No"
                                               id="db_tin_no"
                                               name="db_tin_no" value="<?php echo $db_tin; ?>">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="db_credit_limit"> Credit Limit (BDT)</label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Enter DB Credit Limit"
                                               id="db_credit_limit" name="db_credit_limit" value="<?php echo $db_credit_limit; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="creation_date">Creation Date</label>
                                            <input type="text" class="form-control" name="creation_date"
                                                   value="<?php echo $creation_date; ?>"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="wh_manager_name"> W/H Manager Name</label>
                                        <input type="text" class="form-control " placeholder="W/H Manager Name"
                                               id="wh_manager_name"
                                               name="wh_manager_name" value="<?php echo $wh_manager_name; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="db_tin_no"> Contact No</label>
                                        <input type="text" class="form-control "
                                               placeholder="Contact No"
                                               id="wh_manager_contruct_no"
                                               name="wh_manager_contruct_no"
                                               value="<?php echo $wh_manager_contruct_no; ?>">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_description">Office Address</label>
                                        <textarea class="form-control" rows="4"
                                                  placeholder="Type Office Address"
                                                  id="office_address" name="office_address"><?php echo $office_address; ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dbhouse_description">Warehouse Address</label>
                                        <textarea class="form-control" rows="4"
                                                  placeholder="Type Warehouse Address"
                                                  id="warehouse_address" name="warehouse_address"><?php echo $warehouse_address; ?></textarea>
                                    </div>
                                </div>
                                <br />

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="db_house_status">Delivery Module Status </label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="delivery_module_status"
                                                name="delivery_module_status">
                                            <option value="1" <?php if($delivery_module_status==1){echo 'selected';} ?>>Active</option>
                                            <option value="2" <?php if($delivery_module_status !=1){echo 'selected';} ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <h3>Address</h3>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_address_id">Memo Address[max length:20] </label>

                                        <input type="text" class="form-control" placeholder="Enter DB House Address"
                                               id="dbhouse_address_id" maxlength="20"
                                               name="dbhouse_address" value="<?php echo $dbhouse_address_name; ?>">
                                        <input type="hidden" name="db_address_id" value="<?php echo $dbhouse_address_id; ?>">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">

                                    <div class="col-md-6">
                                        <label class="control-label" for="road">Road/House No.</label>
                                        <input type="text" class="form-control" data-placeholder="Select..." id="road"
                                               placeholder="Enter Road/House No." name="road" value="<?php echo $road; ?>">

                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="village">Village</label>
                                        <input type="text" class="form-control" data-placeholder="Select..."
                                               placeholder="Enter Village" id="village" name="village" value="<?php echo $village; ?>">

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="division">Division</label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="division"
                                                name="division" onchange="get_district()">
                                            <option value=""></option>
                                            <?php
                                            foreach ($division as $key) {
                                                $selected_owner = ($key['id'] == $division_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="district">District</label>
                                        <select class="form-control select2me" id="district" name="district"
                                                onchange="get_thana()">
                                            <option value=""></option>
                                            <?php
                                            foreach ($district as $key) {
                                                $selected_owner = ($key['id'] == $dbhouse[0]['district_id']) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="thana">Thana</label>
                                        <select class="form-control select2me" id="thana" name="thana"
                                                onchange="get_union()">
                                            <option value=""></option>
                                            <?php
                                            foreach ($thana as $key) {
                                                $selected_owner = ($key['id'] == $dbhouse[0]['thana_id']) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="union">Union</label>
                                        <select class="form-control select2me" id="union" name="union"">
                                            <option value=""></option>
                                            <?php
                                            foreach ($union as $key) {
                                                $selected_owner = ($key['id'] == $dbhouse[0]['union_id']) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <h3>Owner Information</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_name"> Distributor Owner </label>
                                        <input type="text" class="form-control" placeholder="Enter Owner Name"
                                               id="owner_name"
                                               name="distributor_name" value="<?php echo $distributor_name ?>"/>
                                        <input type="hidden" value="<?php echo $distributor_id ?>" name="distributor_id">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_address">Residential Address</label><br>
                                        <input type="text" class="form-control" placeholder="Road/House"
                                               id="road" name="distributor_address"
                                               value="<?php echo $distributor_address; ?>">
                                        <input type="hidden" name="distributor_address_id" value="<?php echo $distributor_address_id ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="village">Village</label>
                                        <input type="text" class="form-control" placeholder="Village"
                                               id="village"
                                               name="distributor_village" value="<?php echo $distributor_village; ?>">
                                    </div>
                                </div>


                                <div class="row"><br>

                                    <div class="col-md-6">
                                        <label for="division1">Division</label>
                                        <select class="form-control select2me" data-placeholder="Division"
                                                id="division1"
                                                name="distributor_division" onchange="get_district1()">
                                            <option value=""></option>

                                            <?php
                                            foreach ($division as $key) {
                                                $selected_owner = ($key['id'] == $distributor_division_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="district1">District</label>
                                        <select class="form-control select2me" data-placeholder="District"
                                                id="district1" name="distributor_district"
                                                onchange="get_thana1()">
                                            <option value=""></option>
                                            <?php
                                            foreach ($distributor_district as $key) {
                                                $selected_owner = ($key['id'] == $distributor_district_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="thana1">Thana</label>
                                        <select class="form-control select2me" id="thana1" data-placeholder="Thana"
                                                name="distributor_thana" onchange="get_union1()">
                                            <option></option>
                                            <?php
                                            foreach ($distributor_thana as $key) {
                                                $selected_owner = ($key['id'] == $distributor_thana_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="union1">Union</label>
                                        <select class="form-control select2me" id="union1" data-placeholder="Union" name="distributor_union">
                                            <option></option>
                                            <?php
                                            foreach ($distributor_union as $key) {
                                                $selected_owner = ($key['id'] == $distributor_union_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_mobile_no">Mobile No </label>
                                        <input class="form-control integer-input"
                                               placeholder="01XXXXXXXXX"
                                               name="mobile1" value="<?php echo $distributor_mobile_number; ?>"
                                               id="mobile" type="text" onblur="check();
                                                       return false;"><span id="message" style="color:red;"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="owner_address">Email Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Owner Email Address"
                                               id="owner_address" value="<?php echo $distributor_email; ?>"
                                               name="distributor_email" err="Please Enter Valid Owner Email Address"
                                               regexp="JSVAL_RX_EMAIL">
                                    </div>

                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_mobile_no">Telephone No </label>
                                        <input class="form-control integer-input"
                                               placeholder="02XXXXXXX"
                                               name="mobile2" value="<?php echo $telephone_number; ?>"
                                               id="telephone" type="text" onblur="check_2();
                                                       return false;"><span id="message2" style="color:red;"></span>
                                    </div>
                                </div>
                                <br/>

                                <h3>GEO Info</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="business_zone_layer">Business
                                                Unit:</label><span style="color: red">*</span>
                                            <select class="form-control" data-placeholder="Select..."
                                                    id="business_zone_layer"
                                                    name="business_zone_layer">
                                                <option value="">Choose zone</option>
                                                <?php
                                                foreach ($business_zone as $key) {
                                                    $selected_owner = ($key['id'] == $assign_unit) ? " selected='selected'" : "";
                                                    echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['biz_zone_name'] . '</option>';
                                                }
                                                ?>

                                            </select>
                                            <span class="help-block">
                                                select Business Unit
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="business_zone_name"> Territory:</label><span style="color: red">*</span>
                                            <select class="form-control" id="business_zone_name"
                                                    name="business_zone_name">

                                                <option></option>
                                                <?php
                                                foreach ($territory as $key) {
                                                    $selected_owner = ($key['id'] == $assign_territory) ? " selected='selected'" : "";
                                                    echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="help-block">
                                                select Territory
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="biz_zone_id">CE Area: </label> <span style="color: red">*</span>
                                            <select class="form-control" id="territory" name="territory"
                                                    onchange="get_distribution_house()" required>
                                                <option></option>
                                                <?php
                                                foreach ($ce_area as $key) {
                                                    $selected_owner = ($key['id'] == $assign_ce_area) ? " selected='selected'" : "";
                                                    echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="help-block">
                                                select CE Area
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group" id="select_hub">
                                            <label for="hub">Select HUB: </label> <span style="color: red">*</span>
                                            <select class="form-control" id="hub" name="hub">
                                            </select>
                                            <span class="help-block">
                                                select Hub
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br/>


                                <hr>
                                <div class="portlet box purple">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i><?php echo "Bank Info"; ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table  table-hover" id="bank_info">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Account Holder Name
                                                        </th>
                                                        <th>
                                                            Account No
                                                        </th>
                                                        <th>
                                                            Bank Name
                                                        </th>
                                                        <th>
                                                            Branch Name
                                                        </th>
                                                        <th>
                                                            Bank Type
                                                        </th>
                                                        <th>
                                                            Mobile No
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_cycle_bank_info">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <a class="btn green row_add" id="row_add_bank"
                                                               onclick="add_row_bank()"><i class="fa fa-plus"></i>Add</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="portlet box purple">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i><?php echo "Asset"; ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table  table-hover" id="expenseAmount">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Asset Name
                                                        </th>
                                                        <th>
                                                            Asset Market Value
                                                        </th>
                                                        <th>
                                                            QTY
                                                        </th>
                                                        <th>
                                                            Action
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_cycle">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <a class="btn green row_add" id="row_add"
                                                               onclick="add_row()"><i class="fa fa-plus"></i>Add</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="portlet box purple">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i> Vehicle
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table  table-hover" id="vehicle">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Vehicle Code
                                                        </th>
                                                        <th>
                                                            Vehicle Name
                                                        </th>
                                                        <th>
                                                            Type
                                                        </th>
                                                        <th>
                                                            Reg.Number
                                                        </th>
                                                        <th>
                                                            Driver Name
                                                        </th>
                                                        <th>
                                                            Contact No.(Driver)
                                                        </th>
                                                        <th>
                                                            Exp.Date of Reg.No
                                                        </th>
                                                        <th>
                                                            Action
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle_tbody">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7"></td>
                                                        <td>
                                                            <a class="btn green row_add" id="row_add"
                                                               onclick="addVehicleRow()"><i class="fa fa-plus"></i>Add</a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Save</button>
                                    <button type="button" class="btn default"
                                            onclick="document.location.href = '<?php echo site_url('db_house/distributionHouseIndex'); ?>'">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer/footer');
?>


<script>

    $(document).ready(function () {
        get_bank_details();
        get_assets_details();
        get_vehicle_details();

        var $db_type_id = '<?php echo $db_type_id ?>';
        if ($db_type_id != "6")
        {
            $('#select_hub').hide();
        } else {
            $('#select_hub').show();
        }
    });

    function get_dbh_type() {
        var db_type = $('#db_type').val();
        if (db_type == "6") {
            $('#hub').attr('required', true);
            $('#select_hub').show();
        } else {
            $('#select_hub').css('display', 'none');
            $('#hub').attr('required', false);
        }
    }

    function get_distribution_house() {
        var territory = $('#territory').val();
        $('#hub').empty();
        $('#hub').append('<option value=""></option>');

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getDBHbyterritory/",
            data: {territory: territory},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#hub').append("<option value='" + data[i].id + "'>" + data[i].dbhouse_name + "</option>");
                }
            }
        });
    }



    function get_bank_details()
    {
        var db_id = '<?php echo $id; ?>';

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getBankInfobyDbId/",
            data: {db_id: db_id},
            dataType: "json",
            success: function (data) {
                //alert(JSON.stringify(data));
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    add_row_bank(i);
                    $('#acc_holder_name' + i).val(data[i].name);
                    $('#acc_no' + i).val(data[i].account_no);
                    $('#bank_name' + i).val(data[i].bank_name);
                    $('#branch_name' + i).val(data[i].branch_name);
                    $('#bank_type' + i).select2('val', data[i].bank_type);
                    $('#mobile_no_bank' + i).val(data[i].mobile_no);


                }

            }
        });
    }


    function get_assets_details()
    {
        var db_id = '<?php echo $id; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getAssetsbyDbId/",
            data: {db_id: db_id},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    add_row(i);
                    var count = $("#sample tbody tr").length;

                    $('#asset_name' + i).val(data[i].name);
                    $('#asset_amount' + i).val(data[i].market_value);
                    $('#asset_qty' + i).val(data[i].qty);

                }

            }
        });
    }

    function get_vehicle_details()
    {
        var db_id = '<?php echo $id; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getVehiclesbyDbId/",
            data: {db_id: db_id},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    addVehicleRow();
                    var count = $("#sample tbody tr").length;

                    $('#vehicle_code' + i).val(data[i].vehicle_code);
                    $('#vehicle_name' + i).val(data[i].vehicle_name);
                    $('#reg_no' + i).val(data[i].reg_no);
                    $('#vehicle_type' + i).select2('val', data[i].vehicle_type);
                    $('#driver_name' + i).val(data[i].driver_name);
                    $('#contact_no' + i).val(data[i].contact_no);
                    $('#exp_date' + i).val(data[i].exp_date);

                }

            }
        });
    }




    var count;

    function add_row_bank() {

        count = $("#bank_info tbody tr").length;
        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>db_house/bankInfoRowAdd/",
            data: {count: count},
            dataType: "html",
            success: function (data) {

                $('#bank_info tbody').append(data);
                $("#bank_info tbody select").select2();

            }
        });
    }



    function add_row() {
        count = $("#expenseAmount tbody tr").length;
        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>db_house/add_po_row/",
            data: {count: count},
            dataType: "html",
            success: function (data) {
                $('#expenseAmount tbody').append(data);
                $("#expenseAmount tbody select").select2();

            }
        });
    }

    function addVehicleRow() {
        count = $("#vehicle tbody tr").length;
        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>db_house/addVehicleRow/",
            data: {count: count},
            dataType: "html",
            success: function (data) {
                $('#vehicle tbody').append(data);
                $("#vehicle tbody select").select2();
                $('.date_range').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true
                });
            }
        });
    }

    $("#expenseAmount").on('click', '.delete', function () {
        $(this).parent().parent().remove();
    });


    $("#vehicle").on('click', '.delete', function () {
        $(this).parent().parent().remove();
    });

    $("#bank_info").on('click', '.delete', function () {
        $(this).parent().parent().remove();
    });


    $('#business_zone_layer').change(function () {
        var business_zone_layer = $('#business_zone_layer').val();
        //alert(business_zone_layer);
        $('#business_zone_name').empty();
        $('#business_zone_name').append('<option value=""></option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getBusinessZoneName/",
            data: "business_zone_layer=" + business_zone_layer,
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#business_zone_name').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
                }
            }
        });
    });
    $('#business_zone_name').change(function () {
        var business_zone_name = $('#business_zone_name').val();
        $('#territory').empty();
        $('#territory').append('<option value=""></option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getTerritoryName/",
            data: "business_zone_name=" + business_zone_name,
            dataType: "json",
            success: function (data) {
                //alert(data);
                for (var i = 0; i < data.length; i++) {
                    $('#territory').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
                }
            }
        });
    });


    function get_district() {
        var division = $('#division').val();
        $('#district').empty();
        $('#district').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getDistricts",
            data: {division: division},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#district').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_district1() {
        var division = $('#division1').val();
        $('#district1').empty();
        $('#district1').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getDistricts",
            data: {division: division},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#district1').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_thana() {
        var district = $('#district').val();
        $('#thana').empty();
        $('#thana').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getThana",
            data: {district: district},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#thana').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_thana1() {
        var district = $('#district1').val();
        $('#thana1').empty();
        $('#thana1').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getThana",
            data: {district: district},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#thana1').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_union() {
        var thana = $('#thana').val();
        $('#union').empty();
        $('#union').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getUnion",
            data: {thana: thana},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#union').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_union1() {
        var thana = $('#thana1').val();
        $('#union1').empty();
        $('#union1').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getUnion",
            data: {thana: thana},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#union1').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    function get_village() {
        var union = $('#union').val();
        $('#village').empty();
        $('#village').append("<option value=''></option>");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>db_house/getVillage",
            data: {union: union},
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $('#village').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
            }
        });
    }

    $('select').change(function () {
        var a = $(this).val();
        if (a == 'add_distributor') {
            $('#model_for_add_distributor').modal('show');
            $('#add_distributor').click(function () {
                var form_data = $('#add_distributor_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>db_house/saveDistributorAndBankAccount/",
                    data: {form_data: form_data, type: 'add_distributor'},
                    dataType: "html",
                    success: function (data) {
                        $("#distributor_id option:last").before(data);
                        $("#distributor_id option:last").prev().attr('selected', true);
                        var c = $("#distributor_id option:last").prev().val();
                        $("#distributor_id").select2('val', c);
                        $('#model_for_add_distributor').modal('hide');
                    }
                });

            });
        }
        //add bank account info script

        if (a == 'add_bank_account') {
            $('#model_for_add_bank_account').modal('show');
            $('#add_bank_account').click(function () {
                var form_data = $('#add_bank_account_form').serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>db_house/saveDistributorAndBankAccount/",
                    data: {form_data: form_data, type: 'add_bank_account'},
                    dataType: "html",
                    success: function (data) {
                        $("#bank_acount_id option:last").before(data);
                        $("#bank_acount_id option:last").prev().attr('selected', true);
                        var c = $("#bank_acount_id option:last").prev().val();
                        $("#bank_acount_id").select2('val', c);
                        $('#model_for_add_bank_account').modal('hide');
                    }
                });
            });
        }
        // end account add script

    });

    // Mobile number Validation Checking

    function check() {

        var pass = $('#mobile').val();

        if (pass.length != 11) {
            $("#message").html("Required 11 digits, match requested format!");
        } else {
            $("#message").html('');
        }
    }

    function check_2() {

        var pass = $('#telephone').val();

        if (pass.length != 9) {
            $("#message2").html("Required 9 digits, match requested format!");
        } else {
            $("#message2").html('');
        }
    }

</script>
