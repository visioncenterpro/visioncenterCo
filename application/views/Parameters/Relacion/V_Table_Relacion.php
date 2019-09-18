<table id="tabla_roles" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>id</th>
            <th>Description Menú</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;">Rol Asignado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($relaciones as $r) : ?>
        <tr id="rol<?=$r->id_roles?>">
            <td><?=$r->id_roles_menu?></td>
            <td><?=$r->title?></td>
            <td style="text-align: center;"><?=$r->status_desc?></td>
            <td style="text-align: center;"><?=$r->description?></td>
            <td style="text-align: center;">
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="edit_modal(<?= $r->id_roles_menu ?>)"><i class="fa fa-edit"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete(<?= $r->id_roles_menu ?>)"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>