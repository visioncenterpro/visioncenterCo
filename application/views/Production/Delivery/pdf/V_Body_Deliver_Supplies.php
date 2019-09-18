<table cellpadding="4" style="font-size: 7px;" width="100%" id="tabla">
    <tr>
        <td colspan="29" style="text-align: center;"><b>INSUMOS A DESPACHO</b></td>
    </tr>
    <tr>
        <td colspan="2" width="19%" style="font-size: 8px; text-align: center;">INSUMO</td>
        <td colspan="2" width="9%" style="font-size: 8px; text-align: center;">CANTIDAD SOLICITADA</td>
        <td colspan="24" width="72%" style="font-size: 8px; text-align: center;">ENTREGA N°</td>
    </tr>
    <tr>
        <td rowspan="2" width="3%" style="font-size: 8px; text-align: center; vertical-align: bottom">CODIGO</td>
        <td rowspan="2" width="16%" style="font-size: 8px; text-align: center; vertical-align: bottom"><br><br>DESCRIPCIÓN</td>
        <td rowspan="2" style="font-size: 8px; text-align: center; vertical-align: bottom"><br><br>T/U</td>
        <td rowspan="2" width="3%" style="font-size: 8px; text-align: center; vertical-align: bottom"><br><br>C/I</td>
        
<!--        <td rowspan="2" width="3%" style="font-size: 8px; text-align: center; vertical-align: bottom"><br><br>UND</td>
        <td rowspan="2" width="3%" style="font-size: 8px; text-align: center; vertical-align: bottom"><br><br>C/I</td>-->
        <?php for ($i=1; $i <= 9; $i++) : ?>
            <td width="3%" style="text-align: center;vertical-align: bottom">PAQ</td>
            <td width="3%" style="border-right: 2px solid #212121;text-align: center;vertical-align: bottom">UND</td>
        <?php endfor; ?>
    </tr>
    <tr>
        <?=$deliver[0]?>
    </tr>
    <?=$deliver[1]?>
    <tr>
        <td colspan="2" style="font-size: 8px; "><center>TOTAL UNIDADES PAQUETES</center></td>
        <td style="text-align: center; font-size: 8pt;"><?=$deliver['packs']?></td>
        <td style="border: none;" colspan="1"></td>
        <?php  for($j = 1 ; $j <=9; $j++ ): ?>
            <td class="colL_<?= $j ?>" style="text-align: center;"></td>
            <td class="colR_<?= $j ?>" style="text-align: center;"></td>
        <?php endfor;?>
    </tr>
</table>