<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> Panel</h3>
            </div>
            <div class="box-body" >
                <div class="row" id="indicators">
                    <?= $indicators ?>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header ">

            </div>
            <div class="box-body" >
                <div class="row">
                    <?= $subindicators ?>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-create">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Ausentismo Total</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form_aus" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepickerAuse" name="datepickerAuse">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Operario</label>
                                <select class="form-control" id="operarioaus" name="operarioaus">
                                    <option value="">. . .</option>
                                    <?php foreach ($person as $r) : ?>
                                        <option value="<?= $r->id_abs_employee ?>"><?= $r->operario ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observacion</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." id="textobsaus" name="textobsaus"></textarea>
                            </div>
                        </div>
                    </div>
                </form>      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success pull-right" data-dismiss="modal" onclick="registrarnov()"><i class="fa  fa-user-plus"></i> Registar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-create-nov">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Ausentismo Parciales</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form_nov" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepickerNov" name="datepickerNov">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Operario</label>
                                <select class="form-control" id="operarionov" name="operarionov">
                                    <option value="">. . .</option>
                                    <?php foreach ($person as $r) : ?>
                                        <option value="<?= $r->id_abs_employee ?>"><?= $r->operario ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>  
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Hora Inicio</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="timestar" name="timestar">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Hora Fin</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="timeend" name="timeend">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observacion</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." id="textobsnov" name="textobsnov"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning pull-right" data-dismiss="modal" onclick="registraraus()"><i class="fa  fa-user-plus"></i> Registar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaldetalle">
    <div class="modal-dialog modal-sm" >
        <div class="modal-content">
            <div class="modal-header bg-default">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle Programacion</h4>
            </div>
            <div class="modal-body" id="modal-prog">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#datepickerAuse").val("");
        $("#operarioaus").val("");
        $("#textobsaus").val("");
        $("#textobsaus").val("");

        $('.timepicker').timepicker({
            showInputs: false,
            maxHours: 24,
            showSeconds: false,
            showMeridian: false
        })


        //datepicker
        $('#datepickerAuse').datepicker({

            todayBtn: "linked",
            language: "it",
            autoclose: false,
            todayHighlight: false,
            dateFormat: 'dd/mm/yyyy'
        });
        //datepicker
        $('#datepickerNov').datepicker({

            todayBtn: "linked",
            language: "it",
            autoclose: false,
            todayHighlight: false,
            dateFormat: 'dd/mm/yyyy'
        });
        $("#addAbs").click(function () {
            $("#operarioaus").val("");
            $("#modal-create").modal("show");
        });

        $(function () {
            $("#addAbs-nov").click(function () {
                $("#operarionov").val("");
                $("#modal-create-nov").modal("show");
            });
        });
    })

    function OpenModal(id_area) {

        $.post("<?= base_url() ?>Absenteeism/Panel/C_Panel/LoadDetailProg", {id_area: id_area}, function (data) {
            $("#modal-prog").html(data.table);
            $("#modaldetalle").modal("show");
        }, 'json').fail(function (error) {
            if (error.status == 200) {
                // RedirectLogin();
            } else {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }

    function registrarnov() {

        var datepickerAuse = $("#datepickerAuse").val();
        var operarioaus = $("#operarioaus").val();

        if (datepickerAuse == "") {
            alertify.error('Campo Fecha Vacio');
            return false;
        }
        if (operarioaus == "") {
            alertify.error('Campo Operario Vacio');
            return false;

        }
        var formData = new FormData($('#form_aus')[0]);
        $.ajax({
            url: "<?= base_url() ?>Absenteeism/Panel/C_Panel/Createabsent",
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({
                        title: 'Operacion Exitosa!',
                        text: "Registro Creado.",
                        type: 'success'

                    });
                    $("#indicators").html(obj.ind)


                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
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

    }

    function registraraus() {
        var timestar = $("#timestar").val();
        var timeend = $("#timeend").val();
        var datepickerNov = $("#datepickerNov").val();
        var operarionov = $("#operarionov").val();

        if ( timeend < timestar ) {
            alertify.error('La Hora Final debe ser Mayor a la Hora Inical');
            return false;

        }
        if (datepickerNov == "") {
            alertify.error('Campo Fecha Vacio');
            return false;
        }
        if (operarionov == "") {
            alertify.error('Campo Operario Vacio');
            return false;

        }
        var formData = new FormData($('#form_nov')[0]);
        $.ajax({
            url: "<?= base_url() ?>Absenteeism/Panel/C_Panel/Createnovelty",
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({
                        title: 'Operacion Exitosa!',
                        text: "Registro Creado.",
                        type: 'success'
                    });
                    $("#indicators").html(obj.ind)
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
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

    }

</script>