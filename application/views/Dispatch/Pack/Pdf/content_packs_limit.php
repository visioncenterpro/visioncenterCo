<div class="row" style="page-break-inside: avoid;"> 
    <?php for ($i = 1; $i <= $quantity_packets; $i++) { ?>
        <div class="col-md-6">
            <table cellpadding="3" width="100%" style="font-size: 7pt;">
                <tr>
                    <!--<td rowspan="3" width="4%"><img src="<?=URL_IMAGE.$this->session->company?>" width="140px" height="60px" /></td>-->
                    <td colspan="5" style="text-align: center;font-size: 14px; background-color:<?=$color?> "><?=$forniture?>  (<?=$quantity_packets?>) UND &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PAQUETE NUMERO <?=$ItemQr?></td>
                    <td rowspan="2" width="4%" class="qr" code="<?=$ItemQr?>-<?=$i?>-M" id="qr-<?=$ItemQr?>"></td>
                </tr>
                <tr>
                    <td colspan="2">PEDIDO <?=$type?>-<?=$order?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBRA:&nbsp; <?=$project?>&nbsp;&nbsp;&nbsp;&nbsp;
                        ETIQUETA N&deg; :&nbsp; <?=$ticket?> &nbsp;(<?=$count?>)
                    </td>
                </tr>
                <tr>
                    <td>PAQUETE : <?=$i?>&nbsp;&nbsp; DE &nbsp;&nbsp; <?=$quantity_packets?> &nbsp;&nbsp; <?=$pack->description?></td>
                    <td colspan="4" style="width: 90px">VERSION:&nbsp;&nbsp; 01</td>
                    <td rowspan="2" style="width: 90px; text-align: center;"><?=$ItemQr?>-<?=$i?>-M</td>
                </tr>
            </table>
            <br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">
        </div>
    <?php } ?>
</div>


