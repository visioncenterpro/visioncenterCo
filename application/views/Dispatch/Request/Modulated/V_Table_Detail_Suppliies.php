<table id="table_detail_supplies" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align:center">Codigo</th>
            <th style="text-align:center">Descripción</th>
            <th style="text-align:center">Peso Unt(Kg)</th>
            <th style="text-align:center">Peso total(Kg)</th>
            <th style="text-align:center">Cantidad empacada</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail as $d) : ?>
            <tr>
                <td style="text-align:center"><?= $d->code ?></td>
                <td style="text-align:center"><?= $d->name ?></td>
                <td style="text-align:center"><?= $d->weight_per_supplies ?></td>
                <td style="text-align:center"><?= $d->qp * $d->weight_per_supplies ?></td>
                <td style="text-align:center"><?= $d->qp ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>