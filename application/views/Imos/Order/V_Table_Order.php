<table id="table_order"  class="display table table-bordered table-striped table-condensed " style="min-width: 2000px">
    <thead>
        <tr>
            <th></th>
            <th>No Pedido</th>
            <th>Empleado</th>
            <th>Cliente Final</th>
            <th>Cliente</th>
            <th>Descripción</th>
            <th>Fecha Entrega</th>
            <th>Creado por</th>
            <th>DateCreate</th>
            <th>DataModified</th>
            <th>Estado</th>
            <th>Estado Pedido</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $t) : ?>
            <tr id="<?= $t->NAME ?>">
                <td>
                    <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="ListItems('<?= $t->NAME ?>',<?= $t->ID ?>)"><i class="fa fa-search"></i></button>
                </td>
                <td ><?= $t->NAME ?></td>
                <td><?= $t->EMPLOYEE ?></td>
                <td><?= $t->CUSTOMER ?></td>
                <td><?= $t->CLIENT ?></td>
                <td><?= $t->DESCRIPTION ?></td>
                <td><?= $t->DELIVERY_DATE ?></td>
                <td><?= $t->SOURCE ?></td>
                <td><?= $t->DATECREATE ?></td>
                <td><?= $t->LCHANGE ?></td>
                <td><?= $t->STATUS ?></td>
                <td><?= $t->ORDERSTATUS ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>