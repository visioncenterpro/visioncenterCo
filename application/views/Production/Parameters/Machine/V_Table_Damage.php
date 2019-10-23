<table id="table_damage" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($types as $t) : ?>
            <tr>
                <td id="desc<?=$t->id_type_damage ?>"><?= $t->description ?></td>
                <td id="type<?=$t->id_type_damage ?>"><?= $t->type ?></td>
                <td val="<?=$t->status?>" id="status<?=$t->id_type_damage ?>"><?= $t->statusrecord ?></td>
                <td>
                    <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="Update(<?= $t->id_type_damage ?>)"><i class="fa fa-search"></i></button>
                    <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete(<?= $t->id_type_damage ?>, '<?= $t->description ?>')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
