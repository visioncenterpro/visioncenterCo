<input type="hidden" value="<?=$order?>" id="order_value_to">
<input type="hidden" id="id_supplies_h" />
<div class="form-group">
    <div class="form-group">
        <label>Insumo</label>
        <select class="form-control" id="supplies">
            <?php foreach ($supplies_all as $key => $value) { ?>
                <option value="<?= $value->id_supplies?>"><?= $value->name?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <div class="form-group">
            <label>Cantidad</label>
            <input type="number" class="form-control" id="cnt2" min="1">
        </div>
        <div class="form-group">
            <label>Observación</label>
            <textarea class="form-control" id="observation_to_order"></textarea>
        </div>
        <!-- <button class="btn btn-primary" onclick="create_new_to_order()">Crear nuevo item</button> -->
    </div>
</div>
<hr>
<table id="table_to_order" class="display table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>ACCIÓN</th>
            <th>CODIGO</th>
            <th>DESCRIPCIÓN</th>
            <th>PESO UNIT</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //print_r($quantity_packaged);
        $count = 0;
        foreach ($supplies as $s) : ?>
            <tr class="line <?=$s->id_order_supplies?>">
                <td>
                    <button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="Delete_to_order('<?=$order?>','<?=$s->id_order_supplies?>')" title="Quitar item de la orden"><i class="fa fa-trash"></i></button>
                    <button type="button" class="btn btn-success btn-xs btn-tabla" onclick="Select_Replace('<?=$order?>','<?=$s->id_order_supplies?>',<?=$s->id_supplies?>)" title="Reemplazar item"><i class="fa fa-arrows-h"></i></button>
                </td>
                <td style="text-align: center"><?= $s->code ?></td>
                <td><?= $s->name ?></td>
                <td><?=$s->weight_per_supplies?></td>
            </tr>
        <?php 
            $count++;
        endforeach; ?>
    </tbody>
</table>