<input type="hidden" value="<?=$order?>" id="order_value_to">
<div class="form-group">
    <div class="form-group">
        <select class="form-control" id="supplies">
            <?php foreach ($supplies_all as $key => $value) { ?>
                <option value="<?= $value->id_supplies?>"><?= $value->name?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-inline">
        <!-- <div class="form-group">
            <input type="text" class="form-control" id="code" placeholder="CODIGO">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="name" placeholder="DESCRIPCIÓN">
        </div> -->
        
        <button class="btn btn-primary" onclick="Add_new_to_order()">Agregar</button>
        <button class="btn btn-primary" onclick="create_new_to_order()">Crear nuevo item</button>
    </div>
</div>
<hr>
<table id="table_manual" class="display table table-bordered table-striped table-condensed">
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
        foreach ($supplies as $s) :
            ?>
            <tr>
                <td><button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="Delete_to_order('<?=$order?>')" title="Quitar Paquete del contenedor"><i class="fa fa-trash"></i></button></td>
                <td style="text-align: center"><?= $s->code ?></td>
                <td><?= $s->name ?></td>
                <td><?=$s->weight_per_supplies?></td>
               
            </tr>
        <?php 
            $count++;
        endforeach; ?>
    </tbody>
</table>