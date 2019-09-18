<table id="table_request" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="max-width:15px">N&deg;</th>
            <th style="max-width:56px">Tipo</th>
            <th>Maquina</th>
            <th>Tipo Daño</th>
            <th>Area</th>
            <th style="max-width:130px">Fec. Creacion</th>
            <th style="max-width:130px">Fec. Inicio</th>
            <th style="max-width:130px">Fec. Fin</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($request as $v) : ?>
        <tr id="sol<?=$v->id_request?>">
            <td><?=$v->id_request?></td>
            <td><?=$v->type_request?></td>
            <td><?=$v->maquina?></td>
            <td><?=$v->tipo_dano?></td>
            <td><?=$v->area?></td>
            <td><?=$v->creado?></td>
            <td><?=$v->inicio?></td>
            <td><?=$v->fin?></td>
            <td>
                <?=(!empty($OpenRequestMmto))?'<button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="OpenRequest('.$v->id_request.')" ><i class="fa fa-search"></i></button>':"" ?>
                <?=(!empty($DeleteRequestMmto))?'<button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete('.$v->id_request.')"><i class="fa fa-trash"></i></button>':"" ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
