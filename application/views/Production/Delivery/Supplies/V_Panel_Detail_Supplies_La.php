<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title col-md-6">
                    <div class="user-block">
                        <span class="username" style="margin-left: 0px;"><a href="#">Entrega De Paquetes De Insumos N&deg; </b><?= $delivery ?></b>.</a> (<a class="status"><?= explode("(", $info->description)[0] ?></a>)</span>
                        <br>
                        <?php if(count($empty_p) > 0){ ?>
                            <span class="description" style="margin-left: 0px;font-size: 21px; font-weight: bold; color:#f13e3e">Observacion : Hay paquetes vacios, Eliminelos o editelos</span>
                        <?php }else{ ?>
                            <span class="description" style="margin-left: 0px;">Observacion : <?=ucwords($info->observation,'_')?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <?php if(count($empty_p) == 0){ ?>
                            <?= (!empty($BtnConfirm) && $info->status == 13) ? '<button onclick="OpenModal()"  id="btn-confirm"  class="btn btn-default btn-sm"><i class="fa  fa-spinner"></i> Aprobar Entrega</button>' : "" ?>

                            <?= (!empty($BtnDelivery) && in_array($info->status, array(1,16) )) ? '<button onclick="Deliver()"  id="btn-deliver"  class="btn btn-default btn-sm"><i class="fa fa-sign-in"></i> Entregar</button>' : "" ?>
                    <?php } ?>
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

<div class="modal fade" id="modal-split">
    <div class="modal-dialog" style="width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dividir Paquete</h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>Pack</th><td id="t-pack"></td></tr>
                        <tr><th>Saldo</th><td id="t-balance"></td></tr>
                        <tr><th>Descripcion</th><td id="t-name"></td></tr>
                        <tr><th>Und</th><td id="t-q"></td></tr>
                        <tr><th>Und x Paq</th><td ><input type="number" style="border:none" disabled class="form-control input-sm" id="t-undpack" ></td></tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="quantity-split">Unidades A Sacar Del Paquete</label>
                    <input type="number" class="form-control input-sm" id="quantity-split" >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" id="btn-save" >Entregar</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
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

<div class="hide" id="rmenu">
    <ul>
        <li>
            <a id="split" onclick="$('#modal-split').modal('show')"></a>
        </li>
        <li>
            <a onclick="history.back()">Atras</a>
        </li>
        <li>
            <a onclick="$('#rmenu').removeClass('show').addClass('hide');">Salir</a>
        </li>
    </ul>
</div>

<div class="modal fade" id="modal_edit_manual">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Detalles del paquete #<label id="numberp-edit"></label></h4>
            </div>
            <div class="modal-body" id="content_edit_manual">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function () {
        $(document).ajaxStart(function () {
            $(".overlay_ajax").show();
        }).ajaxStop(function () {
            $(".overlay_ajax").hide();
            $(".loader_ajax2").text("");
        });
    });
    
    $(function () {
        $("#btn-print").click(function () {
            window.open("<?= base_url() ?>Production/Delivery/C_Delivery_La/Print_Deliver_Supplies/<?= $order ?>/<?= $delivery ?>", '_blank');
        });

        if ($("#test").addEventListener) {
            $("#test").addEventListener('contextmenu', function (e) {
                alert("Has intentado abrir el menú contextual"); //here you draw your own menu
                e.preventDefault();
            }, false);
        } else {
            $('body').on('contextmenu', 'tr.test', function () {
                var pack = $(this).attr("pack");
                $("#split").text("Dividir Paquete (" + $(".quantity_packets-" + pack).text() + " " + $(".codeax-" + pack).text() + ")");
                $("#t-pack").text($(".quantity_packets-" + pack).text());
                $("#t-name").text($(".name-" + pack).text());
                $("#t-q").text($(".quantity_supplies-" + pack).text());
                $("#t-balance").text($("#balance_" + pack).text());
                $("#t-undpack").val($(this).attr("undpack"));
                $("#btn-save").attr("onclick", 'SplitPack(' + pack + ')');
                $("#rmenu").removeClass("hide").addClass("show");
                $("#rmenu").attr("style", "top:" + mouseY(event) + "px;left:" + mouseX(event) + "px ");
                window.event.returnValue = false;
            });
        }
        
        if (<?= $info->status ?> != 1 && <?= $info->status ?> != 16) {
            disabledInput();
        }
        var array = document.querySelectorAll("button[id=dis]");
        array.forEach(function(element){
            element.removeAttribute("disabled");
        });
    });

    $(document).bind("click", function (event) {
        $("#rmenu").removeClass("show").addClass("hide");
    });

    function SplitPack(id_order_package_supplies) {
        if (ValidateInput("quantity-split")) {
            if ($("#quantity-split").val() > 0 && parseFloat($("#quantity-split").val()) < parseFloat($("#t-undpack").val())) {
                $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/SplitPackSupplies", {id_order_package_supplies: id_order_package_supplies, quantity: $("#quantity-split").val(), delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
                    if (data.res == "OK") {
                        $("#tables").html(data.tables);
                        $('#modal-split').modal('hide');
                    } else {
                        $('#modal-split').modal('hide');
                        $("#quantity-split").val("");
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, 'json');
            } else {
                $("#quantity-split").parents(".form-group").addClass("has-error").removeClass("has-success");
            }
        }
    }

    function AddAll() {
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/AddAllSuppliesToDelivery", {delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
            if (data.res == "OK") {
                $("#tables").html(data.tables);
            }
        }, 'json');
    }

    function disabledInput() {
        $("#btn-deliver").prop("disabled", true).removeAttr("onclick");
        $(".input-qt").prop("disabled", true);
        $(".btn-all , .btn-primary , .btn-danger , .btn-info, #btn-save ").prop("disabled", true);
        $(".test").on("contextmenu",function(){
            return false;
        }); 
    }

    function OpenModal() {
        $("#modal-approve").modal("show");
    }
    
    function modal_detail(id_order_package_supplies,number_pack,order){
        $.post("<?= base_url()?>Production/Delivery/C_Delivery_La/get_data_edit",{id_order_package_supplies:id_order_package_supplies,number_pack:number_pack,order:order,type:'E'},function(data){
            $("#content_edit_manual").html(data.table);
            $("#modal_edit_manual").modal("show");
            $("#numberp-edit").text(data.number_pack);
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
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
                $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/ApproveDeliverSupplies", {delivery:<?= $delivery ?>, order:<?= $order ?>, status: status, observation: $("#observation").val()}, function (data) {
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
        }).catch(swal.noop)
    }

    function Deliver() {
        if ($("#table_detail > tbody >tr").length > 0) {
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
                    $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/DeliverSupplies", {delivery:<?= $delivery ?>, order:<?= $order ?>}, function (data) {
                        if (data.res == "OK") {
                            disabledInput();
                            $(".status").text("ENTREGADO");
                            $("#btn-confirm").prop("disabled", true).removeAttr("onclick");
                            $("#date_deliver").val(data.date);
                            swal({title: '', text: "", type: 'success'});
                        }
                    }, 'json');
                }
            }).catch(swal.noop)

        } else {
            swal({title: 'Error!', text: "Debe entregar al menos un insumo!", type: 'error'});
        }
    }
    
    function Delete_all(order){
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/DeleteSuppliesDeliveryAll", {delivery:<?= $delivery ?>,order:order}, function (data) {
            if (data.res == "OK") {
                $("#tables").html(data.tables);
            }
        }, 'json');
    }

    function DeleteDetail(id_delivery_supplies_detail, id_order_package_supplies,order) {
        $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/DeleteSuppliesDelivery", {delivery:<?= $delivery ?>,id_delivery_supplies_detail: id_delivery_supplies_detail, id_order_package_supplies: id_order_package_supplies, order:order}, function (data) {
            if (data.res == "OK") {
                $("#delivered_quantity_" + id_order_package_supplies).text(data.delivered_quantity);
                $("#balance_" + id_order_package_supplies).text(data.balance);
                if (data.balance <= 0) {
                    $("#balance_" + id_order_package_supplies).removeClass("bg-danger").addClass("bg-success");
                } else {
                    $("#balance_" + id_order_package_supplies).removeClass("bg-success").addClass("bg-danger");
                }

                $("#tr-" + id_order_package_supplies).remove();
                $("#tables").html(data.tables);
            }
        }, 'json');
    }

    function AddItem(id_order_package_supplies, order) {
        if ($("#tr-" + id_order_package_supplies).length <= 0) {

            $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/AddPackToDeliverySupplies", {delivery:<?= $delivery ?>,id_order_package_supplies: id_order_package_supplies, delivery:<?= $delivery ?>, quantity: 1, order:order}, function (data) {
                if (data.res == "OK") {
                    $("#tables").html(data.tables);
                } else {
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function UpdateDetailDelivery(id_delivery_supplies_detail, id_order_package_supplies, input) {
        if ($("#quantity-" + id_order_package_supplies).val() == 0 || $("#quantity-" + id_order_package_supplies).val() == "") {
            $("#quantity-" + id_order_package_supplies).val(1);
            swal({title: 'Atencion!', text: "La cantidad debe ser mayor a cero", type: 'error'});
        } else {
            $.post("<?= base_url() ?>Production/Delivery/C_Delivery_La/UpdateDetailDeliverySupplies", {id_delivery_supplies_detail: id_delivery_supplies_detail, id_order_package_supplies: id_order_package_supplies, quantity: $(input).val()}, function (data) {
                if (data.res == "OK") {
                    $('#quantity-' + id_order_package_supplies).val(data.quantity);
                    $("#delivered_quantity_" + id_order_package_supplies).text(data.delivered_quantity);
                    $("#balance_" + id_order_package_supplies).text(data.balance);
                    if (data.balance <= 0) {
                        $("#balance_" + id_order_package_supplies).removeClass("bg-danger").addClass("bg-success");
                    } else {
                        $("#balance_" + id_order_package_supplies).removeClass("bg-success").addClass("bg-danger");
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