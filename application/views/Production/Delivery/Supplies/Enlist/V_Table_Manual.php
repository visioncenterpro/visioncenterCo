<input type="hidden" value="<?=$order?>" id="order_value">
<div class="form-group">
    <div class="form-inline">
        <div class="form-group">
            <?php if($iss == 1){ ?>
                    <label>N°Paquete</label>
                    <select class="form-control" id="package_number">
                        <?php for($i = 0; $i < count($vali_pack); $i++){
                            if($vali_pack[$i]->total_pack == 0): ?>
                        <option value="<?=$vali_pack[$i]->number_pack?>" selected="selected"><?=$vali_pack[$i]->number_pack?></option>
                        <?php endif;
                        } ?>
                            <option id="lbl_number_p"></option>
                    </select>
            <?php }else{ ?>
                <label id="lbl_number_p">N°Paquete</label>
                <input type="hidden" id="package_number">
            <?php } ?>
<!--            <select class="form-control" id="package_number">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <button class="btn btn-primary" onclick="add_pack()"><span class="fa fa-plus" aria-hidden="true"></span></button>-->
<!--            <input type="text" class="form-control" id="package_number">-->
        </div>
        <div class="form-group">
            <label>  // Peso (kg)</label>
            <input type="number" class="form-control" id="weight_package">
        </div>
        <button class="btn btn-primary" onclick="Add_packed()">Guardar</button>
    </div>
</div>
<hr>
<?php if(count($empty_p) > 0){ ?>
<label> 
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
<!--            <th>ACCIÓN <br><button class="btn btn-block btn-danger btn-xs" onclick="go_back_all()"><span class="fa fa-trash" aria-hidden="true"></span> All</button></th>-->
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
                
                    <input type="hidden" id="id_supplies_all_<?=$count?>" value="<?= $s->id_supplies ?>">
                    <input type="hidden" id="id_order_supplies_all_<?=$count?>" value="<?= $s->id_order_supplies ?>">
                    <input type="hidden" id="count_all" value="<?= $count ?>">
                    <input type="hidden" id="packed_all_<?=$count?>" value="<?=$quantity_packaged[$count]?>">
<!--                    <input type="hidden" id="id_order_package_supplies_all_<?=$count?>" value="<?=$s->id_order_package_supplies?>">-->
<!--                    <button class="btn btn-block btn-danger btn-xs" onclick="go_back('<?=$s->id_supplies?>','<?=$s->order?>','<?=$s->id_order_supplies?>','<?=$count?>')"><span class="fa fa-trash" aria-hidden="true"></span></button>-->
                
                <td style="text-align: center"><?= $s->code ?></td>
                <td><?= $s->name ?></td>
                <td><?=$s->weight_per_supplies?></td>
                <td id="weight-<?=$count?>"><?=$s->weight_per_supplies * $quantity_packaged[$count]?></td>
                <td id="packed-<?=$count?>"><?=$quantity_packaged[$count]?></td>
                <td>
                    <?php if(round($s->quantity) - $quantity_packaged[$count] == 0){ ?>
                        <input type="checkbox" id="select" disabled="true">
                    <?php }else{ ?>
                        <input type="checkbox" id="select">
                    <?php } ?>
                </td>
                <td style="text-align: center" id="sum-<?=$count?>"><?=round($s->quantity) - $quantity_packaged[$count]?></td>
                <td>
                    <?php
                        if(round($s->quantity) - $quantity_packaged[$count] == 0){ ?>
                    <input type="number" min="0" max="<?=round($s->quantity) - $quantity_packaged[$count]?>" value="<?=round($s->quantity) - $quantity_packaged[$count]?>" id="quantity_pack" style="width: 100%;" disabled="true">
                    <?php }else{ ?>
                    <input type="number" min="0" max="<?=round($s->quantity) - $quantity_packaged[$count]?>" value="<?=round($s->quantity) - $quantity_packaged[$count]?>" id="quantity_pack" style="width: 100%;">
                    <?php } ?>
                    <input type="hidden" id="id_order_supplies" value="<?=$s->id_order_supplies?>">
                    <input type="hidden" id="id_supplies" value="<?=$s->id_supplies?>">
                    <input type="hidden" id="quantity" value="<?=$s->quantity?>">
                    <input type="hidden" id="weight" value="<?php if($s->weight_per_supplies == NULL){echo '0';}else{echo $s->weight_per_supplies;} ?>">
                </td>
            </tr>
        <?php //} 
            $count++;
        endforeach; ?>
    </tbody>
</table>