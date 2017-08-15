
<br/>
<div class="row">
    <div class="form-group">
        <label class="col-md-3 control-label" for="route"> PSR :</label>                                        
        <div class="col-md-3">     
            <select class="form-control select2" data-placeholder="Select..." id="PSR" name="PSR" onchange="sub_route();">
                <option></option>
                <?php foreach ($PSR As $Dbpsr) { ?>                                                 
                    <option value="<?php echo $Dbpsr[id]; ?>" ><?php echo $Dbpsr[name]; ?></option>
                    <?php
                }
                ?>  
            </select>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="form-group">
        <label class="col-md-3 control-label" for="route"> Sub Route:</label>                                        
        <div class="col-md-3">     
            <select class="form-control select2" data-placeholder="Select..." id="subroute" name="subroute" onchange="getOutlet();">
                <option></option>

            </select>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="form-group">
        <label class="col-md-3 control-label" for="outlet">Outlet:</label>
        <div class="col-md-3">     
            <select class="form-control" data-placeholder="Select..." id="outlet" name="outlet" onchange="gerOrderPart();"required >
            </select>
        </div>
    </div>
</div>
<br>

<script type="text/javascript">
    $(".select2").select2({
        placeholder: "Select...",
        allowClear: true
    });


    function sub_route() {
        var psr_id = $("#PSR").val();
        $("#subroute").empty();
       $("#outlet").empty();
        if (psr_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/getRoutebByPSR/",
                data: {psr_id: psr_id},
                dataType: "html",
                success: function (data) {
                   
                     
                    $("#subroute").empty();
                    $("#subroute").append(data);
                    $("#subroute").select2({
                        placeholder: "Select...",
                        allowClear: true
                    
                });
                
                getOutlet();                    
                }
            });
        }
    }
    function getOutlet() {
        var sub_route_id = $("#subroute").val();
        $("#outlet").empty();

        if (sub_route_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/getOutlet/",
                data: {sub_route: sub_route_id},
                dataType: "html",
                success: function (data) {
                    $("#outlet").empty();
                    $("#outlet").append(data);
                    $("#outlet").select2({
                        placeholder: "Select...",
                        allowClear: true
                    });
                }
            });
        }
    }

</script>