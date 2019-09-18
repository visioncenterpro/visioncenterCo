<table id="tabla_ausentismo" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Cedula</th>         
            <th>Nombres/Apellidos</th>           
            <th>Tipo</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>Diferencia</th>           
            <th>Estado</th>            
            <th>Fecha Creacion</th>
            <th>Aprobado</th>
            <th>Fecha Aprobado</th>
            <th>Obs RRHH</th>
            <th>Evidencia Adjunta</th>
            <th style="text-align: center; min-width: 50px"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ausentismo as $v) : ?>
            <tr id="id<?= $v->id_absenteeism ?>">
                <td style="text-align: center;" id="identification<?= $v->id_absenteeism ?>"><?= $v->identification ?></td>
                <td id="name<?= $v->id_absenteeism ?>"><?= $v->nombres ?></td>                         
                <td style="text-align: center;" id="tipo<?= $v->id_absenteeism ?>"><?= $v->tipo ?></td>
                <td style="text-align: center;"><?= $v->start_time ?></td>
                <td style="text-align: center;"><?= $v->end_time ?></td>
                <td style="text-align: center;"><?= $v->dif ?></td>                
                <td style="text-align: center;"id="desc<?= $v->id_absenteeism ?>"><?= $v->description ?></td>  
                <td style="text-align: center;"><?= $v->last_update ?></td>
                <td style="text-align: center;"><?= $v->aproved ?></td>
                <td style="text-align: center;"><?= $v->date_aprobed_by ?></td> 
                <td style="text-align: center;"><?= $v->obs_resources ?></td> 
                <td style="text-align: center;"><?= $v->evidence?>
                <td style="text-align: center; min-width: 50px"><button type="button"  class="btn btn-warning btn-xs btn-tabla" title="Actualizar Novedad"  onclick="evidence('<?= $v->evidence ?>')"><i class="fa fa-download"></i></button>
                    <button type="button"  class="btn btn-info btn-xs btn-tabla" title="Actualizar Novedad"  onclick="Update(<?= $v->id_absenteeism ?>)"><i class="fa fa-search"></i></button>
                                      
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


