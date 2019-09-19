<?php foreach ($data as $t) : ?>
    <?php if (is_array($t)) : ?>
        <tr class="tr-<?= $this->input->post("id_order_supplies_dispatch") ?>">
            <td style="min-width:58px;">
                <button class="btn  btn-danger btn-xs" onclick="DeleteDetail(<?= $t['id'] ?>,<?= $this->input->post("id_order_supplies_dispatch") ?>)"><span class="fa  fa-trash-o" aria-hidden="true"></span></button>
                <button class="btn  btn-info btn-xs" onclick="ChargeDetailDelivery(<?= $t['id'] ?>,<?= $this->input->post("id_order_supplies_dispatch") ?>)"><span class="fa  fa-search" aria-hidden="true"></span></button>
            </td>
            <td style="text-align:center"><?= $t['codeax'] ?></td>
            <td><?= $t['name'] ?></td>
            <td style="text-align:center">(<?= $t['quantity_package'] ?>)<?= $t['code'] ?></td>
            <td style="text-align:center" id="quantity-<?= $this->input->post("id_order_supplies_dispatch") ?>" ><?= $t['quantity'] ?></td>
        </tr>
    <?php else: ?>
        <tr class="tr-<?= $t->id_order_supplies_dispatch ?>">
            <td style="min-width:58px;">
                <button class="btn  btn-danger btn-xs" onclick="DeleteDetail(<?= $t->id_delivery_supplies_detail ?>,<?= $t->id_order_supplies_dispatch ?>)"><span class="fa  fa-trash-o" aria-hidden="true"></span></button>
                <button class="btn  btn-info btn-xs" onclick="ChargeDetailDelivery(<?= $t->id_delivery_supplies_detail ?>,<?= $t->id_order_supplies_dispatch ?>)"><span class="fa  fa-search" aria-hidden="true"></span></button>
            </td>
            <td style="text-align:center"><?= $t->codeax ?></td>
            <td><?= $t->name ?></td>
            <td style="text-align:center">(<?= $t->quantity_package ?>)<?= $t->code ?></td>
            <td style="text-align:center" id="quantity-<?= $t->id_order_supplies_dispatch ?>"><?= $t->quantity ?></td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>