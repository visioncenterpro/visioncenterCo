<div class=" table-wrapper-scroll-y">
    <div class="form-group">
        <label>Insumos</label>
        <div class="form-inline">
            <select class="form-control" id="supplies_d">
                <?php foreach ($itemsS as $key => $value) { ?>
                    <option value='{"id_order_package":"<?= $value->id_order_package?>","order":"<?= $value->order?>"}'>Paquete <?= $value->number_pack." - ".$value->order ?></option>
                <?php } ?>
            </select>
            <button class="btn btn-danger" id="btn-delete" title="Reversar paquete del despacho" onclick="delete_supplies_group()"><span class="fa fa-trash" aria-hidden="true"></span></button>
            <!-- <button class="btn btn-danger" id="btn-delete" title="Reversar paquete hasta produccion" onclick="delete_supplies_group2()"><span class="fa fa-forward" aria-hidden="true"></span></button> -->
        </div>
    </div>
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
            <?php
            $count_supplies = 0;
            foreach ($content as $t) :
                $count_supplies++; ?>
                <tr id="str-cont-<?= $t->id_order_package ?>">
                    <td style="text-align:center;width:15px"><button type="button" class="btn btn-primary" onclick="modal_detail('<?= isset($t->id_order_package_supplies)? $t->id_order_package_supplies : $t->id_order_package;  ?>','<?= $t->order?>')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button></td>
                    <td style="text-align:center"><?= $t->order ?></td>
                    <td style="text-align:center"><?= $t->pack ?></td>
                    <td style="text-align:center" id="scont-quantity-<?= $t->id_order_package ?>"><?= $t->quantity_packets ?></td>
                    <td style="text-align:center" id="scont-weight-<?= $t->id_order_package ?>"><?= round($t->weight, 6) ?></td>
                    <td style="text-align:center;width:15px" >
                        <button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="DeleteSupplies('<?= $t->id_request_detail ?>','<?= $t->id_order_package ?>','<?= $t->order?>')" title="Quitar Paquete del contenedor"><i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-default btn-xs btn-tabla" onclick="modal_goBack('S','<?= $t->id_order_package ?>')" title="Revertir Paquete de la entrega"><i class="fa fa-backward"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <input type="hidden" id="packs_supplies" value="<?= $count_supplies ?>">
        </tbody>
    </table>
</div>