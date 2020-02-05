<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                <i class="fa fa-balance-scale"></i> Solicitudes autorización peso
                </div>
            </div>
            <div class="box-body">
                <table id="table_request" class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align:center">Solicitud despacho</th>
                            <th style="text-align:center">Tipo Vehiculo</th>
                            <th style="text-align:center">Peso max vehiculo (kg)</th>
                            <th style="text-align:center">Peso Total Solicitud (kg) </th>
                            <th style="text-align:center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($request as $d) : ?>
                            <tr>
                                <td style="text-align:center"><?= $d->id_request_sd ?></td>
                                <td style="text-align:center"><?= $d->vehicle ?></td>
                                <td style="text-align:center"><?= $d->weight_veh ?></td>
                                <td style="text-align:center"><?= $d->weightI ?></td>
                                <td><button class="btn btn-block btn-primary btn-xs" onclick="modal_request_weight('<?= $d->id_request_weight ?>')"><span class="fa fa-eye" aria-hidden="true"></span></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_request_weight">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle solicitud</h4>
            </div>
            <div class="modal-body" id="content_request_weight">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" onclick="response(false)">Rechazar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="response(true)">Aprobar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#table_request").DataTable();
    });

    function modal_request_weight(id_request_weight){
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/data_request_weight", {id_request_weight:id_request_weight}, function (data) {
            $("#content_request_weight").html(data.content);
            $("#modal_request_weight").modal("show");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function response(response){
        var id_request_weight = $("#id_request_weight").val();
        var observation = $("#observation").val();
        $.post("<?= base_url() ?>Dispatch/C_Dispatch/response_request_weight", {id_request_weight:id_request_weight,response:response,observation:observation}, function (data) {
            swal({title: '', text: '', type: 'success'});
            $("#modal_request_weight").modal("hide");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
</script>