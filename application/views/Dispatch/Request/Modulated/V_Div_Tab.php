<div class="tab-pane" id="tab_<?= $order ?>">
    <div class="row">
        <div class="col-md-6">
            <div class=" table-wrapper-scroll-y">
                <div class="form-group">
                    <label>Muebles</label>
                    <div class="form-inline">
                        <select class="form-control" id="lblfurniture<?=$order?>">
                            <?php foreach ($furnitures as $key => $f):
                                if($val_f[$key] == 0){
                                    $vl = 1;
                                ?>
                                    <option value="<?=$f->id_forniture?>"><?=$f->description?></option>
                            <?php } 
                                endforeach; ?>
                        </select>
                        <?php if(!isset($vl)){ ?>
                            <button class="btn btn-primary" id="btn-add" disabled="disabled" onclick="add_item_group('<?=$order?>','Modulado')"><span class="fa fa-plus" aria-hidden="true"></span></button>
                        <?php }else{ ?>
                            <button class="btn btn-primary" id="btn-add" onclick="add_item_group('<?=$order?>','Modulado')"><span class="fa fa-plus" aria-hidden="true"></span></button>
                        <?php } ?>
                    </div>
                </div>
                <table id="table_detail" class="table table-bordered table-striped table-condensed ">
                    <thead>
                        <tr>
                            <th colspan="9" style="text-align:center" class="bg-info">MODULADO</th>
                        </tr>
                        <tr>
                            <th style=";text-align:center;width: 15px"><input type="checkbox" class="minimal" id="<?= $order ?>" ></th>
                            <th style=";text-align:center">Item</th>
                            <th style="text-align:center;">Description</th>
                            <th style="text-align:center;">Pack</th>
                            <th style="text-align:center;">Cantidad</th>
                            <th style="text-align:center;">Entregado Produccion</th>
                            <th style="text-align:center;">Despachado</th>
                            <th style="text-align:center;">Disponible</th>
                            <th style="text-align:center;">Peso Total(Kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($packs as $t) : ?>
                            <tr class="test" id="tr-<?= $t->id_order_package ?>" order="<?= $t->order ?>" idpack="<?= $t->id_order_package ?>" weight="<?= $t->weight / $t->quantity_packets ?>" pack="<?= $t->number_pack . " " . $t->code ?>" forniture="<?= $t->id_forniture ?>">
                                <td style="text-align:center;width: 15px">
<!--                                    <button class="btn btn-block btn-default btn-xs" onclick="AddItems2()"><span class="fa fa-sign-in" aria-hidden="true"></span> <?=$t->balance_dispatch?></button>-->
                                    <input type="checkbox" class="minimal-Modulado chk<?= $order ?>" idtable="<?= $t->id_order_package ?>" >
                                </td>
                                <td style="text-align:center"><?= $t->item ?></td>
                                <td id="name_<?= $t->id_order_package ?>"><?= $t->description ?></td>
                                <td style="text-align:center"><?= $t->number_pack . " " . $t->code ?></td>
                                <td style="text-align:center"><?= $t->quantity_packets ?></td>
                                <td style="text-align:center" id="quantity_<?= $t->id_order_package ?>"><?= $t->total_delivery ?></td>
                                <td style="text-align:center" id="dispatch_<?= $t->id_order_package ?>"><?= $t->total_dispatch ?></td>
                                <td class="<?= ($t->balance_dispatch > 0) ? 'bg-danger' : 'bg-success' ?>" style="text-align:center" id="balance_<?= $t->id_order_package ?>" ><?= $t->balance_dispatch ?></td>
                                <td style="text-align:center">
                                    <?= round($t->weight, 6) ?>
                                    <input type="hidden" value="<?=round($t->weight, 6)?>" id="weight-h-<?=$order?>-<?=$t->id_forniture?>">
                                    <input type="hidden" value="<?=$t->balance_dispatch?>" id="available-h-<?=$order?>-<?=$t->id_forniture?>">
                                    <input type="hidden" value="<?=$t->id_order_package?>" id="id_order_package-<?=$order?>-<?=$t->id_forniture?>">
                                    <input type="hidden" value="<?=$t->number_pack.' ' .$t->code?>" id="pack-<?=$order?>-<?=$t->id_forniture?>">
                                    <input type="hidden" value="<?=$t->description?>" id="name-<?=$order?>-<?=$t->id_forniture?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class=" table-wrapper-scroll-y">
                <div class="form-group">
                    <label>Paquetes (Insumos)</label>
                    <div class="form-inline">
                        <select class="form-control" id="slctpq-<?=$order?>">
                            <?php foreach ($suppliesP as $f): ?>
                                <option value="<?=$f->id_order_package_supplies?>">Paquete  <?=$f->number_pack?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(count($suppliesP) > 0){ ?>
                            <button class="btn btn-primary" id="btn-add" onclick="add_item_group_supplies('<?=$order?>','Insumos')"><span class="fa fa-plus" aria-hidden="true"></span></button>
                        <?php }else{ ?>
                            <button class="btn btn-primary" id="btn-add" onclick="add_item_group_supplies('<?=$order?>','Insumos')" disabled="disbled"><span class="fa fa-plus" aria-hidden="true"></span></button>
                        <?php }?>
                    </div>
                </div>
                <table id="table_detail_supplies" class="table table-bordered table-striped table-condensed ">
                    <thead>
                        <tr>
                            <th colspan="8" style="text-align:center" class="bg-info">INSUMOS</th>
                        </tr>
                        <tr>
                            <th style=";text-align:center;width: 15px"><input type="checkbox" class="minimal-supplies" id="o<?= $order ?>" ></th>
                            <th style="text-align:center;">Pack</th>
                            <th style="text-align:center;">Cantidad</th>
                            <th style="text-align:center;">Entregado Produccion</th>
                            <th style="text-align:center;">Despachado</th>
                            <th style="text-align:center;">Disponible</th>
                            <th style="text-align:center;">Peso Total(Kg)</th>
                            <th style="text-align:center;">Detalle del paquete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supplies as $key => $t) : ?>
                            <tr class="test2" id="str-<?= $t->id_order_package_supplies ?>"  order="<?= $t->order ?>" idpack="<?= $t->id_order_package_supplies ?>" pack="<?= $t->number_pack?>" forniture="" >
                                <td style="text-align:center;width: 15px"><input type="checkbox" class="minimal-Insumo chko<?= $order ?>" idtable="<?= $t->id_order_package_supplies ?>" ></td>
                                <td id="sname_<?= $t->id_order_package_supplies ?>"><?= $t->number_pack ?></td>
                                <td style="text-align:center"><?= $t->delivered_quantity ?></td>
                                <td style="text-align:center" id="squantity_<?= $t->id_order_package_supplies ?>"><?= $t->delivered_quantity?></td>
                                <td style="text-align:center" id="sdispatch_<?= $t->id_order_package_supplies ?>"><?= $t->quantity_dispatch?></td>
                                <td class="<?= ($t->delivered_quantity -  $t->quantity_dispatch > 0) ? 'bg-danger' : 'bg-success' ?>" style="text-align:center" id="sbalance_<?= $t->id_order_package_supplies ?>" ><?= $t->delivered_quantity -  $t->quantity_dispatch ?></td>
                                <td style="text-align:center"><?= $weight_p[$key]?></td>
                                <td style="text-align:center"><button type="button" class="btn btn-primary" onclick="modal_detail('<?= $t->id_order_package_supplies?>','<?= $t->order?>')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button></td>
                                <input type="hidden" value="<?=$t->id_order_package_supplies?>" id="id_order_package_supplies_<?=$order?>">
                                <input type="hidden" value="<?=$order?>" id="order_<?= $t->id_order_package_supplies ?>">
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
