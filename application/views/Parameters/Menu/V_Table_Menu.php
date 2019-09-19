<table id="tabla_menu" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Titulo</th>
            <th>Url</th>
            <th>Icon</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menus as $v) : ?>
        <tr id="menu<?=$v->id_menu?>" type="<?=$v->type?>" father="<?=$v->root?>">
            <td id="title<?=$v->id_menu ?>"><?=$v->title?></td>
            <td id="url<?=$v->id_menu ?>"><?=$v->url?></td>
            <td style="text-align: center;" val="<?=$v->icon?>" id="icon<?=$v->id_menu ?>"><i class="fa  <?=$v->icon?>"></i></td>
            <td style="text-align: center;" val="<?=$v->status?>" id="status<?=$v->id_menu ?>"><?=$v->description?></td>
            <td style="text-align: center;">
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="Update(<?=$v->id_menu?>)"><i class="fa fa-search"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete(<?=$v->id_menu?>,'<?=$v->title?>')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>