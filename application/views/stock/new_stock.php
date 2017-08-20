<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->

        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>stock">Current Stock</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                New Stock
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<form role="form" id="add_order_form" action="<?php echo site_url('stock/add_stock'); ?>"
      method="post">
    <!-- BEGIN FORM-->
    <div class="row">
        <div class="col-md-12" >
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12" >


                        <div class="form-group">
                            <label class="control-label text-right control-label-left col-sm-2" for="field1">Challan :</label>
                            <div class="controls col-md-4">

                                <input id="field1" type="text" class="form-control k-textbox" data-role="text" data-parsley-errors-container="#errId1"><span id="errId1" class="error"></span></div>

                        </div>
                        <br>
                        <div class="form-group">
                            <label class="control-label  text-right control-label-left col-sm-2" for="field2">Vat Challan :</label>
                            <div class="controls col-md-4">

                                <input id="field2" type="text" class="form-control k-textbox" data-role="text" data-parsley-errors-container="#errId2"><span id="errId2" class="error"></span></div>



                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" >&nbsp;</div></div>
                <div class="row">
                    <div class="col-md-12" >
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Order</h3>

                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-hover" id="sales_order">
                                        <thead>
                                            <tr>
                                                <th>
                                                    SKU Name (Code)
                                                </th>
                                                <th>
                                                    Pack Size
                                                </th>
                                                <th>
                                                    Unit Price
                                                </th>
                                                <th style="min-width: 100px;">
                                                    CS
                                                </th>
                                                <th style="min-width: 100px;">
                                                    PCS
                                                </th>
                                              
                                                <th>
                                                    Total QTY
                                                </th>
                                                <th style="min-width: 140px;">
                                                    Subtotal
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_cycle">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <a class="btn btn-xs btn-success" id="row_add" data-track="0" onclick="add_row()"><i class="fa fa-plus"></i>
                                                        Add</a>
                                                </td>
                                                <td colspan="4"></td>

                                                <td>Gross Total</td>
                                                <td>
                                                    <input id="grand_total" type="text" class="form-control" name="grand_total" readonly/>
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn-success" id="row_add" data-track="0" onclick="add_row()"><i class="fa fa-plus"></i>
                                                        Add</a>
                                                </td>
                                            </tr>
                                          
                                        </tfoot>
                                    </table>
                                </div>
                                <input type="hidden" class="form-control" id="row_num" name="row_num" value="1">
                            </div>

                        </div>        
                    </div>
                </div>
            </div>
            </form>
        </div>


        <?php
        $this->load->view('footer/footer');
        ?>

        <script type="text/javascript">


var sku_row_count = -1;

    $(document).ready(function () {
        add_row();
    });
    /*add row*/
    function add_row() {

        sku_row_count++;
        var sku_list = block_sku_list();
        var count = sku_row_count;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>stock/add_row/",
            data: {count: count, sku_list: sku_list},
            dataType: "html",
            success: function (data) {

                $('#sales_order tbody').append(data);
                $("#sales_order tbody select").select2({
                    placeholder: "Select",
                    allowClear: true
                });
            }
        });
    }

    /*-----------------------------------------------------------------------
     * Get the  Block Sku by using this function
     *-----------------------------------------------------------------------*/
    function block_sku_list() {
        var sku_id_list = [];
        $('body select[name="sku_id[]"]').each(function () {
            var sku_id = $(this).val();
            if (sku_id) {
                sku_id_list.push(sku_id);
            }
        });
        return sku_id_list;
    }

    /*-----------------------------------------------------------------------
     * delete sales order line if add
     *-----------------------------------------------------------------------*/
    $("table").on('click', '#removeLine', function () {
        $(this).parent('td').parent('tr').remove();
      //  grand_total_amount();
    });
    //end
    
      function get_unit_price(id){
       
        var index     = id.slice(6);
        var sku_id    = $("#sku_id" + index).val();
         $("#Pack_Size" + index).val('');
        $("#TP_price" + index).val('');
        $("#order_qty_CS" + index).val('');
        $("#order_qty_PS" + index).val('');
        $("#Offer_txt" + index).val('');
        $("#Discount" + index).val('');
        $("#Total_qty" + index).val('');
        $("#total_amount" + index).val('');    
        
        
        
       
    //    grand_total_amount();

        if (sku_id != ''){
           
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>stock/getBundleDetailbySku/",
                data: {sku_id: sku_id},
                dataType: "json",
                error:function(e){
                    alert("error");
                },
                success: function (data){
                    $("#TP_price" + index).val(data.price);
                    $("#Pack_Size" + index).val(data.unit);
                   
                  openQty(index);
                }
            });
            //end
            //get mou
           
        } else{
            openQty(index);
        }
    }
  function openQty(index) {
        //var index = index.slice(9);
      
        var TP_price = $("#TP_price" + index).val();

        if (TP_price !== '') {
            $("#order_qty_CS" + index).attr('readonly', false);
             $("#order_qty_PS" + index).attr('readonly', false);
        } else {
            grand_total_amount();
        }
    }
    
      function total_qty_cs(id) {
       var index = id.slice(12);
       var Pack_Size=$("#Pack_Size" + index).val();
       var TP_price=$("#TP_price" + index).val();
       
       
       var order_qty_CS = $("#order_qty_CS" + index).val();
       order_qty_CS = (order_qty_CS != '') ? parseInt(order_qty_CS) : 0;
       var order_qty_PS = $("#order_qty_PS" + index).val();
       order_qty_PS = (order_qty_PS != '') ? parseInt(order_qty_PS) : 0;
       $("#Total_qty"+ index).val(parseInt(order_qty_CS * Pack_Size)+order_qty_PS);
       $("#total_amount"+ index).val(parseFloat(((order_qty_CS * Pack_Size)+order_qty_PS)*TP_price).toFixed(2));
       
             grand_total_amount();
    }
    



    function grand_total_amount() {
        var total_amount = 0;
       
        $('input[name="total_amount[]"]').each(function () {
            var amount = $(this).val();
            if (amount) {
                total_amount = total_amount + parseFloat(amount);
            }
        });
        $("#grand_total").val(parseFloat(total_amount).toFixed(2));
        $("#discount_total").val(parseFloat(total_amount).toFixed(2));
       
        
    }

 $('#add_order_form').unbind('submit').bind('submit',function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        $('#ajax_load').css("display", "block");
     
         var url = "<?php echo site_url('order/add_other_sale_order'); ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: $("#add_order_form").serialize(), // serializes the form's elements.
            success: function (data){
                 // show response from the php script.

                $('#ajax_load').css("display", "none");
                getOutlet();
               $("#outlet").select2('val', '');
//               /$("#outlet").change();
            }
        });
    });
    
 



        </script>
