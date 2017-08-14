<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>


<div class="page-content-wrapper">
    <div class="page-content">

        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create Route Plan</h3>
                        <div class="box-tools pull-right">
                            <div class="actions">

                            </div>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body form">
                        <form role="form" action="<?php echo site_url('route_plan/save_route_plan'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="route_plan_name">Sub Route Plan Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="route_name" name="route_plan_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="route_plan_description">Sub Route Plan Description</label>
                                            <textarea class="form-control" rows="1" id="route_description" name="route_plan_desc" placeholder="Enter Route Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dbhouse">Distribution House <span style="color: red;">*</span></label>
                                            <!--<div class="col-md-4">-->
                                            <select class="form-control select2" data-placeholder="Select..." id="dbhouse" name="dbhouse" onchange="dbhouse_change();" required>
                                                <option value=""></option>
                                                <?php foreach ($dbhouse as $distribution_house) { ?>
                                                    <option value="<?php echo $distribution_house['id'] ?>"><?php echo $distribution_house['name']; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sr">Field Force<span style="color: red;">*</span></label>                                            
                                            <select class="form-control select2me" data-placeholder="Select..." id="psr" name="psr" onchange=";" required>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Date Range <span style="color: red;">*</span></label>
                                            <div class="input-group" >
                                                <input type="text" class="form-control" name="date_frm" id="date_frm" required>
                                                <span class="input-group-addon">
                                                    to
                                                </span>
                                                <input type="text" class="form-control" name="date_to" id="date_to" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <h3> <label class="label label-success"  for="my-select" >Select Saturday Sub Routes</label></h3>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='sat_routes' name="sat_routes[]"  class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <div class="col-md-12">
                                            <h3> <label class="label label-success"  for="my-select" >Select Sunday Sub Routes</label></h3>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='sun_routes' name="sun_routes[]" class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <div class="col-md-12">
                                            <h3> <label class="label label-success"  for="my-select" >Select Monday Sub Routes</label></h3>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='mon_routes' name="mon_routes[]"  class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <div class="col-md-12">
                                          <h3> <label class="label label-success"  for="my-select" >Select Tuesday Sub Routes</label></h3>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='tue_routes' name="tue_routes[]"  class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <div class="col-md-12">
                                         <h3> <label class="label label-success"  for="my-select" >Select Wednesday Sub Routes</label></h3>
                                           </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='wed_routes' name="wed_routes[]"  class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <div class="col-md-12">
                                            <h3> <label class="label label-success"  for="my-select" >Select Thursday Sub Routes</label></h3>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='thu_routes' name="thu_routes[]" class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <div class="col-md-12">
                                            <h3> <label class="label label-success"  for="my-select" >Select Friday Sub Routes</label></h3>
                                               </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <select id='fri_routes' name="fri_routes[]"  class="routes" style="height:30%; width:50%;">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                   
                                 </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-default" onclick="document.location.href = '<?php echo site_url('route_plan/index'); ?>'">Cancel</button>
                                    </div>
                                </div>

                                <!-- END SAMPLE FORM PORTLET-->
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php
$this->load->view('footer/footer');
?>
<script>
    $(document).ready(function () {
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(),
                nowDate.getDate(), 0, 0, 0, 0);

        $(".select2,.routes").select2({
            placeholder: "Select..",
            allowClear: true
        });
        $("#date_frm,#date_to").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            startDate: today
        });

    });


    function dbhouse_change() {
        var db_id = $("#dbhouse").val();
        getPSR(db_id);
        subroute(db_id);
    }


    function getPSR(dbid) {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Route_plan/getPSRbyDBid/",
            data: {db_id: dbid},
            dataType: "html",
            success: function (data) {
                $("#psr").empty();
                $("#psr").append(data);
                $("#psr").select2({
                    placeholder: "Select...",
                    allowClear: true
                });
            }
        });
    }

    function subroute(dbid) {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Route_plan/getSubRoutebyDBid/",
            data: {db_id: dbid},
            dataType: "html",
            success: function (data) {

                $("#sat_routes,#sun_routes,#mon_routes,#tue_routes,#wed_routes,#thu_routes,#fri_routes").empty();
                $("#sat_routes,#sun_routes,#mon_routes,#tue_routes,#wed_routes,#thu_routes,#fri_routes").append(data);
                $("#sat_routes,#sun_routes,#mon_routes,#tue_routes,#wed_routes,#thu_routes,#fri_routes").select2();

            }
        });
    }

</script>

