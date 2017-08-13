
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Product
                </div>
                <?php if($user_role_code == 'MIS'){?>
                <div class="actions">
                    <a href="<?php echo site_url('sku/createSku'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i> Create Product </a>
                </div>
                <?php } ?>
            </div>


            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                            <tr>
                                <th class="center bold">
                                    SI NO
                                </th>

                                <th class="center bold">
                                   Brand
                                </th>
                                <th class="center bold">
                                   Sub Brand
                                </th>

                                <th class="center bold">
                                   SKU Code
                                </th>
                                <th class="center bold">
                                   SKU Full Name
                                </th>
                                <th class="center bold">
                                   Sku Flavor
                                </th>
                                <th class="center bold">
                                   LPC
                                </th>
                                <th class="center bold">
                                    Unit
                                </th>
                                <th class="center bold">
                                   8oz<?php if($user_role_code != 'MIS') {?>(CS)<?php }?>
                                </th>
                                <?php if($user_role_code != 'MIS') {?>
                                <th class="center bold">Invoice Price (CS)</th>
                                <th class="center bold">Trade Price (CS)</th>
                                <th class="center bold">MRP (CS)</th>
                                <?php }?>
                                <th class="center bold">
                                   Launch Date
                                </th>


                                <th class="center bold">
                                    Status
                                </th>
                                <?php if($user_role_code == 'MIS'){?>
                                <th class="center bold">
                                    Action
                                </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                             <?php  $i=1; foreach  ($sku_info as $sku_infos) { ?>
                                <tr>
                                    <td class="center">
                                        <?php echo $i;?>
                                    </td>

                                    <td class="center">
                                        <?php echo $sku_infos['product']; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku_infos['element_name']; ?>
                                    </td>

                                    <td class="center">
                                        <?php echo $sku_infos['sku_code']; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $sku_infos['sku_description']; ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                            echo $sku_infos['sku_type_name'];
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                            echo $sku_infos['sku_lpc'];
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                        echo $sku_infos['unit'];
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                            echo $sku_infos['sku_volume'];
                                        ?>
                                    </td>
                                    <?php if($user_role_code != 'MIS') {?>
                                    <td>
                                        <?php
                                        echo $sku_infos['outlet_lifting_price'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $sku_infos['db_lifting_price'];
                                        ?>
                                    </td>
                                    <td><?php
                                        echo $sku_infos['mrp_lifting_price'];
                                        ?></td>
                                    <?php } ?>
                                    <td class="center">
                                        <?php
                                            echo $sku_infos['sku_launch_date'];
                                        ?>
                                    </td>

                                    <td class="center">
                                        <?php echo $sku_infos['sku_active_status_name']?>
                                    </td>
                                    <?php if($user_role_code == 'MIS') {?>
                                    <td class="center">
                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'sku/skuEditById/'.$sku_infos['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>

                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
