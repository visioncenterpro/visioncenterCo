<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th style="text-align:center">Pedido</th>
            <th style="text-align:center">Mueble</th>
            <th style="text-align:center">Paquete</th>
            <th style="text-align:center">Cantidad</th>
            <th style="text-align:center">Peso total (kg)</th>
            <th style="text-align:center">Tipo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $d) : ?>
            <tr>
                <td style="text-align:center"><?= $d->order ?></td>
                <td style="text-align:center"><?= $d->name ?></td>
                <td style="text-align:center"><?= $d->pack ?></td>
                <td style="text-align:center"><?= $d->quantity_packets ?></td>
                <td style="text-align:center"><?= $d->weight ?></td>
                <td style="text-align:center"><?= $d->type ?><input type="hidden" id="id_request_weight" value="<?= $d->id_request_weight?>" /> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-group">
    <label>Observación</label>
    <textarea class="form-control" id="observation"></textarea>
</div>