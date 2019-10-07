<input type="hidden" value="<?=$order?>" id="order_value">
<div class="form-group">
    <div class="form-inline">
        <div class="form-group">
            <label id="lbl_number_p">N°Paquete <?=$number_pack?></label>
            <input type="hidden" id="package_number_add" value="<?=$number_pack?>">
<!--            <input type="text" class="form-control" id="package_number">-->
        </div>
        <button class="btn btn-primary" onclick="add_supplies()">Guardar</button>
    </div>
</div>
<hr>
<?php if(count($empty_p) > 0){ ?>
<label style="color: #f13e3e; font-size: 140%;"> 
    Los paquetes :
    <?php
        foreach ($empty_p as $value){
            echo " ".$value->number_pack.", ";
        } ?>
    estan vacios !
</label>
 <?php } ?>
<table id="table_manual" class="display table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>DESCRIPCIÓN</th>
            <th>PESO UNIT</th>
            <th>PESO TOTAL</th>
            <th>CANTIDAD EMPACADA</th>
            <th>SELECCIONAR <br><input type="checkbox" onclick="selection_all(this.checked)"> </th>
            <th>SALDO</th>
            <th>NÚMERO A EMPACAR</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //print_r($quantity_packaged);
        $count = 0;
        foreach ($supplies as $s) :
            //if(round($s->exclude) != 1){
            ?>
            <tr>
                
                <input type="hidden" id="id_supplies_add_<?=$count?>" value="<?= $s->id_supplies ?>">
                <input type="hidden" id="id_order_supplies_add_<?=$count?>" value="<?= $s->id_order_supplies ?>">
                <input type="hidden" id="count_add" value="<?= $count ?>">
                <input type="hidden" id="packed_add_<?=$count?>" value="<?=$quantity_packaged[$count]?>">
               
                <td style="text-align: center"><?= $s->code ?></td>
                <td><?= $s->name ?></td>
                <td><?=$s->weight_per_supplies?></td>
                <td id="weight-add-<?=$count?>"><?=$s->weight_per_supplies * $quantity_packaged[$count]?></td>
                <td id="packed-add-<?=$count?>"><?=$quantity_packaged[$count]?></td>
                <td>
                    <?php if(round($s->quantity) - $quantity_packaged[$count] == 0){ ?>
                        <input type="checkbox" id="select_add" disabled="true">
                    <?php }else{ ?>
                        <input type="checkbox" id="select_add">
                    <?php } ?>
                </td>
                <td style="text-align: center" id="sum-add-<?=$count?>"><?=round($s->quantity) - $quantity_packaged[$count]?></td>
                <td>
                    <?php if(round($s->quantity) - $quantity_packaged[$count] == 0){ ?>
                        <input type="number" min="0" max="<?=round($s->quantity) - $quantity_packaged[$count]?>" value="<?=round($s->quantity) - $quantity_packaged[$count]?>" id="quantity_add2" style="width: 100%;" disabled="true" onkeypress="validation_total(event,this,'<?=round($s->quantity) - $quantity_packaged[$count]?>')">
                    <?php }else{ ?>
                        <input type="number" min="0" max="<?=round($s->quantity) - $quantity_packaged[$count]?>" value="<?=round($s->quantity) - $quantity_packaged[$count]?>" id="quantity_add2" style="width: 100%;" onkeypress="validation_total(event,this,'<?=round($s->quantity) - $quantity_packaged[$count]?>')">
                    <?php } ?>
                        <input type="hidden" id="id_order_supplies_add" value="<?=$s->id_order_supplies?>">
                        <input type="hidden" id="id_supplies_add" value="<?=$s->id_supplies?>">
                        <input type="hidden" id="quantity_add21" value="<?=$s->quantity?>">
                        <input type="hidden" id="weight_add" value="<?php if($s->weight_per_supplies == NULL){echo '0';}else{echo $s->weight_per_supplies;} ?>">
                </td>
            </tr>
        <?php //} 
            $count++;
        endforeach; ?>
    </tbody>
</table>