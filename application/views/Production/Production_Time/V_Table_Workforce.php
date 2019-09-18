             
<table id="table_day_day"  class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th><h5>Dia</h5></th>
            <th><h5>Hora</h5></th>
            <th><h5>Maquina</h5></th>
            <th><h5>Cantidad</h5></th>
            <th><h5>Motivo</h5></th>
            <th><h5>Tiempo de Stop</h5></th>
            <th><h5>Personas</h5></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($register as $v) : ?>
            <tr id="user<?= $v->id_production_time ?>">
                <td id="name<?= $v->day ?>"><?= $v->day ?></td>
                <td ><?= $v->hour ?></td>       
                <td ><?= $v->model ?></td>           
                <td ><?= $v->quantity ?></td>
                <td ><?= $v->description ?></td>
                <td ><?= $v->stopped_time ?></td>
                <td ><?= $v->number_operators ?></td>           
                <td style="text-align: center;">
                    <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="Deleteday(<?= $v->id_production_time ?>, '<?= $v->day ?>', '<?= $v->hour ?>')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

