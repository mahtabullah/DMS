<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

    <script src="<?php echo base_url(); ?>assets/js/utility_functions.js" type="text/javascript"></script>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h3 class="page-title">
                        Geographical Master
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url('geographical/geoGraphicalMasterIndex'); ?>">Geographical
                                Master</a>
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
                            <form role="form" action="<?php echo site_url('geographical/saveGeoGraphicalMaster'); ?>"
                                  method="post">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text" class="form-control" id="code" name="code" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" rows="3" id="description"
                                                          name="description" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="geo_layer">Geographical Layer</label>
                                                <select class="form-control input-xlarge select2me"
                                                        data-placeholder="Select..." id="geo_layer" name="geo_layer">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach($biz_zone as $biz_zone_name) {
                                                        echo '<option value="'.$biz_zone_name['id'].'">'.$biz_zone_name['biz_zone_category_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            <span class="help-block">
                                                select Geographical Layer
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--</div>-->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="parent_zone">Parent Business Zone</label>

                                                <select class="form-control input-xlarge select2me"
                                                        data-placeholder="Select..." id="parent_zone"
                                                        name="parent_zone">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach($biz_zone_names as $biz_zones) {
                    echo '<option value="'.$biz_zones['id'].'">['.$biz_zones['biz_zone_name'].'] ['
                        .$biz_zones['biz_zone_category_name'].':'.$biz_zones['ZONE_NAME'].']</option>';
                                                    }
                                                    ?>
                                                </select>
                                            <span class="help-block">
                                                select Parent Business Zone
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Save</button>
                                    <button type="button" class="btn default"
                                            onclick="document.location.href='<?php echo site_url('geographical/geoGraphicalMasterIndex'); ?>'">
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
    <script>

    </script>

<?php
$this->load->view('footer/footer');
?>