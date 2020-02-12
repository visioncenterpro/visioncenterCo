<table class="display table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($old as $o) : ?>
            <tr>
                <td ><?= $o->code ?></td>
                <td ><?= $o->name ?></td>
                <td ><?= $o->quantity ?></td>
                <td style="text-align: center;">Antiguo</td>
            </tr>
        <?php endforeach;

            $observation = "";
            foreach ($new as $n) :
                $observation = $n->observation_replaced;
                ?>
                <tr>
                    <td ><?= $n->code ?></td>
                    <td ><?= $n->name ?></td>
                    <td ><?= $n->quantity ?></td>
                    <td style="text-align: center; background-color: #8aa3dc;">Nuevo</td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="form-group">
    <label>Observación</label>
    <p><?=$observation?></p>
</div>