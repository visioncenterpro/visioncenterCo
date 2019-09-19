<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <thead>
        <tr>
            <th colspan="8" style="text-align:center" class="bg-info">TOTALES</th>
        </tr>
    </thead> 
    <tbody>
        <tr nobr="true">
            <td style="text-align:center;">PAQUETES</td>
            <td style="text-align:right;" class="total-paq"><b><?= $head->num_packets ?></b></td> 
            <td style="text-align:center;">PESO MODULADO</td>
            <td style="text-align:right;" class="total"><b><?= round($head->total_weight_modulate, 6) ?> Kg</b></td> 
            <td style="text-align:center;">PESO INSUMOS</td>
            <td style="text-align:right;" class="total"><b><?= round($head->total_weight_supplies, 6) ?> Kg</b></td> 
            <td style="text-align:center;">PESO INTEGRAL</td>
            <td style="text-align:right;" class="total-integral"><b><?= round(($head->total_weight_modulate + ($head->total_weight_modulate * PORCENT_WEIGHT))+$head->total_weight_supplies, 6) ?> Kg</b></td>    
        </tr>
    </tbody>
</table>
