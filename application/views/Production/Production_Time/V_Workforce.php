<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-clock-o"></i> Tiempos De Producción</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right" onclick="recorder()">Grabar Solicitud <i class="fa fa-fw fa-save"></i></button> 
                    </div> 
                    <form role="form" id="form" name="form">
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Tiempos</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right required"  onchange="registerday()" id="datepicker" name="datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hora</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                    <select class="form-control required"  id="hour" name="hour" onchange="hours()">
                                                        <option id="hour" selected="selected" value="">. . .</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mano de Obra</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-terminal"></i>
                                                    </div>
                                                    <select class="form-control required"  id="manoobra" name="manoobra">
                                                        <option value="">. . .</option>
                                                        <?php foreach ($No_Machine as $r) : ?>
                                                            <option value="<?= $r->id_no_maquine ?>"><?= $r->model ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tipo </label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-terminal"></i>
                                                    </div>
                                                    <select class="form-control required"  id="status" name="status" onchange="tipo()" >
                                                        <option value="">. . .</option>
                                                        <?php foreach ($Estado as $r) : ?>
                                                            <option value="<?= $r->description ?>"><?= $r->description ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>                   
                        <div class="col-md-6">
                            <div class="box box-primary"  style="display:none" id="campos2" name="campos2">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Completar los Campos</h3>
                                </div>

                                <div class="box-body">
                                    <div class="row"> 
                                        <div class="form-group">
                                            <div class="col-xs-2 op1 op2">
                                                <label>Cantidad</label>
                                                <input type="text" class="form-control op1 required" placeholder="Cantidad" id="quantity" name="quantity">
                                            </div>
                                            <div class="col-xs-2 op1">
                                                <label># Personas</label>
                                                <select class="form-control select select-hidden-accessible op1 op2 required" id="people" name="people" >
                                                    <option selected="selected" value="">...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>

                                            <div class="col-xs-6 op2 op3">
                                                <label>Motivo</label>
                                                <select class="form-control select select-hidden-accessible op1 op2" id="reason" name="reason">
                                                    <option value="">. . .</option>
                                                    <?php foreach ($Stop_Machine as $h) : ?>
                                                        <option value="<?= $h->id_reason_stop_machine ?>"><?= $h->description ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-2 op3">
                                                <label>Tiempo Stop</label>
                                                <input type="text" class="form-control op3" placeholder="Tiempo Stop" id="time_stop" name="time_stop">      
                                            </div>
                                        </div>  
                                    </div>
                                </div>


                            </div>

                        </div>

                    </form>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12 regisday"id="content-table">                       

                    </div>
                </div>   




            </div>

        </div>
    </section>
</div>
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        $('.timepicker').timepicker({
            showInputs: false,
            maxHours: 24,
            showSeconds: false,
            showMeridian: false
        })


        //datepicker
        var fecha = new Date();
        var dias = 3; // Número de días a agregar
        fecha.setDate(fecha.getDate() - dias);
        $("#datepicker").datepicker({
            format: "mm/dd/yyyy",
            startDate: fecha
        });
    })


</script>
<script>

    function tipo() {
        var tipo = $("#status").val();
        $("#campos2").show();
        if (tipo == "ACTIVO(A)") {

            $(".op1").show();
            $(".op3").hide();
        }
        if (tipo == "STOP TOTAL") {

            $(".op2").show();
            $(".op3").show();
        }
        if (tipo == "STOP PARCIAL") {

            $(".op1").show();
            $(".op3").show();
            $("#time_stop").val(60).attr("readonly", "readonly");
        }
        alertify.success('DEBE REGISTRAR TODOS LOS CAMPOS');
    }
    function valideday() {

        var stoptime = $("#time_stop").val();
        if (stoptime > 60) {
            alertify.error('SUPERA LOS 60 MINUTOS');
            $("#time_stop").focus();
        }
    }
    function registerday() {
           var dayOpen = $("#datepicker").val();
        $.post("<?= base_url() ?>Production/Production_Time/C_Workforce/date_register", {dayOpen: dayOpen}, function (data) {
            $("#content-table").html(data.table);
             CreateDataTable("table_day_day", false, false, true, true, true);
            $("#hour").html("");
            $.each(data.hour, function (e, i) {
                $("#hour").append("<option value='" + i.hour + "'>" + i.hour + "</option>");
            });
            $(".campos2").show();
            $(".regisday").show();
            alertify.success('REGISTROS DEL DIA');
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function Deleteday(id, day, titulo) {

        swal({
            title: 'Esta seguro de eliminar el el dia  ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Production/Production_Time/C_Workforce/DeleteDay", {id: id, day: day}, function (data) {

                    $("#content-table").html(data.table);
                    CreateDataTable("table_day_day", false, false, true, true, true);

                    alertify.success('REGISTROS DEL DIA ELIMINADO');

                }, 'json').fail(function (error) {
                    if (error.status == 200) {
                        RedirectLogin();
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });

            }
        }).catch(swal.noop)
    }


    function recorder() {
        if (validatefield()) {
            var stoptime = $("#time_stop").val();
            if (stoptime > 60) {
                alertify.error('EL TIEMPO DE STOP SUPERA LOS 60 MINUTOS');
                $("#time_stop").focus();
                document.getElementById("time_stop").selectionStart = 0;
                return;
            }
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?= base_url() ?>Production/Production_Time/C_Workforce/Creaworkforce",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {

                        var dayOpen = $("#datepicker").val();
                        $.post("<?= base_url() ?>Production/Production_Time/C_Workforce/date_register", {dayOpen: dayOpen}, function (data) {
                            $("#content-table").html(data.table);
                            CreateDataTable("table_day_day", false, false, true, true, true);
                            $("#hour").html("");
                            $.each(data.hour, function (e, i) {
                                $("#hour").append("<option value='" + i.hour + "'>" + i.hour + "</option>");
                            });
                           $("#campos2").hide();
                            $(".regisday").show();
                            $("#form")[0].reset();
                            $("#hour").val("");
                            //alertify.success('REGISTROS DEL DIA');
                        }, 'json').fail(function (error) {
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                        });
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido creado.",
                            type: 'success'
                        });
                         

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
        if (!error) {
            alertify.error('DEBE REGISTRAR LOS CAMPOS REQUERIDOS');
        }


    }

</script>
