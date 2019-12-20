<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-truck "></i> Remisiones</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" onclick="modal_add()">Agregar Datos</button>
                        </div>
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-add">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Datos</h4>
            </div>
            <div class="modal-body" id="modal-add-content">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="report()">Generar Reporte</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#table_request").DataTable();
        $("#add_license").hide();
    });

    function allF(){
        var chk = document.querySelectorAll("#remissions");
        chk.forEach(function(element){
            if (element.checked == false) {
                element.checked = true;
            }else{
                element.checked = false;
            }
        });
    }

    function modal_add(){

        var array_id = [];
        var chk = document.querySelectorAll("#remissions");
        chk.forEach(function(element){
            if(element.checked == true){
                array_id.push(element.value);
            }
        });

        if (array_id.length == 0) {
            swal({title: 'Error', text: 'Escoga una solicitud', type: 'error'});
        }else{
            $.post("<?= base_url() ?>Dispatch/C_Dispatch/modal_add_data", {array_id:array_id}, function (data) {
               //console.log(data);
               $("#modal-add-content").html(data.content_modal);
               $("#modal-add").modal("show");
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function type_truck(){
        var id_request_sd = $("#driver").val();
        var text = $( "#myselect option:selected" ).text();
        if(text == "Pendiente"){
            $("#add_license").show();
        }
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/data_truck", {id_request_sd:id_request_sd}, function (data) {
            console.log(data);
            $("#type_truck").val(data[0].description);
            $("#license_plate").val(data[0].license_plate);
            $("#start_time").val(data[0].start_time);
            $("#end_time").val(data[0].end_time);
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function report(){ // reporte control cargue
        var array_id = [];
        var chk = document.querySelectorAll("#remissions");
        chk.forEach(function(element){
            if(element.checked == true){
                array_id.push(element.value);
            }
        });
        var observation = $("#observation").val();
        var id_data_header = $("#driver").val();
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/create_request_cargo", {id_data_header:id_data_header,observation:observation,array_id:array_id}, function (data) {
            console.log(data);
            var a = document.createElement('a');
            a.href = '<?= base_url() ?>Dispatch/C_Dispatch/request_cargo/'+data.id;
            a.setAttribute('target', '_blank');
            a.click();
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

</script>