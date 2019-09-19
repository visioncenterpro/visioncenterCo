<div class="content-wrapper">
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Solicitud De Mantenimiento</h1>
                    </div>
                    <div class="box-body">
                        <form id="form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select class="form-control select2  " id="type" name="type" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="ShowInputs(this.value)">
                                            <option value="MAQUINA" selected="selected">Maquina</option>
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
                                <div class="col-md-3 local" style="display: none">
                                    <div class="form-group">
                                        <label>Daño</label>
                                        <select class="form-control select2 " style="width: 100%;" id="type_damage" name="type_damage" onchange="ShowWhich()">
                                            <option value="">. . .</option>
                                            <?php foreach ($damage as $m) : ?>
                                                <option value="<?= $m->id_type_damage ?>"><?= $m->description ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
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
                                <div class="col-md-3 maquina ">
                                    <div class="form-group">
                                        <label>Entrega De Maquina Inmediato</label>
                                        <input type="checkbox" class="minimal" checked id="chk" name="chk"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Motivo</label>
                                        <textarea class="form-control" rows="3" placeholder="Motivo ..."  name="reason" id="reason"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right" onclick="CreateSolicitud()">Crear Solicitud <i class="fa fa-fw fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        $('.select2').select2();
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        })

    });

    function CreateSolicitud() {
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
            formData.append("check", check);
            $.ajax({
                url: "<?= base_url() ?>Maintenance/Request/C_Request/CreateRequest",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido creado.",
                            type: 'success'
                        }).then((result) => {
                            $("#form")[0].reset();
                            $(".select2").val("").trigger('change');
                        });
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