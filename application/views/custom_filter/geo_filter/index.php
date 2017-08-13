<!--GEO Layer start-->
<div class="col-md-6">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gear"></i>Filter
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title=""></a>
            </div>
        </div>
        <div class="portlet-body" style="display: block;position: relative">
            <div id="geo_layer_filter"></div>
            <?php foreach ($result as $k => $v) { ?>
                <label><?php echo $v['layer_name']; ?></label>
                <select multiple="multiple" style="min-width: 509px !important;" onchange="getNextLayerData(this)" name="<?php echo $v['layer_id']; ?>[]" class="multi_select_with_search" id="<?php echo $v['layer_id']; ?>" >
                    <?php
                    foreach ($v['data'] as $val) {
                        echo '<option value="' . $val['id'] . '" > ' . $val['name'] . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <br/>
            <?php } ?>
            <div style="display: none;">
                <select multiple name="dbhouse_id[]" id="dbhouse_id">
                    <?php
                        foreach ($db_id as $v) {
                            echo '<option value="' . $v . '" selected>' . $v . '</option>';
                        }
                    ?>
                </select>
                <select multiple name="sr_id[]" id="sr_id"></select>
            </div>
            <button class="btn btn-success" onclick="getDistChannelLayer();">Get Distribution Channel</button>

        </div>
    </div>
</div>

<!--GEO Layer end-->


<script type="text/javascript">
    var multi_select_option = '<?php echo $option; ?>';
    if (multi_select_option == 'single') {
        $(".multi_select_with_search").multiselect({multiple: false}).multiselectfilter();
    } else {
        $(".multi_select_with_search").multiselect().multiselectfilter();
    }



    /**=================================================================
     * this is the main function for pupulating layer data
     *-------------------------------------------------------------------*/

    function getNextLayerData(id) {
        var layer_id = $(id).attr('id');
        var layer_num = parseInt(layer_id.slice(16));
        var value = $(id).val();
//        alert(layer_num);

        //hard coded
        if (layer_num < 3) {
            getGeoLayerByParent(value, layer_num);
            makeDBListForExistingReportByGeo(value, layer_num);
        } else if (layer_num == 3) {
            getDbByBizZone(value, layer_num);
            makeDBListForExistingReportByCeArea(value);
        } else if (layer_num == 4) {
            getSrByDb(value, layer_num);
            makeDBListForExistingReport(value);
        } else if (layer_num == 5) {
            makeSrListForExistingReport(value);
        }

    }
    //----------------------------end-------------------------------------



    /**=================================================================
     * get db list by their biz_zone
     *-------------------------------------------------------------------*/
    function getDbByBizZone(parent_id, layer_num) {
        var nextId = '#geo_filter_layer' + (layer_num + 1);
        var layer_number = layer_num + 1;
        clearLayer(layer_number);
        if (parent_id !== null) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>custom_filter/getDbByBizZone/",
                data: {parent_id: parent_id},
                dataType: "json",
                success: function (data) {
                    $(nextId).empty();
                    for (var i = 0; i < data.length; i++) {
                        $(nextId).append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }
                    $(nextId).multiselect("refresh");
                }
            });
        } else {
            $('#geo_filter_layer' + (layer_num - 1)).change();
        }

    }
    //----------------------------end-------------------------------------



    /**=================================================================
     * get geo layer info by their parnet id
     *-------------------------------------------------------------------*/

    function getGeoLayerByParent(parent_id, layer_num) {
        var nextId = '#geo_filter_layer' + (layer_num + 1);
        var layer_number = layer_num + 1;
        clearLayer(layer_number);
        if (parent_id !== null) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>custom_filter/getGeoLayerByParent/",
                data: {parent_id: parent_id},
                dataType: "json",
                success: function (data) {
                    $(nextId).empty();
                    for (var i = 0; i < data.length; i++) {
                        $(nextId).append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }
                    $(nextId).multiselect("refresh");
                }
            });
        } else {
            $('#geo_filter_layer' + (layer_num - 1)).change();
        }

    }
    //----------------------------end-------------------------------------



    /**=================================================================
     * get sr list by db_id
     *-------------------------------------------------------------------*/
    function getSrByDb(db_id, layer_num) {
        var nextId = '#geo_filter_layer' + (layer_num + 1);
        var layer_number = layer_num + 1;
        clearLayer(layer_number);
        if (db_id !== null) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>custom_filter/getSrByDb/",
                data: {db_id: db_id},
                dataType: "json",
                success: function (data) {
                    $(nextId).empty();
                    for (var i = 0; i < data.length; i++) {
                        $(nextId).append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }
                    $(nextId).multiselect("refresh");
                }
            });
        } else {
            $('#geo_filter_layer' + (layer_num - 1)).change();
        }
    }
    //----------------------------end-------------------------------------



    function makeSrListForExistingReport(sr_id) {
        $("#sr_id").empty();
        if (sr_id !== null) {
            for (var i = 0; i < sr_id.length; i++) {
                $("#sr_id").append("<option value='" + sr_id[i] + "' selected>" + sr_id[i] + "</option>");
            }
        }
    }


    function makeDBListForExistingReport(db_id) {
        $("#dbhouse_id").empty();
        if (db_id !== null) {
            for (var i = 0; i < db_id.length; i++) {
                $("#dbhouse_id").append("<option value='" + db_id[i] + "' selected>" + db_id[i] + "</option>");
            }
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>custom_filter/getDbIds/",
                dataType: "json",
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        $("#dbhouse_id").append("<option value='" + data[i].id + "' selected>" + data[i].id + "</option>");
                    }
                }
            });
        }
    }


    function makeDBListForExistingReportByCeArea(parent_id) {

        var nextId = '#dbhouse_id';
        if (parent_id !== null) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>custom_filter/getDbByBizZone/",
                data: {parent_id: parent_id},
                dataType: "json",
                success: function (data) {
                    $(nextId).empty();
                    for (var i = 0; i < data.length; i++) {
                        $(nextId).append("<option value='" + data[i].id + "' selected>" + data[i].id + "</option>");
                    }
                }
            });
        } else {
            $(nextId).empty();
        }
    }


    function makeDBListForExistingReportByGeo(parent_id, layer_num) {
        var nextId = '#dbhouse_id';
        if (parent_id !== null) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>custom_filter/makeDBListForExistingReportByGeo/",
                data: {parent_id: parent_id, layer_num: layer_num},
                dataType: "json",
                success: function (data) {
                    $(nextId).empty();
                    for (var i = 0; i < data.length; i++) {
                        $(nextId).append("<option value='" + data[i].id + "' selected>" + data[i].id + "</option>");
                    }
                }
            });
        } else {
            $(nextId).empty();
        }

    }




    /**=================================================================
     * clear layer data when parent layer is reset
     * @param layer_number
     *-------------------------------------------------------------------*/
    function clearLayer(layer_number) {
        for (var i = layer_number; i <= 6; i++) {
            var nextId = '#geo_filter_layer' + i;
            $(nextId).empty();
            $(nextId).multiselect("refresh");
        }
    }
    //----------------------------end-------------------------------------


</script>
