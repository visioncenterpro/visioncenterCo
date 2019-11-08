<table class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align:center">Pedido</th>
            <th style="text-align:center">Mueble</th>
            <th style="text-align:center">Paquete</th>
            <th style="text-align:center">Cantidad</th>
            <!--<th style="text-align:center;width:15px"></th>-->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $d) : ?>
            <tr>
                <td style="text-align:center"><?= $d->order ?></td>
                <td style="text-align:center"><?= $d->description ?></td>
                <td style="text-align:center"><?= $d->number_pack." ".$d->code ?></td>
                <td style="text-align:center">
                    <input type="number" id="cnt" min="1" max="<?= $d->quantity_packets ?>" value="<?= $d->quantity_packets ?>">
                    <input type="hidden" id="id_order_package" value="<?= $d->id_order_package ?>">
                    <input type="hidden" id="number_pack_back" value="<?= $d->number_pack ?>"> 
                    <input type="hidden" id="order_gp" value="<?= $d->order ?>"> 
                </td>
                <!--<td style="text-align:center">
                    <input type="number" id="cnt" min="1" max="<?= $d->quantity_packets ?>" value="<?= $d->quantity_packets ?>">
                    <input type="hidden" id="id_order_package" value="<?= $d->id_order_package ?>">
                    <input type="hidden" id="number_pack_back" value="<? $d->number_pack ?>">
                </td>-->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <label>Observación</label>
    <textarea class="form-control" id="observation"></textarea>
</div>