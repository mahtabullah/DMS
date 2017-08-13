<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    DB Journey Plan Elements
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('distribution_channel/dbChannelHierarchyElementIndex'); ?>">DB Journey Plan Elements</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <?php
        
        foreach ($distribution_channel_elements as $key){
            $id = $key['id'];
            $db_channel_element_name = $key['db_channel_element_name'];
            $db_channel_element_code = $key['db_channel_element_code'];
            $db_channel_element_description = $key['db_channel_element_description'];
            $db_channel_element_category_id = $key['db_channel_element_category_id'];
            $db_channel_parent_element_id = $key['db_channel_parent_element_id'];
            $biz_zone_id = $key['biz_zone_id'];
            $db_id = $key['db_id'];
        }
        ?>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>Edit
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                          
                        </div>
                    </div>
                    <div class="portlet-body form">                        
                        <form role="form" action="<?php $segments = array('distribution_channel', 'channelHierarchyElementUpdateById', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category <span style="color: red;">*</span></label>                                           
                                            <select class="form-control select2me" data-placeholder="Select..." id="category" name="category" onchange="category_change()" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($distribution_channel as $key) {
                                                    $selected_owner = ($key['id'] == $db_channel_element_category_id) ? " selected='selected'" : "";
                                                    echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['distribution_channel_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $db_channel_element_name;?>" required>
                                        </div>
                                    </div>
                                  </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" class="form-control" id="code" name="code" value="<?php echo $db_channel_element_code;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="1" id="description" name="description"  placeholder="Description"><?php echo $db_channel_element_description;?></textarea>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Business Zone:</label>
                                            <select class="form-control select2me" id="business_zone_id" name="business_zone_id" onchange="get_distribution_house(id);" required >
                                                <option value=""></option>
                                                <?php
                                                foreach ($business_zone as $key) {
                                                    $biz_zones = ($key['id'] == $biz_zone_id) ? " selected='selected'" : "";
                                                    echo '<option value="'.$key['id'].'"'.$biz_zones.'>'.$key['biz_zone_name'].'</option>';
                                                }
                                                ?>                                                
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">                                    
                                        <label for="biz_zone_id">DB Point <span style="color: red;">*</span></label>
                                        <select class="form-control select2me" data-placeholder="Select..." id="biz_zone_id" name="biz_zone_id" required>
                                            <option value=""></option>
                                                <?php
                                                    foreach ($db_houses as $db) {
                                                        $dbs = ($db['id'] == $db_id) ? " selected='selected'" : "";
                                                        echo '<option value="'.$db['id'].'"'.$dbs.'>'.$db['dbhouse_name'].'</option>';
                                                    }
                                                ?>                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_layer">Parent</label>
                                            <select class="form-control select2me" data-placeholder="Select..." id="parent_layer" name="parent_layer">
                                                <option value=''></option>
                                                <?php
                                                foreach ($territory_name as $key) {
                                                    $selected_owner = ($key['id'] == $db_channel_parent_element_id) ? " selected='selected'" : "";
                                                    echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>                                   
                                                               
                                </div>

                                <div class="row">
                                    <div class="col-md-6" id="outlets_div" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label" for="message">Outlets:</label>
                                        </div>
                                        <select multiple id="outlets" name="outlets[]"  style="height:30%; width:50%;" onchange='get_seq()'>
                                            <option value="0" selected="selected"></option>
                                        </select>
                                        <span class="help-block">
                                            select Outlets
                                        </span>
                                    </div>                              
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('distribution_channel/dbChannelHierarchyElementIndex'); ?>'">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<script>

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>distribution_channel/load/",
        data: {type: 'geography', target: 'none'},
        success: function(data) {
            $('#biz_zone_filter').append(data);
        }
    });
    function category_change() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>distribution_channel/getParentsAndChildren/",
            data: {id: $('#category').val()},
            dataType: "json",
            success: function(data) {
                $('#parent_layer').empty();
                $('#outlets').empty();
                $('#parent_layer').append("<option value='' selected='selected'></option>");
                var j = 0;
                for (var i = 0; i < data.element_parents.length; i++) {
                    $.each(data.element_parents[i], function(key, val) {
                        $('#parent_layer').append("<option value='" + val.id + "'>" + val.db_channel_element_name + "</option>");
                        j++;
                    });
                }
                var j = 0;
                for (var i = 0; i < data.element_children.length; i++) {
                    $.each(data.element_children[i], function(key, val) {
                        $('#outlets').append("<option value='" + val.id + "'>" + val.outlet_name + "</option>");
                    });
                }
            }
        });
    }
    //                                                );

    var k = 0;
    function get_seq() {
        $('#seq_div').append("<div class='row'><div class='col-md-12'><div class='form-group'>" +
                "<label id=" + k + " class='col-md-3 control-label'>" + $('#outlets option:selected').text() + "</label></div>" +
                "<div class='col-md-3'><div class='form-group'>" +
                "<input class='form-control' type='text' id='seq_num" + k + "' name='seq_num" + k + "' required/>" +
                "<input type='hidden' name='select_id" + k + "' value='" + $('#outlets option:selected').val() + "'/>" +
                "<input type='hidden' name='option_select_count' value='" + k + "'/></div></div></div>");
        $('#seq_num' + k + '').focus();
        k++;
    }
</script>

<?php
$this->load->view('footer/footer');
?>