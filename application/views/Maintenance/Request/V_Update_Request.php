<?php
$dLoc = "<option value=''>. . .<option>";
foreach ($damageLoc as $m) :
    $dLoc .= "<option value='" . $m->id_type_damage . "'>" . $m->description . "</option>";
endforeach;
$dMac = "<option value=''>. . .<option>";
foreach ($damageMac as $m) :
    $dMac .= "<option value='" . $m->id_type_damage . "'>" . $m->description . "</option>";
endforeach;
?>


<div class="content-wrapper">
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Solicitud De Mantenimiento N&deg; <span class="username"><a><?= $record->id_request ?></a></span></h1>
                    </div>
                    <div class="box-body">
                        <form id="form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha De Creación</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" disabled id="creation_date" name="creation_date" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 maquina">
                                    <div class="form-group">
                                        <label>Entrega De Maquina</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right " disabled id="delivery_date_machine" name="delivery_date_machine">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Inicio De Mantenimiento</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right " disabled id="start_maintenance" name="start_maintenance">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fin De Mantenimiento</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right " disabled id="end_maintenance" name="end_maintenance">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 maquina">
                                    <div class="form-group">
                                        <label>Entrega De Maquina Inmediato</label>
                                        <input type="checkbox" class="minimal" checked id="chk" name="chk"> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select class="form-control select2  " id="type" name="type" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="ShowInputs(this.value)">
                                            <option value="" >. . .</option>
                                            <option value="MAQUINA" >Maquina</option>
                                            <option value="LOCATIVO">Locativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 maquina">
                                    <div class="form-group">
                                        <label>Maquinas</label>
                                        <select class="form-control select2 " style="width: 100%;" id="maquina" name="maquina" onchange="SelectArea()">
                                            <option value="">. . .</option>
                                            <?php foreach ($maquinas as $m) : ?>
                                                <option value="<?= $m->id_machine ?>" area="<?= $m->area ?>"><?= $m->description . " (" . $m->model . ")" ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 local">
                                    <div class="form-group">
                                        <label>Daño</label>
                                        <select class="form-control select2 " style="width: 100%;" id="type_damage" name="type_damage" onchange="ShowWhich()">
                                            <option value="">. . .</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Area</label>
                                        <select class="form-control select2 " style="width: 100%;" id="area" name="area">
                                            <option value="">. . .</option>
                                            <?php foreach ($area as $m) : ?>
                                                <option value="<?= $m->id_pro_area ?>"><?= $m->description ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 which" style="display: none">
                                    <div class="form-group">
                                        <label>Cual</label>
                                        <input type="text" class="form-control" id="which" name="which">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Asignado a:</label>
                                        <select class="form-control select2 " multiple="multiple" style="width: 100%;" id="assigned" name="assigned">
                                            <?php foreach ($aux as $m) : ?>
                                                <option value="<?= $m->id_users ?>"><?= $m->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Motivo</label>
                                        <textarea class="form-control" rows="3" placeholder="..."  name="reason" id="reason"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Descripcion De El Daño</label>
                                        <textarea class="form-control" rows="3" placeholder="..."  name="description_damage" id="description_damage"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Procedimiento</label>
                                        <textarea class="form-control" rows="3" placeholder="..."  name="process" id="process"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="button" id="update" class="btn btn-default btnProcess" onclick="UpdateSolicitud()">Actualizar Solicitud <i class="fa fa-fw fa-save"></i></button>
                        <button type="button" id="start" class="btn btn-default btnProcess" style="display:none" onclick="StartSolicitud(1)">Iniciar Mantenimiento <i class="fa fa-clock-o"></i></button>
                        <button type="button" id="end" class="btn btn-default btnProcess" style="display:none" onclick="StartSolicitud(2)">Finalizar Mantenimiento <i class="fa fa-clock-o"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {

<?php if (isset($record)): ?>

            $("#type").val("<?= $record->type_request ?>");
            $("#area").val("<?= $record->area ?>");
            $("#reason").val("<?= $record->reason ?>");
            $("#creation_date").val("<?= $record->creation_date ?>");
            $("#start_maintenance").val("<?= $record->start_maintenance ?>");
            $("#end_maintenance").val("<?= $record->end_maintenance ?>");
            $("#description_damage").val("<?= $record->description_damage ?>");
            $("#process").val("<?= $record->process ?>");


            var values = '<?= $record->assigned ?>';
            if (values != '') {
                $.each(values.split(","), function (i, e) {
                    $("#assigned option[value='" + e + "']").attr("selected", "selected");
                    $("#assigned").trigger("change");
                });
            }
            
    <?php if ($record->type_request == "MAQUINA"): ?>
                $("#maquina").val("<?= $record->machine ?>");
                $(".maquina").show();
                $("#type_damage").html("<?= $dMac ?>");
                $("#delivery_date_machine").val("<?= $record->delivery_date_machine ?>");
    <?php else: ?>
                $(".maquina").hide();
                $("#type_damage").html("<?= $dLoc ?>");
    <?php endif; ?>

    <?php if (empty($record->delivery_date_machine)): ?>
                $("#chk").attr("checked", false);
    <?php else: ?>
                $("#chk").attr("checked", true);
                $("#chk").prop("disabled", true)
    <?php endif; ?>
            $("#type_damage").val("<?= (empty($record->type_damage)) ? "" : $record->type_damage ?>");
<?php endif; ?>

        $('.select2').select2();
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        }).on('ifChecked', function (event) {
            UpdateDateMachine();
        });

        showbtn();
    });

    function UpdateDateMachine() {
        swal({
            title: 'Confirma la entrega de la maquina',
            text: "La entrega es irreversible!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Maintenance/Request/C_Request/UpdateFieldRequest", {campo: "delivery_date_machine", "id_request":<?= $record->id_request ?>, "type_request":$("#type").val(),"machine":$("#maquina").val()}, function (data) {
                    $("#delivery_date_machine").val(data.res);
                    $("#chk").prop("disabled", true);
                    showbtn();
                }, 'json');
            }
        }).catch(function () {
            $('#chk').iCheck('uncheck');
        })
    }

    function StartSolicitud(op) {
        error = false;
        if (op == 1) {
            if ($("#type").val() == "MAQUINA" && ($("#delivery_date_machine").val() == "" || $("#assigned").val() == "" || $("#assigned").val() == null)) {
                error = true;
                swal({title: 'Error!', text: '1) Asignar Solicitud 2) Entregar La Maquina', type: 'error'});
            } else if ($("#type").val() == "LOCATIVO" && $("#assigned").val() == "") {
                error = true;
                swal({title: 'Error!', text: '1) Asignar Solicitud', type: 'error'});
            }

            if (!error) {
                $.post("<?= base_url() ?>Maintenance/Request/C_Request/UpdateFieldRequest", {campo: "start_maintenance", "id_request":<?= $record->id_request ?>, "type_request":$("#type").val(),"machine":$("#maquina").val()}, function (data) {
                    $("#start_maintenance").val(data.res);
                    showbtn();
                    swal('Operacion Exitosa!','La solicitud fue iniciada!','success');
                }, 'json');
            }

        } else {
            if ($("#start_maintenance").val() != "") {
                if($("#type_damage").val() == ""){
                    swal({title: 'Error!', text: 'Selecciona un Daño', type: 'error'});
                }else if($("#area").val() == ""){
                    swal({title: 'Error!', text: 'Selecciona una area', type: 'error'});
                }else{
                    $.post("<?= base_url() ?>Maintenance/Request/C_Request/UpdateFieldRequest", {type_damage:$("#type_damage").val(),area:$("#area").val(),reason:$("#reason").val(),description_damage:$("#description_damage").val(),process:$("#process").val(),campo: "end_maintenance", "id_request":<?= $record->id_request ?>,"type_request":$("#type").val(),"machine":$("#maquina").val()}, function (data) {
                        $("#end_maintenance").val(data.res);
                        showbtn();
                        swal('Operacion Exitosa!','La solicitud fue finalizada!','success');
                    }, 'json');
                }
            }
        }


    }

    function showbtn() {
        if ($("#type").val() == "MAQUINA") {
            if ($("#delivery_date_machine").val() != "" && $("#assigned").val() != "") {
                if ($("#start_maintenance").val() != "") {
                    $("#end").show();
                    $("#start").hide();
                } else {
                    $("#start").show();
                    $("#end").hide();
                }
            } else {
                $("#start").hide();
            }
        } else if ($("#type").val() == "LOCATIVO") {
            if ($("#assigned").val() != "") {
                if ($("#start_maintenance").val() != "") {
                    $("#end").show();
                    $("#start").hide();
                } else {
                    $("#start").show();
                    $("#end").hide();
                }
            } else {
                $("#start").hide();
            }
        }
        if($("#end_maintenance").val() != ""){
            $(".btnProcess").hide();
        }
        if($("#start_maintenance").val() != ""){
            $("#type").attr("disabled",true).trigger('update');
            $("#maquina").attr("disabled",true).trigger('update');
        }
    }

    function UpdateSolicitud() {
        var error = false;

        var check = ($("#chk").is(":checked")) ? 1 : 0;

        if ($("#type").val() == "MAQUINA") {
            ValidateInput("maquina");
            if ($("#maquina").val() == "") {
                error = true;
            }
        } else {
            ValidateInput("type_damage");
            if ($("#type_damage").val() == "") {
                error = true;
            } else {
                if ($("#type_damage").val() == 14) {
                    ValidateInput("which");
                    if ($("#which").val() == "") {
                        error = true;
                    }
                }
            }
        }
        ValidateInput("reason");
        if ($("#reason").val() == "") {
            error = true;
        }
        ValidateInput("area");
        if ($("#area").val() == "") {
            error = true;
        }

        if (!error) {
            var formData = new FormData($('#form')[0]);
            formData.append("id_request", <?= $record->id_request ?>);
            formData.append("check", check);
            formData.append("maquina", $("#maquina").val());
            formData.append("type", $("#type").val());
            var asig = "";
            if ($("#assigned").val() != null) {
                var asig = $("#assigned").val();
            }
            formData.append("asig", asig);
            $.ajax({
                url: "<?= base_url() ?>Maintenance/Request/C_Request/UpdateRequest",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido actualizado.",
                            type: 'success'
                        });

                        showbtn();
                    } else if (obj.res == "STARTED") {
                        swal({title: 'Error!', text: 'No es posible una actualizacion para una solicitud iniciada', type: 'error'});
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                if(error.status == 200){
                    RedirectLogin();
                }else{
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        }
    }

    function ShowInputs(tipo) {
        $(".which").hide();
        $("#maquina").val("").trigger('change');
        ;
        $("#type_damage").val("").trigger('change');
        ;
        $("#which").val("").trigger('change');
        ;
        switch (tipo) {
            case "MAQUINA":
                $(".local").hide();
                $(".maquina").show();
                break;
            case "LOCATIVO":
                $(".maquina").hide();
                $(".local").show();
                break;
            default:
                break;
        }
    }

    function ShowWhich() { //otros cual?
        var sel = $("#type_damage option:selected ").text();
        $("#which").val("");
        $(".which").hide();
        if (sel == "OTRO") {
            $(".which").show();
        }
        $("#area").val("").trigger('change');
    }

    function SelectArea() {
        var area = $("#maquina option:selected ").attr("area");
        $("#area").val(area).trigger('change');
    }
</script>