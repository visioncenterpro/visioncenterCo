<table class="display table table-bordered table-striped table-condensed" id="table_deleted">
    <thead>
        <tr>
            <th style="width: 70px;text-align: center">CÓDIGO</th>
            <th style="width: 70px;text-align: center">DESCRIPCION</th>
            <th style="width: 70px;text-align: center">CANTIDAD</th>
            <th style="width: 70px;text-align: center">MEDIDA</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($record_deleted as $key => $t) : ?>
            <tr>
                <td style="text-align: center"><?= $t->code ?></td>
                <td style="text-align: center"><?= $t->name ?></td>
                <td style="text-align: center"><?= $t->quantity ?></td>
                <td style="text-align: center"><?= $t->description ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>