<div class=" table-wrapper-scroll-y">
    <table id="table_container" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th colspan="6" style="text-align:center" class="bg-info">MODULADO</th>
            </tr>
            <tr>
                <th style="text-align:center">Pedido</th>
                <th style="text-align:center">Mueble</th>
                <th style="text-align:center">Paquete</th>
                <th style="text-align:center">Cantidad</th>
                <th style="text-align:center">Peso Total</th>
                <th style="text-align:center;width:15px"><button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="DeleteAll('Modulado')"><i class="fa fa-trash"></i></button></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($content as $t) : ?>
                <tr id="tr-cont-<?= $t->id_order_package ?>">
                    <td style="text-align:center"><?= $t->order ?></td>
                    <td style="text-align:center"><?= $t->name ?></td>
                    <td style="text-align:center"><?= $t->pack ?></td>
                    <td style="text-align:center" id="cont-quantity-<?= $t->id_order_package ?>"><?= $t->quantity_packets ?></td>
                    <td style="text-align:center" id="cont-weight-<?= $t->id_order_package ?>"><?= round($t->weight, 6) ?></td>
                    <td style="text-align:center;width:15px" >
                    	<button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="Delete(<?= $t->id_request_detail ?>,<?= $t->id_order_package ?>,'Modulado',<?= $t->order ?>)" title="Quitar Paquete del contenedor"><i class="fa fa-trash"></i></button>
                    	<button type="button" class="btn btn-default btn-xs btn-tabla" onclick="modal_goBack('M','<?= $t->id_order_package ?>')" title="Revertir Paquete de la entrega"><i class="fa fa-backward"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>