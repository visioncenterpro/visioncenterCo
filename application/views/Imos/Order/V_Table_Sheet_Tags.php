<table id="table_sheet" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Lamina</th>
            <th>Estandar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dato as $t) : ?>
            <tr id="<?= $t->MATNAME ?>">
                <td style="text-align: center"><?= $t->MATNAME ?></td>
                <td style="text-align: center">
                    <select class="form-control input-sm lam-<?= $t->MATNAME ?>" >
                        <option value="">. . .</option>
                        <option value="D">DOBLE</option>
                        <option value="S">SIMPLE</option>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>