<table class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align:center">Pedido</th>
            <th style="text-align:center">Mueble</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $d) : ?>
            <tr>
                <td style="text-align:center"><?= $order ?></td>
                <td style="text-align:center"><?= $d->description ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <label>Observación</label>
    <textarea class="form-control" id="observationP"></textarea>
</div>