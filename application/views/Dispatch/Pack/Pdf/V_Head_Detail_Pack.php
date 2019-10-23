<?php if($new){?>
<script src="<?=base_url()?>dist/jquery/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/JsBarcode/dist/jquery.qrcode.min.js"></script>
<?php } ?>
<style>
body {
  height: 21cm;
  width: 25cm;
    /* to centre page on screen*/
    margin-left: auto;
    margin-right: auto;
    margin:auto;
     font-family: sans-serif;
}
table {
  border-collapse: collapse;
  border:none;
}
table td, table th {
  border: 1px solid black;
}

  @media print {
    body {
        height: 21.59cm;
        width: 27.94cm;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
        margin:auto;
         font-family: sans-serif;
    }

    tr {
      page-break-inside:avoid; page-break-after:auto
    }
  }
</style>

<table  cellpadding="3" width="100%" style="font-size: 10pt; page-break-inside:avoid;">
 <tr>
    <td rowspan="3" width="4%"><img src="<?=URL_IMAGE.$this->session->company?>" width="140px" height="60px" /></td>
    <td colspan="5" style="text-align: center;font-size: 14px; background-color:<?=$color?> "><?=$forniture?>  (<?=$quantity_packets?>) UND &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PAQUETE NUMERO <?=$ItemQr?></td>
    <td rowspan="2" width="4%" class="qr" code="<?=$ItemQr?>-<?=$ticket?>-M" id="qr-<?=$ItemQr?>"></td>
 </tr>
 <tr>
    <!--<td colspan="2">CLIENTE:&nbsp;&nbsp; <?=$client?></td>-->
    <td colspan="2">CLIENTE:&nbsp;&nbsp; <?=$client?>;PAQUETE :<?=$start?> DE <?=$pack->end?>;ETIQUETA N <?=$ticket?></td>
    <td>OBRA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=$project?></td>
    <td colspan="2">PEDIDO <?=$type?>-<?=$order?></td>
 </tr>
 <tr>
    <td style="width: 100px">FECHA <?=date("Y-m-d")?></td>
    <td>CODIGO:&nbsp;&nbsp; F PRO 01 10</td>
    <td>ETIQUETA N&deg; :&nbsp;&nbsp;&nbsp; <?=$ticket?> &nbsp;&nbsp;&nbsp;(<?=$count?>)</td>
    <td>PAQUETE : <?=$start?>&nbsp;&nbsp; DE &nbsp;&nbsp; <?=$pack->end?> &nbsp;&nbsp; <?=$pack->description?></td>
    <td style="width: 90px">VERSION:&nbsp;&nbsp; 01</td>
    <td style="width: 45px; text-align: center;"><?=$ItemQr?>-<?=$ticket?>-M</td>
 </tr>
</table><br />
