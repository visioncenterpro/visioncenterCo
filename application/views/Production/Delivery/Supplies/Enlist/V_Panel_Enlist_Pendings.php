<style>
    .small-box:hover { color: #040202;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Insumos Pendientes</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" onclick="search()">Buscar</button>
                        </div>
                        
                        <table id="table_orders" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="chk_all" onclick="checked_all()"></th>
                                    <th>Order</th>
                                    <th>Cliente</th>
                                    <th>Proyecto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="chk">
                                        <input type="hidden" id="order" value="<?=$value->order?>">
                                    </td>
                                    <td><?= $value->order?></td>
                                    <td><?= $value->client?></td>
                                    <td><?= $value->project?></td>
                                </tr> 
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr style="border-top: 2px solid #b7b5b5;">
                <div class="row" style=" margin-top: 25px;">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs" id="tabs_dinamic">
                                
                            </ul>
                            <div class="tab-content" id="content-table">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function(){
       $("#table_orders").DataTable({});
    });
    
    function checked_all(){
        var chk_all = document.getElementById('chk_all').checked;
        var array_chk = document.querySelectorAll("input[id=chk]");
        array_chk.forEach(function(element){
            if(chk_all == true){
                element.checked = true;
            }else{
                element.checked = false;
            }
        });
    }
    
    function search(){
        var array_chk = document.querySelectorAll("input[id=chk]");
        var arr_chk = [];
        array_chk.forEach(function(element){
            arr_chk.push(element.checked);
        });
        var array = document.querySelectorAll("input[id=order]");
        var count = 0;
        var array_order = [];
        array.forEach(function(element){
            if(arr_chk[count] == true){
                array_order.push(element.value);
            }
            count++;
        });
        
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/search_supplies_pending",{array_order:array_order},function(data){
            console.log(data);
            $("#tabs_dinamic").html(data.tabs);
            $("#content-table").html(data.table);
            for(var i = 0; i < data.order_validation.length; i++){
                TableData2("table_supplies_"+data.order_validation[i], false, false, true, data.order_validation[i]);
                //$("#table_supplies_"+data.order_validation[i]).append('<label style="margin-left: 5px;"><a onclick="Excel_All(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Excel ALL</span></a></label>');
           
            }
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Excel_All(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-excel-o"></i> Excel ALL</span></a></label>');
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function excel(order){
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/excel_one",{order:order},function(data){
            console.log(data);
            var a=$("<a>");
            a.attr("href",data.data);
            $("body").append(a);
            a.attr("download","ReporteInsumoPendientes.xls");
            a[0].click();
            a.remove();
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function Excel_All(){
        var array_chk = document.querySelectorAll("input[id=chk]");
        var arr_chk = [];
        array_chk.forEach(function(element){
            arr_chk.push(element.checked);
        });
        var array = document.querySelectorAll("input[id=order]");
        var count = 0;
        var array_order = [];
        array.forEach(function(element){
            if(arr_chk[count] == true){
                array_order.push(element.value);
            }
            count++;
        });
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/excel",{array_order:array_order},function(data){
            console.log(data);
            var a=$("<a>");
            a.attr("href",data.data);
            $("body").append(a);
            a.attr("download","ReporteInsumoPendientes.xls");
            a[0].click();
            a.remove();
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
</script>