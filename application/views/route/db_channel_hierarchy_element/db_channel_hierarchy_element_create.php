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
                    Distribution Channel Element
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('distribution_channel/dbChannelHierarchyElementIndex'); ?>">Distribution Channel Hierarchy Element</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Create</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>Create
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                            
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" action="<?php echo site_url('distribution_channel/savedbChannelHierarchyElement'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category<span style="color: red;">*</span></label>                                            
                                            <select class="form-control select2me" data-placeholder="Select..." id="category" name="category" onchange="category_change();">
                                                <option value=""></option>
                                                <?php
                                                foreach ($distribution_channel as $distribution_channel_name){
                                                    echo '<option value="' . $distribution_channel_name['id'] . '">' . $distribution_channel_name['distribution_channel_name'] . '</option>';
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">                                        
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="1" id="description" name="description" placeholder="Description"></textarea>
                                        </div>                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Business Zone:</label>
                                            <select class="form-control select2me" id="business_zone_id" name="business_zone_id" onchange="get_distribution_house(id);" required >
                                                <option value="0">Select.....</option>
                                                <?php foreach ($business_zone as $v) { ?>
                                                    <option value="<?php echo $v['id']; ?>"><?php echo $v['biz_zone_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Distribution House:</label>
                                            <select class="form-control select2me" id="distribution_house_id" name="distribution_house_id" onchange="category_change();" required >
                                                <option value="">Select.....</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                        
                                        <div class="form-group">
                                            <label for="parent_layer">Parent</label>
                                            <select class="form-control select2me" data-placeholder="Select..." id="parent_layer" name="parent_layer">
                                                <option value='0'>No Parent</option>
                                            </select>
                                        </div>                                        
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Save</button>
                                    <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('distribution_channel/dbChannelHierarchyElementIndex'); ?>'">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

function category_change(){
    var db_id = $("#distribution_house_id").val();
    var category_id = $('#category').val();
    if(db_id !='' && category_id =='2'){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>distribution_channel/getParentsAndChildren/",
            data: {category_id: category_id,db_id:db_id},
            dataType: "json",
            success: function(data) {
                $('#parent_layer').empty();
                $('#parent_layer').append("<option value='' selected='selected'></option>");
                for(var i = 0; i < data.length; i++) {
                    $('#parent_layer').append("<option value='" + data[i].id + "'>" + data[i].db_channel_element_name + "</option>");
                }
            }
        });    
    }
    
}


function get_distribution_house(){
            var biz_zone_id = $("#business_zone_id").val();
            $("#distribution_house_id").empty();
            $("#distribution_house_id").append('<option value=""></option>');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>master_data_upload/get_distribution_house/",
                data:{biz_zone_id:biz_zone_id},
                dataType: "json",
                success: function (data){
                    $("#distribution_house_id").append(data);
                }
            });
        }

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