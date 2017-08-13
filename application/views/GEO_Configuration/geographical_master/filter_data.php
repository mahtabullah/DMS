
<table id = "sample_2" class="table table-striped table-bordered table-hover table-full-width">
    <thead>
        <tr>
            <th class="bold">
               Sl No.
            </th>
            <th class="bold">
                Name
            </th>
            <th class="bold">
                Code
            </th>
            <th class="bold">
                Geographical Layer
            </th>
            <th class="bold">
                Parent
            </th>
            <th class="bold">
                Action
            </th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; foreach ($biz_zone_name as $biz) { $i++; ?>
            <tr>
                <td>
                    <?php echo $i; ?>
                </td>
                <td>
                    <?php echo $biz['biz_zone_name']; ?>
                </td>
                <td>
                    <?php echo $biz['biz_zone_code']; ?>
                </td>
                <td>
                    <?php
                    if(empty($biz['biz_zone_category_name'])){
                            echo 'No Layer';                                        
                        }else{
                            echo $biz['biz_zone_category_name'];
                        }
                    ?>
                </td>
                <td>
                    <?php
                     if(empty($biz['biz_zone_name'])){
                            echo 'No Parent Zone';                                        
                        }else{
                            echo $biz['biz_zone_name'];
                        } 
                    ?>
                </td>
                <td>                                       
                    <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'geographical/geoGraphicalMasterEditById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>                                    
                    <button  class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'geographical/geoGraphicalMasterDeleteById/'.$biz['id'].'\''; ?>);" ><i class="fa fa-times"></i> Delete</button>
                    <!-- ConfirmationWindow function footer/footer.php -->
                </td>
            </tr>
            <?php                            
        }
        ?>
    </tbody>
</table>
<script>

    $('#sample_2').DataTable( {
        dom: 'T<"clear">lfrtip'
    });

</script>