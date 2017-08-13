
<div class="row">
    <div class="col-md-12">
        <span class="help-block">
            Select <?php echo $filter_text_main; ?> <span style="color: red">*</span>
        </span>
        <select class="form-control input-xlarge" data-placeholder="Select..." id="layer1" onchange="layer_change(1)" name="layer1" required>
            <option value=""></option>
            <?php foreach ($layer1 as $key) { ?>
                <option value="<?php echo $key['id'] ?>" data-category="<?php echo $key['id'] ?>"><?php echo $key['biz_zone_category_name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div id="add_new_layer"></div>


<br><br>
<div class="row"  id="reset_btn">
    <div class="col-md-12">
        <button type="button" id='reset_filter' class="btn red" onclick='reset();'>Reset Filter</button>
        <button type="button" id='search_filter_data' class="btn green" onclick='search_filter_data();'>Search</button>
    </div>

</div>


<script>

                    function layer_change(id_num) {
                        var layer_number = id_num;
                        var layer_value = $('#layer' + id_num + '').val();
                        var text = $('#layer' + id_num + ' option:selected').text();

                        if ($('#layer' + id_num + '').val() != '') {

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>filter/add_layer",
                                data: {layer_number: layer_number, layer_value: layer_value, text: text},
                                dataType: "html",
                                success: function(data) {
                                    $("#filter select").each(function() {
                                        var ab = $(this).attr('id').slice(5);
                                        if (ab > layer_number) {
                                            $('#layer' + ab).parent('div').parent('div').remove();
                                        }


                                    });


                                    $('#add_new_layer').append(data);
                                    $('#layer' + (layer_number + 1)).select2();


                                }
                            });
                        }
                    }


                    function reset() {

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>filter/load/",
                            success: function(data) {
                                $('#filter').empty();
                                $('#filter').append(data);
                                $('#layer1').select2();
                            }
                        });

                    }

                    var zone_id = 0;
                    var biz_zone_category_id = 0;
                    var nice = 0;
                    function search_filter_data() {
                        zone_id = 0;
                        biz_zone_category_id = 0;
                        nice = 0;
                        $("#filter select").each(function() {
                            if ($(this).attr('id') == 'layer1') {
                                biz_zone_category_id = $(this).val();
                            } else {
                                var parent_biz_zone_id = $(this).val();
                                if (parent_biz_zone_id != '') {
                                    zone_id = parent_biz_zone_id;
                                    nice = $("option:selected", this).attr('data-category');

                                }
                            }
                        });

                        if (zone_id != 0 || biz_zone_category_id != 0) {
                            //if(zone_id==0){
                            //alert("t"+biz_zone_category_id+".id="+biz_zone_category_id);
                            //var result = "t"+biz_zone_category_id+".id="+biz_zone_category_id;
                            //}else{
                            //alert(nice);
                            //alert("t"+nice+".id="+zone_id+"");
                            //var result = "t"+nice+".id="+zone_id+"";
                            //alert(biz_zone_category_id);
                            //alert("zone_id = "+zone_id);

                            //}
                            //}else{
                            //alert("biz_zone_category_id = "+biz_zone_category_id);
                            //}

                            get_data();
                        }

                    }
</script>