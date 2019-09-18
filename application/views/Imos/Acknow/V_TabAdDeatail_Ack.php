<table id="Adtable_detail" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th rowspan="2"></th>
            <th rowspan="2">Item</th>
            <th rowspan="2">Qty</th>
            <th rowspan="2">Code</th>
            <th rowspan="2">Code.Esp</th>
            <th colspan="2" class="bg-info" style="text-align: center">Hinges</th>
            <th rowspan="2">Ruteo</th>
            <th rowspan="2">Opening</th>
            <th rowspan="2">Door style</th>
            <th colspan="2" class="bg-info" style="text-align: center">Finished</th>
            <th colspan="3" class="bg-success" style="text-align: center">Cabinet Structure</th>
            <th rowspan="2">Unit Price</th>
            <th rowspan="2">Total Price</th>
            <th rowspan="2">Aprox Vol</th>
        </tr>
        <tr>
            <th class="bg-info">L</th>
            <th class="bg-info">R</th>
            <th class="bg-info">L</th>
            <th class="bg-info">R</th>
            <th class="bg-success">Height</th>
            <th class="bg-success">Width</th>
            <th class="bg-success">Depth</th>
        </tr>
        
    </thead>
    <tbody>
        <?php foreach ($addata_detail as $v) : ?>
            <tr>
                <td>
                    <button type="button"  class="btn btn-info btn-xs" onclick="ShowModal(<?=$v->id_import_salesline?>,'<?=$v->code?>')"><i class="fa fa-search"></i></button>
                </td>
                <td><?=$v->item?></td>
                <td><?=$v->qty?></td>
                <td><?=$v->code.$v->code1?></td>
                <td><?=$v->code_esp?></td>
                <td class="bg-info"><?=$v->hinges_left?></td>
                <td class="bg-info"><?=$v->hinges_right?></td>
                <td><?=$v->route?></td>
                <td><?=$v->opening?></td>
                <td><?=$v->door_style?></td>
                <td class="bg-info"><?=$v->finished_side_left?></td>
                <td class="bg-info"><?=$v->finished_side_right?></td>
                <td class="bg-success"><?=$v->height?></td>
                <td class="bg-success"><?=$v->width?></td>
                <td class="bg-success"><?=$v->depth?></td>
                <td>$ <?=$v->unit_prices?></td>
                <td>$ <?=$v->total_prices?></td>
                <td><?=$v->volume?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
