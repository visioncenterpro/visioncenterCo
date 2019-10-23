<?php for ($i = 1; $i <= $quantity_packets; $i++) { ?>
    <div class="col-md-6">
        <table cellpadding="3" width="100%" style="font-size: 7pt;">
            <tr>
                <td colspan="5" style="text-align: center;font-size: 14px; background-color:cornflowerblue ">  (<?=$quantity_packets?>) UND &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PAQUETE NUMERO <?=$start?></td>
                <td rowspan="3" width="4%" class="qr" code="<?=$ItemQr?>" id="qr-<?=$ItemQr?>"></td>
            </tr>
            <tr>
                <td colspan="2">PEDIDO <?=$type?>-<?=$order?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBRA:&nbsp; <?=$project?>&nbsp;&nbsp;&nbsp;&nbsp;
                    ETIQUETA N&deg; :&nbsp; <?=$ticket?> &nbsp;(<?=$count?>)
                </td>
            </tr>
            <tr>
                <td>PAQUETE : <?=$start?>&nbsp;&nbsp; DE &nbsp;&nbsp; <?php foreach ($end as $value) { echo $value->total;}?> &nbsp;&nbsp;</td>
                <td style="width: 90px">VERSION:&nbsp;&nbsp; 01</td>
            </tr>
        </table>
        <br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">
    </div>
<?php } ?>

