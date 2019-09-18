<br />
<table  cellpadding="3"  width="100%" style="font-size: 6pt; page-break-inside:avoid;">
    <tr>
        <td colspan="2" width="47%" style="text-align: center;">MUEBLE</td>
        <td colspan="16" width="53%" style="text-align: center">PARCIALES</td>
    </tr>
    <tr>
        <td width="3%" style="text-align: center">No.</td>
        <td width="29%" style="text-align: center;">DESCRIPCIÓN</td>
        <td width="10%" style="text-align: center" colspan="2">PAQUETE</td>
        <td width="5%" style="text-align: center">CANT</td>
        <td width="4%" style="text-align: center">01</td>
        <td width="4%" style="text-align: center">02</td>
        <td width="4%" style="text-align: center">03</td>
        <td width="4%" style="text-align: center">04</td>
        <td width="4%" style="text-align: center">05</td>
        <td width="4%" style="text-align: center">06</td>
        <td width="4%" style="text-align: center">07</td>
        <td width="4%" style="text-align: center">08</td>
        <td width="4%" style="text-align: center">09</td>
        <td width="4%" style="text-align: center">10</td>
        <td width="4%" style="text-align: center">11</td>
        <td width="4%" style="text-align: center">12</td>
        <td width="5%" style="text-align: center">TOTAL</td>
    </tr>
    <?php 
    $sw = false;

    foreach ($packages as $paq) : ?>
        <tr nobr="true">
        <?php if(!$sw): ?>
            <td rowspan ="1" style="text-align:center;"><?=$item?></td>
            <td rowspan ="1" style="text-align:center;background-color:<?=$colorPdf?>"><?=$name?></td>
            <?php $sw = true; ?>
        <?php else: ?>
            <td style="border-color: #000; border:none"></td>
            <td style="border-color: #000; border:none"></td>
        <?php endif; ?>
        
        <td  style="text-align:center;"><?=$paq->number_pack?></td>
        <td  style="text-align:center;"><?=$paq->code?></td>
        <td class="qty" style="text-align:center;"><?=$paq->quantity_packets?></td>
        
        <?=str_repeat("<td  style='text-align:center;'></td>", 13);?>
        
        
    <?php endforeach; ?>
</table>