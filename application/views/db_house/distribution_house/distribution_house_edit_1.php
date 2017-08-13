<?php
$this->load->view( 'header/header' );
$data[ 'role' ] = $this->session->userdata( 'user_role' );
$this->load->view( 'left/left', $data );
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
                        <a href="<?php echo site_url( 'home/home_page' ); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url( 'db_house/distributionHouseIndex' ); ?>">Distribution House</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit </p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- hidden add distributor from code -->
<!--        <div class="modal fade" id="model_for_add_distributor" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h2 class="modal-title">Add Distributor</h2>
                    </div>
                    <div class="modal-body" id="popup_body">
                        <form method="POST" id="add_distributor_form">
                            <div class="portlet" id="dialog-form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="owner_name">Owner Name <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Owner Name"
                                                   id="owner_name"
                                                   name="distributor_name"  required/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="owner_code">Owner Code <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Owner Code"
                                                   id="owner_code"
                                                   name="distributor_code" required/>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="owner_address">Owner Address</label>
                                            <input type="text" class="form-control" placeholder="Enter Owner Address"
                                                   id="owner_address"
                                                   name="address_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="owner_mobile_no">Owner Mobile No <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control integer-input"
                                                   placeholder="Enter Owner Mobile"
                                                   id="owner_mobile_no" name="mobile1" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn default" data-dismiss="modal" id="close_popup">Close</button>
                        <button type="submit" value="submit" class="btn blue" id="add_distributor">Add</button>
                    </div>
                </div>
            </div>
        </div>-->
        <!--hidden add distributor from code end -->


        <!-- hidden add bank_account from code -->
<!--        <div class="modal fade" id="model_for_add_bank_account" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h2 class="modal-title">Add Bank Account</h2>
                    </div>
                    <div class="modal-body" id="popup_body">
                        <form method="POST" id="add_bank_account_form">
                            <div class="portlet" id="dialog-form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="ho_name">Account Holder Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Account Holder Name" id="ho_name"
                                                   name="name" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="account_no">Account No <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Account No"
                                                   id="account_no"
                                                   name="account_no" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="bank_name">Bank Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Bank Name"
                                                   id="bank_name"
                                                   name="bank_name" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="branch_name">Branch Name <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Branch Name"
                                                   id="branch_name"
                                                   name="branch_name" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="routing_number">Routing Number<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Routing Number " id="routing_number" name="routing_number" >
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn default" data-dismiss="modal" id="close_popup">Close</button>
                        <button type="button" class="btn blue" id="add_bank_account">Add</button>
                    </div>
                </div>
            </div>
        </div>-->
        <!--hidden add bank_account from code end -->

        <?php
        foreach ($dbhouse as $key) {
            $id = $key['id'];
            $dbhouse_name = $key['dbhouse_name'];
            $dbhouse_code = $key['dbhouse_code'];
            $dbhouse_description = $key['dbhouse_description'];
            $dbhouse_address_id = $key['dbhouse_address_id'];
            $dbhouse_address_name = $key['address_name'];
            $distributor_id = $key['distributor_id'];
            $db_house_status = $key['db_house_status'];
            $db_point = $key['db_point'];
            $business_zone_id = $key['biz_zone_id'];
            $bank_account_id = $key['bank_account_id'];
            $db_credit_limit = $key['db_credit_limit'];
            $db_type_id = $key['type'];
            $db_email = $key['email'];
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
                        <form role="form" action="<?php echo site_url( 'db_house/saveDbHouse' ); ?>" method="post" onsubmit="return validateStandard(this);">
                            <div class="form-body">
                                <h4>DB House Info</h4><hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_name">Name </label>
                                        <input type="text" class="form-control" placeholder="Distribution House Name"
                                               id="dbhouse_name"
                                               name="dbhouse_name" value="<?php echo $dbhouse_name; ?>" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dbhouse_code">Code</label>
                                        <input type="text" class="form-control" placeholder="Distribution House Code"
                                               id="dbhouse_code"
                                               name="dbhouse_code" value="<?php echo $dbhouse_code;?>">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_description">Description</label>
                                            <textarea class="form-control" rows="4"
                                                      placeholder="Distribution House Description"
                                                      id="dbhouse_description" name="dbhouse_description"><?php echo $dbhouse_description;?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="db_house_status">Status </label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="db_house_status"
                                                name="db_house_status" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($status as $key) {
                                                $selected_owner = ($key['id'] == $db_house_status) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['db_house_status_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="db_type">Type </label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="db_type"
                                                name="db_type" required>
                                            <option value=""></option>
                                            <?php foreach ($db_type as $key){
                                                $selected_owner = ($key['id'] == $db_type_id) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
<!--                                    <div class="col-md-6">
                                        <label for="distributor_id">Owner <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="distributor_id"
                                                name="distributor_id" required>
                                            <option value=""></option>
                                            <?php //foreach ( $owner as $owner_name ) { ?>
                                                <option
                                                    value="<?php //echo $owner_name[ 'id' ] ?>"><?php //echo $owner_name[ 'distributor_name' ] ?></option>
                                            <?php //} ?>
                                            <option value="add_distributor">---Add Distributor---</option>
                                        </select>
                                    </div>-->

                                    <div class="col-md-6">
                                        <label for="category">Category </label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="category"
                                                name="category" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($outlet_category as $key) {
                                                $selected_owner = ($key['id'] == $category) ? " selected='selected'" : "";
                                                echo '<option value="' . $key['id'] . '"' . $selected_owner . '>' . $key['outlet_category_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                
                                
                                    <div class="col-md-6">
                                        <label for="db_point">Point</label>
                                        <input type="text" class="form-control" placeholder="Enter DB Point"
                                               id="db_point" name="db_point" value="<?php echo $db_point;?>">
                                    </div>
                                    </div>
<!--                                <br/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="bank_acount_id">DB Bank A/C Info <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="bank_acount_id"
                                                name="bank_acount_id" required>
                                            <option value=""></option>
                                            <?php //foreach ( $bank as $bank_name ) { ?>
                                                <option
                                                    value="<?php //echo $bank_name[ 'id' ] ?>"><?php //echo $bank_name[ 'name' ] . "(" . $bank_name[ 'account_no' ] . ")" ?></option>
                                            <?php //} ?>
                                            <option value="add_bank_account">---Add Bank Info---</option>
                                        </select>
                                    </div>
                               
                                
                                    <div class="col-md-6">
                                        <label for="db_credit_limit">DB Credit Limit (BDT)</label>
                                        <input type="text" class="form-control float-input" placeholder="Enter DB Credit Limit" id="db_credit_limit" name="db_credit_limit">
                                    </div>
                                     </div>-->
                                <br/>
                                <div class="row">
                                    
                                
                                
                                    <div class="col-md-6">
                                        <label for="db_email"> Email</label>
                                        <input type="text" class="form-control " placeholder="Enter DB Email"
                                               id="db_email" value="<?php echo $db_email;?>"
                                               name="db_email" err="Please Enter Valid DB Email Address" regexp="JSVAL_RX_EMAIL">
                                    </div>
                                    </div>
                                <br/>

                                <div class="row">
                                    
                                        <div class="col-md-6">
                                            <label for="db_vat_no"> Vat No:</label>
                                            <input type="text" class="form-control " placeholder="Enter Vat No"
                                                   id="db_vat_no" value="<?php echo $db_vat?>"
                                                   name="db_vat_no">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="db_tin_no"> Tin No</label>
                                            <input type="text" class="form-control " placeholder="Enter DB Tin No"
                                                   id="db_tin_no" value="<?php echo $db_tin?>"
                                                   name="db_tin_no">
                                        </div>
                                    
                                </div>
                                <br/>
                                <div class="row">
                                    
                                        <div class="col-md-6">
                                        <label for="db_credit_limit"> Credit Limit (BDT)</label>
                                        <input type="text" class="form-control float-input" placeholder="Enter DB Credit Limit" 
                                         value="<?php echo $db_credit_limit;?>"      id="db_credit_limit" name="db_credit_limit">
                                        </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="creation_date">Creation Date</label>
                                            <input type="text" class="form-control" name="creation_date" value="<?php echo $creation_date;?>" id="creation_date">
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <br/>
                                <h4>Distributor Profile</h4><hr>
                                <div class="row">
                                        <div class="col-md-6">
                                            <label for="owner_name"> Name </label>
                                            <input type="text" class="form-control" placeholder="Enter Owner Name"
                                                   id="owner_name"
                                                   name="distributor_name"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="owner_code"> Code </label>
                                            <input type="text" class="form-control" placeholder="Enter Owner Code"
                                                   id="owner_code"
                                                   name="distributor_code" />
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       
                                           
                                        <div class="col-md-6">
                                            <label for="owner_address">Residential Address</label><br>
                                            <input type="text" class="form-control" placeholder="Road/House"
                                                   id="road"
                                                   name="road">
                                        </div>
                                        <div class="col-md-6"><br>
                                            <input type="text" class="form-control" placeholder="Village"
                                                   id="village"
                                                   name="village">
                                        </div>
                                        </div>
                                        
                                    
                                    
                                      <div class="row"><br>
                                        <div class="col-md-6">
                                            <select class="form-control select2me" data-placeholder="Division" id="division1"
                                                name="division" onchange="get_district1()">
                                            <option value=""></option>
                                            <?php foreach ( $division as $divation ) { ?>
                                                <option
                                                    value="<?php echo $divation[ 'id' ] ?>"><?php echo $divation[ 'name' ] ?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                        <div class="col-md-6">
                                             <select class="form-control select2me" data-placeholder="District" id="district1" name="district"
                                                onchange="get_thana1()">

                                             </select><br><span class="help-block">Select District</span>
                                        </div>
                                        
                                        </div><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control select2me" id="thana1" data-placeholder="Thana" name="thana" onchange="get_union1()">

                                        </select><br><span class="help-block">Select Thana</span>
                                        </div>
                                        
                                    </div>
                                   
                                    <br/>
                                    <br/>
                                     <div class="row">
                                         <div class="col-md-6">
                                            <label for="owner_mobile_no">Mobile No </label>
                                            <input class="form-control integer-input"
                                                   placeholder="01XXXXXXXXX"
                                                   name="mobile1"
                                                   id="mobile" type="text" onblur="check(); 
                                                   return false;" ><span id="message" style="color:red;"></span>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="owner_address">Email Address</label>
                                            <input type="text" class="form-control" placeholder="Enter Owner Email Address"
                                                   id="owner_address"
                                                   name="distributor_email" err="Please Enter Valid Owner Email Address" regexp="JSVAL_RX_EMAIL">
                                        </div>
                                        
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="owner_mobile_no">Telephone No </label>
                                            <input class="form-control integer-input"
                                                   placeholder="02XXXXXXX"
                                                   name="mobile2"
                                                   id="telephone" type="text" onblur="check_2(); 
                                                   return false;" ><span id="message2" style="color:red;"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="bank_name">Bank Name </label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Bank Name"
                                                   id="bank_name" name="bank_name" />
                                        </div>
                                        
                                    </div><br />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="bank_acount_id">Bank Account No.</label>
                                            <input type="text" class="form-control" placeholder="Enter Bank Account Number"
                                                   id="account_no"
                                                   name="account_no">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="branch_name">Branch Name </label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Branch Name"
                                                   id="branch_name" name="branch_name" />
                                        </div>
                                    </div>
                                    <br />
                                    
<!--                                <h4>Demarcation</h4><hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="east">East</label>
                                        <input type="text" class="form-control " placeholder="Location" id="east"
                                               name="east">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="west">West</label>
                                        <input type="text" class="form-control " placeholder="Location" id="west"
                                               name="west">
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="north">North</label>
                                        <input type="text" class="form-control " placeholder="Location" id="north"
                                               name="north">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="south">South</label>
                                        <input type="text" class="form-control " placeholder="Location" id="south"
                                               name="south">
                                    </div>
                                </div>-->
                                <br/>
                                <h3>GEO Info</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="business_zone_layer">Business Region:</label>
                                            <select class="form-control" data-placeholder="Select..." id="business_zone_layer"
                                                    name="business_zone_layer">
                                                <option value="">Choose zone</option>
                                                <?php foreach ($business_zone as $business_zone_name) { ?>
                                                    <option
                                                        value="<?php echo $business_zone_name['id'] ?>"><?php echo $business_zone_name['biz_zone_name'] ?></option>
                                                    <?php } ?>
                                            </select>
                                            <span class="help-block">
                                                select Business Region
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="business_zone_name"> Area:</label>
                                            <select class="form-control" id="business_zone_name" name="business_zone_name"">
                                            </select>
                                            <span class="help-block">
                                                select Area
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="biz_zone_id">Territory: </label>
                                            <select class="form-control" id="territory" name="territory" onchange="get_territory()" required>
                                            </select>
                                            <span class="help-block">
                                                select Territory
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div id="mkt_div">
                                                <label class="control-label" for="mkt">Town:</label>
                                                <select class="form-control" id="mkt" name="mkt">
                                                </select>
                                                <span class="help-block">
                                                    select Town
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <br/>
                                <h4>Address</h4><hr>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="dbhouse_address_id">Address </label>

                                        <input type="text" class="form-control" placeholder="Enter DB House Address"
                                               id="dbhouse_address_id"
                                               name="dbhouse_address" value="" >
                                        
                                    </div>
                                </div>
                                <br />
                                
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <label class="control-label" for="road">Road/House No.</label>
                                        <input type="text" class="form-control" data-placeholder="Select..." id="road"
                                         placeholder="Enter Road/House No." name="road">

                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="village">Village</label>
                                        <input type="text" class="form-control" data-placeholder="Select..."
                                         placeholder="Enter Village" id="village" name="village">

                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="division">Division</label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="division"
                                                name="division" onchange="get_district()">
                                            <option value=""></option>
                                            <?php foreach ( $division as $divition ) { ?>
                                                <option
                                                    value="<?php echo $divition[ 'id' ] ?>"><?php echo $divition[ 'name' ] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="district">District</label>
                                        <select class="form-control select2me" id="district" name="district"
                                                onchange="get_thana()">

                                        </select>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="thana">Thana</label>
                                        <select class="form-control select2me" id="thana" name="thana" onchange="get_union()">

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="union">Union</label>
                                        <select class="form-control select2me" id="union" name="union"">

                                        </select>
                                    </div>
                                </div>
                                <br/>

                                
                                <br/>
                                <br/>
                        
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Save</button>
                                    <button type="button" class="btn default"
                                            onclick="document.location.href = '<?php echo site_url( 'db_house/distributionHouseIndex' ); ?>'">
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
$this->load->view( 'footer/footer' );
?>



<script>
    $('#business_zone_layer').change(function() {
                var business_zone_layer = $('#business_zone_layer').val();
                //alert(business_zone_layer);
                $('#business_zone_name').empty();
                $('#business_zone_name').append('<option value=""></option>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>db_house/getBusinessZoneName/",
                    data: "business_zone_layer=" + business_zone_layer,
                    dataType: "json",
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            $('#business_zone_name').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
                        }
                    }
                });
            });
    $('#business_zone_name').change(function() {
                var business_zone_name = $('#business_zone_name').val();
//                alert(business_zone_name);
                $('#territory').empty();
                $('#territory').append('<option value=""></option>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>db_house/getTerritoryName/",
                    data: "business_zone_name=" + business_zone_name,
                    dataType: "json",
                    success: function(data) {
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
    function get_union() {
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
    
//    function get_territory() {
//        var biz_zone = $('#business_zone_name').val();
//        if ($('#business_zone_layer').val() == '0') {
//            alert("Select 'Point' to get Distribution Point");
//        }
//        else {
//            $('#territory').empty();
//            $('#territory').append("<option value=''></option>");
//            $.ajax({
//                type: "POST",
//                url: "<?php echo base_url(); ?>db_house/getTerritoryName/",
//                data: "business_zone_name=" + biz_zone,
//                dataType: "json",
//                success: function(data) {
//                    //console.log(data);
//                    for (var i = 0; i < data.length; i++) {
//                        $('#territory').append("<option value='" + data[i].id + "'>" + data[i].biz_zone_name + "</option>");
//                    }
//                }
//            });
//        }
//    }


//    var num_of_add = 0;
//    function row_add() {
//        num_of_add = num_of_add + 1;
//        var c = $('#tbody_cycle tr:last').children().children().children().children().html();
//        var d = $('#tbody_cycle tr:last .product_line_id option:selected').val();
//        var e = $('#tbody_cycle tr:last .product_line_id option:selected').text();
//        var f = '<option value="' + d + '">' + e + '</option>';
//        var j = $('#tbody_cycle tr:last .product_line_id option').size();
//
//        c = c.replace(f, '');
//        if (j == 1) {
//            alert('No more Product Line available');
//        } else {
//            $('#tbody_cycle tr:last').children().children().children().children().attr('readonly', true);
//            $('#tbody_cycle tr:last td:nth-child(2)').children().attr('readonly', true);
//            $('#tbody_cycle tr:last td:nth-child(3)').children().removeClass('remCF');
//            $('#tbody_cycle').append('<tr id="1"><td><div class="row"><div class="col-md-6"><select class="form-control input-medium product_line_id" data-placeholder="Select..." name="product_line_id[]" required>' + c + '</select></div></div></td><td><input id="erp_code' + num_of_add + '" type="text"  class="form-control" width="10px" name="erp_code[]" required/></td><td><a href="javascript:void(0);" class="remCF btn btn-xs red btn-editable" >Remove</a></td></tr>');
//        }
//    }
//
//    $("#tbody_cycle").on('click', '.remCF', function () {
//
//        $(this).parent('td').parent('tr').remove();
//        $('#tbody_cycle tr:last').children().children().children().children().attr('readonly', false);
//        $('#tbody_cycle tr:last td:nth-child(2)').children().attr('readonly', false);
//        $('#tbody_cycle tr:last td:nth-child(3)').children().addClass('remCF');
//
//
//    });

    $('#creation_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    
    
    
    // Mobile number Validation Checking
    
 function check()
{

    var pass = $('#mobile').val();
    
    if(pass.length !=11){
        $("#message").html("Required 11 digits, match requested format!");
    }else{
        $("#message").html('');
    }
}
 function check_2()
{

    var pass = $('#telephone').val();
    
    if(pass.length != 9){
        $("#message2").html("Required 9 digits, match requested format!");
    }else{
        $("#message2").html('');
    }
}

</script>
