<div id="page">
    <div id="main">
        <div class="row">
            <div class="col-md-12">
                <span class="help-block">
                    Select <?php echo $filter_text_main; ?>
                </span>
                <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="layer1" onchange="layer_change(1)" name="layer1">
                    <option value=""></option>
                    <?php foreach ($frst_layer as $frst) { ?>
                        <option value="<?php echo $frst['id'] ?>"><?php echo $frst[$frst_layer_index] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span class="help-block">
                    Select <?php echo $filter_text_secondary; ?>
                </span>
                <select class="form-control input-xlarge select2me" data-placeholder="Select..." id="layer2" onchange="layer_change(2)" name="layer2">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <!--    <br><br>-->
    </div>
    <br><br>
    <div class="row"  id="reset_btn">
        <div class="col-md-12">
            <button type="button" id='reset_filter' class="btn blue" onclick='reset_filter_upon_click();'>Reset Filter</button>
        </div>
    </div>
    <input type="hidden" class="form-control" placeholder="Code" id="select_count" name="select_count">
</div>

<script>
                    var select_count = 0;
                    var add_target = 0;
                    function layer_change(id_num) {
                        //alert(id_num);
                        if ($('#layer' + id_num + '').val() != '') {
                            var num = 0;
                            if (id_num == 1) {
                                num = 1;
                            }
                            else {
                                num = 2;
                            }
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>distribution_channel/filter_layer" + num + "/",
                                data: {id: $('#layer' + id_num + '').val(), type: '<?php echo $type; ?>', target: '<?php echo $target; ?>'},
                                dataType: "json",
                                success: function(data) {
                                    $('#layer' + parseInt(id_num + 1) + '').empty();
                                    $('#layer' + parseInt(id_num + 2) + '').remove();
                                    $('#span' + parseInt(id_num + 2) + '').remove();
                                    $('#layer' + parseInt(id_num + 1) + '').append('<option value=""></option>');
                                    //console.log(data);
                                    for (var i = 0; i < data.length; i++) {
                                        $('#layer' + parseInt(id_num + 1) + '').append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                                    }
                                    if (id_num != 1) {
                                        add_another(id_num, data, '<?php echo $target ?>');
                                    }
                                }
                            });
                        }
                    }

                    function add_another(id_num, data, target) {
                        //alert(target);
                        if ($('#layer' + parseInt(id_num + 1) + '').length == 0) {
                            $('#main').append('<div class="row"><div class="col-md-4">'
                                    + '<select class="form-control input-xlarge select2me" data-placeholder="Select..." id="layer' + parseInt(id_num + 1) + '" onchange="layer_change(' + parseInt(id_num + 1) + ')" name="layer' + parseInt(id_num + 1) + '">'
                                    //+ '<option value=""></option>'
                                    + '</select>'
                                    + '<span class="help-block" id="span' + parseInt(id_num + 1) + '"></span>'
                                    + '</div></div>');
                            $('#layer' + parseInt(id_num + 1) + '').append('<option value=""></option>');
                            for (var i = 0; i < data.length; i++) {
                                $('#layer' + parseInt(id_num + 1) + '').append("<option value='" + data[i].id + "' data-name='"+ target +"'>" + data[i].name + "</option>");
                            }
                            if (target == 'finish') {
                                //$('#layer' + parseInt(id_num + 1) + '').attr('onchange', '');
                                $('#layer' + parseInt(id_num + 1) + '').attr('onchange', "get_market_info('#layer"+parseInt(id_num + 1)+"');");
                                
                            }
                            
                            if (data.length == 0) {
                                $('#layer' + parseInt(id_num + 1) + '').remove();
//                            $('#span' + parseInt(id_num + 1) + '').remove();
                                select_count = parseInt(id_num);
                                $('#select_count').val(select_count);

                                add_target_filter(parseInt(id_num), target);
                            }
                            else {
                                select_count = parseInt(id_num + 1);
                                $('#select_count').val(select_count);
                               
                            }
                            //alert(i);
                        }
                    }
                    function add_target_filter(id_num, target) {
                        if (target == 'dbhouse') {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>distribution_channel/getDbhouseById/",
                                data: {id: $('#layer' + id_num + '').val()},
                                dataType: "json",
                                success: function(data1) {
                                    
                                    add_another(id_num, data1, 'finish');
                                    //alert(data1);
                                }
                            });
                        }
                        
                        if (target == 'db_channel') {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>distribution_channel/getDbChannelById/",
                                data: {id: $('#layer' + id_num + '').val()},
                                dataType: "json",
                                success: function(data1) {
                                    //alert(data1);
                                    add_another(id_num, data1, 'finish');
                                }
                            });
                        }
                        //alert(id_num);
                    }
                    function reset_filter_upon_click() {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>distribution_channel/load/",
                            data: {type: '<?php echo $type; ?>', target: '<?php echo $target; ?>'},
                            success: function(data) {
                                $('#page').html(data);
                            }
                        });
                    }
</script>