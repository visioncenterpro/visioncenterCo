<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-truck "></i> Relación control de cargue </h3>
                <button class="btn btn-primary" onclick="generate_report(<?=$id_request_cargo?>)"><span class="fa fa-file" aria-hidden="true"></span> Generar Reporte</button>
                <button class="btn btn-default" onclick="back()"><span class="fa fa-backward" aria-hidden="true"></span> atras</button>
            </div>
            <div class="box-body">
                <div id="content1">
                    <?=$content1?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observación</label>
                            <textarea class="form-control" id="observation"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="content">
                    <?=$content?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#dispatch_r").DataTable();
        $("#dispatch_all").DataTable();
        $(".inp").hide();
    });

    function edit(){
        if($("#type").val() == "1"){
            $("#type").val("2");
        }else{
            $("#type").val("1");
        }
        $(".selc").toggle();
        $(".inp").toggle();
    }

    function AddRemission(id_request_cargo,id_remission,id_request_sd){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/create_request_cargo", {id_request_cargo:id_request_cargo,id_remission:id_remission,id_request_sd:id_request_sd}, function (data) {
            swal({title: '', text: '', type: 'success'});
            data_view(id_request_cargo);
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function AddAll(id_request_cargo){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/create_request_cargo_all", {id_request_cargo:id_request_cargo}, function (data) {
            swal({title: '', text: '', type: 'success'});
            data_view(id_request_cargo);
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function delete_remission(id_request_cargue_detail,id_remission,id_request_sd){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/delete_request_cargo", {id_request_cargue_detail:id_request_cargue_detail,id_remission:id_remission,id_request_sd:id_request_sd}, function (data) {
            swal({title: '', text: '', type: 'success'});
            data_view(<?=$id_request_cargo?>);
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function DeleteAll(id_request_cargo){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/delete_request_cargo_all", {id_request_cargo:id_request_cargo}, function (data) {
            swal({title: '', text: '', type: 'success'});
            data_view(id_request_cargo);
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function data_view(id_request_cargo){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/data_table_cargo_detail", {id_request_cargo:id_request_cargo}, function (data) {
            $("#content").html(data.content);
            $("#content1").html(data.content1);
            $("#dispatch_r").DataTable();
            $("#dispatch_all").DataTable();
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function generate_report(id_request_cargo){
        if(($("#driver").val() == 0 && $("#driver").val() == "") || ($("#license_plate").val() == "" || $("#license_plate").val() == "Pendiente")){
            swal({title: 'Atención', text: 'Ingrese todos los campos al formulario', type: 'error'});
        }else{
            if($("#type").val() == "1"){
                var e = document.getElementById("driver");
                var driver = e.options[e.selectedIndex].text;
            }else{
                var driver = $(".inp").val();
            }
            
            var license_plate = $("#license_plate").val();
            var observation = $("#observation").val();
            var type_vehicle = $("#type_vehicle").val();
            $.post("<?= base_url() ?>Dispatch/C_Dispatch/validate_request_cargo", {id_request_cargo:id_request_cargo,driver:driver,license_plate:license_plate,observation:observation,type_vehicle:type_vehicle}, function (data) {
                if (data.length > 0) {
                    var a = document.createElement('a');
                    a.href = '<?= base_url() ?>Dispatch/C_Dispatch/request_cargo/<?=$id_request_cargo?>';
                    a.setAttribute('target', '_blank');
                    a.click();  
                    data_view(id_request_cargo);
                }else{
                    swal({title: 'Atención', text: 'No hay datos para generar el reporte', type: 'error'});
                }
                
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function license_plate(){
        var id_request_sd = $("#driver").val();
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/data_driver", {id_request_sd:id_request_sd}, function (data) {
            $("#license_plate").val(data.license_plate);
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function pdf_requisition(id_remission,id_request_sd){
        var a = document.createElement('a');
        a.href = "<?= base_url() ?>Dispatch/C_Dispatch/PdfRequisition/"+id_remission+"/"+id_request_sd;
        a.setAttribute('target', '_blank');
        a.click();
    }

    function back(){
        window.location = "<?= base_url() ?>Dispatch/C_Dispatch/request_cargo_form";
    }

</script>