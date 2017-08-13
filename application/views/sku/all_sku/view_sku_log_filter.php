<div class="row">
    <div class="col-md-12">
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Filter Data
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">

                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover" id="sample_2">
                                <thead>
                                    <tr>

                                        <th scope="col" style="font-size: 12px;">
                                            SKU Name
                                        </th>
                                        <th scope="col" style="font-size: 12px;">
                                            DD Price
                                        </th>
                                        <th scope="col" style="font-size: 12px;">
                                            Trade Price
                                        </th>
                                        <th scope="col" style="font-size: 12px;">
                                            MRP
                                        </th>
                                        <th scope="col" style="font-size: 12px;">
                                            User Name
                                        </th>
                                        <th scope="col" style="font-size: 12px;">
                                            Log Time
                                        </th>


                                    </tr>
                                </thead>
                                <tbody id="tbody_cycle">
                                    <?php
                                    foreach ($sku_log_info as $sku_log_infos) {
                                    ?>

                                        <tr id="row_attr">
                                            <td id="outlet_no" style="text-align: right; font-size: 12px;"><?php



                                            $sku_id = $sku_log_infos['sku_id'];

                                              $sku_name = $this->method_call->getSkuName($sku_id);
                                                foreach ($sku_name as $sku_names) {
                                                    echo $sku_names['sku_name'];
                                                }



                                            ?></td>

                                            <td id="outlet_no" style="text-align: right; font-size: 12px;"><?php echo $sku_log_infos['bulk_purchase_price'];?></td>

                                            <td id="outlet_no" style="text-align: right; font-size: 12px;"><?php echo $sku_log_infos['sku_default_price'];?></td>
                                            <td id="outlet_no" style="text-align: right; font-size: 12px;"><?php echo $sku_log_infos['sku_mrp_price'];?></td>
                                            <td id="outlet_no" style="text-align: right; font-size: 12px;"><?php 
                                            
                                            
                                            
                                            $emp_name = $this->method_call->getDistEmpName($sku_log_infos['user_id']);
                                            foreach ($emp_name as $dist_emp) {
                                                echo $dist_emp['first_name'];
                                            }



                                            ?></td>
                                            <td id="outlet_no" style="text-align: right; font-size: 12px;"><?php echo $sku_log_infos['time_log'];?></td>





                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
