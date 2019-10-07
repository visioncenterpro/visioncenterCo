<input type="hidden" value="<?=$order?>" id="order_value">
<input type="hidden" value="<?=$number_pack?>" id="number_pack">
<?php if($type == 'A'){ ?>
    <div class="form-group">
        <div class="form-inline">

            <div class="form-group" style="margin-right: 5%;">
                <label>Paquete N°</label>
                <label id="pq"></label>
                <input type="hidden" id="package_number_edit">
            </div>
            <div class="form-group">
                <label>Peso (kg)</label>
                <?php 
                $weight = 0;
                foreach ($header as $value1) {
                    $weight = $value1->weight_per_package;
                } ?>
                <input type="text" class="form-control" id="weight_package_edit" value="<?=$weight?>">
            </div>
            <button class="btn btn-primary" id="update_btn1" onclick="Update_packet()">Guardar</button>
        </div>
    </div>
    <hr>
<?php } ?>
<table id="table_manual" class="display table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <?php if($type == 'A'){ ?>
                <th>ACCIÓN<br><button class="btn btn-block btn-danger btn-xs" onclick="go_back_all_edit()"><span class="fa fa-trash" aria-hidden="true"></span> All</button></th>
            <?php } ?>
            
            <th>CODIGO</th>
            <th>DESCRIPCIÓN</th>
            <th>PESO UNIT</th>
            <th>PESO TOTAL</th>
            <th>CANTIDAD EMPACADA EN PQ</th>
            <th>SALDO TOTAL</th>
            <th>SALDO DISPONIBLE</th>
            <?php if($type == 'A'){ ?>
            <th>SELECCIONAR <br><input type="checkbox" onclick="selection_all_edit(this.checked)"> </th>
            <th>NÚMERO A EMPACAR</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 0;
        foreach ($supplies as $s) :
            //echo $s->quantity ."-". $quantity_total[$count]."<br>";
            //echo round($s->quantity)." - ".$quantity_packaged[$count]."<br>";
            if($quantity_packaged[$count] != 0){
                //echo round($s->quantity)." - ".$quantity_packaged[$count]."<br>";
            ?>
            <tr>
                <input type="hidden" id="id_supplies_all_edit<?=$count?>" value="<?= $s->id_supplies ?>">
                <input type="hidden" id="id_order_supplies_all_edit<?=$count?>" value="<?= $s->id_order_supplies ?>">
                <input type="hidden" id="count_all_edit" value="<?= $count ?>">
                <input type="hidden" id="packed_all_edit<?=$count?>" value="<?=$quantity_packaged[$count]?>">
                <input type="hidden" id="id_order_package_supplies_all_edit<?=$count?>" value="<?=$s->id_order_package_supplies_detail?>">
                <?php if($type == 'A'){ ?>
                <td>
                    <button class="btn btn-block btn-danger btn-xs" onclick="go_back_edit('<?=$s->id_supplies?>','<?=$s->order?>','<?=$s->id_order_supplies?>','<?=$count?>','<?=$s->id_order_package_supplies_detail?>')"><span class="fa fa-trash" aria-hidden="true"></span></button>
                </td>
                <?php } ?>
                <td style="text-align: center"><?= $s->code ?></td>
                <td><?= $s->name ?></td>
                <td><?= $s->weight_per_supplies ?></td>
                <td><?= $s->weight_per_supplies *  $quantity_packaged[$count]?></td>
                <td id="packed-edit-<?=$count?>"><?=$quantity_packaged[$count]?></td>
                <td id="packed-edit-<?=$count?>"><?=$s->quantity?></td>
                <td style="text-align: center" id="sum-edit-<?=$count?>"><?=round($s->quantity) - $quantity_total[$count]?></td>
                <?php if($type == 'A'){ ?>
                <td>
                    <?php if(round($s->quantity) - $quantity_total[$count] == 0){ ?>
                        <input type="checkbox" id="select_edit" disabled="true">
                    <?php }else{ ?>
                        <input type="checkbox" id="select_edit">
                    <?php } ?>
                </td>
                <td>
                    <?php
                        if(round($s->quantity) - $quantity_total[$count] == 0){ ?>
                        <input type="number" min="0" max="<?=round($s->quantity) - $quantity_total[$count]?>" value="<?=round($s->quantity) - $quantity_total[$count]?>" id="quantity_pack_edit" style="width: 100%;" disabled="true" onkeypress="validation_total(event,this,'<?=round($s->quantity) - $quantity_total[$count]?>')">
                    <?php }else{ ?>
                        <input type="number" min="0" max="<?=round($s->quantity) - $quantity_total[$count]?>" value="<?=round($s->quantity) - $quantity_total[$count]?>" id="quantity_pack_edit" style="width: 100%;" onkeypress="validation_total(event,this,'<?=round($s->quantity) - $quantity_total[$count]?>')">
                    <?php } ?>
                    <input type="hidden" id="id_order_supplies_edit" value="<?=$s->id_order_supplies?>">
                    <input type="hidden" id="id_supplies_edit" value="<?=$s->id_supplies?>">
                    <input type="hidden" id="quantity_edit" value="<?=$s->quantity?>">
                    <input type="hidden" id="quantity_edit_packed" value="<?=$quantity_packaged[$count]?>">
                </td>
                <?php } ?>
            </tr>
        <?php } 
            $count++;
        endforeach; ?>
    </tbody>
</table>