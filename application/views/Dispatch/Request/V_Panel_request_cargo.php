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
            <div class="modal-body" id="modal-add">
                <?= $content_modal?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        
    });

    function modal_add(){
        $("#modal-add").modal("show");
    }

    function type_truck(){
        var array_id = [];
        var chk = document.querySelectorAll("#remissions");
        chk.forEach(function(element){
            if(element.checked == true){
                array_id.push(element.value);
            }
        });
        var id_request_sd = $("#driver").val();
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/data_truck", {array_id:array_id}, function (data) {
           $("#type_truck").val(data[0].description);
           $("#license_plate").val(data[0].license_plate);
           $("#start_time").val(data[0].start_time);
           $("#end_time").val(data[0].end_time);

        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
</script>