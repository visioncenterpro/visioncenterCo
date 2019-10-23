<table  cellpadding="4" width="100%" style=" font-size: 7pt; ">
    <tr>
        <td style="border: none;"><b>PAQUETE No:<?= $number_pack ?></b></td>
        <td  colspan="6" style="text-align: right;  border: none;"><b>CANTIDAD DE PAQUETES: <?= $quantity_packets ?></b></td>
    </tr>
</table>

<table cellpadding="4" style="font-size: 7pt; " width="100%" >
    <tr>
        <td style="text-align: center" width="20%">REFERENCIA</td>
        <td style="text-align: center" width="46%">MATERIAL - CALIBRE</td>
        <td style="text-align: center" width="7%">LARGO</td>
        <td style="text-align: center" width="7%">ANCHO</td>
        <td style="text-align: center" width="10%">MOD/PAQ</td>
        <td style="text-align: center" width="10%">TOTAL MOD</td>
        <td style="text-align: center" width="10%">PESO</td>
    </tr>

    <?php
    $weight = 0;
    foreach ($detail as $v) : ?>
        <tr>
            <td width="20%"><?= $v->piece ?></td>
            <td style="text-align: center" width="46%"><?= $v->description ?></td>
            <td style="text-align: center" width="7%"><?= $v->longF ?></td>
            <td style="text-align: center" width="7%"><?= $v->widthF ?></td>
            <td style="text-align: center" width="10%"><?= $v->quantity_pieces ?></td>
            <td style="text-align: center" width="10%"><?= $v->quantity_pieces * $quantity_packets ?></td>
            <td style="text-align: center" width="10%"><?= round($v->weight, 2) ?></td>
        </tr>
        <?php
        $weight += $v->weight;
    endforeach;
    ?>
    <tr>
        <td colspan="6" style="text-align: right">Peso (<?= $quantity_packets ?> Paquetes)</td>
        <td style="text-align: center" width="10%"><?= round($weight, 2) ?></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: right">Total Peso (<?=PORCENT_WEIGHT * 100?>%)</td>
        <td style="text-align: center" width="10%"><?= round($weight + ($weight * PORCENT_WEIGHT), 2) ?></td>
    </tr>
</table>
<br />
