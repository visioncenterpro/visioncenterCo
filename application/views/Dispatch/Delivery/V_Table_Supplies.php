<div class="col-md-7 table-wrapper-scroll-y">
    <table id="table_pack" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th style="text-align:center;max-width:79px;">Paquete</th>
                <th style="text-align:center;max-width:79px;">Und</th>
                <th style="text-align:center;max-width:79px;">Peso Max. Permitido Paq (Kg)</th>
                <th style="text-align:center;max-width:79px;">Entregado</th>
                <th style="text-align:center;max-width:79px;">Saldo</th>
                <th style="text-align:center;max-width:79px;">Detalle</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = 0;
            foreach ($headers as $t) :
                if($t->delivered_quantity == 1){
                    $delivered = 1;
                    $balance = 0;
                }else{
                    $delivered = 0;
                    $balance = 1;
                }
                $rows++;
                ?>
                <tr class="test" pack="<?= $t->id_order_package_supplies ?>" undpack="<?= ($t->type_package == 1)?$t->quantity_per_package:$t->quantity_supplies ?>">
                    <td style="text-align:center"><?= $t->number_pack ?></td>
                    <td style="text-align:center"><?= $t->quantity_pq ?></td>
                    <td style="text-align:center"><?= $t->weight_per_package ?></td>
                    <td style="text-align:center"><?= $delivered ?></td>
                    <?php if($balance == 0) { ?>
                        <td style="text-align:center; background-color:#58cc58;"><?= $balance ?></td>
                    <?php }else{ ?>
                        <td style="text-align:center"><?= $balance ?></td>
                    <?php } ?>
                        <td style="text-align:center"><button class="btn btn-primary btn-sm" id="dis" onclick="modal_detail('<?=$t->id_order_package_supplies?>','<?=$t->number_pack?>','<?=$t->order?>')"><span class="fa fa-eye" aria-hidden="true"></span></button></td>
                </tr>
                
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="col-md-5 table-wrapper-scroll-y">
    <table id="table_detail" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th style="max-width:79px;text-align:center">Paquete</th>
                <th style="text-align:center;max-width:90px;">Und</th>
                <th style="text-align:center;max-width:79px;">Peso Max. Permitido Paq (Kg)</th>
                <th style="text-align:center;width: 95px">Cantidad</th>
            </tr>
        </thead>
        <tbody>
           <?php
           foreach ($detail as $t) : ?>
                <tr id="tr-<?=$t->id_order_package_supplies?>">
                    <td style="text-align:center"><?= $t->number_pack ?></td>
                    <td style="text-align:center"><?= $t->quantity_pq ?></td>
                    <td style="text-align:center"><?= $t->weight_per_package ?></td>
                    <td style="text-align:center">1</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>