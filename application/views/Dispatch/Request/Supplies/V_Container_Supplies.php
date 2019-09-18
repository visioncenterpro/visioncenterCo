<div class=" table-wrapper-scroll-y">
    <table id="table_container_supplies" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th colspan="6" style="text-align:center" class="bg-info">INSUMOS</th>
            </tr>
            <tr>
                <th style="text-align:center">Detalle</th>
                <th style="text-align:center">Pedido</th>
                <th style="text-align:center">Paquete</th>
                <th style="text-align:center">Cantidad</th>
                <th style="text-align:center">Peso Total(Kg)</th>
                <th style="text-align:center;width:15px"><button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="DeleteAllSupplies('Insumo')"><i class="fa fa-trash"></i></button></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($content as $t) : ?>
                <tr id="str-cont-<?= $t->id_order_package ?>">
                    <td style="text-align:center;width:15px"><button type="button" class="btn btn-primary" onclick="modal_detail('<?= isset($t->id_order_package_supplies)? $t->id_order_package_supplies : $t->id_order_package;  ?>','<?= $t->order?>')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button></td>
                    <td style="text-align:center"><?= $t->order ?></td>
                    <td style="text-align:center"><?= $t->pack ?></td>
                    <td style="text-align:center" id="scont-quantity-<?= $t->id_order_package ?>"><?= $t->quantity_packets ?></td>
                    <td style="text-align:center" id="scont-weight-<?= $t->id_order_package ?>"><?= round($t->weight, 6) ?></td>
                    <td style="text-align:center;width:15px" ><button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="DeleteSupplies('<?= $t->id_request_detail ?>','<?= $t->id_order_package ?>','<?= $t->order?>')"><i class="fa fa-trash"></i></button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>