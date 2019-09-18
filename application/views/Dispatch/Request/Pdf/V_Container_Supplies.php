<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <thead>
        <tr>
            <th colspan="6" style="text-align:center" class="bg-info">INSUMOS</th>
        </tr>
        <tr style="background-color: #e4e4e4;">
            <th style="width:88px;text-align:center">Pedido</th>
            <th style="text-align:center">Insumo</th>
            <th style="width:88px;text-align:center">Paquete</th>
            <th style="width:88px;text-align:center">Cantidad</th>
            <th style="width:88px;text-align:center">Peso Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($content as $t) : ?>
            <tr id="str-cont-<?= $t->id_order_package ?>">
                <td style="text-align:center"><?= $t->order ?></td>
                <td style="text-align:center"><?= $t->name ?></td>
                <td style="text-align:center"><?= $t->pack ?></td>
                <td style="text-align:center" id="scont-quantity-<?= $t->id_order_package ?>"><?= $t->quantity_packets ?></td>
                <td style="text-align:center" id="scont-weight-<?= $t->id_order_package ?>"><?= round($t->weight, 6) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>