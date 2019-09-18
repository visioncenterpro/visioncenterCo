<table cellpadding="3" style="width:100%; font-size: 7pt; margin-top: 5px;">
    <tr>
        <th colspan="5">
            <?php if (isset($data['consolidado'])): ?>
            <div style="text-align: center"><h1>CONSOLIDADO TOTAL DE MATERIALES</h1></div>
            <?php else: ?>
                <table style="width:100%; font-size: 9pt; margin-top: 5px;text-align: center;">
                    <tr>
                        <th  style="width:18%" >Nombre Del Articulo</th><td ><?= $info['article'] ?></td>
                        <td  style="width:15%"><b>N&deg; Pos</b></td><td style="width:10%"><?= $info['position'] ?></td>
                        <td  style="width:15%"><b>Medidas</b></td><td  style="width:18%"><?= $info['med'] ?></td>
                    </tr>
                </table>
            <?php endif; ?>
        </th>
    </tr>
    <tr style="background-color: #e4e4e4;">
        <th style="text-align: center">NO&deg;</th>
        <th style="text-align: center">CODIGO AX</th>
        <th style="text-align: center">DESCRIPCIÓN AX</th>
        <th style="text-align: center">CANTIDAD</th>
        <th style="text-align: center">UNIDAD</th>
    </tr>
    <?= $data['tbody']; ?>
    
</table>