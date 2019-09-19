<table id="table_weight"  class="display table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align: center">DESCRIPCION</th>
            <th style="text-align: center">CANTIDAD X PAQUETE</th>
            <th style="text-align: center">PESO X PAQUETE (KG)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $t) : ?>
            <tr id="<?=$t->id_supplies?>">
                <td><?= $t->name ?></td>
                <td><div class="form-group"><input type="number" id="cxp<?=$t->id_supplies?>" class="form-control input-sm required" value="<?=$t->quantity_per_package?>" ></div></td>
                <td><div class="form-group"><input type="number" id="wxp<?=$t->id_supplies?>" class="form-control input-sm required" value="<?=$t->weight_per_package?>"></div> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>