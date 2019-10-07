<style>
    .small-box:hover { color: #040202;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Alistar Insumos</h3>
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
                            <input type="text" id="txt-order" value="20233" class="form-control" placeholder="Buscar Pedido...">
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

<div class="modal fade" id="modal-supplies">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" id="modal-weight">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-default pull-right"  onclick="UpdateSupplies()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_manual">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Paquete manual - order  #<label id="order"></label></h4>
            </div>
            <div class="modal-body" id="content_manual">
                <label id="edit_label">No puede superar el limite de número a empacar</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="Add_packed()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_manual">
    <div class="modal-dialog" >
        <div class="modal-content" style="width: 103%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Paquete manual - order  #<label id="order-edit"></label></h4>
            </div>
            <div class="modal-body" id="content_edit_manual">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" id="update_btn" onclick="Update_packet()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_supplies">
    <div class="modal-dialog" >
        <div class="modal-content" style="width: 103%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar insumo - order  #<label id="order-add"></label></h4>
            </div>
            <div class="modal-body" id="content_add_supplies">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" id="update_btn" onclick="add_supplies()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_obs">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Observación</h4>
            </div>
            <div class="modal-body"> 
                <input type="hidden" id="id_order_supplies_i">
                <input type="hidden" id="excl">
                <textarea class="form-control" id="obs"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" id="update_btn" onclick="Exclude()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#edit_label").hide();
        $("#table_orders").DataTable();
        $("#btnload").click(function () {
            if (ValidateInput("txt-order")) {
                var order = $("#txt-order").val();
                $.post("<?= base_url() ?>Production/Delivery/C_Delivery/SearchOrder", {order: order}, function (data) {
                    if (data.res == "OK") {
                        if (data.rows > 0) {
                            $("#content-table").html(data.table);
                            TableData("table_supplies", false, false, true);
                            TableData("table_pack", false, false, true);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-bookmark-o"></i> Etiquetas</span></a></label>');
                            $('input[type="checkbox"]').iCheck({
                                checkboxClass: 'icheckbox_minimal-blue'
                            }).on('ifChanged', function (e) {
                                var isChecked = e.currentTarget.checked;
                                if (isChecked == true) {
                                    var exclude = 1;
                                } else {
                                    var exclude = 0;
                                }
                                Exclude_modal(this.value, exclude);
                            });
                            
                            $("#count").html($("#total-packs").text());

                        } else {
                            swal({title: 'Error!', text: "No existen registros para este pedido", type: 'error'});
                        }
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, "json");
            }
        });
        $("#comment").keypress(function(character){
            //console.log(character);
            var characters_count = $("#comment").val().length;
            if(parseInt(characters_count) + 1 > 80){
                $("#warning").attr("style", "color:red");
                return false;
            }
            
        });
         $("#comment").bind('paste', function(e){
            var characters_count = $("#comment").val().length;
            var data = e.originalEvent.clipboardData.getData('Text');
            if(parseInt(data.length) + parseInt(characters_count) > 80){
                $("#warning").attr("style", "color:red");
                return false;
            }
         });
    });

    var pbt = 0;
    function validation_total(e,value,max){
        pbt++;
        //console.log(value);
        if(pbt == 1){
            value.value = value.value + e.key;
        }
        if(parseInt(value.value+ e.key) > parseInt(max)){
            value.value = "";
            $("#edit_label").show();
            $("#edit_label").attr("style", "color:red");
            //return false;
        }
        //value.value = "1";
    }
    
    function search(order){
        $("#order_value").val(order);
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/SearchOrder2", {order: order}, function (data) {
            if (data.res == "OK") {
                if (data.rows > 0) {
                    console.log(data);
                    $("#content-table").html(data.table);
                    TableData("table_supplies", false, false, true);
                    TableData("table_pack", false, false, true);
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Alistamiento</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Pendientes</span></a></label>');
                    $('input[type="checkbox"]').iCheck({
                        checkboxClass: 'icheckbox_minimal-blue'
                    }).on('ifChanged', function (e) {
                        var isChecked = e.currentTarget.checked;
                        if (isChecked == true) {
                            var exclude = 1;
                        } else {
                            var exclude = 0;
                        }
                        Exclude_modal(this.value, exclude);
                    });
                    $("#count").html(data.packs.length);
                    $("#order-lbl").html(order);
                    $("#order-lbl2").html(order);
                    window.scroll({
                        top: 700,
                        left: 700,
                        behavior: 'smooth'
                    });

                } else {
                    swal({title: 'Error!', text: "No existen registros para este pedido", type: 'error'});
                }
            } else {
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        }, "json");
    }

    function Pending(order){
        var win = window.open("<?= base_url() ?>Production/Delivery/C_Delivery/Pending_Report_Supplies/"+order+"", '_blank');
        win.focus();
    }
    
    function Manual_Package(order){
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/get_data_manual",{order:order},function(data){
            console.log(data);
            $("#order").text(order);
            $("#content_manual").html(data.table);
            $("#modal_manual").modal("show");
            if(data.res_number == true){
                if(data.number[0]['number_pack'] == null){
                    data.number[0]['number_pack'] = 0;
                }
                if(data.iss === 1){
                    $("#lbl_number_p").text(parseInt(data.number[0]['number_pack']) + parseInt(1));
                }else{
                    $("#lbl_number_p").text("N°Paquete "+(parseInt(data.number[0]['number_pack']) + parseInt(1)));
                }
               // $("#lbl_number_p").text("N°Paquete "+(parseInt(data.number[0]['number_pack']) + parseInt(1)));
                $("#package_number").val(parseInt(data.number[0]['number_pack']) + parseInt(1));
            }else{
                if(data.iss === 1){
                    $("#lbl_number_p").text(data.number[0]['number_pack']);
                }else{
                    $("#lbl_number_p").text("N°Paquete "+data.number[0]['number_pack']);
                }
                
                $("#package_number").val(data.number[0]['number_pack']);
            }

        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function modal_edit(id_order_package_supplies,number_pack,order){
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/get_data_edit",{id_order_package_supplies:id_order_package_supplies,number_pack:number_pack,order:order,type:'A'},function(data){
            console.log(data);
            $("#order-edit").text(order);
            $("#content_edit_manual").html(data.table);
            $("#modal_edit_manual").modal("show");
            $("#pq").text(number_pack);
            $("#package_number_edit").val(number_pack);
            if(data.supplies.lenght == 0){
                document.getElementById("update_btn1").disabled = true;
                document.getElementById("update_btn").disabled = true;
            }
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function modal_add_supplies(id_order_package_supplies,number_pack,order){
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/get_data_add",{order:order,number_pack:number_pack},function(data){
            //console.log(data);
            $("#order-add").text(order);
            $("#content_add_supplies").html(data.table);
            $("#modal_add_supplies").modal("show");
            

        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function Update_packet(){
        var order = $("#order_value").val();
        var array_c = document.querySelectorAll("input[id=select_edit]");
        var array_check = [];
        array_c.forEach(function(element){
           array_check.push(element.checked);
        });
        var number_pack = $("#number_pack").val();
        var array = document.querySelectorAll("input[id=quantity_pack_edit]");
        var pack_total = [];
        //var count = 0;
        var counter = 0;
        var chk = 0;
        
        var counter_val = 0;
        var val_chk = 0;
        array.forEach(function(element) {
            if((array_check[counter_val] == false && element.value == 0)){
                val_chk = 1;
                return false;
            }
            counter_val++;
        }, this);
        
        array.forEach(function(element) {
            if(array_check[counter] == true){
                chk = 1;
            }
            if(element.value == ""){
                element.value = 1;
            }
            pack_total.push(element.value);
            counter++;
        }, this);
        var weight_package = $("#weight_package_edit").val();
        var array_o = document.querySelectorAll("input[id=id_order_supplies_edit]");
        var array_order_supplies = [];
        array_o.forEach(function(element) {
            array_order_supplies.push(element.value);
        }, this);
        var array_s = document.querySelectorAll("input[id=id_supplies_edit]");
        var array_id_supplies = [];
        array_s.forEach(function(element) {
            array_id_supplies.push(element.value);
        }, this);
        var array_qe = document.querySelectorAll("input[id=quantity_edit]");
        var array_quantity_edit = [];
        var counter2 = 0;
        array_qe.forEach(function(element){
            array_quantity_edit.push(element.value);
            counter2++;
        });
        var array_qep = document.querySelectorAll("input[id=quantity_edit_packed]");
        var count = 0;
        var counter3 = 0;
        array_qep.forEach(function(element){
            if(array_check[counter3] === true){
                element.value = pack_total[counter3];
            }
            count = count + parseInt(element.value);
            counter3++;
        });
        
        if(weight_package == "" || chk == 0){
            var txt = "";
            if(chk == 0){
                txt = "(seleccione algún insumo)";
            }
            swal({title: 'Error!', text: "Ingrese todos los datos al formulario "+txt, type: 'error'});
        }else{
            if(val_chk == 1){
                swal({
                    title: 'Atención',
                    text: "Hay elementos sin seleccionar, desea guardar los cambios?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result) {
                        $.post("<?= base_url()?>Production/Delivery/C_Delivery/Update_Packed",{order:order,count:count,number_pack:number_pack,pack_total:pack_total,weight_package:weight_package,count:count,array_order_supplies:array_order_supplies,array_id_supplies:array_id_supplies,array_check:array_check,array_quantity_edit:array_quantity_edit},function(data){
                            $("#content-table").html(data.table);
                            TableData("table_supplies", false, false, true);
                            TableData("table_pack", false, false, true);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');

                            $('input.minimal:checkbox').iCheck({
                                checkboxClass: 'icheckbox_minimal-blue'
                            }).on('ifChanged', function (e) {
                                var isChecked = e.currentTarget.checked;
                                if (isChecked == true) {
                                    var exclude = 1;
                                } else {
                                    var exclude = 0;
                                }
                                Exclude_modal(this.value, exclude);
                            });

                            $("#count").html(data.packs.length);
                            //$("#count").html($("#total-packs").text());
                            if(typeof data.data2[0][0]['quantity_packaged'] == "undefined" || data.data2[0][0]['quantity_packaged'] === null){
                                var quantity_packaged = 0;
                            }else{
                                var quantity_packaged = data.data2[0][0]['quantity_packaged'];
                            }
                            var array1 = document.querySelectorAll("input[id=quantity_edit_packed]");
                            // var cont_array = [];
                            // array1.forEach(function(element){
                            //     cont_array.push(element.value);
                            // });
                            var array_quantity = document.querySelectorAll("input[id=quantity_edit]");
                            var count_q = 0;
                            var data_quantity = [];
                            array_quantity.forEach(function(element){
                                data_quantity.push(element.value);
                                if(data.data[count_q][0]['quantity_packaged'] != 0){
                                    //console.log(data);
                                    document.getElementById("sum-edit-"+count_q).innerText = "";
                                    document.getElementById("packed-edit-"+count_q).innerText = "";

                                    document.getElementById("sum-edit-"+count_q).innerText = parseInt(data.data2[count_q][0]['quantity']) - parseInt(data.data2[count_q][0]['quantity_packaged']);
                                    //document.getElementById("sum-edit-"+count_q).innerText = parseInt(parseInt(data_quantity[count_q]) - parseInt(quantity_packaged))
                                    document.getElementById("packed-edit-"+count_q).innerText = data.data[count_q][0]['quantity_packaged'];
                                    element.value = data.data[count_q][0]['quantity_packaged'];
                                    //element.value = data.data2[count_q][0]['quantity'];
                                     count_q++;
                                }

                            });

                            var count_q2 = 0;
                            var count_q21 = 0;
                            var array = document.querySelectorAll("input[id=quantity_pack_edit]");
                            console.log(array);
                            array.forEach(function(element){
                                console.log(count_q2);
                                if(data.data[count_q2][0]['quantity_packaged'] != 0){
                                    //element.value = parseInt(data_quantity[count_q2]) - parseInt(data.data[count_q2][0]['quantity_packaged']);
                                    //element.setAttribute("max", parseInt(data_quantity[count_q2]) - parseInt(data.data2[0][0]['quantity_packaged']));
                                    //element.value = parseInt(parseInt(data_quantity[count_q2]) - parseInt(quantity_packaged));
                                    //console.log(count_q2);
                                    element.value = parseInt(data.data2[count_q21][0]['quantity']) - parseInt(data.data2[count_q21][0]['quantity_packaged']);
                                    element.setAttribute("max", parseInt(data.data2[count_q21][0]['quantity']) - parseInt(data.data2[count_q21][0]['quantity_packaged']));
                                    if(parseInt(data.data2[count_q21][0]['quantity']) - parseInt(data.data2[count_q21][0]['quantity_packaged']) == 0){
                                        element.setAttribute("disabled", "true");
                                    }
                                    count_q21++;
                                }
                                count_q2++;
                            });
                            var count_q3 = 0;
                            var array_s = document.querySelectorAll("input[id=select_edit]");
                            array_s.forEach(function(element){
                                element.checked = false;
                                if(parseInt(data_quantity[count_q3]) - parseInt(data.data[count_q3][0]['quantity_packaged']) == 0){
                                    element.setAttribute("disabled", "true");
                                }
                                $("#id_order_package_supplies_all_edit"+count_q3).val(data.sum[count_q3]);
                                count_q3++;
                            });
                            //validation_header(order);
                            swal({title: 'Exito', text: "Se han guardado los cambios", type: 'success'});
                            if(val_chk == 1){
                                $("#modal_edit_manual").modal("hide");
                            }
                            $("#order-lbl").html(order);
                            $("#order-lbl2").html(order);
                        },'json').fail(function (error) {
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                        });
                    }
                });
            }else{
                $.post("<?= base_url()?>Production/Delivery/C_Delivery/Update_Packed",{order:order,count:count,number_pack:number_pack,pack_total:pack_total,weight_package:weight_package,count:count,array_order_supplies:array_order_supplies,array_id_supplies:array_id_supplies,array_check:array_check,array_quantity_edit:array_quantity_edit},function(data){
                    $("#content-table").html(data.table);
                    TableData("table_supplies", false, false, true);
                    TableData("table_pack", false, false, true);
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');

                    $('input.minimal:checkbox').iCheck({
                        checkboxClass: 'icheckbox_minimal-blue'
                    }).on('ifChanged', function (e) {
                        var isChecked = e.currentTarget.checked;
                        if (isChecked == true) {
                            var exclude = 1;
                        } else {
                            var exclude = 0;
                        }
                        Exclude_modal(this.value, exclude);
                    });

                    $("#count").html(data.packs.length);
                    //$("#count").html($("#total-packs").text());
                    if(typeof data.data2[0][0]['quantity_packaged'] == "undefined" || data.data2[0][0]['quantity_packaged'] === null){
                        var quantity_packaged = 0;
                    }else{
                        var quantity_packaged = data.data2[0][0]['quantity_packaged'];
                    }
                    var array1 = document.querySelectorAll("input[id=quantity_edit_packed]");
                    // var cont_array = [];
                    // array1.forEach(function(element){
                    //     cont_array.push(element.value);
                    // });
                    var array_quantity = document.querySelectorAll("input[id=quantity_edit]");
                    var count_q = 0;
                    var data_quantity = [];
                    array_quantity.forEach(function(element){
                        data_quantity.push(element.value);
                        if(data.data[count_q][0]['quantity_packaged'] != 0){
                            //console.log(data);
                            document.getElementById("sum-edit-"+count_q).innerText = "";
                            document.getElementById("packed-edit-"+count_q).innerText = "";

                            document.getElementById("sum-edit-"+count_q).innerText = parseInt(data.data2[count_q][0]['quantity']) - parseInt(data.data2[count_q][0]['quantity_packaged']);
                            //document.getElementById("sum-edit-"+count_q).innerText = parseInt(parseInt(data_quantity[count_q]) - parseInt(quantity_packaged))
                            document.getElementById("packed-edit-"+count_q).innerText = data.data[count_q][0]['quantity_packaged'];
                            element.value = data.data[count_q][0]['quantity_packaged'];
                            //element.value = data.data2[count_q][0]['quantity'];
                             count_q++;
                        }

                    });

                    var count_q2 = 0;
                    var count_q21 = 0;
                    var array = document.querySelectorAll("input[id=quantity_pack_edit]");
                    console.log(array);
                    array.forEach(function(element){
                        console.log(data.data[count_q2][0]['quantity_packaged']);
                        if(data.data[count_q2][0]['quantity_packaged'] != 0){
                            //element.value = parseInt(data_quantity[count_q2]) - parseInt(data.data[count_q2][0]['quantity_packaged']);
                            //element.setAttribute("max", parseInt(data_quantity[count_q2]) - parseInt(data.data2[0][0]['quantity_packaged']));
                            //element.value = parseInt(parseInt(data_quantity[count_q2]) - parseInt(quantity_packaged));
                            //console.log(count_q2);
                            element.value = parseInt(data.data2[count_q21][0]['quantity']) - parseInt(data.data2[count_q21][0]['quantity_packaged']);
                            element.setAttribute("max", parseInt(data.data2[count_q21][0]['quantity']) - parseInt(data.data2[count_q21][0]['quantity_packaged']));
                            if(parseInt(data.data2[count_q21][0]['quantity']) - parseInt(data.data2[count_q21][0]['quantity_packaged']) == 0){
                                element.setAttribute("disabled", "true");
                            }
                            count_q21++;
                        }
                        count_q2++;
                    });
                    var count_q3 = 0;
                    var array_s = document.querySelectorAll("input[id=select_edit]");
                    array_s.forEach(function(element){
                        element.checked = false;
                        if(parseInt(data_quantity[count_q3]) - parseInt(data.data[count_q3][0]['quantity_packaged']) == 0){
                            element.setAttribute("disabled", "true");
                        }
                        $("#id_order_package_supplies_all_edit"+count_q3).val(data.sum[count_q3]);
                        count_q3++;
                    });
                    //validation_header(order);
                    swal({title: 'Exito', text: "Se han guardado los cambios", type: 'success'});
                    if(val_chk == 1){
                        $("#modal_edit_manual").modal("hide");
                    }
                    $("#order-lbl").html(order);
                    $("#order-lbl2").html(order);
                },'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
            
        }
    }
    
    function delete_pq(order,number_pack){
        //validation_supplies d
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/validation_supplies",{order:order,number_pack:number_pack},function(data){
            console.log(data);
            $("#content-table").html(data.table);
            TableData("table_supplies", false, false, true);
            TableData("table_pack", false, false, true);
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
            $('input.minimal:checkbox').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            }).on('ifChanged', function (e) {
                var isChecked = e.currentTarget.checked;
                if (isChecked == true) {
                    var exclude = 1;
                } else {
                    var exclude = 0;
                }
                Exclude_modal(this.value, exclude);
            });
            $("#count").html(data.packs.length);
            $("#order-lbl").html(order);
            $("#order-lbl2").html(order);
            swal({title: '', text: '', type: 'success'});
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function Add_packed(id_supplies,pack){
        $(".overlay_ajax").show();
        var order = $("#order_value").val();
        var array_c = document.querySelectorAll("input[id=select]");
        var array_check = [];
        array_c.forEach(function(element){
           array_check.push(element.checked);
        });
        var array = document.querySelectorAll("input[id=quantity_pack]");
        var pack_total = [];
        var count = 0;
        var counter = 0;
        array.forEach(function(element) {
            if(array_check[counter] == true){
                if(element.value == ""){
                    element.value = 1;
                }
                count = count + parseInt(element.value);
            }
            pack_total.push(element.value);
            counter++;
        }, this);
        var package_number = $("#package_number").val();
        var weight_package = $("#weight_package").val();
        var array_o = document.querySelectorAll("input[id=id_order_supplies]");
        var array_order_supplies = [];
        array_o.forEach(function(element) {
            array_order_supplies.push(element.value);
        }, this);
        var array_s = document.querySelectorAll("input[id=id_supplies]");
        var array_id_supplies = [];
        array_s.forEach(function(element) {
            array_id_supplies.push(element.value);
        }, this);
        
        
        if(weight_package == ""){
            swal({title: 'Error!', text: "Ingrese todos los datos al formulario", type: 'error'});
        }else{
            $.post("<?= base_url()?>Production/Delivery/C_Delivery/Add_Packed",{id_supplies:id_supplies,order:order,pack:pack,package_number:package_number,pack_total:pack_total,weight_package:weight_package,count:count,array_order_supplies:array_order_supplies,array_id_supplies:array_id_supplies,array_check:array_check},function(data){
                $(".overlay_ajax").hide();
                $(".loader_ajax2").text("");
                var array_quantity = document.querySelectorAll("input[id=quantity]");
                var count_q = 0;
                var data_quantity = [];
                array_quantity.forEach(function(element){
                    
                    $("#content-table").html(data.table);
                    TableData("table_supplies", false, false, true);
                    TableData("table_pack", false, false, true);
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
                    $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
                    $('input.minimal:checkbox').iCheck({
                        checkboxClass: 'icheckbox_minimal-blue'
                    }).on('ifChanged', function (e) {
                        var isChecked = e.currentTarget.checked;
                        if (isChecked == true) {
                            var exclude = 1;
                        } else {
                            var exclude = 0;
                        }
                        Exclude_modal(this.value, exclude);
                    });
                    
                    $("#count").html(data.packs.length);
                    //$("#count").html($("#total-packs").text());
                    
                    
                    data_quantity.push(element.value);
                    //console.log(data.total[0][count_q]);
                    if(data.data[count_q][0]['quantity_packaged'] != 0){
                        document.getElementById("sum-"+count_q).innerText = "";
                        document.getElementById("packed-"+count_q).innerText = "";
                        
                        document.getElementById("sum-"+count_q).innerText = parseInt(element.value) - parseInt(data.total[0][count_q]['quantity_packed']);
                        //document.getElementById("sum-"+count_q).innerText = parseInt(element.value) - parseInt(data.sum[count_q]);
                        document.getElementById("packed-"+count_q).innerText = data.data[count_q][0]['quantity_packaged'];
                        count_q++;
                    }
                    document.getElementById("weight_package").value = "";
                    
                });
                
                var count_q2 = 0;
                var array = document.querySelectorAll("input[id=quantity_pack]");
                array.forEach(function(element){
                    if(data.data[count_q2][0]['quantity_packaged'] != 0){
                        element.value = parseInt(data_quantity[count_q2]) - parseInt(data.data[count_q2][0]['quantity_packaged']);
                        element.setAttribute("max", parseInt(data_quantity[count_q2]) - parseInt(data.data[count_q2][0]['quantity_packaged']));
                        if(parseInt(data_quantity[count_q2]) - parseInt(data.data[count_q2][0]['quantity_packaged']) == 0){
                            element.setAttribute("disabled", "true");
                        }
                        $("#packed_all_"+count_q2).val(data.data[count_q2][0]['quantity_packaged']);
                    }
                    count_q2++;
                });
                
                var count_q3 = 0;
                var array_s = document.querySelectorAll("input[id=select]");
                array_s.forEach(function(element){
                    element.checked = false;
                    if(parseInt(data_quantity[count_q3]) - parseInt(data.data[count_q3][0]['quantity_packaged']) == 0){
                        element.setAttribute("disabled", "true");
                    }
                    count_q3++;
                });
                
                var count_w = 0;
                var array_w = document.querySelectorAll("input[id=weight]");
                array_w.forEach(function(element){
                    document.getElementById("weight-"+count_w).innerText = "";
                    document.getElementById("weight-"+count_w).innerText = parseInt(element.value)*(parseInt(data_quantity[count_w]) - parseInt(data.data[count_w][0]['quantity_packaged']));
                    count_w++;  
                });
                
                if(data.iss === 1){
                    var pk = $("#package_number").val();
                    $("#package_number").val(parseInt(pk) + 1);
                    $("#lbl_number_p").text((parseInt(pk) + 1));
                    $( "#package_number option[value="+(parseInt(pk) + 1)+"]" ).attr('selected','selected');
                    
                }else{
                    var pk = $("#package_number").val();
                    $("#package_number").val(parseInt(pk) + 1);
                    $("#lbl_number_p").text("N°Paquete "+(parseInt(pk) + 1));
                }
                $("#order-lbl").html(order);
                $("#order-lbl2").html(order);
                
                swal({title: 'Exito', text: "Se han guardado los datos", type: 'success'});
            },'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
    
    function add_supplies(id_supplies,pack){
        $(".overlay_ajax").show();
        var order = $("#order_value").val();
        var array_c = document.querySelectorAll("input[id=select_add]");
        var array_check = [];
        array_c.forEach(function(element){
           array_check.push(element.checked);
        });
        console.log(array_check.length);
        var array = document.querySelectorAll("input[id=quantity_add2]");
        var pack_total = [];
        var count = 0;
        var counter = 0;
        array.forEach(function(element) {
            if(array_check[counter] == true){
                if(element.value == ""){
                    element.value = 1;
                }
                count = count + parseInt(element.value);
            }
            pack_total.push(element.value);
            counter++;
        }, this);
        console.log(pack_total.length);
        var package_number = $("#package_number_add").val();
        var weight_package = $("#weight_add").val();
        var array_o = document.querySelectorAll("input[id=id_order_supplies_add]");
        var array_order_supplies = [];
        array_o.forEach(function(element) {
            array_order_supplies.push(element.value);
        }, this);
        var array_s = document.querySelectorAll("input[id=id_supplies_add]");
        var array_id_supplies = [];
        array_s.forEach(function(element) {
            array_id_supplies.push(element.value);
        }, this);
       
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/Add_Packed",{id_supplies:id_supplies,order:order,pack:pack,package_number:package_number,pack_total:pack_total,weight_package:weight_package,count:count,array_order_supplies:array_order_supplies,array_id_supplies:array_id_supplies,array_check:array_check},function(data){
            $(".overlay_ajax").hide();
            $(".loader_ajax2").text("");

            $("#order-lbl").html(order);
            $("#order-lbl2").html(order);

            $("#modal_add_supplies").modal("hide");

            //swal({title: 'Exito', text: "Se han guardado los datos", type: 'success'});
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
        
        var myVar = setTimeout(validation_header_re,1000,order,package_number);
        //myVar = setTimeout(alertFunc, 3000);
        //clearInterval(myVar);
    }
    
    function go_back_all_edit(){
        var array1 = document.querySelectorAll("input[id=quantity_edit_packed]");
        var cont_array = [];
        array1.forEach(function(element){
            cont_array.push(element.value);
        });
        var array = document.querySelectorAll("input[id=count_all_edit]");
        var count = 0;
        var total = array.length;
        var order = $("#order_value").val();
        var package_number = $("#package_number_edit").val();
        var positionpb = 0;
        //console.log(array.length);
        array.forEach(function(element){
            var id_supplies = $("#id_supplies_all_edit"+count).val();
            var id_order_supplies = $("#id_order_supplies_all_edit"+count).val();
            var pack = $("#packed_all_edit"+count).val();
            var weight = $("#weight_package_edit").val();
            var id_order_package_supplies_detail = $("#id_order_package_supplies_all_edit"+count).val();
            console.log(id_order_package_supplies_detail);
            if(pack != "0"){
                if(cont_array[count] !== "0"){
                    //validation_header_re(order, package_number);
                    $.post("<?= base_url()?>Production/Delivery/C_Delivery/Go_Back_Pack_Edit",{id_supplies:id_supplies,order:order,id_order_supplies:id_order_supplies,package_number:package_number,id_order_package_supplies_detail:id_order_package_supplies_detail,number_pack:package_number,weight:weight,positionpb:positionpb},function(data){
                        if(count == total){
                            //console.log(data.pos);
                            $("#content-table").html(data.table);
                            TableData("table_supplies", false, false, true);
                            TableData("table_pack", false, false, true);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
                            $('input.minimal:checkbox').iCheck({
                                checkboxClass: 'icheckbox_minimal-blue'
                            }).on('ifChanged', function (e) {
                                var isChecked = e.currentTarget.checked;
                                if (isChecked == true) {
                                    var exclude = 1;
                                } else {
                                    var exclude = 0;
                                }
                                Exclude_modal(this.value, exclude);
                            });
                            
                            $("#count").html(data.packs.length);
                            
                            if(data.data2[0]['quantity_packaged'] == null){
                                var quantity_packaged = 0;
                            }else{
                                var quantity_packaged = data.data2[0]['quantity_packaged'];
                            }
                            
                            //console.log(data.pos);
                            document.getElementById("packed-edit-"+data.pos).innerText = "";
                            document.getElementById("packed-edit-"+data.pos).innerText = "0";

                            document.getElementById("sum-edit-"+data.pos).innerText = "";
                            document.getElementById("sum-edit-"+data.pos).innerText = parseInt(data.data2[0]['quantity']) - parseInt(quantity_packaged);


                            var array = document.querySelectorAll("input[id=quantity_pack_edit]");
                            var count2 = 0;
                            array.forEach(function(element){
                                if(count2 == data.pos){
                                    console.log(data);
                                    element.value = parseInt(data.data2[0]['quantity']) - parseInt(quantity_packaged);
                                    element.removeAttribute("disabled");
                                    element.setAttribute("max",data.data[0]['quantity']);
                                    //break;
                                }
                                count2++;
                            });
                            var arrays = document.querySelectorAll("input[id=select_edit]");
                            var counts = 0;
                            arrays.forEach(function(element){
                                if(counts == data.pos){
                                    element.removeAttribute("disabled");
                                    //break;
                                }
                                counts++;
                            });

                            var array_quantity = document.querySelectorAll("input[id=quantity_edit_packed]");
                            var counts2 = 0;
                            array_quantity.forEach(function(element){
                                if(counts2 == data.pos){
                                    element.value = "0";
                                }
                                counts2++;
                            });
                
                            //$("#count").html($("#total-packs").text());
                            
                            //$("#modal_edit_manual").modal("hide");
                        }
                    },'json').fail(function (error) {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    });
                }
                positionpb++;
            }
            count++;
        });
        //swal({title: '', text: '', type: 'success'});
        var myVar = setTimeout(validation_header_re,2000,order,package_number);
        //myVar = setTimeout(alertFunc, 3000);
        //clearInterval(myVar);
    }
    
    function validation_header_re(order,pack_number){
        $(".overlay_ajax").show();
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/validation_header_RE",{order:order,number_pack:pack_number},function(data){
            console.log(data);
            $("#content-table").html(data.table);
            TableData("table_supplies", false, false, true);
            TableData("table_pack", false, false, true);
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
            $('input.minimal:checkbox').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            }).on('ifChanged', function (e) {
                var isChecked = e.currentTarget.checked;
                if (isChecked == true) {
                    var exclude = 1;
                } else {
                    var exclude = 0;
                }
                Exclude_modal(this.value, exclude);
            });

            $("#count").html(data.packs.length);
            swal({title: '', text: '', type: 'success'});
            $("#order-lbl").text(order);
            $("#order-lbl2").text(order);
            $(".overlay_ajax").hide();
            $(".loader_ajax2").text("");
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function go_back_all(){
        var array = document.querySelectorAll("input[id=count_all]");
        var count = 0;
        var total = array.length;
        var order = $("#order_value").val();
        array.forEach(function(element){
            var id_supplies = $("#id_supplies_all_"+count).val();
            var id_order_supplies = $("#id_order_supplies_all_"+count).val();
            var package_number = $("#package_number").val();
            var pack = $("#packed_all_"+count).val();
            //var id_order_package_supplies_detail = $("#id_order_package_supplies_all"+count).val();
            console.log(pack);
            if(pack != "0"){
                $.post("<?= base_url()?>Production/Delivery/C_Delivery/Go_Back_Pack",{id_supplies:id_supplies,order:order,id_order_supplies:id_order_supplies,package_number:package_number,count:count},function(data){
                    console.log(data);
                    //if(count == total){
                        $("#content-table").html(data.table);
                        TableData("table_supplies", false, false, true);
                        TableData("table_pack", false, false, true);
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
                        $('input.minimal:checkbox').iCheck({
                            checkboxClass: 'icheckbox_minimal-blue'
                        }).on('ifChanged', function (e) {
                            var isChecked = e.currentTarget.checked;
                            if (isChecked == true) {
                                var exclude = 1;
                            } else {
                                var exclude = 0;
                            }
                            Exclude_modal(this.value, exclude);
                        });
                        
                        $("#count").html(data.packs.length);
                        //$("#count").html($("#total-packs").text());
                        
                        document.getElementById("packed-"+data.count).innerText = "";
                        document.getElementById("packed-"+data.count).innerText = "0";

                        document.getElementById("sum-"+data.count).innerText = "";
                        document.getElementById("sum-"+data.count).innerText = data.data[0]['quantity'];


                        var array = document.querySelectorAll("input[id=quantity_pack]");
                        var count = 0;
                        array.forEach(function(element){
                            if(count == data.count){
                                element.value = data.data[0]['quantity'];
                                element.removeAttribute("disabled");
                                element.setAttribute("max",data.data[0]['quantity']);
                                //break;
                            }
                            count++;
                        });

                        var arrays = document.querySelectorAll("input[id=select]");
                        var counts = 0;
                        arrays.forEach(function(element){
                            if(counts == data.count){
                                element.removeAttribute("disabled");
                                //break;
                            }
                            counts++;
                        });
                        $("#package_number").val("1");
                        $("#lbl_number_p").text("N°Paquete 1");
                    //}
                },'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
            count++;
        });
        $("#order-lbl").html(order);
        $("#order-lbl2").html(order);
    }
    
    function go_back(id_supplies,order,id_order_supplies,position){
        var package_number = $("#package_number").val();
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/Go_Back_Pack",{id_supplies:id_supplies,order:order,id_order_supplies:id_order_supplies,package_number:package_number},function(data){
            console.log(data);
            $("#content-table").html(data.table);
            TableData("table_supplies", false, false, true);
            TableData("table_pack", false, false, true);
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
            $('input.minimal:checkbox').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            }).on('ifChanged', function (e) {
                var isChecked = e.currentTarget.checked;
                if (isChecked == true) {
                    var exclude = 1;
                } else {
                    var exclude = 0;
                }
                Exclude_modal(this.value, exclude);
            });

            $("#count").html(data.packs.length);
            //$("#count").html($("#total-packs").text());
            
            if(data.delete == true){
                document.getElementById("packed-"+position).innerText = "";
                document.getElementById("packed-"+position).innerText = "0";
                
                document.getElementById("sum-"+position).innerText = "";
                document.getElementById("sum-"+position).innerText = data.data[0]['quantity'];


                var array = document.querySelectorAll("input[id=quantity_pack]");
                var count = 0;
                array.forEach(function(element){
                    if(count == position){
                        element.value = data.data[0]['quantity'];
                        element.removeAttribute("disabled");
                        element.setAttribute("max",data.data[0]['quantity']);
                        //break;
                    }
                    count++;
                });
                
                var arrays = document.querySelectorAll("input[id=select]");
                var counts = 0;
                arrays.forEach(function(element){
                    if(counts == position){
                        element.removeAttribute("disabled");
                        //break;
                    }
                    counts++;
                });
                $("#package_number").val(parseInt(data.pq[0]['pack']) + 1);
                $("#lbl_number_p").text("N°Paquete "+(parseInt(data.pq[0]['pack']) + 1));
                $("#order-lbl").html(order);
                $("#order-lbl2").html(order);
            }else{
                swal({title: 'Atención!', text: "El insumo seleccionado no corresponde al N° del paquete "+package_number, type: 'error'});
            }
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function go_back_edit(id_supplies,order,id_order_supplies,position,id_order_package_supplies_detail){
        var package_number = $("#number_pack").val();
        var number_pack = $("#number_pack").val();
        var weight = $("#weight_package_edit").val();
        var id_order_package_supplies_detail2 = $("#id_order_package_supplies_all_edit"+position).val();
        console.log(id_order_package_supplies_detail2);
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/Go_Back_Pack_Edit",{id_supplies:id_supplies,order:order,id_order_supplies:id_order_supplies,package_number:package_number,number_pack:number_pack,id_order_package_supplies_detail:id_order_package_supplies_detail2,number_pack:package_number,weight:weight},function(data){
            validation_header_re(order,package_number);
            $("#content-table").html(data.table);
            TableData("table_supplies", false, false, true);
            TableData("table_pack", false, false, true);
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Enlist(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-list"></i> Alistar</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Tags(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-print"></i> Etiquetas</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="PDF(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-file-pdf-o"></i> Reporte Alistamiento insumos</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Pending(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cubes"></i> Reporte Pendientes</span></a></label>');
            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Manual_Package(\'' + order + '\')" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-cube"></i> Paq. Manual</span></a></label>');
            $('input.minimal:checkbox').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            }).on('ifChanged', function (e) {
                var isChecked = e.currentTarget.checked;
                if (isChecked == true) {
                    var exclude = 1;
                } else {
                    var exclude = 0;
                }
                Exclude_modal(this.value, exclude);
            });
            
            $("#count").html(data.packs.length);
            //$("#count").html($("#total-packs").text());
            
            if(data.delete === true){
                if(data.data2[0]['quantity_packaged'] == null){
                    var quantity_packaged = 0;
                }else{
                    var quantity_packaged = data.data2[0]['quantity_packaged'];
                }
                
                document.getElementById("packed-edit-"+position).innerText = "";
                document.getElementById("packed-edit-"+position).innerText = "0";

                document.getElementById("sum-edit-"+position).innerText = "";
                document.getElementById("sum-edit-"+position).innerText = parseInt(data.data2[0]['quantity']) - parseInt(quantity_packaged);


                var array = document.querySelectorAll("input[id=quantity_pack_edit]");
                var count = 0;
                array.forEach(function(element){
                    if(count == position){
                        element.value = parseInt(data.data2[0]['quantity']) - parseInt(quantity_packaged);
                        element.removeAttribute("disabled");
                        element.setAttribute("max",data.data[0]['quantity']);
                        //break;
                    }
                    count++;
                });
                var arrays = document.querySelectorAll("input[id=select_edit]");
                var counts = 0;
                arrays.forEach(function(element){
                    if(counts == position){
                        element.removeAttribute("disabled");
                        //break;
                    }
                    counts++;
                });
                
                var array_quantity = document.querySelectorAll("input[id=quantity_edit_packed]");
                var counts2 = 0;
                array_quantity.forEach(function(element){
                    if(counts2 == position){
                        element.value = "0";
                    }
                    counts2++;
                });
                //validation_header(order);
            }else{
                if(data.delete === 1){
                    $("#modal_edit_manual").modal("hide");
                }else{
                    swal({title: 'Atención!', text: "El insumo seleccionado no corresponde a N° del paquete "+package_number, type: 'error'});
                }
                
            }
            //$("#modal_edit_manual").modal("hide");
            $("#order-lbl").text(order);
            $("#order-lbl2").text(order);
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function validation_header(order){
        // validacion para actualizar cabezera
        var number_pack = $("#number_pack").val();
        var weight_package = $("#weight_package_edit").val();
        var array_c = document.querySelectorAll("input[id=select_edit]");
        var array_check = [];
        array_c.forEach(function(element){
           array_check.push(element.checked);
        });
        var array = document.querySelectorAll("input[id=quantity_edit_packed]");
        var count = 0;
        var counter = 0;
        array.forEach(function(element) {
            //if(array_check[counter] == true){
                count = count + parseInt(element.value);
            //}
            counter++;
        }, this);
        //--*************************--//
        $.post("<?= base_url()?>Production/Delivery/C_Delivery/validation_header",{number_pack:number_pack,order:order,weight_package:weight_package,count:count},function(data){
            console.log(data);
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function add_pack(){
        var x = document.getElementById("package_number");
        var option = document.createElement("option");
        option.text = parseInt(x.length) + 1;
        option.value = parseInt(x.length) + 1;
        x.add(option);
    }
    
    function selection_all(val){
        var arrayq = document.querySelectorAll("input[id=quantity_pack]");
        var array_quantity = [];
        arrayq.forEach(function(element){
           array_quantity.push(element.value); 
        });
        var array = document.querySelectorAll("input[id=select]");
        var count = 0;
        array.forEach(function(element){
            if(val == true){
                if(array_quantity[count] != 0){
                    element.checked = true;
                }
            }else{
                element.checked = false;
            }
            count++;
        });
    }
    
    function selection_all_edit(val){
        var arrayq = document.querySelectorAll("input[id=quantity_pack_edit]");
        var array_quantity = [];
        arrayq.forEach(function(element){
           array_quantity.push(element.value); 
        });
        var array = document.querySelectorAll("input[id=select_edit]");
        var count = 0;
        array.forEach(function(element){
            if(val == true){
                if(array_quantity[count] != 0){
                    element.checked = true;
                }
            }else{
                element.checked = false;
            }
            count++;
        });
    }
    
    function PDF(order){
        var win = window.open("<?= base_url() ?>Production/Delivery/C_Delivery/PDF_supplies/"+order+"", '_blank');
        win.focus();
    }
    
    function UpdateSupplies(){
        if(validatefield()){
            var GeneralArray = [];
            $("#table_weight tbody tr").each(function(){
                var arrayHijo = [];
                var id = $(this).attr("id");
                arrayHijo.push(id);
                arrayHijo.push($("#cxp"+id).val());
                arrayHijo.push($("#wxp"+id).val());
                GeneralArray.push(arrayHijo);
            });
            
            $.post("<?= base_url()?>Production/Delivery/C_Delivery/UpdateWeightSupplies",{GeneralArray:GeneralArray},function(data){
                if(data.res == "OK"){
                    $("#modal-supplies").modal("hide");
                    if($("#txt-order").val() != ""){
                        GeneratePacks($("#txt-order").val());
                    }else{
                        swal({title: 'Error!', text: "Debe digitar un pedido", type: 'warning'});
                    }
                }else{
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            },'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
            
        }
    }
    
    function Enlist(order){
        if(parseInt($("#count").text()) > 0 ){
            window.open("<?= base_url() ?>Production/Delivery/C_Delivery/Print_Enlist/"+order, '_blank');
        }else{
            swal({title: 'Atencion!', text: "No existen paquetes generados", type: 'warning'});
        }
    }
    
    function Tags(order){
        if(parseInt($("#count").text()) > 0 ){
            window.open("<?= base_url() ?>Production/Delivery/C_Delivery/GeneratePacksSDSupplies/"+order, '_blank');
             //window.open("<?= base_url() ?>Production/Delivery/C_Delivery/Print_Tags/"+order, '_blank');
        }else{
            swal({title: 'Atencion!', text: "No existen paquetes generados", type: 'warning'});
        }
    }
    
    function Exclude_modal(id_order_supplies, exclude){
        if(exclude == 1){
            $("#id_order_supplies_i").val(id_order_supplies);
            $("#excl").val(exclude);
            $("#modal_obs").modal("show");
        }else{
            $("#id_order_supplies_i").val(id_order_supplies);
            $("#excl").val(exclude);
            Exclude();
        }
    }

    function Exclude(){
        var id_order_supplies = $("#id_order_supplies_i").val();
        var exclude = $("#excl").val();
        var obs = $("#obs").val();
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/UpdateOrderSupplies", {id_order_supplies: id_order_supplies,field:'exclude', value: exclude, obs:obs}, function (data) {   
            if(data.res == "OK" && exclude == 1){
                swal({title: '', text: '', type: 'success'});
            }
            $("#modal_obs").modal("hide");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function GeneratePacks(order){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/GeneratePacks", {order: order}, function (data) {   
            if(data.res == "OK"){
                $("#content-pack").html(data.table);
                TableData("table_pack", false, false, true);
                $("#count").html($("#total-packs").text());
                swal({title: 'OK !', text: "Paquetes generados con exito!", type: 'success'}); 
            }else if(data.res == "WEIGHT"){
                $("#modal-weight").html(data.supplies);
                
                var table = CreateDataTable("table_weight",false);
                $('#modal-supplies').on('shown.bs.modal', function () {
                    table.columns.adjust();
                });
                $("#modal-supplies").modal("show");
            }else{
                swal({title: 'Error !', text: data.res, type: 'error'});   
            }
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
</script>