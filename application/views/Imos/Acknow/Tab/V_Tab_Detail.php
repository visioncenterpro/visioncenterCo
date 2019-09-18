<div class="row">
    <div class="col-md-12">
        <table id="table_detail" class="table table-bordered table-striped table-condensed " style="min-width:2000px">
            <thead>
                <tr>
                    <th rowspan="2" style="width:51px"></th>
                    <th rowspan="2" style="width:15px">Item</th>
                    <th rowspan="2" style="width:15px">Qty</th>
                    <th rowspan="2" style="width:20px">code</th>
                    <th rowspan="2" style="width:20px">code1</th>
                    <th rowspan="2" style="width:20px">code.Esp</th>
                    <th colspan="2" class="bg-info" style="text-align: center; width: 30px;">Hinges</th>
                    <th rowspan="2" style="width:15px">Route</th>
                    <th rowspan="2" style="width:20px">Opening</th>
                    <th rowspan="2" style="width:75px">Door style</th>
                    <th colspan="2" class="bg-info" style="text-align: center; width: 30px;">Finished</th>
                    <th colspan="3" class="bg-success" style="text-align: center; width: 60px;">cabinet Structure</th>
                    <th rowspan="2" style="width:75px">Unit Price</th>
                    <th rowspan="2" style="width:75px">Total Price</th>
                    <th rowspan="2" style="width:70px">Aprox Vol</th>
                    <th rowspan="2">Descripcion</th>
                    <th rowspan="2">Note</th>
                </tr>
                <tr>
                    <th class="bg-info" style="width:10px">L</th>
                    <th class="bg-info" style="width:10px">R</th>
                    <th class="bg-info" style="width:10px">L</th>
                    <th class="bg-info" style="width:10px">R</th>
                    <th class="bg-success" style="width:20px">Height</th>
                    <th class="bg-success" style="width:20px">Width</th>
                    <th class="bg-success" style="width:20px">Depth</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $item = 1;
                foreach ($tbody as $d):
                    ?>
                <tr id="tr-<?= $item ?>">
                    <td style="">
                        <button type="button" class="btn btn-info btn-xs btn-tabla" onclick="ShowItems(<?=$item?>)"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-xs btn-tabla" onclick="DeleteItems(<?=$item?>)"><i class="fa fa-trash"></i></button>
                    </td>
                        <td style=""><?= $item ?></td>
                        <td><?= $d['qty'] ?></td>
                        <td ><?= $d['code'] ?></td>
                        <td ><?= $d['code1'] ?></td>
                        <td><?= $d['code_esp'] ?></td>
                        <td class="bg-info"><?= $d['hinges_left'] ?></td>
                        <td class="bg-info"><?= $d['hinges_right'] ?></td>
                        <td ><?= $d['route'] ?></td>
                        <td ><?= $d['opening'] ?></td>
                        <td ><?= $d['door_style'] ?></td>
                        <td class="bg-info"><?= $d['finished_side_left'] ?></td>
                        <td class="bg-info"><?= $d['finished_side_right'] ?></td>
                        <td class="bg-success"><?= $d['height'] ?></td>
                        <td class="bg-success"><?= $d['width'] ?></td>
                        <td class="bg-success"><?= $d['depth'] ?></td>
                        <td ><?= $d['unit_prices'] ?></td>
                        <td ><?= $d['total_prices'] ?></td>
                        <td ><?= round($d['volume'],2) ?></td>
                        <td ><?= $d['description'] ?></td>
                        <td ><?= $d['notes'] ?></td>
                    </tr>
                    <?php $item++;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>