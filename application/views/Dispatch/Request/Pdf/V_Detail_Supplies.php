<table cellpadding="3" style="page-break-inside:avoid;  width:100%; font-size: 7pt; margin-top: 15px;">
    <tr style="background-color: #e4e4e4;">
        <th style="text-align: center" colspan="5">INSUMOS</th>
    </tr>
    <tr style="background-color: #e4e4e4;">
        <th style="text-align: center">Descripcion</th>
        <th style="text-align: center">Paquete</th>
        <th style="text-align: center">Cantidad</th>
        <th style="text-align: center">Peso Total</th>
    </tr>
    <tbody>
        <?php 
        $Tpacks = 0;
        $Tweight = 0;
        foreach ($detail as $key => $v) : ?>
            <tr>
                <td>
                    <?php foreach ($supplies[$key] as $vs) {
                        //echo $v->id_order_package ."-". $vs->access_order_package_supplies." ";
                        if($v->id_order_package == $vs->access_order_package_supplies){
                            echo $vs->code." - ".$vs->name."<br>";
                        }
                        $Tweight += $vs->quantity_packaged * $vs->weight_per_supplies;
                    } ?>
                </td>
                <td style="text-align: center"><?= $v->pack ?></td>
                <td style="text-align: center"><?= $v->quantity_packets ?></td>
                <td style="text-align: right"><?= round($v->weight,6) ?></td>
            </tr>
        <?php 
            $Tpacks += $v->quantity_packets;
        endforeach; ?>
        <tr>
            <td colspan="2" style="text-align: center">TOTAL</td>
            <td style="text-align: center" class="total-packs"><?= $Tpacks ?></td>
            <td style="text-align: right" ><?= round($Tweight,6) ?></td>
        </tr>
    </tbody>
</table>