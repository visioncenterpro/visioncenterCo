<style>
    .small-box:hover { color: #040202;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Alistar Paquetes SD</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table_orders" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Cliente</th>
                                    <th>Proyecto</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $key => $value) { ?>
                                <tr>
                                    <td><?= $value->order?></td>
                                    <td><?= $value->client?></td>
                                    <td><?= $value->project?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" aria-label="Left Align" onclick="search('<?=$value->order?>')">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr> 
                                <?php } ?>
                            </tbody>
                        </table>
<!--                        <div class="input-group">
                            <input type="text" id="txt-order" value="20287" class="form-control" placeholder="Buscar Pedido...">
                            <span class="input-group-btn">
                                <button type="button" id="btnload" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>-->
                    </div>
                </div>
                <hr style="border-top: 2px solid #b7b5b5;">
                <div class="row" style=" margin-top: 25px;">
                    <div class="col-md-12" id="content-table">

                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<!-- Modal para realizar parametrizacion  -->
<div id="relation-pieces"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-sm"  style="width:350px">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center"><strong>RELACION PIEZAS</strong></h4>
            </div>
            <div class="modal-body" id="relation-body" >

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal para realizar parametrizacion2  -->
<div id="relation-pieces2"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-sm"  style="width:350px">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center"><strong>RELACION PIEZAS2</strong></h4>
            </div>
            <div class="modal-body" id="relation-body2" >

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-add-piece">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Pieza</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Largo</label>
                            <input type="number" class="form-control addpiece" id="largo" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Ancho</label>
                            <input type="number" class="form-control addpiece" id="ancho" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Calibre</label>
                            <input type="number" class="form-control addpiece" id="calibre" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Peso</label>
                            <input type="number" class="form-control addpiece" id="peso" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning pull-right" id="save-pz">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-delete-piece">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Pieza</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table_delete_pieces"  class="display table table-bordered table-striped table-condensed ">
                        <thead>
                            <tr>
                                <th style="width: 100px">LARGO</th>
                                <th style="width: 100px">ANCHO</th>
                                <th style="width: 100px">CALIBRE</th>
                                <th style="width: 100px">PESO</th>
                                <th style="width: 100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#table_orders").DataTable();
        $(document).keypress(function (e) {
            if (e.which == 13) {
                $("#btnload").click();
                return false;
            }
        });
        
        $("#btnload").click(function () {
            if (ValidateInput("txt-order")) {
                var order = $("#txt-order").val();
                $.post("<?= base_url() ?>Production/Delivery/C_Delivery/SearchOrderPackSD", {order: order}, function (data) {
                    if (data.res == "OK") {
                        if (data.rows > 0) {
                            $("#content-table").html(data.table);
                            TableData("table_pieces", false, false, true);
                            if(data.packs.count > 0){
                                TableData("table_pack", false, false, true);
                            }
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Empaque</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Range(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-bookmark-o"></i> Etiquetas</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Range2(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-bookmark-o"></i> Etiquetas2 </span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Weight(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-calculator"></i> Peso</span></a></label>');
                            
                            $("#count").html($("#total-packs").text());
                            window.scroll({
                                top: 100,
                                left: 100,
                                behavior: 'smooth'
                            });
                            //console.log(parseFloat(data.packs.total_weight) * <?= PORCENT_WEIGHT ?>);
                            $("#count-weight").html(data.packs.total_weight+" kg");
                            var integral = (parseFloat(data.packs.total_weight) * <?= PORCENT_WEIGHT ?>) + parseFloat(data.packs.total_weight);
                            
                            $("#count-integral").html(integral+" kg");
                           // Weight(order);
                            
                        } else {
                            swal({title: 'Error!', text: "No existen registros para este pedido", type: 'error'});
                        }
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, "json");
            }
        });
    });
    
    // pb
    function search(order){
        if (ValidateInput("txt-order")) {
            //var order = $("#txt-order").val();
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/SearchOrderPackSD", {order: order}, function (data) {
                if (data.res == "OK") {
                    if (data.rows > 0) {
                        $("#content-table").html(data.table);
                        TableData("table_pieces", false, false, true);
                        if(data.packs.count > 0){
                            TableDatap("table_pack", false, false, true,order);
                        }
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Empaque</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Range(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Range2(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas2 </span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Weight(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-calculator"></i> Peso</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-plus"></i>Adicionar</span></a></label>');
                        
                        $("#count").html($("#total-packs").text());
                        console.log(parseFloat(data.packs.total_weight));
                        $("#count-weight").html(Number((parseFloat(data.packs.total_weight)).toFixed(2))+" kg");
                        var integral = (parseFloat(data.packs.total_weight) * <?= PORCENT_WEIGHT ?>) + parseFloat(data.packs.total_weight);
                        $("#order-lbl").html(order);
                        $("#count-integral").html(Number((integral).toFixed(2))+" kg");
                        window.scroll({
                            top: 700,
                            left: 700,
                            behavior: 'smooth'
                        });
                        //swal({title: 'Datos Cargados!', text: "", type: 'success'});
                        // Weight(order);

                    } else {
                        swal({title: 'Error!', text: "No existen registros para este pedido", type: 'error'});
                    }
                } else {
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            }, "json");
        }
    }

    function excel(order){
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/excel_one_m",{order:order},function(data){
            var a=$("<a>");
            a.attr("href",data.data);
            $("body").append(a);
            a.attr("download","ReporteModuladosPendientes.xls");
            a[0].click();
            a.remove();
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function Pending(order){
        var win = window.open("<?= base_url() ?>Production/Delivery/C_Delivery/Pending_Report/"+order+"", '_blank');
        win.focus();
    }
    
    function Enlist(order){
        if(parseInt($("#count").text()) > 0 ){
             window.open("<?= base_url() ?>Production/Delivery/C_Delivery/Generate_Resumen/"+order, '_blank');
        }else{
            swal({title: 'Atencion!', text: "No existen paquetes generados", type: 'warning'});
        }
    }
    
    function Savepiece(id_order_package){
        if(ValidateInput("peso")){
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/AddPieceToPack", {largo:$("#largo").val(),ancho:$("#ancho").val(),calibre:$("#calibre").val(),peso:$("#peso").val(), order:$("#txt-order").val(),id_order_package:id_order_package}, function (data) {
                if (data.res == "OK") {
                    $("#pz-add-"+id_order_package).text(parseInt($("#pz-add-"+id_order_package).text())+1);
                    $("#pz-weight-"+id_order_package).text(parseFloat($("#pz-weight-"+id_order_package).text()) + parseFloat($("#peso").val()));
                    $('#modal-add-piece').modal('hide');
                    swal({title: '', text: "OK", type: 'success'});
                }else{
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            }, 'json');
        }
    }
    
    function DeletePiece(id_order_package_addpiece,id_order_package){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/DeletePieceToPack", {id_order_package_addpiece:id_order_package_addpiece,order:$("#txt-order").val(),id_order_package:id_order_package}, function (data) {
            if (data.res == "OK") {
                $("#pzs"+id_order_package_addpiece).remove();
                $("#pz-add-"+id_order_package).text(parseInt($("#pz-add-"+id_order_package).text()) - 1);
                $("#pz-weight-"+id_order_package).text(parseFloat(data.peso));
                $('#modal-add-piece').modal('hide');
                swal({title: '', text: "OK", type: 'success'});
            }else if(data.res == "Empty"){
                swal({title: '', text: "EL PAQUETE NO TIENE PIEZAS ADICIONALES", type: 'warning'});
            }else{
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        }, 'json');
    }
    
    function OpenDeletePiece(id_order_package){
        if(parseInt($("#pz-add-"+id_order_package).text()) > 0){
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/CharguePieceToPack", {order:$("#txt-order").val(),id_order_package:id_order_package}, function (data) {
                    var rows = '';
                    $.each(data,function(e,i){
                        rows += '<tr id="pzs'+data[e].id_order_package_addpiece+'">';
                        rows += '<td>'+data[e].long+'</td>';
                        rows += '<td>'+data[e].width+'</td>';
                        rows += '<td>'+data[e].caliber+'</td>';
                        rows += '<td>'+data[e].weight+'</td>';
                        rows += '<td><button type="button" class="btn btn-sm btn-danger"  onclick="DeletePiece('+data[e].id_order_package_addpiece+','+id_order_package+')"><i class="fa fa-fw fa-trash"></i> </button></td>';
                        rows += '</tr>';
                    });
                $("#table_delete_pieces > tbody ").html(rows);
                $("#modal-delete-piece").modal("show");

            }, 'json');
        }else{
            swal({title: '', text: "EL PAQUETE NO TIENE PIEZAS ADICIONALES", type: 'warning'});
        }
    }
    
    function AddPiece(id_order_package){
        $(".addpiece").val("");
        $('#modal-add-piece').modal('show');
        $("#save-pz").attr("onclick","Savepiece("+id_order_package+")");
    }
    

    function Range(order) {
        if($("#tabla >tbody >tr").length <= 0){
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/GenerateRangeTag", {order:order}, function (data) {
                if(data.res == "OK"){
                    $('#relation-body').html(data.table);
                    $('#relation-pieces').modal('show');
                }else{
                    swal({title: 'Error!', text:data.res, type: 'error'});
                }

            }, 'json');
        }else{
            $('#relation-pieces').modal('show');
        }
    }
    
    function Range2(order) {
        if($("#tabla2 >tbody >tr").length <= 0){
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/GenerateRangeTag2", {order:order}, function (data) {
                if(data.res == "OK"){
                    $('#relation-body2').html(data.table);
                    $('#relation-pieces2').modal('show');
                }else{
                    swal({title: 'Error!', text:data.res, type: 'error'});
                }

            }, 'json');
        }else{
            $('#relation-pieces2').modal('show');
        }
    }
    
    function Tags(order,min,max,btn){
        $(btn).addClass("btn-primary").removeClass("btn-default");
        window.open("<?= base_url() ?>Production/Delivery/C_Delivery/PrintPack/" + order+"/"+min+"/"+max, '_blank');
    }
    function Tags2(order,min,max,btn){
        $(btn).addClass("btn-primary").removeClass("btn-default");
        window.open("<?= base_url() ?>Production/Delivery/C_Delivery/GeneratePacksSD2/" + order+"/"+min+"/"+max, '_blank');
    }

//
    function Weight(order){

        $(".overlay_ajax").show();
        if(parseInt($("#count").text()) > 0 ){
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/CalculateWeightPackSD", {order:order}, function (data) {
                $("#content-pack").html(data.table);
                
                TableData("table_pack", false, false, true);
                $("#count-weight").html(data.data['total_weight']+" kg");
                var integral = parseFloat(data.data['total_weight'] * <?= PORCENT_WEIGHT ?>) + parseFloat(data.data['total_weight']);
                $("#count-integral").html(integral+" kg");
                swal({title: 'Datos cargados!', text: '', type: 'success'});
                if(data.res == "OK"){
                    $(".overlay_ajax").hide();
                    $(".loader_ajax2").text("");
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }else{
            swal({title: 'Atencion!', text: "No existen paquetes generados", type: 'warning'});
        }
    }
    
    function GeneratePacks(order) {
        swal({title: 'Atencion!', text: "Esta Opcion no esta habilitada", type: 'warning'});
    }
</script>
