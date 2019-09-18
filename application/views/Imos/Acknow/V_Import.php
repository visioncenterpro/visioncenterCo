<style>
    .div-info1{
        border: 3px solid #dedede;
        padding: 15px;
        /*margin-left: 5px;*/
    }
    .table-info > tbody > tr >th{
        width: 25%
    }
    .table-info > tbody > tr >td, .table-info > tbody > tr >th{
        padding-right: 15px;
        padding-left: 15px;
    }
    h3{
        color: #3c8dbc;
    }
    .btn-sm{
        margin-right: 3px;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <i class="fa  fa-tags"></i>
                <a class="btn icon-btn btn-default" id="load" ><span class="glyphicon btn-glyphicon glyphicon-share img-circle text-success"></span>Cargar Archivos</a>
                <a class="btn icon-btn btn-default " id="btn-imp" onclick="SaveAck('import');" ><span class="glyphicon btn-glyphicon glyphicon-cloud-upload img-circle text-success"></span>Importar Datos</a>
                <a class="btn icon-btn btn-default " id="btn-imp" onclick="SaveAck('create');" ><span class="glyphicon btn-glyphicon glyphicon-floppy-saved img-circle text-success"></span>Crear Nuevo</a>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a id="info_li"  data-toggle="tab"  href="#info"><i class="fa fa-info"></i> Info General</a></li>
                                <li ><a id="info_li"  data-toggle="tab"  href="#style"><i class="fa fa-paint-brush"></i> Estilo</a></li>
                                <li><a id="detalle_li" data-toggle="tab"   href="#detalle"><i class="fa  fa-th"></i> Items</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class = "tab-pane active" id="info">
                                    <?= $tabInfo ?>
                                </div>
                                <div class = "tab-pane" id="style">
                                    <?= $tabStyle ?>
                                </div>
                                <div class = "tab-pane" id="detalle">
                                    <?= $tabDetail ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="load_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Cargar Archivos Ack.</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div id="fileTreeDemo_3" style="overflow-y: scroll;max-height: 400px;" class="demo"></div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary" onclick="SelectFile()">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-item">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header bg-blue-active">
                <button type="button" class="btn btn-default pull-right btn-sm" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-default pull-right btn-sm" id="add" onclick="addRow()" >Agregar Item</button>
                <button type="button" class="btn btn-default pull-right btn-sm" id="update" style="display:none"  >Modificar</button>
                <h4 class="modal-title tittle-item"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control input-sm input-row required" id="description" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control input-sm input-row required" id="code" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="code1">code1</label>
                            <input type="text" class="form-control input-sm input-row" id="code1" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="code_esp">Code Esp</label>
                            <input type="text" class="form-control input-sm input-row" id="code_esp" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hinges_left">Hinges Left</label>
                            <select class="form-control input-sm input-row" id="hinges_left">
                                <option value="">. . .</option>
                                <option value="L">SI</option>
                                <option value="" selected="">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hinges_right">Hinges Right</label>
                            <select class="form-control input-sm input-row" id="hinges_right">
                                <option value="">. . .</option>
                                <option value="R">SI</option>
                                <option value="" selected="">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="route">Route</label>
                            <input type="text" class="form-control input-sm input-row" id="route" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="opening">Opening</label>
                            <input type="text" class="form-control input-sm input-row" id="opening" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="door_style">Door Style</label>
                            <select class="form-control input-sm input-row required" id="door_style">
                                <option value="">. . .</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="finished_side_left">Finished Side Left</label>
                            <select class="form-control input-sm input-row" id="finished_side_left">
                                <option value="">. . .</option>
                                <option value="L">SI</option>
                                <option value="" selected="">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="finished_side_right">Finished Side Right</label>
                            <select class="form-control input-sm input-row" id="finished_side_right">
                                <option value="">. . .</option>
                                <option value="R">SI</option>
                                <option value="" selected="">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="height">Height</label>
                            <input type="number" class="form-control input-sm input-row required" onkeyup="return Greater_zero(this);" id="height" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="width">Width</label>
                            <input type="number" class="form-control input-sm input-row required" onkeyup="return Greater_zero(this);" id="width" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="depth">Depth</label>
                            <input type="number" class="form-control input-sm input-row required" onkeyup="return Greater_zero(this);" id="depth" value="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unit_prices">Unit Prices</label>
                            <input type="number" class="form-control input-sm input-row" id="unit_prices" value="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <input type="number" class="form-control input-sm input-row required" onkeyup="return Greater_zero(this);" id="qty" value="1">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control input-row" rows="3" id="notes"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script>
    var item = 1;
    $(document).ready(function () {
        $("#load").click(function () {
            $("#load_form").modal("show");
        });

        $('#fileTreeDemo_3').fileTree({
            root: '<?= NETWORK_UNIT_ACK ?>',
            script: '<?= base_url() ?>dist/jqueryFileTree/connectors/jqueryFileTree.php',
            folderEvent: 'click',
            expandSpeed: 750,
            collapseSpeed: 750,
            expandEasing: 'easeOutBounce',
            collapseEasing: 'easeOutBounce',
            loadMessage: 'Un momento...'
        }, function (file) {
        });

        CretateTableTab('table_detail', 0);
        $("#table_detail_filter").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-info btn-sm " onclick="Create()"><i class="fa  fa-plus-circle"></i> Agregar</button></label>');

    });
 
    function addRow() {
        if (validatefield()) {
            $('#table_detail').DataTable().destroy();

            var table = $('#table_detail').DataTable({
                scrollY: "500px",
                paging: false,
                fixedHeader: true,
                order: [[1, 'asc']],
                sScrollX: true,
                scrollCollapse: true
            });
            
            var vol = Volume($("#height").val(),$("#width").val(),$("#depth").val(),$("#qty").val());
            
            var rowNode = table.row.add(['<button type="button" class="btn btn-info btn-xs btn-tabla" onclick="ShowItems(' + item + ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="DeleteItems(' + item + ')"><i class="fa fa-trash"></i></button>', item,
                $("#qty").val(), $("#code").val(), $("#code1").val(), $("#code_esp").val(), $("#hinges_left").val(), $("#hinges_right").val(), $("#route").val(), $("#opening").val(), $("#door_style").val(),
                $("#finished_side_left").val(), $("#finished_side_right").val(), $("#height").val(), $("#width").val(), $("#depth").val(), $("#unit_prices").val(), $("#unit_prices").val() * $("#qty").val(), vol
                        , $("#description").val(), $("#notes").val()])
                    .draw().node();
            $(rowNode).attr("id", "tr-" + item);

            item++;

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                table.columns.adjust();
            });

            $("#table_detail_filter").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-info btn-sm " onclick="Create()"><i class="fa  fa-plus-circle"></i> Agregar</button></label>');
            $("#modal-item").modal("hide");
        }
    }

    function ShowItems(id) {
        $(".input-row").val("");
        $("#qty").val($("#tr-" + id + " > td")[2].innerText);
        $("#code").val($("#tr-" + id + " > td")[3].innerText);
        $("#code1").val($("#tr-" + id + " > td")[4].innerText);
        $("#code_esp").val($("#tr-" + id + " > td")[5].innerText);
        $("#hinges_left").val($("#tr-" + id + " > td")[6].innerText);
        $("#hinges_right").val($("#tr-" + id + " > td")[7].innerText);
        $("#route").val($("#tr-" + id + " > td")[8].innerText);
        $("#opening").val($("#tr-" + id + " > td")[9].innerText);
        $("#door_style").val($("#tr-" + id + " > td")[10].innerText);
        $("#finished_side_left").val($("#tr-" + id + " > td")[11].innerText);
        $("#finished_side_right").val($("#tr-" + id + " > td")[12].innerText);
        $("#height").val($("#tr-" + id + " > td")[13].innerText);
        $("#width").val($("#tr-" + id + " > td")[14].innerText);
        $("#depth").val($("#tr-" + id + " > td")[15].innerText);
        $("#unit_prices").val($("#tr-" + id + " > td")[16].innerText);
        $("#description").val($("#tr-" + id + " > td")[19].innerText);
        $("#notes").val($("#tr-" + id + " > td")[20].innerText);
        
        $(".form-group").removeClass("has-error");
        $(".tittle-item").text("Modificar Item");
        $("#add").hide();
        $("#update").show().attr("onclick", "UpdateRow(" + id + ")");
        $("#modal-item").modal("show");
    }

    function UpdateRow(id) {
        if (validatefield()) {
            $("#tr-" + id + " > td")[2].innerText = $("#qty").val();
            $("#tr-" + id + " > td")[3].innerText = $("#code").val();
            $("#tr-" + id + " > td")[4].innerText = $("#code1").val();
            $("#tr-" + id + " > td")[5].innerText = $("#code_esp").val();
            $("#tr-" + id + " > td")[6].innerText = $("#hinges_left").val();
            $("#tr-" + id + " > td")[7].innerText = $("#hinges_right").val();
            $("#tr-" + id + " > td")[8].innerText = $("#route").val();
            $("#tr-" + id + " > td")[9].innerText = $("#opening").val();
            $("#tr-" + id + " > td")[10].innerText = $("#door_style").val();
            $("#tr-" + id + " > td")[11].innerText = $("#finished_side_left").val();
            $("#tr-" + id + " > td")[12].innerText = $("#finished_side_right").val();
            $("#tr-" + id + " > td")[13].innerText = $("#height").val();
            $("#tr-" + id + " > td")[14].innerText = $("#width").val();
            $("#tr-" + id + " > td")[15].innerText = $("#depth").val();
            $("#tr-" + id + " > td")[16].innerText = $("#unit_prices").val();
            $("#tr-" + id + " > td")[17].innerText = $("#unit_prices").val() * $("#qty").val();
            $("#tr-" + id + " > td")[18].innerText = Volume($("#height").val(),$("#width").val(),$("#depth").val(),$("#qty").val());;
            $("#tr-" + id + " > td")[19].innerText = $("#description").val();
            $("#tr-" + id + " > td")[20].innerText = $("#notes").val();
            $("#modal-item").modal("hide");
        }
    }
    
    

    function Create() {
        $(".tittle-item").text("Agregar Item");
        $(".form-group").removeClass("has-error");
        $(".input-row").val("");
        $("#add").show();
        $("#update").hide();
        $("#modal-item").modal("show");
    }

    function SelectFile() {
        $("#load_form").modal("hide");
        if ($(".seleccionado").length > 0) {
            $(".loader_ajax2").text("Cargando Archivo...");
            $.post("<?= base_url() ?>Imos/Acknow/C_Import/Readfile", {folder: $(".seleccionado").text(),dir:$(".seleccionado").attr("rel"), option: 'load'}, function (data) {
                if (data.msg == "OK") {
                    $("#detalle").html("");
                    if (data.error != "") {
                        swal({title: 'Error!', text: 'Error de datos en la celda(' + data.error + ')', type: 'error'});
                    } else {
                        $.each(data.info, function (e, i) {
                            $("#" + e).val(i);
                        });
                        $("#detalle").html(data.detail);
                        CretateTableTab('table_detail', 0);
                        $("#table_detail_filter").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-info btn-sm " onclick="Create()"><i class="fa  fa-plus-circle"></i> Agregar</button></label>');
                        item = data.item;
                    }
                } else {
                    swal({title: 'Error!', text: data.msg, type: 'error'});
                }
            }, 'json').fail(function (error) {
                if (error.status == 200) {
//                    RedirectLogin();
                } else {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        } else {
            $("#btn-imp").attr("disabled", true);
            swal({title: 'Error!', text: "Debe Seleccionar Un pedido", type: 'error'});
        }
    }
    
    function SAck(op){
        if ($("#order").val() != "") {

            var formData = new FormData();

            for (var i = 1; i < document.forms.length; i++) {
                var form = document.forms[i];
                if (form.id == "formInfo" || form.id == "formStyle") {
                    var data = new FormData(form);
                    var formValues = data.entries();
                    while (!(ent = formValues.next()).done) {
                        formData.append(`${ent.value[0]}`, ent.value[1])
                    }
                }
            }

            var array_body = [];
            $("#table_detail tbody tr").each(function () {
                var array_body_hijo = [];
                $(this).find("td").each(function () {
                    if ($(this).children().length > 0) {
                        array_body_hijo.push($(this).children().eq(0).val());
                    } else {
                        array_body_hijo.push($(this).text());
                    }
                });
                array_body.push(array_body_hijo);
            });

            formData.append("order", $("#order").val());

            var json_arr = JSON.stringify(array_body);
            formData.append("detail", json_arr);
            formData.append("import", (op == 'import') ? 1 : 0);

            $.ajax({
                url: "<?= base_url() ?>Imos/Acknow/C_Import/SaveAck",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $("#formInfo")[0].reset();
                        $("#formStyle")[0].reset();
                        $("#order").val("");
                        $("#detalle").html(obj.detail);
                        var msg = (op == 'import')?"Ack Importado Con Exito!":"Ack Creado Con Exito!";
                        swal({title: 'Exito!', text: msg, type: 'success'});
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                global: true,
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                if (error.status == 200) {
                    RedirectLogin();
                } else {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        } else {
            if (op == 'import') {
                swal({title: 'Error', text: "Debe seleccionar un Ack valido!", type: 'error'});
            } else {
                swal({title: 'Error', text: "Debe digitar un codigo de Order valido!", type: 'error'});
            }
        }
    }
    
    function SAck_update(op,data_salesline){
        if ($("#order").val() != "") {

            var formData = new FormData();

            for (var i = 1; i < document.forms.length; i++) {
                var form = document.forms[i];
                if (form.id == "formInfo" || form.id == "formStyle") {
                    var data = new FormData(form);
                    var formValues = data.entries();
                    while (!(ent = formValues.next()).done) {
                        formData.append(`${ent.value[0]}`, ent.value[1])
                    }
                }
            }

            var array_body = [];
            $("#table_detail tbody tr").each(function () {
                var array_body_hijo = [];
                $(this).find("td").each(function () {
                    if ($(this).children().length > 0) {
                        array_body_hijo.push($(this).children().eq(0).val());
                    } else {
                        array_body_hijo.push($(this).text());
                    }
                });
                array_body.push(array_body_hijo);
            });

            formData.append("order", $("#order").val());

            var json_arr = JSON.stringify(array_body);
            formData.append("detail", json_arr);
            formData.append("import", (op == 'import') ? 1 : 0);
            console.log(data_salesline);
            formData.append("data_salesline", data_salesline);

            $.ajax({
                url: "<?= base_url() ?>Imos/Acknow/C_Import/UpdateAck",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        $("#formInfo")[0].reset();
                        $("#formStyle")[0].reset();
                        $("#order").val("");
                        $("#detalle").html(obj.detail);
                        var msg = (op == 'import')?"Ack Importado Con Exito!":"Ack Creado Con Exito!";
                        swal({title: 'Exito!', text: msg, type: 'success'});
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                global: true,
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                if (error.status == 200) {
                    RedirectLogin();
                } else {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        } else {
            if (op == 'import') {
                swal({title: 'Error', text: "Debe seleccionar un Ack valido!", type: 'error'});
            } else {
                swal({title: 'Error', text: "Debe digitar un codigo de Order valido!", type: 'error'});
            }
        }
    }

    function SaveAck() {
        if ($("#order").val() != "") {
            var formData = new FormData();

            for (var i = 1; i < document.forms.length; i++) {
                var form = document.forms[i];
                if (form.id == "formInfo" || form.id == "formStyle") {
                    var data = new FormData(form);
                    var formValues = data.entries();
                    while (!(ent = formValues.next()).done) {
                        formData.append(`${ent.value[0]}`, ent.value[1])
                    }
                }
            }

            var array_body = [];
            $("#table_detail tbody tr").each(function () {
                var array_body_hijo = [];
                $(this).find("td").each(function () {
                    if ($(this).children().length > 0) {
                        array_body_hijo.push($(this).children().eq(0).val());
                    } else {
                        array_body_hijo.push($(this).text());
                    }
                });
                array_body.push(array_body_hijo);
            });

            formData.append("order", $("#order").val());

            var json_arr = JSON.stringify(array_body);
            formData.append("detail", json_arr);
            
            $.ajax({
                url: "<?= base_url() ?>Imos/Acknow/C_Import/vali_saveack",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.rs == "true"){
                        swal({
                            title: 'Atención',
                            text: "La order ya se encuentra registrada, quiere actualizar los datos?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si'
                        }).then((result) => {
                            if (result) {
                                SAck_update(SAck,obj.data);
                            } 
                        });
                    }else{
                        SAck(SAck);
                    }
                },
                global: true,
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                if (error.status == 200) {
                    RedirectLogin();
                } else {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        }else{
            if (op == 'import') {
                swal({title: 'Error', text: "Debe seleccionar un Ack valido!", type: 'error'});
            } else {
                swal({title: 'Error', text: "Debe digitar un codigo de Order valido!", type: 'error'});
            }
        }
    }
    
    function DeleteItems(id){
        swal({
            title: 'Esta seguro de eliminar este Item?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $('#tr-'+id).remove();
            }
        }).catch(swal.noop)
    }
</script>