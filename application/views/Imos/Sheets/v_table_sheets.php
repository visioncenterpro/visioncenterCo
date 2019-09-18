<div class="form-group">
    <button class="btn btn-primary" onclick="modal_new()"><span class="fa fa-plus" area-hidden="true"></span> Nuevo</button>
    <button class="btn btn-success" onclick="modal_sheet_data()"><span class="fa fa-refresh" area-hidden="true"></span> Sincronizar datos láminas</button>
</div>
<table id="table_sheets" class="table table-bordered table-striped table-condensed">
<thead>
    <tr>
        <th>Acción</th>
        <th>Code</th>
        <th>Descripción</th>
        <th>Modelo</th>
        <th>Desperdicio</th>
        <th>Calibre</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($sheets as $value) { ?>
        <tr>
            <td><button type="button" class="btn btn-success" onclick="modal_edit('<?=$value->id_wood_sheet?>')"><span class="fa fa-edit" aria-hidden="true"></span></button></td>
            <td><?=$value->code?></td>
            <td><?=$value->description?></td>
            <td><?=$value->format?></td>
            <td><?=$value->waste?></td>
            <td><?=$value->caliber?></td>
        </tr>
    <?php }?>
</tbody>
</table>