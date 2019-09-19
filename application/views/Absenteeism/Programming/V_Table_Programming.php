<table id="tabla_programacion" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Seccion</th>
            <th>Tipo</th>
            <th>Equipo</th>
            <th>Turno</th>
            <th>Categoria</th>
            <th></th>
           
        </tr>
    </thead>
    <tbody>
       
        <?php foreach ($programacion as $v) : ?>
            <tr id="id<?= $v->id_abs_employee ?>">
                <td style="text-align: center;" id="identification<?= $v->id_abs_employee ?>"><?= $v->identification ?></td>
                <td style="text-align: center;"><?= $v->name ?></td>                         
                <td style="text-align: center;" ><?= $v->last_name ?></td>
                <td style="text-align: center;"><?= $v->description ?></td>
                <td style="text-align: center;"><?= $v->code ?></td>
                <td style="text-align: center;"><?= $v->tipodescrip ?></td>                
                <td style="text-align: center;"><?= $v->work_shift ?></td>  
                <td style="text-align: center;"><?= $v->category ?></td>                    
                <td style="text-align: center;">
                    <button type="button"  class="btn btn-info btn-xs btn-tabla" title="Actualizar"  onclick="Update(<?= $v->id_abs_employee ?>)"><i class="fa fa-search"></i></button>
                   <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Delete(<?=$v->id_abs_employee?>,'<?=$v->name?>')"><i class="fa fa-trash"></i></button>
           
                </td>
            </tr>
        <?php endforeach; ?>
       
    </tbody>
</table>


