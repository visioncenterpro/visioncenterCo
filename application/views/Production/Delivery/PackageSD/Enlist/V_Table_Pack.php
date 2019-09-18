<table id="table_pack"  class="display table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="width: 70px;text-align: center">NUMERO</th>
            <th>MUEBLE</th>
            <th style="width: 70px;text-align: center">TIPO</th>
            <th style="width: 70px;text-align: center">PAQUETES</th>
            <th style="width: 70px;text-align: center">PIEZAS</th>
            <th style="width: 70px;text-align: center">PIEZAS ADD</th>
            <th style="width: 70px;text-align: center">PESO</th>
            <th style="width: 70px;text-align: center"></th>
            <th style="width: 70px;text-align: center"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total_packs = 0;
        foreach ($packs['data'] as $t) : 
        $total_packs += $t->quantity_packets;
        ?>
            <tr>
                <td style="text-align: center"><?= $t->number_pack ?></td>
                <td><?= $t->description ?></td>
                <td style="text-align: center"><?= $t->code ?></td>
                <td style="text-align: center"><?= $t->quantity_packets ?></td>
                <td style="text-align: center"><?= $t->quantity_pieces ?></td>
                <td style="text-align: center" id="pz-add-<?= $t->id_order_package ?>"><?= $t->quantity_pieces_add ?></td>
                <td style="text-align: center" id="pz-weight-<?= $t->id_order_package ?>"><?= round($t->weight,2) ?></td>
                <td style="text-align: center"><button type="button" class="btn btn-sm btn-primary" onclick="AddPiece(<?= $t->id_order_package ?>)"><i class="fa fa-fw fa-puzzle-piece"></i><i class="fa fa-fw fa-plus"></i></button></td>
                <td style="text-align: center"><button type="button" class="btn btn-sm btn-info"  onclick="OpenDeletePiece(<?= $t->id_order_package ?>)"><i class="fa fa-fw fa-puzzle-piece"></i><i class="fa fa-fw fa-search"></i> </button></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td style="text-align: center"></td>
                <td></td>
                <td style="text-align: center"</td>
                <td style="text-align: center" id="total-packs"><?=$total_packs?></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
            </tr>
    </tbody>
</table>