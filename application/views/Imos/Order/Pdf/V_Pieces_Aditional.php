<?php if (count($AdAditional) > 0 ) { ?>
    <table cellpadding="3" style="width:100%; font-size: 7pt; margin-top: 5px;">
        <tr>
            <th colspan="11" style="text-align: center">PIEZAS ADICIONALES</th>
        </tr>
        <tr style="background-color: #e4e4e4;">
            <th style="text-align: center">CODIGO</th>
            <th style="text-align: center">TIPO</th>
            <th style="text-align: center">CANTIDAD</th>
            <th style="text-align: center">ACABADO</th>
            <th style="text-align: center">LAMINA</th>
            <th style="text-align: center;">CANTO</th>
            <th style="text-align: center">ALTO</th>
            <th style="text-align: center">ANCHO</th>
            <th style="text-align: center">CALIBRE</th>
            <th style="text-align: center">PESO</th>
            <th style="text-align: center">AREA</th>
        </tr>
        <?php foreach ($AdAditional as $t) : ?>
                <tr>
                    <td style="text-align: center"><?=$t->code?></td>
                    <td><?=$t->name?></td>
                    <td style="text-align: center"><?=$t->qty?></td>
                    <td style="text-align: center"><?=$t->finished?></td>
                    <td style="text-align: center"><?=$t->code_sheet_ax?></td>
                    <td style="text-align: center">1:<?=$t->a1?><br />1:<?=$t->l1?><br />1:<?=$t->a2?><br />1:<?=$t->a2?></td>
                    <td style="text-align: center"><?=$t->height?></td>
                    <td style="text-align: center"><?=$t->width?></td>
                    <td style="text-align: center"><?=$t->caliber?></td>
                    <td style="text-align: center"><?=$t->weight?></td>
                    <td style="text-align: center"><?= number_format($t->area,2,'.',',')?></td>
                </tr>
            
        <?php  if(!empty($t->comments)){ ?>
                <tr>
                <td colspan="11">Comentarios : <?=$t->comments?></td>
                </tr>
        <?php } endforeach; ?>
    </table>
<?php }?>
<br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">
<div class='salto_pagina' style='page-break-inside:avoid; page-break-after: always;'></div>
