<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-sign-in"></i> Confirmar Entrega</h3>
            </div>
            <div class="box-body">
                <div class="row" >
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">Tipo Entrega</label>
                            <select class="form-control input-sm required" id="type" onchange="Filtrar()">
                                <option value="">. . .</option>
                                <?php foreach ($type as $v) : ?>
                                    <option value="<?= $v->view ?>"><?= $v->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type">Número</label>
                            <input type="number" class="form-control input-sm required" id="id_delivery" name="number" onchange="Filtrar()">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="content">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        LoadTable();
    });


    function Filtrar() {
        $('#table_delivery').DataTable().destroy();
        $('#table_delivery > tbody').remove();
        LoadTable();
    }

    function LoadTable() {

        var type = $("#type").val();
        var id_delivery = $("#id_delivery").val();

        if (id_delivery == "") {
            id_delivery = "all";
        }
        if (type == "") {
            type = "all";
        }


        var oTable = $('#table_delivery').dataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "scrollY": "380px",
            "lengthChange": false,
            "searching": false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                "url": "<?= base_url() ?>Dispatch/Delivery/C_Delivery_Dispatch/ListarDelivery/" + id_delivery + '/' + type,
                "dataSrc": "datos"
            },
            "language": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            }, columnDefs: [
                //{  className: "text-center td-estado", targets: [0,7], width:'20px' },
                //{  className: "text-center", targets: [4,5] }
            ],
        });
    }

</script>