<table class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align:center">Código</th>
            <th style="text-align:center">Insumo</th>
            <th style="text-align:center">Paquete</th>
            <th style="text-align:center">Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $request_sd_detail = 0;
        $order = 0;
         foreach ($data as $d) :
            $request_sd_detail = $d->id_request_detail;
            $order = $d->order ?>
            <tr>
                <td style="text-align:center"><?= $d->code ?></td>
                <td style="text-align:center"><?= $d->name ?></td>
                <td style="text-align:center"><?= $d->number_pack ." Ppal" ?></td>
                <td style="text-align:center"><?= $d->quantity_packets ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <label>Observación</label>
    <textarea class="form-control" id="observation"></textarea>
    <input type="hidden" id="type" value="<?= $type ?>">
    <input type="hidden" id="request_sd_detail" value="<?= $request_sd_detail ?>">
    <input type="hidden" id="order_gs" value="<?= $order ?>" >
</div>