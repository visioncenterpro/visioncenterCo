<table id="table_delivery" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="max-width:15px"></th>
            <th style="max-width:79px;text-align:center">ENTREGA N&deg;</th>
            <th style="text-align:center;max-width:90px;">CREACION</th>
            <th style="text-align:center;max-width:79px;">ORDER</th>
            <th>CLIENTE</th>
            <th style="text-align:center;max-width:79px;">ESTADO</th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach ($rows as $t) : ?>
            <tr>
                <td ><button class="btn btn-block btn-primary btn-xs" onclick="InfoDelivery(<?=$t->id_delivery_package?>,'<?=$t->order?>')"><span class="fa fa-sign-in" aria-hidden="true"></span></button></td>
                <td style="text-align:center"><?=$t->id_delivery_package?></td>
                <td style="text-align:center"><?=$t->date?></td>
                <td style="text-align:center"><?=$t->order?></td>
                <td><?=$t->client?></td>
                <td style="text-align:center"><?=$t->description?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
