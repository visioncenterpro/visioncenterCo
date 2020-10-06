<button type="button" class="btn btn-primary" onclick="Report_ALL()">Generar Consolidado por orden</button>
<button type="button" class="btn btn-success" onclick="Report_All2()">Generar Consolidado Total</button>
<hr>
<table id="table_order_total"  class="display table table-bordered table-striped table-condensed " style="min-width: 2000px">
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
                    <input type="checkbox" id="chk" onClick="array_total('<?=$t->NAME?>',this)" />
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