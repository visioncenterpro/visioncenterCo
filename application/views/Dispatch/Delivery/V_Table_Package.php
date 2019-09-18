<div class="col-md-6 table-wrapper-scroll-y">
    <table id="table_pack" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th style="max-width:79px;text-align:center">Item</th>
                <th style="text-align:center;max-width:90px;">Description</th>
                <th style="text-align:center;max-width:79px;">Pack</th>
                <th>Cantidad</th>
                <th>Entregado</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = 0;
            foreach ($list as $t) :
                $rows++;
                ?>
                <tr>
                    <td style="text-align:center"><?= $t->item ?></td>
                    <td><?= $t->description ?></td>
                    <td style="text-align:center"><?= $t->number_pack . " " . $t->code ?></td>
                    <td style="text-align:center"><?= $t->quantity_packets ?></td>
                    <td style="text-align:center" id="delivered_quantity_<?= $t->id_order_package ?>"><?= $t->delivered_quantity ?></td>
                    <td style="text-align:center" id="balance_<?= $t->id_order_package ?>" class='<?=($t->saldo > 0)?"bg-danger":"bg-success"?>'  ><?= $t->saldo ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="col-md-6 table-wrapper-scroll-y">
    <table id="table_detail" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th style="max-width:79px;text-align:center">Item</th>
                <th style="text-align:center;max-width:90px;">Description</th>
                <th style="text-align:center;max-width:79px;">Pack</th>
                <th style="text-align:center;width: 95px">Cantidad</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($detail as $t) : ?>
                <tr id="tr-<?=$t->id_order_package?>">
                    <td style="text-align:center"><?= $t->item ?></td>
                    <td><?= $t->description ?></td>
                    <td style="text-align:center"><?= $t->number_pack . " " . $t->code ?></td>
                    <td style="text-align:center"><?=$t->quantity?></td>
                    <td style="text-align:center">
                        <button type="button" class="btn btn-default btn-xs" onclick="OpenReversePack('<?=$delivery?>','<?=$t->id_order_package?>','<?=$t->id_delivery_package_detail?>','<?=$t->quantity?>')">
                            <i class="fa fa-backward"></i> Revertir Paquete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

