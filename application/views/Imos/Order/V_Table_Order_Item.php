<table id="table_items" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Item</th>
            <th>Código Item</th>
            <th>Alto</th>
            <th>Ancho</th>
            <th>Profundo</th>
            <th>Peso</th>
            <th>Cantidad</th>
            <th style="text-align:center">Img</th>
            <th style="min-width:50px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $item = 1;
            foreach ($items as $t) : 
            $name = (!empty($t->INFO1)?$t->INFO1:(!empty($t->INFO2)?$t->INFO2:(!empty($t->INFO3)?$t->INFO3:$t->CPID)));  
            $item = ($t->GRPPOS >= $item)?$t->GRPPOS:$item;

        ?>
            <tr>
                <!--Si CPID es igual a PN se debe concatenar CPID.DEPTH -->
                <td><?= $t->GRPPOS ?></td>
                <td><?=($name == 'PN') ? $t->CPID.$t->DEPTH : $name ?></td>
                <td><?= $t->HEIGHT ?><input type="hidden" id="height_h" value="<?= $t->HEIGHT ?>"></td>
                <td><?= $t->WIDTH ?><input type="hidden" id="width_h" value="<?= $t->WIDTH ?>"></td>
                <td><?= $t->DEPTH ?><input type="hidden" id="depth_h" value="<?= $t->DEPTH ?>"></td>
                <td><?= ROUND($t->WEIGHT,2) ?><input type="hidden" id="weight_h" value="<?= ROUND($t->WEIGHT,2) ?>"></td>
                <td>1</td>
                <td style="text-align:center"><img src="<?=SERVER_IMOS?>/<?= $t->ORDERID ?>/<?= $t->ID ?>_<?= $t->CPID ?>/PERSP.png" onerror="this.src = '<?= base_url("dist/img/Warning.png") ?>'; this.style='width:20px'; " style="max-width: 40px;"></td>
                <td>
                    <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="ShowDetailsItem(<?= $t->ID ?>,'<?= $t->ORDERID ?>','<?= $t->CPID ?>','<?= $id ?>','<?=(!empty($t->INFO1)?$t->INFO1:(!empty($t->INFO2)?$t->INFO2:(!empty($t->INFO3)?$t->INFO3:$t->CPID)))  ?>','<?= $t->HEIGHT ?>x<?= $t->WIDTH ?>x<?= $t->DEPTH ?>','<?= $t->POSSTR ?>')"><i class="fa fa-search"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php foreach ($itemsAdd as $t) :  
            $item++;
            ?>
            <tr id="tr-<?= $t->id_salesline ?>">
                <td><?=str_pad($item, 3, "0", STR_PAD_LEFT)?></td>
                <td id="code-<?= $t->id_salesline ?>"><?= $t->code ?></td>
                <td id="height-<?= $t->id_salesline ?>"><?= $t->height ?></td>
                <td id="width-<?= $t->id_salesline ?>"><?= $t->width ?></td>
                <td id="depth-<?= $t->id_salesline ?>"><?= $t->depth ?></td>
                <td id="weight-<?= $t->id_salesline ?>"><?= $t->weight ?></td>
                <td id="qty-<?= $t->id_salesline ?>"><?= $t->qty ?></td>
                <td></td>
                <td>
                    <button type="button"  class="btn btn-primary btn-xs btn-tabla" onclick="OpenModalDetailsItem(<?= $t->id_salesline ?>,'<?= $t->type ?>')"><i class="fa fa-edit"></i></button>
                    <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteDetailsItem(<?= $t->id_salesline ?>)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<input type="hidden" id="max-item" value="<?=str_pad($item, 3, "0", STR_PAD_LEFT)?>">