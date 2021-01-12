<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title col-md-6">
                    <div class="user-block">
                        <span class="username" style="margin-left: 0px;"><a href="#">Entrega De Paquetes SD N&deg; </b><?= $delivery ?></b>.</a> (<a class="status"><?= explode("(", $info->description)[0] ?></a>)</span>
                        <br><span class="description" style="margin-left: 0px;font-size: 18px;">Observacion : <?=ucwords($info->observation)?></span>
                    </div>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <?= (!empty($BtnConfirm) && $info->status == 13 && $view == "Dispatch") ? '<button onclick="OpenModal()"  id="btn-confirm"  class="btn btn-default btn-sm"><i class="fa  fa-spinner"></i> Aprobar Entrega</button>' : "" ?>

                    <?= (!empty($BtnDelivery) && in_array($info->status, array(1,16) )) ? '<button onclick="Deliver()"  id="btn-deliver"  class="btn btn-default btn-sm"><i class="fa fa-sign-in"></i> Entregar</button>' : "" ?>
                    <button  id="btn-print" class="btn  btn-default btn-sm"><i class="fa fa-print"></i> Imprimir</button>
                    <button  onclick="history.back()" class="btn  btn-default btn-sm"><i class="fa fa-backward"></i> Atras</button>
                   
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="client" class="control-label">Cliente</label>
                            <input type="text" class="form-control input-sm" id="client" value="<?= $info->client ?>" disabled="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="order" class="control-label">Order</label>
                            <input type="text" class="form-control input-sm" id="order" value="<?= $order ?>" disabled="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Creada:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-sm" value="<?= $info->date ?>" id="date" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Entregada:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-sm" value="<?= $info->date_deliver ?>" id="date_deliver" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Recibida:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right input-sm" value="<?= $info->date_received ?>" id="date_received" disabled="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="tables">
                    <?= $tables ?>
                </div>
            </div>

            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-approve">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Aprobar Entrega</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Observación</label>
                    <textarea class="form-control" id="observation" rows="3" placeholder="Enter ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"  onclick="Approve(16)">No Aprobar</button>
                <button type="button" class="btn btn-success pull-right" data-dismiss="modal" onclick="Approve(15)" id="btn-app" >Aprobar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-reverse">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reversar Paquetes</h4>
            </div>
            <div class="modal-body">
                <div class="row">
<!--                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Solicitud Despacho</label>
                            <select class="form-control select2 " id="rev-solicitud" >
                              <option selected="">. . .</option>
                            </select>
                        </div>
                    </div>-->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="control-label">Cantidad</label>
                            <input type="number" class="form-control input-sm" id="rev-cantidad" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"  >Cancelar</button>
                <button type="button" class="btn btn-success pull-right" data-dismiss="modal"  id="btn-reverse" >Reversar</button>
            </div>
        </div>
    </div>
</div>
<!--MODAL  ------------------------------------------------------------------------------------->


<script>
    $(document).ready(function () {
        $(document).ajaxStart(function () {
            $(".overlay_ajax").show();
        }).ajaxStop(function () {
            $(".overlay_ajax").hide();
            $(".loader_ajax2").text("");
        });
    });
    
    $(function(){
        
        if(<?=$info->status?> != 1 && <?= $info->status ?> != 16){
            disabledInput();
        }
        
        $("#btn-print").click(function(){
            window.open("<?= base_url() ?>Production/Delivery/C_Delivery/Print_Deliver_PacksSD/<?= $order ?>/<?= $delivery ?>", '_blank');
        });
        
    });
    
    
    function OpenReversePack(delivery,id_order_package,id_delivery_package_detail,quantity){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/ListRequestReverse", {id_order_package:id_order_package, id_delivery_package_detail:id_delivery_package_detail}, function (data) {
            var option = '<option value="">. . .</option>';
            $.each(data.res,function(e,i){
                option += '<option value='+data.res[e].id_request_sd+'>'+data.res[e].id_request_sd+'</option>';
            });
            document.getElementById('rev-cantidad').setAttribute("max", quantity);
            $("#rev-cantidad").val(quantity);
            $("#rev-solicitud").html(option);
            $("#modal-reverse").modal("show");
            $("#btn-reverse").attr("onclick","ReversePack("+delivery+","+id_order_package+","+id_delivery_package_detail+")");
            
        }, 'json');
    }
    
    function ReversePack(delivery,id_order_package,id_delivery_package_detail){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/ReversePack", {delivery:<?= $delivery ?>, order:<?= $order ?>,request:delivery,quantity:$("#rev-cantidad").val(),id_order_package:id_order_package, id_delivery_package_detail:id_delivery_package_detail}, function (data) {
            if (data.rs.res == "OK") {
                //$("#tables").html(data.tables);
                $("#tables").html(data.tables);
                disabledInput();
                swal({title: '', text: "OK", type: 'success'});
            }
        }, 'json');
    }
    

    function AddAll() {
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/AddAllPackToDelivery", {delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
            if (data.res == "OK") {
                $("#tables").html(data .tables);
            }
        }, 'json');
    }
    

    function RemoveAll() {
        if($("#table_detail > tbody > tr").length > 0){
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/RemoveAllPackToDelivery", {delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
                if (data.res == "OK") {
                    $("#tables").html(data.tables);
                }
            }, 'json');
        }
    }
    
    function add_furniture(){
        var furniture = $("#furniture").val();
        var all = document.querySelectorAll("input[type=hidden]");
        var cont = 1;
        all.forEach(function(element) {
            if(element.id == furniture){
                var pack = $("#p-"+furniture+"-"+cont).val();
                var sum = element.value;
                var id_order_package = $("#id_order_package_"+cont).val();
                if(sum > 0){
                    $.post("<?= base_url() ?>Production/Delivery/C_Delivery/Add_furniture", {delivery:<?= $delivery ?>, order:<?= $order ?>, furniture:furniture, pack:pack, sum:sum, id_order_package:id_order_package}, function (data) {
                        var e = data;
                        add_furniture_table(e);
                    }, 'json');
                }else{
                    console.log(1);
                }
                cont++;
            }
        }, this);
    }
    
    function add_furniture_table(e){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/Add_furniture_table", {delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
            if (e == "OK") {
                $("#tables").html(data.tables);
            }
        }, 'json');
    }
    
    function update_data_furniture(furniture){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/update_data_furniture", {order:<?= $order ?>,furniture:furniture}, function (data) {
            console.log(data);
        }, 'json');
    }
    
    function disabledInput() {
        $("#btn-deliver").prop("disabled", true).removeAttr("onclick");
        $(".input-qt").prop("disabled", true);
        $(".btn-all , .btn-primary , .btn-danger , .btn-info, #btn-save ").prop("disabled", true);
    }
    
    function OpenModal() {
        $("#modal-approve").modal("show");
    }
    
    function Approve(status) {

        var msg = (status == 15) ? "correcta" : "incorrecta";

        swal({
            title: 'Confirma que la entrega es ' + msg + '?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Production/Delivery/C_Delivery/ApproveDeliverPack", {delivery:<?= $delivery ?>, order:<?= $order ?>, status: status, observation: $("#observation").val()}, function (data) {
                    if (data.res == "OK") {
                        disabledInput();
                        $(".description").text("Observacion : "+$("#observation").val());
                        $(".status").text((status == 15) ? "APROBADO" : "NO APROBADO");
                        $("#btn-confirm").prop("disabled", true).removeAttr("onclick");
                        $("#date_received").val(data.date);
                        swal({title: '', text: "", type: 'success'});
                    }
                }, 'json');
            }
        }).catch(swal.noop);
    }

    function Deliver() {
        if($("#table_detail > tbody >tr").length > 0){
            swal({
                title: 'Confirma la entrega?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {
                if (result) {
                    $.post("<?= base_url() ?>Production/Delivery/C_Delivery/DeliverPacksSD", {delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
                        if (data.res == "OK") {
                            disabledInput();
                            $(".status").text("ENTREGADO");
                            $("#btn-confirm").prop("disabled", true).removeAttr("onclick");
                            $("#date_deliver").val(data.date);
                            swal({title: '', text: "", type: 'success'});
                        }
                    }, 'json');
                }
                var all = document.querySelectorAll("input[id=forniture-h]");
                setTimeout(function(){
                    all.forEach(function(element) {
                        update_data_furniture(element.value);
                    }, this);
                }, 1000);
            }).catch(swal.noop);
            
        }else{
            swal({title: 'Error!', text: "Debe entregar al menos un paquete!", type: 'error'});
        }
    }

    function DeleteDetail(id_delivery_package_detail, id_order_package, id_delivery) {
        var order = $("#order").val();
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery/DeletePackToDelivery", {id_delivery_package_detail: id_delivery_package_detail, id_order_package: id_order_package,order:order,id_delivery:id_delivery}, function (data) {
            if (data.rs.res == "OK") {
                $("#delivered_quantity_" + id_order_package).text(data.rs.delivered_quantity);
                $("#balance_" + id_order_package).text(data.rs.balance);
                if (data.rs.balance <= 0) {
                    $("#balance_" + id_order_package).removeClass("bg-danger").addClass("bg-success");
                } else {
                    $("#balance_" + id_order_package).removeClass("bg-success").addClass("bg-danger");
                }

                $("#tr-" + id_order_package).remove();
                $("#tables").html(data.tables);
            }
        }, 'json');
    }

    function AddItem(id_order_package, item, forniture, no, pack, id_furniture) {
        if ($("#tr-" + id_order_package).length <= 0) {
            var order = $("#order").val();
            var quantity = $("#"+id_furniture).val();
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/AddPackToDelivery", {id_order_package: id_order_package, delivery:<?= $delivery ?>, quantity:quantity ,order:order}, function (data) {
                if (data.rs.res == "OK") {
                    $("#delivered_quantity_" + id_order_package).text(data.rs.delivered_quantity);
                    $("#balance_" + id_order_package).text(data.rs.balance);
                    if (data.rs.balance <= 0) {
                        $("#balance_" + id_order_package).removeClass("bg-danger").addClass("bg-success");
                    } else {
                        $("#balance_" + id_order_package).removeClass("bg-success").addClass("bg-danger");
                    }

                    var btn = '<button class="btn btn-block btn-danger btn-xs" onclick="DeleteDetail(' + data.rs.id + ',' + id_order_package + ')"><span class="fa  fa-trash-o" aria-hidden="true"></span></button>';
                    var input = '<input id="quantity-' + id_order_package + '" class="input-qt" onchange="UpdateDetailDelivery(' + data.rs.id + ',' + id_order_package + ',this)" style="height: 20px;width: 70px;text-align: center" class="" value="1" type="number" >';
                    $('#table_detail tbody').append('<tr id="tr-' + id_order_package + '"><td>' + btn + '</td><td style="text-align:center">' + item + '</td><td>' + forniture + '</td><td style="text-align:center">' + no + ' ' + pack + '</td><td style="text-align:center">' + input + '</td><td id="pz-' + id_order_package + '"></td></tr>');
                    $("#tables").html(data.tables);
                } else {
                    swal({title: 'Error!', text: data.rs.res, type: 'error'});
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
    
    function AddItems2(id_order_package, item, forniture, no, pack, quantity, id_delivery) {
        if ($("#tr-" + id_order_package).length <= 0) {
            var order = $("#order").val();
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/AddPackToDelivery2", {id_order_package: id_order_package, delivery:<?= $delivery ?>, quantity: quantity, id_delivery:id_delivery,order:order}, function (data) {
                if (data.rs.res == "OK") {

                    $("#delivered_quantity_" + id_order_package).text(data.rs.delivered_quantity);
                    $("#balance_" + id_order_package).text(data.rs.balance);
                    if (data.rs.balance <= 0) {
                        $("#balance_" + id_order_package).removeClass("bg-danger").addClass("bg-success");
                    } else {
                        $("#balance_" + id_order_package).removeClass("bg-success").addClass("bg-danger");
                    }

                    var btn = '<button class="btn btn-block btn-danger btn-xs" onclick="DeleteDetail(' + data.rs.id + ',' + id_order_package + ')"><span class="fa  fa-trash-o" aria-hidden="true"></span></button>';
                    var input = '<input id="quantity-' + id_order_package + '" class="input-qt" onchange="UpdateDetailDelivery(' + data.rs.id + ',' + id_order_package + ',this)" style="height: 20px;width: 70px;text-align: center" class="" value="'+quantity+'" type="number" >';
                    $('#table_detail tbody').append('<tr id="tr-' + id_order_package + '"><td>' + btn + '</td><td style="text-align:center">' + item + '</td><td>' + forniture + '</td><td style="text-align:center">' + no + ' ' + pack + '</td><td style="text-align:center">' + input + '</td><td id="pz-' + id_order_package + '"></td></tr>');
                    $("#tables").html(data.tables);
                } else {
                    swal({title: 'Error!', text: data.rs.res, type: 'error'});
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function UpdateDetailDelivery(id_delivery_package_detail, id_order_package, input) {
        if($("#quantity-"+id_order_package).val() == 0 || $("#quantity-"+id_order_package).val() == ""){
            $("#quantity-"+id_order_package).val(1);
             swal({title: 'Atencion!', text: "La cantidad debe ser mayor a cero", type: 'error'});
        }else{
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery/UpdateDetailDelivery", {id_delivery_package_detail: id_delivery_package_detail, id_order_package: id_order_package, quantity: $(input).val()}, function (data) {
                if (data.res == "OK") {
                    $('#quantity-' + id_order_package).val(data.quantity);
                    $("#delivered_quantity_" + id_order_package).text(data.delivered_quantity);
                    $("#balance_" + id_order_package).text(data.balance);
                    if (data.balance <= 0) {
                        $("#balance_" + id_order_package).removeClass("bg-danger").addClass("bg-success");
                    } else {
                        $("#balance_" + id_order_package).removeClass("bg-success").addClass("bg-danger");
                    }
                } else {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
</script>