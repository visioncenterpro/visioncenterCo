<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <tbody>
        <tr>
            <th colspan="6" style="text-align:center" class="bg-info">MODULADO</th>
        </tr>
        <tr style="background-color: #e4e4e4;">
            <td style="width:88px;text-align: center;">PEDIDO</td>
            <td style="text-align: center">MUEBLE</td>
            <td style="width:88px;text-align: center">PAQUETE</td>
            <td style="width:88px;text-align: center;">CANTIDAD</td> 
            <td style="width:88px;text-align: center;">PESO TOTAL</td> 
        </tr>
       <?php foreach ($content as $t) : ?>
                <tr id="tr-cont-<?= $t->id_order_package ?>">
                    <td style="text-align:center"><?= $t->order ?></td>
                    <td style="text-align:center"><?= $t->name ?></td>
                    <td style="text-align:center"><?= $t->pack ?></td>
                    <td style="text-align:center" id="cont-quantity-<?= $t->id_order_package ?>"><?= $t->quantity_packets ?></td>
                    <td style="text-align:center" id="cont-weight-<?= $t->id_order_package ?>"><?= round($t->weight, 6) ?></td>
                </tr>
            <?php endforeach; ?>
        
    </tbody>
</table>