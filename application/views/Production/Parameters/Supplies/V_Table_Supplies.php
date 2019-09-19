<table id="table_supplies" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="max-width:280px;text-align:center">NOMBRE</th>
            <th style="text-align:center;max-width:80px;">CODIGO AX</th>
            <th style="text-align:center;max-width:100px;">CANT/PAQUETE</th>
            <th style="text-align:center;max-width:100px;">PESO POR PAQUETE</th>
            <th style="text-align:center;max-width:100px;">DIMENSION</th>
            <th style="text-align:center;max-width:120px;">UNIDAD</th>
            <th style="text-align:center;max-width:120px;">TIPO</th>
            <th style="text-align:center;max-width:20px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $data) : ?>
        <tr>
            <td style="text-align:left" class='name-<?= $data->id_supplies ?>'><?=$data->name?></td>
            <td style="text-align:left" class='code-<?= $data->id_supplies ?>'><?=$data->code?></td>
            <td style="text-align:left" class='<?=(!empty($data->quantity_per_package))?"bg-info":"bg-danger"?> quantity-<?= $data->id_supplies ?>'><?=$data->quantity_per_package?></td>
            <td style="text-align:left" class='<?=(!empty($data->weight_per_package))?"bg-success":"bg-danger"?> weight-<?= $data->id_supplies ?>'><?=$data->weight_per_package?></td>
            <td style="text-align:left" class='dimension-<?= $data->id_supplies ?>'><?=$data->dimension?></td>
            <td style="text-align:left" class='code_unit-<?= $data->id_supplies ?>' code_unit='<?= $data->id_unit ?>'><?=$data->d_unit?></td>
            <td style="text-align:left" class='code_type-<?= $data->id_supplies ?>' code_type='<?= $data->id_type_supplies ?>'><?=$data->d_type?></td>
            <td>
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="openModalUpdate(<?= $data->id_supplies ?>)"><i class="fa fa-search"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


