<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/30/17
 * Time: 3:28 PM
 */
?>

<div class="portlet box purple">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Distribution Employees
        </div>

        <div class="actions">
            <a href="<?php echo site_url( 'distribution_channel/createDbChannelHierarchyElement' ); ?>" class="btn green"><i
                    class="fa fa-plus"></i> Create Distribution Chanel</a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable">


            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_3">
                <thead>
                <tr>-->-->
                <th>
                    SL No.
                </th>
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Code
                </th>
                <th>
                    Description
                </th>
                <th>
                    Parent
                </th>
                <th>
                    Distributor Name
                </th>
                <th>
                    Type
                </th>
                <th>
                    Action
                </th>

            </tr>
                </thead>
                <tbody>
                <?php $sl = 1;
                foreach ( $result as $distribution_channel ) { ?>
                <tr>
                <td>
                    <?php echo $sl; $sl++?>
                </td>
                <td>
                    <?php echo $distribution_channel['id']; ?>
                </td>
                <td>
                    <?php echo $distribution_channel['db_channel_element_name']; ?>
                </td>
                <td>
                    <?php echo $distribution_channel['db_channel_element_code']; ?>
                </td>

                <td>
                    <?php echo $distribution_channel['db_channel_element_description']; ?>
                </td>
                <td>
                <?php
                    if(empty($distribution_channel['distribution_channel_name'])){
                       echo "No Parent";
                    }else {
                        echo $distribution_channel['distribution_channel_name'];
                    }

               ?>
                </td>
                <td>
                    <?php echo $distribution_channel['dbhouse_name']; ?>
                </td><td>
                    <?php echo $distribution_channel['element_type']; ?>
                </td>
                                                   <td class="center">
                                                        <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'distribution_channel/channelHierarchyElementEditById/'.$distribution_channel['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>
                                                        <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'distribution_channel/channelHierarchyElementDeleteById/'.$distribution_channel['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>
                                                            <!-- ConfirmationWindow function footer/footer.php -->
                                                    </td>
                                                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
