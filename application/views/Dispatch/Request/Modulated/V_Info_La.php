<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title col-md-2">
                    <div class="user-block">
                        <span class="username" style="margin-left: 0px;"><a href="#">Solicitud De Despachos No <?= $request->id_request_sd ?></a> </span>
                    </div>
                </div>
                <button type="button" class="btn btn-default pull-right" onclick="window.location='<?=base_url().'Dispatch/C_Dispatch_La'?>'"><i class="fa fa-backward"></i> Volver</button>
                <button type="button" class="btn btn-default pull-right" id="btn-aprob" onclick="CreateRequisition()"><i class="fa fa-check "></i> Generar Remisión</button>
                <button type="button" class="btn btn-default pull-right" id="btn-aprob" onclick="UpdateRequest2()"><i class="fa fa-save"></i> Guardar Cambios</button>
                <button type="button" class="btn btn-default pull-right" onclick="report_supervisory()"><i class="fa fa-print"></i> Control de cargue supervisor</button>
                <button type="button" class="btn btn-default pull-right" onclick="request_cargo()"><i class="fa fa-print"></i> Control de cargue</button>
                <button type="button" class="btn btn-default pull-right" onclick="request_dispatch()"><i class="fa fa-print"></i> Solcitud Despacho</button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="driver">Conductor</label>
                            <input type="text" class="form-control input-sm" value="<?= $request->driver ?>" id="driver" onchange="UpdateRequest('driver', this.value)">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="license_plate">Placa</label>
                            <input type="text" class="form-control input-sm" id="license_plate" value="<?= $request->license_plate ?>" onchange="UpdateRequest('license_plate', this.value)">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="dispatch_date">Fecha Despacho</label>
                            <input type="text" class="form-control input-sm" id="dispatch_date" disabled value="<?= $request->dispatch_date ?>" >
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="quantity_packages">Paquetes</label>
                            <input type="number" class="form-control input-sm" id="quantity_packages" disabled value="<?= $request->num_packets ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="weight">Peso Modulado (Kg)</label>
                            <input type="number" class="form-control input-sm" id="weight" disabled  value="<?= round($request->total_weight_modulate, 6) ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="weight">Peso Insumos (Kg)</label>
                            <input type="number" class="form-control input-sm" id="weight_supplies" disabled  value="<?= round($request->total_weight_supplies, 6) ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="weight">Peso Integral (Kg)</label>
                            <input type="number" class="form-control input-sm" id="weightI" disabled  value="<?= round(($request->total_weight_modulate + ($request->total_weight_modulate * PORCENT_WEIGHT))+$request->total_weight_supplies, 6) ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de vehiculo</label>
                            <select class="form-control" id="vehicle" onchange="max_weight($(this).val())">
                                <?php foreach ($vehicles as $key => $value) { ?>
                                    <option value="<?=$value->id_weight_vehicle?>"><?=$value->description?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Peso Máximo (Kg)</label>
                            <input type="text" disabled="true" class="form-control" id="max_weight" value="0">
                        </div>
                    </div>
                    <?php //foreach ($request_weight as $key => $value) {
                        if($request_weight != NULL  && $request_weight->id_status != "1"){ ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observación solicitud peso</label>
                                <p><?= $request_weight->observation ?></p>
                            </div>
                        </div>
                    <?php } 
                        //} ?>

                    <?php //foreach ($request_weight as $key => $value) {
                        
                        if($request_weight != NULL && $request_weight->id_status == "1"){ ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observación solicitud peso</label>
                                <p>En espera respuesta de solicitud peso</p>
                            </div>
                        </div>
                    <?php } 
                        //} ?>
                </div>
                
                <div class="row">
                    <div class="col-md-12" id="tab-body">
                        <?php //if($count!= 0){
                            echo $tabs;
                       // }?>
                    </div>
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
                <h4 class="modal-title">Agregar Al Contenedor</h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>Pedido</th><td id="t-order"></td></tr>
                        <tr><th>Mueble</th><td id="t-forniture"></td></tr>
                        <tr><th>Pack</th><td id="t-pack"></td></tr>
                        <tr><th>Cantidad</th><td id="t-quantity"></td></tr>
                        <tr><th>Saldo</th><td id="t-balance"></td></tr>
                        <tr><th>Peso</th><td id="t-weight"></td></tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="quantity-split">Cantidad A Despachar</label>
                    <input type="number" class="form-control input-sm" id="quantity-split" onkeyup="ValNumber(this);">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" id="btn-save" >Aceptar</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-split-supplies">
    <div class="modal-dialog" style="width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Al Contenedor</h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>Pedido</th><td id="ts-order"></td></tr>
                        <tr><th>Insumo</th><td id="ts-supplies"></td></tr>
                        <tr><th>Pack</th><td id="ts-pack"></td></tr>
                        <tr><th>Cantidad</th><td id="ts-quantity"></td></tr>
                        <tr><th>Saldo</th><td id="ts-balance"></td></tr>
                        <tr><th>Peso</th><td id="ts-weight"></td></tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="quantity-split-supplies">Cantidad A Despachar</label>
                    <input type="number" class="form-control input-sm" id="quantity-split-supplies" onkeyup="ValNumber(this);">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" id="btn-save2" >Aceptar</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="hide click-right" id="rmenu">
    <ul>
        <li>
            <a id="split" onclick="$('#modal-split').modal('show')"></a>
        </li>
        <li><a id="rmall" onclick="AddSelected('Modulado')">Agregar Paquetes Seleccionados</a></li>
        <li>
            <a onclick="history.back()">Atras</a>
        </li>
        <li>
            <a onclick="$('#rmenu').removeClass('show').addClass('hide');">Salir</a>
        </li>
    </ul>
</div>
<div class="hide click-right" id="smenu">
    <ul>
        <li>
            <a id="splits" onclick="$('#modal-split-supplies').modal('show')"></a>
        </li>
        <li><a id="rmalls" onclick="AddSelected('Insumo')">Agregar Insumos Seleccionados</a></li>
        <li>
            <a onclick="history.back()">Atras</a>
        </li>
        <li>
            <a onclick="$('#smenu').removeClass('show').addClass('hide');">Salir</a>
        </li>
    </ul>
</div>

<div class="modal fade" id="modal_detail_supplies">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalles del paquete #<label id="number_pack_detail"></label></h4>
            </div>
            <div class="modal-body" id="content_detail_supplies">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_goBack">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Revertir paquete de la solicutd de despacho</h4>
            </div>
            <div class="modal-body" id="content-goBack">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" onclick="save_goBack()">Guardar</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_goBackP">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Revertir Mueble hasta producción</h4>
            </div>
            <div class="modal-body" id="content-goBackP">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" onclick="delete_item_group2()">Reversar</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    
    $(function () {
//        TableData("table_container", false, false, false);
        InitializeCheck();

        if (<?= $request->status ?> == 17  || <?= $vali_request_w ?> == 1) {
            Lock();
        }

        if (<?= $request->updated_subdetail ?> == 2) {
            $("#btn-aprob").attr("disabled", true);
        }

        if ($("#test").addEventListener) {
            $("#test").addEventListener('contextmenu', function (e) {
                alert("Has intentado abrir el menú contextual"); // here you draw your own menu
                e.preventDefault();
            }, false);
        } else {
            $("#vehicle").val("<?= $request->id_weight_vehicle ?>");
            $("#max_weight").val("<?= $request->max_weight ?>");
            $('body').on('contextmenu', 'tr.test', function () {
                var pack = $(this).attr("idpack");
                $("#quantity-split").val(0);
                $("#split").text("Agregar Paquete Al Contenedor");
                $("#t-order").text($(this).attr("order"));
                $("#t-pack").text($(this).attr("pack"));
                $("#t-balance").text($("#balance_" + pack).text());
                $("#t-quantity").text($("#quantity_" + pack).text());
                $("#t-forniture").text($("#name_" + pack).text());
                $("#t-weight").text($(this).attr("weight"));
                $("#btn-save").attr("onclick", "AddPack(" + pack + ")");
                
                $("#rmenu").removeClass("hide").addClass("show");
                $("#rmenu").attr("style", "top:" + mouseY(event) + "px;left:" + mouseX(event) + "px ");
                window.event.returnValue = false;
            });
        }

        if ($("#test2").addEventListener) {
            $("#test2").addEventListener('contextmenu', function (e) {
                alert("Has intentado abrir el menú contextual"); //here you draw your own menu 
                e.preventDefault();
            }, false);
        } else {
            $('body').on('contextmenu', 'tr.test2', function () {
                var pack = $(this).attr("idpack");
                $("#quantity-split-supplies").val(0);
                $("#splits").text("Agregar Al Contenedor ");
                $("#ts-order").text($(this).attr("order"));
                $("#ts-pack").text($(this).attr("pack"));
                $("#ts-balance").text($("#sbalance_" + pack).text());
                $("#ts-quantity").text($("#squantity_" + pack).text());
                $("#ts-supplies").text($("#sname_" + pack).text());
                $("#ts-weight").text($(this).attr("weight"));
                $("#btn-save2").attr("onclick", "AddPackSupplies(" + pack + ")");
                $("#smenu").removeClass("hide").addClass("show");
                $("#smenu").attr("style", "top:" + mouseY(event) + "px;left:" + mouseX(event) + "px ");
                window.event.returnValue = false;
            });
        }
    });

    function report_supervisory(){
        $.ajax({
            url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/get_report_supervisory",
            type: 'POST',
            data: {id_request_sd:<?=$request->id_request_sd?>},
            success: function(data){
                dato = JSON.parse(data);
                if (dato.length > 0) {
                    var a = document.createElement('a');
                    a.href = '<?= base_url() ?>Dispatch/C_Dispatch_La/report_supervisory/<?=$request->id_request_sd?>';
                    a.setAttribute('target', '_blank');
                    a.click();
                }else{
                    swal({title: 'Atención', text: 'no hay datos para mostrar', type: 'error'});
                }
            }
        });
    }

    function request_dispatch(){
        var a = document.createElement('a');
        a.href = '<?= base_url() ?>Dispatch/C_Dispatch_La/PdfRequest/<?=$request->id_request_sd?>';
        a.setAttribute('target', '_blank');
        a.click();
    }

    function request_cargo(){
        $.ajax({
            url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/get_request_cargo",
            type: 'POST',
            data: {id_request_sd:<?=$request->id_request_sd?>},
            success: function(data){
                dato = JSON.parse(data);
                if(dato == null){
                    swal({title: 'Atención', text: 'no hay control de cargue relacionada a esta solicitud', type: 'error'});
                }else{
                    var a = document.createElement('a');
                    a.href = '<?= base_url() ?>Dispatch/C_Dispatch/request_cargo/'+dato.id_request_cargue;
                    a.setAttribute('target', '_blank');
                    a.click();
                }
            }
        });
    }

    function modal_goBack(type,id_order_package,id_delivery_package_detail,id_request_detail){
        $.ajax({
            url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/get_data_goBack",
            type: 'POST',
            data: {type:type,id_order_package:id_order_package,id_delivery_package_detail:id_delivery_package_detail,id_request_detail:id_request_detail},
            success: function(data){
                dato = JSON.parse(data);
                $("#content-goBack").html(dato.content);
                $("#modal_goBack").modal("show");
            }
        });
    }

    function save_goBack(){

        swal({
            title: 'Atención',
            text: "Desea revertir paquetes de esta solicitud?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result) {
                var type2 = $("#type").val();

                if (type2 == "M") {
                    var cnt = $("#cnt").val();
                    var observation = $("#observation").val();
                    var id_order_package = $("#id_order_package").val();
                    var number_pack = $("#number_pack_back").val();
                    var order = $("#order_gp").val();
                    var id_delivery_detail = $("#id_delivery_detailFF").val();
                    

                    var arr_modulate = document.querySelectorAll("#quantity_h"); //remissions
                    var total_modulate = 0;
                    arr_modulate.forEach(function(element){
                        total_modulate = parseInt(total_modulate) + parseInt(element.value);
                    });
                    var pack_supplies = $("#packs_supplies").val();
                    var quantity_packages = (parseInt(pack_supplies) + parseInt(total_modulate)) - parseInt(cnt);

                    var type = 0;
                    if (<?= $request->status ?> == 17 ) {
                        type = 1
                    }
                    var id_request_detail = $("#id_request_sd_detail").val();

                    $.ajax({
                        url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/goBack_Package",
                        type: 'POST',
                        data: {order:order,cnt:cnt,observation:observation,id_order_package:id_order_package,number_pack:number_pack,quantity_packages:quantity_packages,id_request_sd:<?=$request->id_request_sd?>,id_delivery_detail:id_delivery_detail,type:type,id_request_detail:id_request_detail,type2:type2},
                        success: function(data){
                            dato = JSON.parse(data);
                            location.reload();
                        }
                    });
                }else{
                    var request_sd_detail = $("#request_sd_detail").val();
                    var observation = $("#observation").val();
                    var order = $("#order_gs").val();
                    $.ajax({
                        url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/goBack_Package_Supplies",
                        type: 'POST',
                        data: {request_sd_detail:request_sd_detail, order:order, observation:observation},
                        success: function(data){
                            dato = JSON.parse(data);
                            location.reload();
                        }
                    });
                }
            }
        });   
    }
    
    // Created Ivan Contreras 27/03/2019
    function max_weight(id_vehicle){
         $.ajax({
            url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/get_vehicle",
            type: 'POST',
            data: {id_vehicle:id_vehicle},
            success: function(data){
                dato = JSON.parse(data);
                $("#max_weight").val(dato.max_weight);
            }
        });
    }
    
    //  08/04/2019
    function add_item_group(order,type){
        var furniture = $("#lblfurniture"+order).val();
        var weight = document.querySelectorAll("input[id=weight-h-"+order+"-"+furniture+"]");
        var available = document.querySelectorAll("input[id=available-h-"+order+"-"+furniture+"]");
        var order_package = document.querySelectorAll("input[id=id_order_package-"+order+"-"+furniture+"]");
        var name = document.querySelectorAll("input[id=name-"+order+"-"+furniture+"]");
        var pack = document.querySelectorAll("input[id=pack-"+order+"-"+furniture+"]");
        var weight_arr = [];
        var order_package_arr = [];
        var name_arr = [];
        var pack_arr = [];
        weight.forEach(function(element) {
            weight_arr.push(element.value);
        }, this);
        order_package.forEach(function(element) {
            order_package_arr.push(element.value);
        }, this);
        name.forEach(function(element) {
            name_arr.push(element.value);
        }, this);
        pack.forEach(function(element) {
            pack_arr.push(element.value);
        }, this);
        
        var id_delivery_detail = $("#id_detail-"+order+"-"+furniture).val();
        var count = 0;
        available.forEach(function(element) {
            if(element.value > 0){
                $.ajax({
                    url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/AddItemGroup",
                    type: 'POST',
                    data: {id_forniture:furniture,order:order,type:type,request:<?=$request->id_request_sd?>,weight:weight_arr[count],quantity:element.value,id_order_package:order_package_arr[count],name:name_arr[count],pack:pack_arr[count],id_delivery_detail:id_delivery_detail},
                    success: function(data){
                        var dt = JSON.parse(data);
                        if (dt.res == "OK") {
                            $("#quantity_packages").val(dt.num_packets);
                            $("#weight").val(dt.total_weight_modulate);
                            $("#weight_supplies").val(dt.total_weight_supplies);
                            $("#weightI").val((dt.total_weight_modulate + (dt.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + dt.total_weight_supplies);      
                            $("#tab-body").html(dt.tabs);
                            InitializeCheck();
                        } else {
                            swal({title: 'error!', text: data.res, type: 'error'});
                        }
                    }
                });
            }
            count++;
        }, this);
    }
    
    function add_item_group_supplies(order,type){
        var id_package_supplies = $("#slctpq-"+order).val();
        $.ajax({
            url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/AddItemGroupSupplies",
            type: 'POST',
            data: {id_package_supplies:id_package_supplies,order:order,type:type,request:<?=$request->id_request_sd?>},
            success: function(data){
                var dt = JSON.parse(data);
                if (dt.res == "OK") {
                    $("#quantity_packages").val(dt.num_packets);
                    $("#weight").val(dt.total_weight_modulate);
                    $("#weight_supplies").val(dt.total_weight_supplies);
                    $("#weightI").val((dt.total_weight_modulate + (dt.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + dt.total_weight_supplies);      
                    $("#tab-body").html(dt.tabs);
                    InitializeCheck();
                } else {
                    swal({title: 'error!', text: data.res, type: 'error'});
                }
            }
        });
    }
    
    function modal_detail(id_order_package_supplies,order){
        $.ajax({
            url:  "<?= base_url() ?>Dispatch/C_Dispatch_La/get_data_detail",
            type: 'POST',
            data: {id_order_package_supplies:id_order_package_supplies,order:order},
            success: function(data){
                var dt = JSON.parse(data);
                if (dt.res == "OK") {
                    $('#content_detail_supplies').html(dt.table);
                    $("#number_pack_detail").text(dt.number_pack);
                    $('#modal_detail_supplies').modal('show');
                } else {
                    swal({title: 'error!', text: data.res, type: 'error'});
                }
            }
        });
    }
    
    //***************************************************//

    function InitializeCheck() {
        $('.minimal-Modulado, .minimal-Insumo').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });

        $('.minimal, .minimal-supplies').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        }).on('ifChanged', function (e) {
            var isChecked = e.currentTarget.checked;
            var order = $(this).attr("id");
            if (isChecked == true) {
                $('.chk' + order).iCheck('check');
            } else {
                $('.chk' + order).iCheck('uncheck');
            }
        });

    }

    function AddSelected(type) {
        var countU = 0;
        var arrPack = [];
        var arrOrder = [];
        $(".minimal-" + type).each(function () {
            var id = $(this).attr("idtable");
            if ($(this).prop("checked")) {
                arrPack.push(id);
                arrOrder.push($("#order_"+id).val());
                countU++;
            }
        });
        if (countU <= 0) {
            swal({title: 'error!', text: "Debe seleccionar por lo menos un registro", type: 'warning'});
        } else {
            $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/AddPackSDToRequestGroup", {arrPack: arrPack, order:arrOrder, request:<?= $request->id_request_sd ?>, type: type, quantity:1}, function (data) {
                if (data.res == "OK") {
                    $("#quantity_packages").val(data.num_packets);
                    $("#weight").val(data.total_weight_modulate);
                    $("#weight_supplies").val(data.total_weight_supplies);
                    $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);      
                    $("#tab-body").html(data.tabs);
                    InitializeCheck();
                } else {
                    swal({title: 'error!', text: data.res, type: 'error'});
                }
            }, 'json');
        }
    }

    function CreateRequisition() {
        if($("#vehicle").val() == null){
            swal({
                title: 'Escoga un tipo de vehiculo',
                text: "",
                type: 'error'
            });
        }else{
            if($("#max_weight").val() < Math.round($("#weightI").val()) && (<?= $vali_request_w ?> == 0 || <?= $status ?> == 16)){
                // swal({
                //     title: 'Atención',
                //     text: "El peso integral supera la capacidad del vehiculo, elimine paquetes",
                //     type: 'error'
                // });
                swal({
                    title: 'Atención',
                    text: "El peso integral supera la capacidad del vehiculo, desea solicitar autorizacion del peso?",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result) {
                        var id_vehicle = $("#vehicle").val();
                        var weight_i = $("#weightI").val();
                        var total = parseFloat($("#max_weight").val()) + parseFloat(<?= $max_weight->weight ?>);
                        if(weight_i > total){
                            swal({
                                title: 'Atención',
                                text: "El peso integral ("+weight_i+" Kg) supera el sobrepeso maximo permitido ("+<?= $max_weight->weight ?>+" Kg). Peso maximo camión: "+$("#max_weight").val()+" Kg + sobrepeso maximo permitido "+<?= $max_weight->weight ?>+" Kg ("+total+" Kg)",
                                type: 'error'
                            });
                        }else{
                            $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/Create_Request_weight", {request:<?= $request->id_request_sd ?>,id_vehicle:id_vehicle,weight_i:weight_i}, function (data) {
                                if(data == "already"){
                                    swal({title: 'Atención', text: 'Ya se envio una solicitud de cambio de peso, espere la respuesta del administrador', type: 'warning'});
                                }else{
                                    swal({title: '', text: '', type: 'success'});
                                    location.reload();
                                }
                            }, 'json').fail(function (error) {
                                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                            });
                            swal({
                                title: 'Solicitud enviada',
                                text: "",
                                type: 'success'
                            });
                        }
                    }
                });
            }else{
                swal({
                    title: 'Confirma la generacion de la(s) requisición(es)?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3c8dbc',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!'
                }).then((result) => {
                    if (result) {
                        var arr_modulate = document.querySelectorAll("#quantity_h");
                        var total_modulate = 0;
                        arr_modulate.forEach(function(element){
                            total_modulate = parseInt(total_modulate) + parseInt(element.value);
                        });
                        var pack_supplies = $("#packs_supplies").val();
                        var quantity_packages = parseInt(pack_supplies) + parseInt(total_modulate);
                        //console.log(quantity_packages);
                        var id_vehicle = $("#vehicle").val();

                        $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/CreateRequisition", {request:<?= $request->id_request_sd ?>,id_vehicle:id_vehicle,weight:$("#weight").val(),weightI:$("#weightI").val(),weight_supplies:$("#weight_supplies").val(),quantity_packages:quantity_packages}, function (data) {
                                if (data.res == "OK") {
                                    swal({title: '', text: '', type: 'success'});
                                    Lock();
                                    $.each(data.reqs,function(e,i){
                                        window.open("<?= base_url() ?>Dispatch/C_Dispatch_La/PdfRequisition/"+i+"/<?= $request->id_request_sd ?>", '_blank');
                                    });
                                } else {
                                    swal({title: 'Error!', text: data, type: 'error'});
                                }
                        }, 'json').fail(function (error) {
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                        });
                    }
                }).catch(swal.noop)
            }
        }
    }

    function Lock() {
        //$("#lock").addClass("fa-lock").removeClass("fa-unlock");
        //$(".btn-danger , #btn-aprob, #btn-add").attr("disabled", true);
        $("#btn-aprob").attr("disabled", true);
        //$('input').iCheck('disable');
        //$(".input-sm").attr("disabled", true);
        $("#vehicle").attr("disabled", true);
        //$("select").attr("disabled", true);
    }
    
    function DeleteAll(type){
        swal({
            title: 'Esta seguro de eliminar todos los Paquetes del contenedor?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                var type2 = 0;
                if (<?= $request->status ?> == 17) {
                    type2 = 1;
                }
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeleteAllPackRequestSD", {request:<?= $request->id_request_sd ?>, type: type,type2:type2}, function (data) {
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weight_supplies").val(data.total_weight_supplies);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);      
                        $("#tab-body").html(data.tabs);
                        InitializeCheck();
                        swal({title: '', text: '', type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function DeleteSupplies(id_request_detail,id_order_package,order){
        swal({
            title: 'Atención',
            text: "Desea revertir este paquete de la solicitud?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result) {
                var type = 0;
                if (<?= $request->status ?> == 17) {
                    type = 1;
                }
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeleteSuppliesRequestSD", {request:<?= $request->id_request_sd ?>, id_request_detail:id_request_detail,id_order_package:id_order_package,order:order,type:type}, function (data) {
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weight_supplies").val(data.total_weight_supplies);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);      
                        $("#tab-body").html(data.tabs);
                        InitializeCheck();
                        swal({title: '', text: '', type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        });
    }
    
    function DeleteAllSupplies(type){
        swal({
            title: 'Esta seguro de eliminar todos los Insumos del contenedor?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                var type2 = 0;
                if (<?= $request->status ?> == 17) {
                    type2 = 1;
                }
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeleteAllSuppliesRequestSD", {request:<?= $request->id_request_sd ?>, type: type, type2:type2}, function (data) {
                    if (data.res == "OK") {
                        $("#tab-body").html(data.tabs);
                        InitializeCheck();
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function Delete(id_request_detail, id_order_package, type, order) {
        swal({
            title: 'Esta seguro de eliminar el Paquete del contenedor?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                var type2 = 0;
                if (<?= $request->status ?> == 17) {
                    type2 = 1;
                }
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeletePackRequestSD", {id_request_detail: id_request_detail, request:<?= $request->id_request_sd ?>, type: type, type2:type2}, function (data) {
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weight_supplies").val(data.total_weight_supplies);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);
                        if (type == "Modulado") {
                            $("#dispatch_" + id_order_package).text(parseInt($("#dispatch_" + id_order_package).text()) - parseInt($("#cont-quantity-" + id_order_package).text()));
                            $("#balance_" + id_order_package).text(parseInt($("#balance_" + id_order_package).text()) + parseInt($("#cont-quantity-" + id_order_package).text())).removeClass("bg-success").addClass("bg-danger");
                            $("#tr-cont-" + id_order_package).remove();
                            var validation = document.getElementById("a_"+order);
                            if(validation === null){
                                var node = document.createElement("LI");
                                node.setAttribute("id", "a_"+order);
                                var a = document.createElement("A");
                                var att = document.createAttribute("href");
                                att.value = '#tab_'+order+'';
                                var att2 = document.createAttribute("data-toggle");
                                att2.value = 'tab';
                                a.setAttributeNode(att);
                                a.setAttributeNode(att2);
                                var textnode = document.createTextNode(order);
                                a.appendChild(textnode); 

                                node.appendChild(a);
                                document.getElementById("content").appendChild(node); 
                            }
                            $("#tab-body").html(data.tabs);
                            
                        } else {
                            $("#sdispatch_" + id_order_package).text(parseInt($("#sdispatch_" + id_order_package).text()) - parseInt($("#scont-quantity-" + id_order_package).text()));
                            $("#sbalance_" + id_order_package).text(parseInt($("#sbalance_" + id_order_package).text()) + parseInt($("#scont-quantity-" + id_order_package).text())).removeClass("bg-success").addClass("bg-danger");
                            $("#str-cont-" + id_order_package).remove();
                            var validation = document.getElementById("a_"+order);
                            if(validation === null){
                                var node = document.createElement("LI");
                                node.setAttribute("id", "a_"+order);
                                var a = document.createElement("A");
                                var att = document.createAttribute("href");
                                att.value = '#tab_'+order+'';
                                var att2 = document.createAttribute("data-toggle");
                                att2.value = 'tab';
                                a.setAttributeNode(att);
                                a.setAttributeNode(att2);
                                var textnode = document.createTextNode(order);
                                a.appendChild(textnode); 

                                node.appendChild(a);
                                document.getElementById("content").appendChild(node); 
                            }
                            $("#tab-body").html(data.tabs);
                        }
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function UpdateRequest(field, value) {
        $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/UpdateRequestSD", {request:<?= $request->id_request_sd ?>, field: field, value: value}, function (data) {

        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function UpdateRequest2(){
        var driver = $("#driver").val();
        var value = $("#license_plate").val();
        var vehicle = $("#vehicle").val();

        var arr_modulate = document.querySelectorAll("#quantity_h");
        var total_modulate = 0;
        arr_modulate.forEach(function(element){
            total_modulate = parseInt(total_modulate) + parseInt(element.value);
        });
        var pack_supplies = $("#packs_supplies").val();
        var quantity_packages = parseInt(pack_supplies) + parseInt(total_modulate);
        var type = 0;

        if((<?= $request->status ?> == 17) && (Math.round($("#weightI").val()) > $("#max_weight").val())){
            swal({title: 'Atención', text: 'El peso integral supera la capacidad del vehiculo', type: 'error'});
        }else{
            if (<?= $request->status ?> == 17) {
                type = 1;
            }
            $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/UpdateRequestSD2", {request:<?= $request->id_request_sd ?>, driver:driver, value:value, vehicle:vehicle,quantity_packages:quantity_packages,type:type}, function (data) {
                swal({title: 'Exito', text: 'Cambios Guardados', type: 'success'});
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }

    }

    function AddPackSupplies(id_order_package_supplies) {
        if (parseInt($("#ts-balance").text()) > 0) {
            if ($("#quantity-split-supplies").val() > 0 && $("#quantity-split-supplies").val() <= parseInt($("#ts-balance").text())) {
                var order = $("#ts-order").text();
                var name = $("#ts-supplies").text();
                var pack = $("#ts-pack").text();
                var quantity = $("#quantity-split-supplies").val();
                var weight = parseFloat($("#ts-weight").text());
                var type = 'Insumo';
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/AddPackSDToRequest", {order: order, id_order_package: id_order_package_supplies,id_forniture:'', quantity: quantity, request:<?= $request->id_request_sd ?>, name: name, pack: pack, weight: weight, type: type}, function (data) {
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight_supplies").val(data.total_weight_supplies); 
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);
                        $("#sdispatch_" + id_order_package_supplies).text(parseInt($("#sdispatch_" + id_order_package_supplies).text()) + parseInt(quantity));
                        var balance = parseInt($("#sbalance_" + id_order_package_supplies).text()) - quantity;
                        $("#sbalance_" + id_order_package_supplies).text(balance);
                        if (balance <= 0) {
                            $("#sbalance_" + id_order_package_supplies).removeClass("bg-danger").addClass("bg-success");
                        }
                        if (data.new == "TRUE") {
                            var btn = '<button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="Delete(' + data.id + ',' + id_order_package_supplies + ',\'' + type + '\')"><i class="fa fa-trash"></i></button>';
                            $("#table_container_supplies  tbody").append('<tr id="str-cont-' + id_order_package_supplies + '"><td style="text-align:center">' + order + '</td><td style="text-align:center">' + name + '</td><td style="text-align:center">' + pack + '</td><td style="text-align:center" id="scont-quantity-' + id_order_package_supplies + '">' + quantity + '</td><td style="text-align:center" id="scont-weight-' + id_order_package_supplies + '">' + weight * quantity + '</td><td style="text-align:center">' + btn + '</td></tr>');
                        } else {
                            $("#scont-quantity-" + id_order_package_supplies).text(parseInt($("#scont-quantity-" + id_order_package_supplies).text()) + parseInt(quantity));
                            $("#scont-weight-" + id_order_package_supplies).text(parseFloat($("#scont-weight-" + id_order_package_supplies).text()) + parseFloat(weight * quantity));
                        }
                        $('#modal-split-supplies').modal('hide');
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            } else {
                swal({title: 'Error!', text: "La cantidad debe ser mayor a cero y menor o igual a " + parseInt($("#ts-balance").text()), type: 'error'});
            }
        } else {
            $('#modal-split').modal('hide');
            swal({title: 'Error!', text: "No hay saldo disponible", type: 'error'});
        }
    }

    function AddPack(id_order_package) {
        if (parseInt($("#t-balance").text()) > 0) {
            if ($("#quantity-split").val() > 0 && $("#quantity-split").val() <= parseInt($("#t-balance").text())) {
                var order = $("#t-order").text();
                var name = $("#t-forniture").text();
                var pack = $("#t-pack").text();
                var quantity = $("#quantity-split").val();
                var id_forniture = $("#tr-"+id_order_package).attr("forniture");
                var weight = parseFloat($("#t-weight").text());
                var type = 'Modulado';
                var id_delivery_detail = $("#id_detail-"+order+"-"+id_forniture).val();
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/AddPackSDToRequest", {order: order, id_order_package: id_order_package,id_forniture:id_forniture, quantity: quantity, request:<?= $request->id_request_sd ?>, name: name, pack: pack, weight: weight, type: type, id_delivery_detail:id_delivery_detail}, function (data) {
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);
                        $("#dispatch_" + id_order_package).text(parseInt($("#dispatch_" + id_order_package).text()) + parseInt(quantity));
                        var balance = parseInt($("#balance_" + id_order_package).text()) - quantity;
                        $("#balance_" + id_order_package).text(balance);
                        if (balance <= 0) {
                            $("#balance_" + id_order_package).removeClass("bg-danger").addClass("bg-success");
                        }
                        if (data.new == "TRUE") {
                            var btn = '<button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="Delete(' + data.id + ',' + id_order_package + ',\'' + type + '\')"><i class="fa fa-trash"></i></button>';
                            $("#table_container  tbody").append('<tr id="tr-cont-' + id_order_package + '"><td style="text-align:center">' + order + '</td><td style="text-align:center">' + name + '</td><td style="text-align:center">' + pack + '</td><td style="text-align:center" id="cont-quantity-' + id_order_package + '">' + quantity + '</td><td style="text-align:center" id="cont-weight-' + id_order_package + '">' + weight * quantity + '</td><td style="text-align:center">' + btn + '</td></tr>');
                        } else {
                            $("#cont-quantity-" + id_order_package).text(parseInt($("#cont-quantity-" + id_order_package).text()) + parseInt(quantity));
                            $("#cont-weight-" + id_order_package).text(parseFloat($("#cont-weight-" + id_order_package).text()) + parseFloat(weight * quantity));
                        }
                        location.reload();
                        $('#modal-split').modal('hide');
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            } else {
                swal({title: 'Error!', text: "La cantidad debe ser mayor a cero y menor o igual a " + parseInt($("#t-balance").text()), type: 'error'});
            }
        } else {
            $('#modal-split').modal('hide');
            swal({title: 'Error!', text: "No hay saldo disponible", type: 'error'});
        }
    }

    function delete_item_group(){
        swal({
            title: 'Esta seguro de eliminar todos los items del contenedor?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                var json = JSON.parse($("#furniture_d").val());
                var id_forniture = json.id_forniture;
                var order = json.order;
                var type = 0;
                if (<?= $request->status ?> == 17) {
                    type = 1;
                }
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeletePackRequestSDGroup", {request:<?= $request->id_request_sd ?>, id_forniture:id_forniture,type:type,order:order}, function (data) {
                    console.log(data);
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);
                        $("#tab-body").html(data.tabs);
                        InitializeCheck();
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function delete_item_group2(){
        swal({
            title: 'Esta seguro de reversar todos los items hasta producción?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                var json = JSON.parse($("#furniture_d").val());
                var id_forniture = json.id_forniture;
                var order = json.order;
                var type = 0;
                if (<?= $request->status ?> == 17) {
                    type = 1;
                }
                var observation = $("#observationP").val();
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeletePackRequestSDGroup2", {request:<?= $request->id_request_sd ?>, id_forniture:id_forniture,type:type,order:order,observation:observation}, function (data) {
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);
                        $("#tab-body").html(data.tabs);
                        InitializeCheck();
                        $("#modal_goBackP").modal("hide");
                        swal({title: '', text: '', type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function modal_goBackP(){
        var json = JSON.parse($("#furniture_d").val());
        var id_forniture = json.id_forniture;
        var order = json.order;
        $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/get_data_goBackP", {request:<?= $request->id_request_sd ?>, id_forniture:id_forniture, order:order}, function (data) {
            $("#content-goBackP").html(data.content);
            $("#modal_goBackP").modal("show");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function delete_supplies_group(){
        swal({
            title: 'Esta seguro de eliminar todos los items del contenedor?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                var json = JSON.parse($("#supplies_d").val());
                var id_order_package_supplies = json.id_order_package;
                var order = json.order;
                var type = 0;
                if (<?= $request->status ?> == 17) {
                    type = 1;
                }
                $.post("<?= base_url() ?>Dispatch/C_Dispatch_La/DeleteSuppliesRequestSDGroup", {request:<?= $request->id_request_sd ?>, id_order_package_supplies:id_order_package_supplies,type:type,order:order}, function (data) {
                    console.log(data);
                    if (data.res == "OK") {
                        $("#quantity_packages").val(data.num_packets);
                        $("#weight").val(data.total_weight_modulate);
                        $("#weightI").val((data.total_weight_modulate + (data.total_weight_modulate *<?= PORCENT_WEIGHT ?>)) + data.total_weight_supplies);
                        $("#tab-body").html(data.tabs);
                        InitializeCheck();
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)   
    }

    $(document).bind("click", function (event) {
        $(".click-right").removeClass("show").addClass("hide");
    });

</script>
