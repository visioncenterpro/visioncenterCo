<div class="row" style="page-break-inside: avoid;"> 
    <div class="col-md-6">
        <table cellpadding="3" width="100%" style="font-size: 7pt;">
            <thead>
                <tr>
                    <td style="text-align: center;font-size: 120%;">Referencia</td>
                    <td style="text-align: center;font-size: 120%;">Nombre</td>
                    <td style="text-align: center;font-size: 120%;width: 8%;">Tipo</td>
                    <td style="text-align: center;font-size: 120%;width: 8%;">Cantidad</td>
                    <td style="text-align: center;font-size: 120%;width: 8%;">Peso total</td>
                    <td style="text-align: center;font-size: 120%;width: 8%;">Peso UNT</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                $totalw = 0;
                foreach ($detail as $val) {
                $total = $total + $val->quantity_packaged;
                $totalw = $totalw + ($val->weight_per_supplies * $val->quantity_packaged);
                ?>
                <tr>
                    <td style="text-align:center;"><?=$val->code?></td>
                    <td style="text-align:center;"><?=$val->name?></td>
                    <td style="text-align:center;"><?=$val->description?></td>
                    <td style="text-align:center;"><?=$val->quantity_packaged?></td>
                    <td style="text-align:center;"><?=$val->weight_per_supplies * $val->quantity_packaged?></td>
                    <td style="text-align:center;"><?=$val->weight_per_supplies?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td style="text-align:center;" colspan="3">CANTIDAD TOTAL INSUMOS : </td>
                    <td style="text-align:center;"><?=$total?></td>
                    <td style="text-align:center;"><?=$totalw?></td>
                </tr>
            </tbody>
        </table>
        <br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">
    </div>
</div>