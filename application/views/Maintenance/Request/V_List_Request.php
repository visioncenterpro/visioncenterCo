<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Solicitudes De Mantenimiento</h3>

            </div>
            <div class="box-body">
                <div class="col-md-12" id="content-table">
                    <?= $table ?>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        CreateTable(); 
    });

    function OpenRequest(id) {
        window.open('<?= base_url(); ?>Maintenance/Request/C_Request/InfoRequestMmto/' + id, '_blank');
    }

    function CreateTable() {
        $('#table_request').DataTable({
            "order": [[0, "desc"]],
            'paging': false,
            "scrollY": "500px",
            "scrollCollapse": true,
            "language": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
            }
        });
    }

    function Delete(id_request) {
        swal({
            title: 'Esta seguro de eliminar la solicitud ' + id_request + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Maintenance/Request/C_Request/DeleteRequest", {id_request: id_request}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                            $("#content-table").html(data.tabla);
                            CreateTable();
                        });
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });

            }
        }).catch(swal.noop)
    }

</script>