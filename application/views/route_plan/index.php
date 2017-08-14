<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                   Sub Route Plans
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Sub Route Plan</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        
        <div class="row">
        <div class="col-md-4" id="filter">
            
        </div>
        </div>
        <br />

      


        <div class="box box-default">
            <div class="box-title">
                
                 <div class="box-header with-border">
                  <h3 class="box-title">Sub Route Plans</h3>
                  <div class="box-tools pull-right">
                     <div class="actions">
                            <a href="<?php echo site_url('route_plan/makeRoutePlan'); ?>" class="btn btn- btn-success pull-right" id="add_route"><i class="fa fa-plus"></i> Create Sub Route Plan</a>
                        </div>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
               
            </div>
            <div class="box-body">
                <?php // echo $this->pagination->create_links(); ?>
<!--                <div style="text-align: center;margin: 0 auto;margin-top: 10px;margin-bottom: -24px;position: relative; z-index: 1000;width: 400px;">
                <form action ="<?=base_url()?>route_plan/index" method="post" id="searchform">
                    Search: 
                    <input type="text" name="searchterm" placeholder="Search Sales Representative" id="searchterm"  value="<?=$searchterm?>" style="width: 200px;" /> 
                    <input type="submit" value="Search" id="submit" />
                </form>
                </div>-->
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_4">
                    <thead>
                        <tr>
                            <th>
                                SL No.
                            </th>
                            <th>
                                Route Plan Name
                            </th>
                            <th>
                                Route Plan Code
                            </th>
                                                       
                            <th>
                                Distributor Name
                            </th>
                            <th>
                                PSR Name
                            </th>
                            <th>
                                Start Date
                            </th>
                            <th>
                                End Date
                            </th>
                            <th>
                                Modify date
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sl=1;
                        foreach ($Route_plan as $rp_i) { ?>
                            <tr>
                                <td>
                                    <?php echo $sl;$sl++; ?>
                                </td>
                                <td>
                                    <?php echo $rp_i['route_plan_name']; ?>
                                </td>
                                <td>
                                    <?php echo $rp_i['route_plan_code']; ?>
                                </td>
                               
                                <td>
                                    <?php echo $rp_i['dbhouse_name']; ?>
                                </td>
                                <td>
                                    <?php echo $rp_i['first_name']; ?>
                                </td>
                                <td>
                                    <?php echo date('d-m-Y',strtotime($rp_i['start_date'])); ?>
                                </td>
                                <td>
                                    <?php echo date('d-m-Y',strtotime($rp_i['end_date'])); ?>
                                </td>
                                 <td>
                                    <?php echo date('d-m-Y',strtotime($rp_i['Modify_date'])); ?>
                                </td>
                                <td class="">
                                    <a href="<?php
                                    $segments = array('route_plan', 'index_edit',$rp_i['id']);
                                    echo site_url($segments);
                                    ?>" data-id="1" class="btn btn-xs blue btn-editable" onclick="return confirm('Are you sure Edit this item?')"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="<?php
                                    $segments = array('route_plan', 'index_delete',$rp_i['id']);
                                    echo site_url($segments);
                                    ?>" data-id="1" class="btn btn-xs red btn-editable" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-times"></i> Delete</a>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
            </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<?php
$this->load->view('footer/footer');
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#sample_4').DataTable( {
                dom: 'T<"clear">lfrtip',
                "bSort": false,
                "paging": false,
                searching: true,
                "iDisplayLength": 100
            });
    });
    function get_market_info(info){
       var db_id = $(info).val();
        $('#ajax_load').css("display","block");
        var request = $.ajax({
        url: "<?php echo base_url(); ?>route_plan/filter_data/",
            type: "POST",
            data: {db_id: db_id},
            dataType: "html"
        });

        request.done(function(msg) {
            $("#content-view").html( msg );
             $("#content-view").html( msg );
                            $('#sample_2').DataTable( {
            dom: 'T<"clear">lfrtip'
        });
         $('#ajax_load').css("display","none");
        });
    }
</script>