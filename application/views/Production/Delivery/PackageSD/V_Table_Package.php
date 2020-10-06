<div class="col-md-6 table-wrapper-scroll-y">
   
    <div class="form-group">
        <label>Muebles</label>
        <div class="form-inline">
            <select class="form-control" id="furniture">
                <?php foreach ($furniture as $key => $value) {
                    //if($value->delivered_quantity != 0){ ?>
                        <option value="<?=$value->id_forniture?>"><?=$value->description?></option>
                <?php //}
                } ?> 
            </select>
            <button class="btn btn-primary" onclick="add_furniture()"><span class="fa fa-sign-in" aria-hidden="true"></span></button>
        </div>
    </div>
    <table id="table_pack" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th style="width:25px"><button class="btn btn-block btn-success btn-xs btn-all" onclick="AddAll()"><span class="fa fa-sign-in" aria-hidden="true"></span> All</button></th>
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
                    <td>
                        <button class="btn btn-block btn-default btn-xs" onclick="AddItems2(<?= $t->id_order_package ?>,<?= $t->item ?>,'<?= str_replace('"', ' ', $t->description) ?>',<?= $t->number_pack?>,'<?=$t->code ?>','<?=$t->saldo?>','<?=$delivery?>')"><span class="fa fa-sign-in" aria-hidden="true"></span> <?=$t->saldo?></button> 
                        <button class="btn btn-block btn-primary btn-xs" onclick="AddItem(<?= $t->id_order_package ?>,<?= $t->item ?>,'<?= str_replace('"', ' ', $t->description) ?>',<?= $t->number_pack?>,'<?=$t->code ?>',<?=$t->id_forniture?>)"><span class="fa fa-sign-in" aria-hidden="true"></span></button>
                    </td>
                    <td style="text-align:center"><?= $t->item ?></td>
                    <td><?= $t->description ?></td>
                    <td style="text-align:center"><?= $t->number_pack . " " . $t->code ?></td>
                    <td style="text-align:center"><?= $t->quantity_packets ?></td>
                    <td style="text-align:center" id="delivered_quantity_<?= $t->id_order_package ?>"><?= $t->delivered_quantity ?></td>
                    <td style="text-align:center" id="balance_<?= $t->id_order_package ?>" class='<?=($t->saldo > 0)?"bg-danger":"bg-success"?>'  >
                        <?= $t->saldo ?>
                        <input type="hidden" id="<?=$t->id_forniture?>" value="<?=$t->saldo?>">
                        <input type="hidden" id="p-<?=$t->id_forniture?>-<?=$t->number_pack?>" value="<?=$t->number_pack?>">
                        <input type="hidden" id="id_order_package_<?=$rows?>_<?=$t->id_forniture?>" value="<?=$t->id_order_package?>">
                        <input type="hidden" id="type_<?=$t->id_forniture?>" value="<?=$t->code?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="col-md-6 table-wrapper-scroll-y">
    <table id="table_detail" class="table table-bordered table-striped table-condensed ">
        <thead>
            <tr>
                <th style="width:25px"><button class="btn btn-block btn-danger btn-xs btn-all" onclick="RemoveAll()"><span class="fa fa-trash-o" aria-hidden="true"></span> All</button></th>
                <th style="max-width:79px;text-align:center">Item</th>
                <th style="text-align:center;max-width:90px;">Description</th>
                <th style="text-align:center;max-width:79px;">Pack</th>
                <th style="text-align:center;width: 95px">Cantidad</th>
                <?= (!empty($BtnReverse)) ? '<th style="text-align:center"></th>' : "" ?>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($detail as $t) : ?>
                <input type="hidden" id="forniture-h" value="<?=$t->id_forniture?>">
                <tr class="test" id="tr-<?=$t->id_order_package?>">
                    <td ><button class="btn btn-block btn-danger btn-xs" onclick="DeleteDetail(<?= $t->id_delivery_package_detail ?>,<?= $t->id_order_package ?>,<?=$delivery?>)"><span class="fa  fa-trash-o" aria-hidden="true"></span></button></td>
                    <td style="text-align:center"><?= $t->item ?></td>
                    <td><?= $t->description ?></td>
                    <td style="text-align:center"><?= $t->number_pack . " " . $t->code ?></td>
                    <td style="text-align:center"><input type="number" value="<?=$t->quantity?>" class="input-qt" id="quantity-<?=$t->id_order_package?>" onchange="UpdateDetailDelivery(<?= $t->id_delivery_package_detail ?>,<?= $t->id_order_package ?>,this)" style="height: 20px;width: 70px;text-align: center"></td>
                    <?php // (!empty($BtnReverse)) ? '<td style="text-align:center"><button type="button" class="btn btn-default btn-xs" onclick="OpenReversePack('.$t->id_order_package.','.$t->id_delivery_package_detail.')"><i class="fa fa-backward"></i> Revertir Paquete</button></td>' : "" ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

