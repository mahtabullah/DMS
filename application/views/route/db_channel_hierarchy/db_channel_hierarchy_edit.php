<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                   DB Journey Plan Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('distribution_channel/dbChannelHierarchyIndex'); ?>">Journey Plan Hierarchy</a>
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
            foreach ($distribution_channel_info_by_id as $key) {
                $id = $key['id'];
                $distribution_channel_name = $key['distribution_channel_name'];
                $distribution_channel_code = $key['distribution_channel_code'];
                $distribution_channel_description = $key['distribution_channel_description'];
                $distribution_channel_parent_id = $key['parent_channel_id'];

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
                        <form role="form" action="<?php $segments = array('distribution_channel', 'distributionChannelUpdateById', $id); echo site_url($segments); ?>" method="post">
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required value="<?php echo $distribution_channel_name;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="code">Code<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="code" name="code" required value="<?php echo $distribution_channel_code;?>">
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" rows="3" id="description" name="description" ><?php echo $distribution_channel_description;?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="parent_layer">Parent Layer</label>                                                          
                                                <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="parent_layer" name="parent_layer">
                                                    <option value="0">No Parent Layer</option>
                                                    <?php
                                                        foreach ($distribution_channel as $key) {
                                                            $selected_owner = ($key['id'] == $distribution_channel_parent_id) ? " selected='selected'" : "";
                                                            echo '<option value="'.$key['id'].'"'.$selected_owner.'>'.$key['distribution_channel_name'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>   
                                    </div>    
                                    <div class="form-actions">
                                        <button type="submit" class="btn blue">Update</button>
                                        <a href="<?php echo site_url('distribution_channel'); ?>"><button type="button" class="btn default">Cancel</button></a>
                                    </div>
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