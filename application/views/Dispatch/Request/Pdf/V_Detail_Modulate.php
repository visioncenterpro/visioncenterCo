<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <tbody>
        <tr>
            <td width="29%" style="text-align: center;">DESCRIPCIÓN</td>
            <td width="10%" style="text-align: center">PAQUETE</td>
            <td width="9%" style="text-align: center">CANT TOTAL</td>
            <td width="4%" style="text-align: center;">PESO TOTAL</td> 
        </tr>
        <?=$detail?>
        <tr nobr="true">
            <td style="border-color: #000; border:none"></td>
            <td style="text-align:center;">TOTAL</td>
            <td style="text-align:center;"j class="total-packs" rowspan="2"><?=$total['Tpacks']?></td>
            <td style="text-align:right;"><?=round($total['Tweight'],6)?></td>    
        </tr>
        <tr nobr="true">
            <td style="border-color: #000; border:none"></td>
            <td style="text-align:center;">PESO INTEGRAL</td>
            <td style="text-align:right;" class="total-integral"><b><?=round(($total['Tweight'] * PORCENT_WEIGHT) + $total['Tweight'],6)?> Kg</b></td>    
        </tr>
    </tbody>
</table>

<!--<br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">-->