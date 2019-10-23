<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-truck "></i> Solicitudes De Despacho Pendientes</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
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
<div class="modal fade" id="modal-dispatch">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ordenes relacionadas al pedido # <label id="request"></label></h4>
            </div>
            <div class="modal-body" id="modal-weight">
                <table id="myTable" class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Cliente</th>
                            <th>Proyecto</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        TableData("table_request", true, false, false);
        $("#table_request_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="CreateRequestSD()"><i class="fa  fa-plus-circle"></i> Crear Solicitud SD</button></label>');
    });
    function CreateRequestSD() {
        swal({
            title: 'Confirma creacion de la solictud?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result) {
                var order = $("#order").val();
                $.post("<?= base_url() ?>Dispatch/C_Dispatch/CreateRequestSD", {}, function (data) {
                    if (data.res == "OK") {
                        window.location.href = "<?= base_url() ?>Dispatch/C_Dispatch/InfoRequestDispatchSD/" + data.id;
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function info(id_request){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/get_data_remission", {id_request:id_request}, function (data) {
            document.getElementById('request').innerText = id_request;
            $("#myTable").DataTable({
                    data:data,
                    columns: [
                        { data: 'order' },
                        { data: 'client' },
                        { data: 'project' }
                    ],
                    destroy: true // para evitar errores al volver a llamar la función
                });
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
        $("#modal-dispatch").modal("show");
    }

</script>