
<div class="row">

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Order</h3>

            </div><!-- /.box-header -->
            <div class="box-body no-padding">
                 <table class="table table-striped table-bordered table-hover table-full-width" id="sample_3">
                    <thead>
                        <tr>
                            <th>
                                SL No.
                            </th>
                            <th>
                                Memo No
                            </th>
                            <th>
                                Outlet Name
                            </th>
                                                       
                            <th>
                                Sub Route
                            </th>
                            <th>
                                PSR Name
                            </th>
                            <th>
                                Order Date
                            </th>
                            <th>
                                Order Qty
                            </th>
                            
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sl=1;
                        foreach ($Order as $orderline) { ?>
                            <tr>
                                <td>
                                    <?php echo $sl;$sl++; ?>
                                </td>
                                <td>
                                    <?php echo $orderline['so_id']; ?>
                                </td>
                                <td>
                                     <?php echo $orderline['outlet_name']; ?>
                                </td>
                                
                                <td>
                                     <?php echo $orderline['sub_route']; ?>
                                </td>
                                <td>
                                     <?php echo $orderline['PSR']; ?>
                                </td>
                                <td>
                                    
                                    <?php echo date('d-m-Y',strtotime($orderline['planned_order_date'])); ?>
                                </td>
                                <td>
                                      <?php echo $orderline['Total_qty']; ?>
                                    
                                </td>
                                 
                                <td class="">
                                   
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
           
            </div><!-- /.box-body -->
            <div class="box-footer no-padding">

            </div>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div><!-- /.row -->


