<table id="tbl" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Area</th>
            <th>Turno</th>
            <th>Cantidad</th>                           
        </tr>
    </thead>
    <tbody>
    <?php foreach ($datos as $d) : ?>
        <tr id="">
            <td id=""><?=$d->description?></td>
            <td id=""><?=$d->turno?></td>
            <td id=""><?=$d->total?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>