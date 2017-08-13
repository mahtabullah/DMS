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
                    Product
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url( 'home/home_page' ); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url( 'sku/skuIndex' ); ?>">Product</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Edit
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>
                        </div>
                    </div>
                    <?php
                    foreach ( $sku_info as $key ) {
                        $mou_id[] = $key[ 'mou_id' ];
                        $id = $key[ 'id' ];
                    }
                    ?>
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array( 'sku', 'skuUpdateById', $id );
                        echo site_url( $segments ); ?>" method="post">
                            <div class="form-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="parent_id">Sub Brand <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="parent_id" name="parent_id"
                                                required>
                                            <option value=""></option>
                                            <?php for ( $i = 0; $i < count( $sku_category ); $i++ ) {
                                                foreach ( $sku_category[ $i ] as $mms ) {
                                                    $selected_owner = ( $mms[ 'id' ] == $sku_info[ 0 ][ 'parent_id' ] ) ? " selected='selected'" : "";
                                                    echo '<option value="' . $mms[ 'id' ] . '"' . $selected_owner . '>' . $mms[ 'element_name' ] . '</option>';

                                                }
                                            } ?>
                                        </select>
                                    </div>                                    
                                     <div class="col-md-6">
                                        <label for="sku_name">Sku Name Bangla <span style="color: red; ">*</span></label>
                                        <input type="text" class="form-control" placeholder="SKU Name Bangla"
                                               id="sku_name_b"
                                               name="sku_name_b" value="<?php echo $sku_info[ 0 ][ 'sku_name_b' ]; ?>" required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="sku_name">SKU Short Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Sku Short Name"
                                               id="sku_name"
                                               name="sku_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sku_name">SKU Name <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="SKU Name" id="sku_name"
                                               name="sku_name"
                                               value="<?php echo $sku_info[ 0 ][ 'sku_name' ]; ?>" required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="sku_code">SKU Code <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="SKU Code" id="sku_code"
                                               name="sku_code"
                                               value="<?php echo $sku_info[ 0 ][ 'sku_code' ]; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sku_type_id">SKU Type <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="sku_type_id" name="sku_type_id"
                                                required>
                                            <option value=""></option>
                                            <?php
                                            foreach ( $sku_type as $mmss ) {
                                                $selected_owner = ( $mmss[ 'id' ] == $sku_info[ 0 ][ 'sku_type_id' ] ) ? " selected='selected'" : "";
                                                echo '<option value="' . $mmss[ 'id' ] . '"' . $selected_owner . '>' . $mmss[ 'sku_type_name' ] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div><br/>  
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="sku_type_id">SKU Category <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Sku Category"
                                                id="sku_category_id" name="sku_category_id" required>
                                            <option value=""></option>
                                            <?php foreach ($category as $mmss) { ?>
                                                <option
                                                    value="<?php echo $mmss['id'] ?>"><?php echo $mmss['sku_category_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="unit">Packaging Size <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Packaging Size"
                                                id="unit" name="unit[]"
                                                multiple class="unit" onchange="get_outlet_default_size(this);"
                                                required>
                                            <option value=""></option>
                                            <?php
                                            foreach ( $unit as $unit_categorys ) {
                                                foreach ( $mou_id as $key => $value ) {

                                                    if ( $unit_categorys[ 'id' ] == $value ) {
                                                        $selected_owner = " selected='selected'";
                                                        break;
                                                    } else {
                                                        $selected_owner = "";
                                                    }
                                                }
                                                echo '<option value="' . $unit_categorys[ 'id' ] . '"' . $selected_owner . '>' . $unit_categorys[ 'unit_name' ] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="weight_unit">Volume Unit<span style="color: red;">*</span></label>
                                    <select class="form-control select2me" data-placeholder="Select Container Type"
                                            id="weight_unit"
                                            name="weight_unit" required onchange="getMaxUnit()">
                                        <option value=""></option>
                                        <?php foreach ($volume_unit as $unit_category) { ?>
                                            <option
                                                value="<?php echo $unit_category['id']; ?>"><?php echo $unit_category['name'] ?></option>
                                        <?php } ?>
                                    </select>                                    
                                </div>
                                    

<!--                                    <div class="col-md-6 form-group">
                                        <label for="sku_description">Product Description</label>
                                        <input type="text" class="form-control" placeholder="SKU Description"
                                               id="sku_description"
                                               name="sku_description"
                                               value="<?php echo $sku_info[ 0 ][ 'sku_description' ]; ?>">
                                    </div>-->
                                    
                                    

                                    <div class="col-md-6 form-group">
                                        <label for="sku_active_status_id">Status <span
                                                style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="sku_active_status_id"
                                                name="sku_active_status_id" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ( $status as $mm ) {
                                                $selected_owner = ( $mm[ 'id' ] == $sku_info[ 0 ][ 'sku_active_status_id' ] ) ? " selected='selected'" : "";
                                                echo '<option value="' . $mm[ 'id' ] . '"' . $selected_owner . '>' . $mm[ 'sku_active_status_name' ] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_creation_date">Creation Date <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="sku_creation_date"
                                               name="sku_creation_date"
                                               value="<?php echo date( "d-m-Y", strtotime( $sku_info[ 0 ][ 'sku_creation_date' ] ) ); ?>"
                                               readonly required>
                                    </div>
                                    <br/>

                                    <div class="col-md-6 form-group">
                                        <label for="sku_launch_date">Launch Date</label>
                                        <input type="text" class="form-control date-picker" id="sku_launch_date"
                                               name="sku_launch_date"
                                               value="<?php echo date( "d-m-Y", strtotime( $sku_info[ 0 ][ 'sku_launch_date' ] ) ); ?>">

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_expiry_date">Expiry Date</label>
                                        <input type="text" class="form-control" id="sku_expiry_date"
                                               name="sku_expiry_date"
                                               value="<?php echo date( "d-m-Y", strtotime( $sku_info[ 0 ][ 'sku_expiry_date' ] ) ); ?>">
                                    </div>
                                    <br/>

                                    <div class="col-md-6 form-group">
                                        <label for="weight_unit">Weight Unit <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select Weight Unit"
                                                id="weight_unit"
                                                name="weight_unit" required>
                                            <option value=""></option>
                                            <option value="1" <?php if ( $sku_info[ 0 ][ 'sku_weight_id' ] == 1 ) {
                                                echo "selected";
                                            } ?> >Ltr
                                            </option>
                                            <option value="2" <?php if ( $sku_info[ 0 ][ 'sku_weight_id' ] == 2 ) {
                                                echo "selected";
                                            } ?> >Kg
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_waight_value">Weight<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input" id="sku_waight_value"
                                               name="sku_waight_value"
                                               value="<?php echo $sku_info[ 0 ][ 'sku_waight_value' ]; ?>" required>
                                    </div>
                                    <br/>

                                    <div class="col-md-6 form-group">
                                        <label for="parent_id">Brand <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..."
                                                id="parent_id" name="parent_id"
                                                required>
                                            <option value=""></option>
                                            <?php for ( $i = 0; $i < count( $sku_category ); $i++ ) {
                                                foreach ( $sku_category[ $i ] as $mms ) {
                                                    $selected_owner = ( $mms[ 'id' ] == $sku_info[ 0 ][ 'parent_id' ] ) ? " selected='selected'" : "";
                                                    echo '<option value="' . $mms[ 'id' ] . '"' . $selected_owner . '>' . $mms[ 'element_name' ] . '</option>';

                                                }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bulk_purchase_price">DD Price <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Product DD Price " id="bulk_purchase_price"
                                               name="bulk_purchase_price"
                                               value="<?php echo $sku_info[ 0 ][ 'db_lifting_price' ]; ?>" required>
                                    </div>
                                    <br/>

                                    <div class="col-md-6 form-group">
                                        <label for="sku_default_price">Trade Price <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Product Trade Price" id="sku_default_price"
                                               name="sku_default_price"
                                               value="<?php echo $sku_info[ 0 ][ 'outlet_lifting_price' ]; ?>" required>

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sku_mrp_price">MRP <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control float-input"
                                               placeholder="Product MRP Price" id="sku_mrp_price"
                                               name="sku_mrp_price"
                                               value="<?php echo $sku_info[ 0 ][ 'mrp_lifting_price' ]; ?>" required>
                                    </div>
                                    <br/>

                                    
                                    <div class="col-md-6 form-group">
                                    <label for="outlet_default_pack_size">Outlet Default Pack Size <span style="color: red;">*</span></label>
                                    <select class="form-control" data-placeholder="Select Outlet Default Pack Size" id="outlet_default_pack_size" name="outlet_default_pack_size"  required>
                                        <option value=''></option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="db_default_pack_size">DB Default Pack Size <span style="color: red;">*</span></label>
                                    <select class="form-control" data-placeholder="Select DB Default Pack Size" id="db_default_pack_size" name="db_default_pack_size"  required>
                                        <option value=''></option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue" id="save">Update</button>
                                <button type="button" class="btn default"
                                        onclick="document.location.href = '<?php echo site_url( 'sku/skuIndex' ); ?>'">
                                    Cancel
                                </button>
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
    $(document).ready(function () {
        $("#unit").change();
    });
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    $('#sku_launch_date').datepicker({
        startDate: today,
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    $('#sku_expiry_date').datepicker({
        startDate: today,
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    var outlet_default_mou_id = '<?php echo $sku_info[0]['outlet_default_mou_id']; ?>';
    var db_default_mou_id = '<?php echo $sku_info[0]['db_default_mou_id']; ?>';
    if (outlet_default_mou_id != '') {
        outlet_default_mou_id = outlet_default_mou_id;
    } else {
        outlet_default_mou_id = 0;
    }


    if (db_default_mou_id != '') {
        db_default_mou_id = db_default_mou_id;
    } else {
        db_default_mou_id = 0;
    }
    function get_outlet_default_size(id) {
        var pack_list = $(id).select2('data');
        $("#outlet_default_pack_size").empty();
        $("#db_default_pack_size").empty();
        for (var i = 0; i < pack_list.length; i++) {
            if (outlet_default_mou_id == pack_list[i].id) {
                $("#outlet_default_pack_size").append("<option value='" + pack_list[i].id + "' selected='selected'>" + pack_list[i].text + "</option>");
            } else {
                $("#outlet_default_pack_size").append("<option value='" + pack_list[i].id + "'>" + pack_list[i].text + "</option>");
            }

        }
        for (var i = 0; i < pack_list.length; i++) {
            if (db_default_mou_id == pack_list[i].id) {
                $("#db_default_pack_size").append("<option value='" + pack_list[i].id + "' selected='selected'>" + pack_list[i].text + "</option>");
            } else {
                $("#db_default_pack_size").append("<option value='" + pack_list[i].id + "'>" + pack_list[i].text + "</option>");
            }

        }
    }
</script>