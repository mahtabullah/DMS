<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                   Current Stock
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Current Stock</a>
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
                  <h3 class="box-title">Current Stock</h3>
                  <div class="box-tools pull-right">
                     <div class="actions">
                           
                        </div>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
               
            </div>
            <div class="box-body">
             
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_4">
                    <thead>
                        <tr>
                            <th>
                                SL No.
                            </th>
                            <th>
                                Sku name
                            </th>
                            <th>
                                Pack Size
                            </th>
                                                       
                            <th>
                                Price
                            </th>
                            <th>
                                Total_Qty
                            </th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sl=1;
                        foreach ($current_stock as $rp_i) { ?>
                            <tr>
                                <td>
                                    <?php echo $sl;$sl++; ?>
                                </td>
                                <td>
                                    <?php echo $rp_i['sku_name']; ?>
                                </td>
                                <td>
                                    <?php echo $rp_i['Pack_Size']; ?>
                                </td>
                               
                                <td>
                                    <?php echo $rp_i['Price']; ?>
                                </td>
                                <td>
                                    <?php echo $rp_i['Total_Qty']; ?>
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