<table id="tabla_Machine" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Description</th>
            <th>Codigo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Area</th>
            <th>Estatus</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($machine as $m) : ?>
            <tr id="mach<?= $m->id_machine ?>">
                <td id="desc<?= $m->id_machine ?>"><?= $m->description ?></td>
                <td id="cod<?= $m->id_machine ?>"><?= $m->code ?></td>
                <td id="bran<?= $m->id_machine ?>"><?= $m->brand ?></td>
                <td id="mod<?= $m->id_machine ?>"><?= $m->model ?></td>
                <td id="area<?= $m->id_machine ?>" idarea="<?= $m->area ?>"><?= $m->despcarea ?></td>
                <td id="sta<?= $m->id_machine ?>" idstatus="<?= $m->status ?>" ><?= $m->descstatus ?></td>                
                <td>
                     <?=(!empty($BtnInfoMachine))?'<button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="Update('.$m->id_machine.')" ><i class="fa fa-search"></i></button>':"" ?>
                    <?=(!empty($BtnDeleteMachine)) ? '<button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete(' . $m->id_machine . ',\''.$m->description. '\')"><i class="fa fa-trash"></i></button>' : "" ?>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>