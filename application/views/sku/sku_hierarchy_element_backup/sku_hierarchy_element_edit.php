<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>

<script src="<?php echo base_url(); ?>assets/js/utility_functions.js" type="text/javascript"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Product Hierarchy Element 
                </h3>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sku/skuHierarchyElementIndex'); ?>">Product Hierarchy Element</a>
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
                     <?php
                        foreach ($tbld_sku_hierarchy_elements as $key) {
                            $id = $key['id'];
                            $element_name = $key['element_name'];
                            $element_code = $key['element_code'];
                            $element_description = $key['element_description'];
                            $element_category_id = $key['element_category_id'];
                            $parent_element_id = $key['parent_element_id'];
                        }
                    ?>
                    <div class="portlet-body form">
                        <form role="form" name="form" action="<?php $segments = array('sku', 'skuHierarchyElementUpdateById', $id); echo site_url($segments); ?>" method="post" novalidate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $element_name;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code" value="<?php echo $element_code;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="3" id="description" name="description"  placeholder="Description"><?php echo $element_description;?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sku_layer">Product Layer<span style="color:red;">*</span></label>                                            
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="sku_layer" name="sku_layer">
                                                <option value=""></option>                                                
                                                <?php 
                                                    foreach ($sku_hierarchy as $key) {
                                                        $selected_owner = ($key['id'] == $element_category_id) ? " selected='selected'" : "";
                                                        echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['layer_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_element">Parent Element</label>                                         
                                            <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_element" name="parent_element">
                                                <option value=""></option>
                                                 <?php 
                                                    foreach ($sku_hierarchy_elements as $key) {                                                        
                                                        $selected_owner = ($key['parent_element_id'] == $parent_element_id) ? " selected='selected'" : "";
                                                        echo '<option value="'.$key['parent_element_id'].'"'.$selected_owner.'>'.$key['parent_element_name'].'</option>';
                                                        
                                                    }
                                                ?>                                                
                                            </select>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Update</button>
                                <button type="button" class="btn default" onclick="document.location.href = '<?php echo site_url('sku/skuHierarchyElementIndex'); ?>'">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
            $('#sku_layer').change(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>sku/getParents/",
                    data: {id: $('#sku_layer').val()},
                    dataType: "json",
                    success: function(data) {
                        $('#parent_element').empty();
                        $('#parent_element').append("<option value='' selected='selected'></option>");
                        for (var i = 0; i < data.length; i++) {
                            $.each(data[i], function(key, val) {
                                $('#parent_element').append("<option value='" + val.id + "'>" + val.element_name + "</option>");
                            });
                        }
                    }
                });
            });
</script>


<?php
$this->load->view('footer/footer');
?>