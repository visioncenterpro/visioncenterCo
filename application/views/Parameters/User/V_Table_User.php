<table id="tabla_user" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>E-mail</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($user as $v) : ?>
        <tr id="user<?=$v->id_users?>">
            <td id="name<?=$v->id_users ?>"><?=$v->name?></td>
            <td style="text-align: center;"><?=$v->user?></td>           
            <td style="text-align: center;"><?=$v->rol?></td>
             <td style="text-align: center;"><?=$v->email?></td>
            <td style="text-align: center;"><?=$v->status?></td>           
            <td style="text-align: center;">
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="Update(<?=$v->id_users?>)"><i class="fa fa-search"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete(<?=$v->id_users?>,'<?=$v->name?>')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
