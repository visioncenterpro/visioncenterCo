<script src="<?=base_url()?>dist/jquery/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/JsBarcode/dist/jquery.qrcode.min.js"></script>
<style>
    @media print
    {
        body {
            font-family: sans-serif;


        }
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    }
    @page{
        /*//size: auto;   /* auto is the initial value */
        height: 27.9cm;
        width: 21.6cm;
        /* this affects the margin in the printer settings */
        margin: 1mm 1mm 1mm 1mm;
    }
    .tags {
        font-size: 9pt;
        height: 5cm;
        /*height: 3.3cm;*/
        /*width: 7cm;*/ 
        width: 15cm; 
        margin: 1mm 1mm 1mm 1mm;
        /*font-size: 9px;*/
    }
    body {
        font-family: sans-serif;
        margin: 1mm 1mm 1mm 1mm;

    }
</style>
<?php foreach ($packs as $t) :?>
    <table border="1" cellpadding="3" class="tags">
        <tr>
            <td><b>MILESTONE</b></td>
            <td style="text-align: center;"><b>Pedido: <?=$t->order?></b></td>
            <td rowspan="4" width="27%" class="qr" 
                code="Pedido:<?=str_pad($t->order, 25, " ", STR_PAD_RIGHT)+ord(95)?>
                
                Insumo:<?=str_pad($t->supplies, 25, " ", STR_PAD_RIGHT)+ord(95)?>
                Cantidad:<?=round($t->quantity,2)?>">
            </td>
        </tr>
        <tr>
            <td colspan="2"><?=$t->client?></td>
        </tr>
        <tr>
            <td colspan="2"><?=$t->project?></td>
        </tr>
        <tr>
            <td><b>Code: <?=$t->code?></b></td>
            <td style="font-size:8pt;"><b>Cant: <?=round($t->quantity,2)?></b></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;"><?=$t->supplies?></td>
        </tr>
    </table>
<?php endforeach; ?>
<script>
$(function(){
    $(".qr").each(function () {
        var code = $(this).attr("code");
        jQuery($(this)).qrcode({
		text	: code,
                 width:145,
                height:145,
	});
    });
}) ;   
</script>