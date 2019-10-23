<table id="table_pack"  class="display table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            
            <th style="width: 70px;text-align: center">NÚMERO PAQ</th>
            <th style="width: 70px;text-align: center">CANT/PAQ</th>
            <th style="width: 70px;text-align: center">PESO MAX. PERMITIDO PAQ</th>
            <th style="width: 70px;text-align: center">PESO TOTAL PAQ</th>
            <th style="width: 70px;text-align: center">ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total_packs = 0;
        //print_r($packs);
        $count = 0;
        foreach ($packs as $key => $t) :
        $total_packs += $t->quantity_supplies;
        ?>
            <tr>
                <td style="text-align: center"><?= $t->number_pack ?></td>
<!--                <td style="text-align: center"><?= $t->quantity_total_supplies ?></td>-->
<!--                <td style="text-align: center"><?= $t->quantity_packets ?></td>-->
                <td style="text-align: center"><?= $t->quantity_per_package ?></td>
                <td style="text-align: center"><?= round($t->weight_per_package) ?></td>
                <td style="text-align: center"><?= $weight[$key] ?></td>
                <td><button class="btn btn-success" onclick="modal_edit('<?=$t->id_order_package_supplies?>','<?=$t->number_pack?>','<?=$order?>')"><span class="fa fa-edit" aria-hidden="true"></span></button></td>
            </tr>
        <?php
        $count++;
        endforeach; ?>
            <tr>
                <td style="text-align: center"></td>
                <td style="text-align: center" id="total-packs"><?=$total_packs?></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
            </tr>
    </tbody>
</table>