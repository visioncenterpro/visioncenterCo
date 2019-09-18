<table cellpadding="4" style="font-size:7pt;" width="100%">
    <tr>
        <td colspan="17" style="text-align: center;"><b>INSUMOS A ENTREGAR</b></td>
    </tr>
    <tr>
        <td colspan="2" width="34%" style="text-align: center">INSUMO</td>
        <td colspan="3" width="18%" style="text-align: center">CANTIDAD SOLICITADA</td>
        <td colspan="12" width="48%" style="text-align: center">PARCIALES</td>
    </tr>
    <tr>
        <td width="5%" style="text-align: center;">CODIGO</td>
        <td width="29%" style="text-align: center;">DESCRIPCIÓN</td>
        <td width="6%" style="text-align: center;">PAQUETES</td>
        <td width="6%"style="text-align: center;">U/P</td>
        <td width="6%" style="text-align: center;">UNIDADES</td>
        <?php
        for ($index = 1; $index <= 12; $index++) : ?>
            <td width="4%" style="text-align: center;"><?=$index?></td>
        <?php endfor; ?>
    </tr>
    <?php 
    $total = 0;
    foreach ($packs['data'] as $t) :
    $total += $t->quantity_packets;    
    ?>
        
    <tr>
        <td><?=$t->code?></td>
        <td><?=$t->name?></td>
        <td style="text-align: center"><?=$t->quantity_packets." ".$t->pack?></td>
        <td style="text-align: center"><?=$t->quantity_per_package?></td>
        <td style="text-align: center"><?=$t->quantity_supplies?></td>
        <?=str_repeat('<td></td>', 12);?>
    </tr>
    
    <?php  endforeach; ?>
    <tr>
    <br><br>
    <td colspan="2">TOTAL PAQUETES</td>
    <td style="text-align: center;"><?=$total?></td>
</tr>
</table>
<br />
<table  cellpadding="4" style="text-align: center; font-size:7pt;" nobr="true" width="100%">
    <tr>
        <td colspan="1" width="52%" rowspan="4"></td>
        <td colspan="24" width="48%">PARCIALES</td>
    </tr>
    <tr>
        <?php
        for ($index = 1; $index <= 12; $index++) : ?>
            <td width="4%" colspan="2"><?=$index?></td>
        <?php endfor; ?>
    </tr>
    <tr>
        <?=str_repeat('<td width="4%" colspan="2">FECHA</td>', 12);?>
    </tr>
    <tr style="color: #A4A4A4;">
        <?=str_repeat('<td width="2%">D<br>I<br>G<br>I<br>T<br>Ó<br><br>E<br>N<br><br>B<br>A<br>S<br>E</td><td width="2%">E<br>N<br>T<br>R<br>E<br>G<br>Ó</td>', 12);?>
    </tr>
</table>