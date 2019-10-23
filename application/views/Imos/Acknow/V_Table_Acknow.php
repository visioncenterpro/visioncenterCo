<table id="table_ack" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="max-width: 30px"></th>
            <th>OrderId</th>
            <th>Account</th>
            <th>Person</th>
            <th>Apto</th>
            <th>City</th>
            <th>Space</th>
            <th>Line</th>
            <th style="max-width:130px">Fec. Fin</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ack as $v) : ?>
            <tr>
                <td>
                    <button type="button"  class="btn btn-info btn-xs" onclick="ShowDetailsAck(<?= $v->id_import_salestable ?>)"><i class="fa fa-search"></i></button>
                </td>
                <td><?= $v->order ?></td>
                <td><?= $v->account_num ?></td>
                <td><?= $v->person_in_charge ?></td>
                <td><?= $v->apto ?></td>
                <td><?= $v->city ?></td>
                <td><?= $v->space_type ?></td>
                <td><?= $v->line_order ?></td>
                <td><?= $v->order_date ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
