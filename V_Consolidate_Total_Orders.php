<table cellpadding="3" style="width:100%; font-size: 7pt; margin-top: 5px;">
    <tr>
        <th colspan="5">
            <div style="text-align: center"><h1>CONSOLIDADO TOTAL DE MATERIALES</h1></div>
        </th>
    </tr>
    <tr style="background-color: #e4e4e4;">
        <th style="text-align: center">NO&deg;</th>
        <th style="text-align: center">CODIGO AX</th>
        <th style="text-align: center">DESCRIPCIÓN AX</th>
        <th style="text-align: center">CANTIDAD</th>
        <th style="text-align: center">UNIDAD</th>
    </tr>
    <?php 
        for($i=0; $i < count($data); $i++){ 
        if($i > 0){ ?>
            <th colspan="5">
                <div style="text-align: center"><h1></h1></div>
            </th>
        <?php } ?>
            <tr> 
                <td colspan="5" style="text-align:center;background-color: #e4e4e4;">ORDER <?= $orders[$i] ?></td>
            </tr>
    <?php
            echo $data[$i]['tbody'];
        }
    ?>
    
</table>