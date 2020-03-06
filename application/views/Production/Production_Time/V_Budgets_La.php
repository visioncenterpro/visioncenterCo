<style>
    .ppto{display: none;}
    .bpptocreate{display: none;}
    .bpptoupdate{display: none;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-clock-o"></i> Parametros para Presupuestos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right bpptocreate" onclick="recorder()">Grabar Presupuesto <i class="fa fa-fw fa-save"></i></button> 
                        <button type="button" class="btn btn-default pull-right bpptoupdate" onclick="update()">Actualizar Presupuesto <i class="fa fa-fw fa-refresh"></i></button> 
                    </div>        
                    <div class="col-md-12" >
                        <!-- general form elements -->
                        <div class="box box-primary" >
                            <form role="form" id="form" name="form">                                
                                <div class="col-md-12 table-wrapper-scroll-y" >
                                    <div class="col-xs-2 ">
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right required"  onchange="day_open()"id="datepicker" name="datepicker">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label>Dias Habiles</label>
                                            <input type="text" class="form-control required" id="business_days" name="business_days" placeholder="Dia Habiles" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">                                            
                                            <label>Presupuesto Laminas Entregadas</label>
                                            <input type="text" class="form-control " Value="Laminas Entregadas" disabled placeholder="Laminas Entregadas">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Laminas Entregadas</label>
                                                <input type="text" class="form-control required"  id="sheets" name="sheets" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">                                            
                                            <label>Presupuesto Corte</label>
                                            <input type="text" class="form-control " Value="Corte" disabled id="pptocorte" name="pptocorte"placeholder="Ppto Corte">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Laminas Mes</label>
                                                <input type="text" class="form-control required"  id="ppto_v_corte" name="ppto_v_corte" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">
                                            <label>Presupuesto Enchape</label>
                                            <input type="text" class="form-control " Value="Enchape" disabled id="pptoenchape" placeholder="Ppto Enchape">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Piezas Mes</label>
                                                <input type="text" class="form-control required"  id="ppto_v_enchape" name="ppto_v_enchape" >
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  
                                <div class="row">
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">
                                            <label>Presupuesto Maquinado</label>
                                            <input type="text" class="form-control " Value="Maquinado" disabled id="pptoenchape" placeholder="Ppto Maquinado">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Maquinado Mes</label>
                                                <input type="text" class="form-control required"  id="ppto_v_maquinado" name="ppto_v_maquinado" >
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  
                                <div class="row">
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">
                                            <label>Presupuesto Rta</label>
                                            <input type="text" class="form-control " Value="Rta" disabled id="pptoenchape" placeholder="Ppto Rta">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Mes</label>
                                                <input type="text" class="form-control required"  id="ppto_v_rta" name="ppto_v_rta" >
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  

                                <div class="row">
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">
                                            <label>Presupuesto Marcos</label>
                                            <input type="text" class="form-control " Value="Marcos" disabled id="pptomarcos" placeholder="Ppto Marcos">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Mes</label>
                                                <input type="text" class="form-control required"  id="ppto_v_marcos" name="ppto_v_marcos" >
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  
                                <div class="row">
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">
                                            <label>Presupuesto Repizas</label>
                                            <input type="text" class="form-control " Value="Repisas" disabled id="pptorepisas" placeholder="Ppto Repisas">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Mes</label>                                            
                                                <input type="text" class="form-control required"  id="ppto_v_repizas" name="ppto_v_repizas" >
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  
                                <div class="row">
                                    <div class="col-md-6 table-wrapper-scroll-y" >
                                        <div class="col-md-4 ppto">
                                            <label>Presupuesto Puertas</label>
                                            <input type="text" class="form-control " Value="Puertas" disabled id="pptopuertas" placeholder="Ppto Puertas">
                                        </div>
                                        <div class="col-md-4 ppto">
                                            <div class="form-group">
                                                <label>Presupuesto Mes</label>
                                                <input type="text" class="form-control required"  id="ppto_v_puertas" name="ppto_v_puertas" >
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  
                            </form>
                        </div>
                    </div>                   

                </div>

            </div>

        </div>
    </section>
</div>

<script>
    $(function () {


        CreateDataTable("table_day_day", false, false, true, true, true);

        //$(".bppto").hide();
        //Initialize Select2 Elements
        $(".select2").select2();


        $('.timepicker').timepicker({
            showInputs: false,
            maxHours: 24,
            showSeconds: false,
            showMeridian: false
        })


        //datepicker
        $('#datepicker').datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"

        })
    })


</script>
<script>
    function valideday() {

        var stoptime = $("#time_stop").val();
        if (stoptime > 60) {
            alertify.error('SUPERA LOS 60 MINUTOS');
            $("#time_stop").focus();
        }
    }

    function recorder() {
        if (validatefield()) {
            var dayOpen = $("#datepicker").val();

               
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        url: "<?= base_url() ?>Production/Production_Time/C_Budgets_La/CreBudgets",
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
                                });
                                $(".ppto").hide();
                                $(".bpptocreate").hide();
                                $("#datepicker").val("");
                                $("#business_days").val("");
                                $("#form")[0].reset();
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
    }



    function day_open() {

        var dayOpen = $("#datepicker").val();

        $.post("<?= base_url() ?>Production/Production_Time/C_Budgets_La/watch_Budgets", {dayOpen: dayOpen}, function (data) {

            alertify.success('DEBE REGISTRAR TODOS LOS CAMPOS HABILIDADOS ');
            if (data.Datos != null) {
                $(".ppto").show();
                $(".bpptoupdate").show();
                $(".bpptocreate").hide();
                $("#business_days").val(data.days);
                $("#sheets").val(data.Datos.budget_sheets_delivered);
                $("#ppto_v_corte").val(data.Datos.budget_sheet_cut);
                $("#ppto_v_enchape").val(data.Datos.budget_sheet_canteo);
                $("#ppto_v_maquinado").val(data.Datos.budget_sheet_machining);
                $("#ppto_v_rta").val(data.Datos.budget_sheet_rta);
                $("#ppto_v_marcos").val(data.Datos.budget_sheet_marcos);
                $("#ppto_v_repizas").val(data.Datos.budget_sheet_shelves);
                $("#ppto_v_puertas").val(data.Datos.budget_sheet_doors);
            } else {

                $(".ppto").show();
                $(".bpptocreate").show();
                $(".bpptoupdate").hide();
                $("#business_days").val(data.days);
                $("#sheets").val("");
                $("#ppto_v_corte").val("");
                $("#ppto_v_enchape").val("");
                $("#ppto_v_maquinado").val("");
                $("#ppto_v_rta").val("");
                $("#ppto_v_marcos").val("");
                $("#ppto_v_repizas").val("");
                $("#ppto_v_puertas").val("");

            }


        }, 'json').fail(function (error) {
            alertify.error('PERIODO REGISTRADO');
            $(".ppto").hide();
            $(".bppto").hide();
            //$("#business_days").val(data.days);
        });

    }

    function update() {
          swal({
            title: 'Esta seguro de Actualizar este dia  '  ,
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Actualizar!'
        }).then((result) => {
            if (result) {
                
                 var formData = new FormData($('#form')[0]);
                    $.ajax({
                        url: "<?= base_url() ?>Production/Production_Time/C_Budgets_La/updateBudgets",
                        type: 'POST',
                        data: formData,
                        async: false,
                        success: function (data) {
                            var obj = jQuery.parseJSON(data);
                            if (obj.res == "OK") {
                                $(".ppto").hide();
                                $(".bpptoupdate").hide();
                                $("#datepicker").val("");
                                $("#business_days").val("");
                                $("#form")[0].reset();
                   
                     swal({
                                    title: 'Operacion Exitosa!',
                                    text: "El registro ha sido creado.",
                                    type: 'success'
                                });

                            } else {
                                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});

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
        }).catch(swal.noop)
    }

</script>
