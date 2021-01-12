<style>td{vertical-align: middle !important;}</style>
<table id="table_pieces" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Cod.Pieza</th>
            <th>Tipo</th>
            <th>Cant</th>
            <th>Acabado</th>
            <th>LaminaAX</th>
            <th>Canto</th>
            <th>Alto</th>
            <th>Ancho</th>
            <th>Calibre</th>
            <th>Peso</th>
            <th>Area</th>
            <th>Img</th>
            <th style="min-width:80px"></th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach ($PiecesRecord as $t) : 
            $arrayCantos = explode(";",$t->cantos);
            $arrayGeneral = array("1: N/A","2: N/A","3: N/A","4: N/A");
            if(!empty($t->cantos)){
                foreach ($arrayCantos as $a):
                    $arrayCanto = explode("-",$a);
                    $arrayGeneral[$arrayCanto[0]-1] = $arrayCanto[0].":".$arrayCanto[1];
                endforeach;
            }
        ?>
            <tr>
                <td ><?= (empty($t->IDPIEZA))?"":$t->IDPIEZA."-".$t->FLENG."X".$t->FWIDTH ?></td>
                <td ><?= $t->NAME ?></td>
                <td ></td>
                <td ><?= $t->RENDERPMAT ?></td>
                <td ><?=$t->MATNAME ?></td>
                <td ><?=$arrayGeneral[0]?><br /><?=$arrayGeneral[1]?><br /><?=$arrayGeneral[2]?><br /><?=$arrayGeneral[3]?><br /></td>
                <td style="text-align:center"><?= $t->FLENG ?></td>
                <td style="text-align:center"><?= $t->FWIDTH ?></td>
                <td style="text-align:center"><?= $t->FTHK ?></td>
                <td style="text-align:center"><?= round($t->WEIGHT,2) ?></td>
                <td style="text-align:center"><?= round($t->AREA,2) ?></td>
                <td ><img src="<?=SERVER_IMOS."/$t->ORDERIDGPRS/BITMAPS/$t->ID.png";?>" style="max-width:65px"></td>
                <td ><button type="button"  class="btn btn-default" onclick="Showbarcode('<?=$idProadmin?>',<?= $t->ID ?>,'<?= $t->IDPIEZA."-".$t->FLENG."X".$t->FWIDTH ?>')"><i class="fa fa-barcode"></i></button>
                    <button type="button"  class="btn btn-default" onclick="ShowComments('<?=$idProadmin?>',<?= $t->ID ?>,'<?= $t->IDPIEZA."-".$t->FLENG."X".$t->FWIDTH ?>')"><i class="fa fa-info"></i></button> 
                    <input type="hidden" id="com-<?= $idProadmin ?>-<?= $t->ID ?>" value="<?= $t->TEXT1 ?>" >
                </td>
            </tr>
        <?php endforeach; ?>
            
        <?php foreach ($PiecesAdd as $t) : ?>
        <tr id="tr-<?= $t->id_pieces_line ?>">
            <td id="code-<?= $t->id_pieces_line ?>"><?= $t->code ?></td>
            <td id="name-<?= $t->id_pieces_line ?>"><?= $t->name ?></td>
            <td id="qty-<?= $t->id_pieces_line ?>" style="text-align:center"><?= $t->qty ?></td>
            <td id="finished-<?= $t->id_pieces_line ?>"><?= $t->finished ?></td>
            <td id="code_sheet_ax-<?= $t->id_pieces_line ?>"><?=$t->code_sheet_ax ?></td>
            <td id="canto-<?= $t->id_pieces_line ?>">1:<?=$t->a1?><br />2:<?=$t->l1?><br />3:<?=$t->a2?><br />4:<?=$t->l2?><br /></td>
            <td id="height-<?= $t->id_pieces_line ?>" style="text-align:center"><?= $t->height ?></td>
            <td id="width-<?= $t->id_pieces_line ?>" style="text-align:center"><?= $t->width ?></td>
            <td id="caliber-<?= $t->id_pieces_line ?>" style="text-align:center"><?= $t->caliber ?></td>
            <td id="weight-<?= $t->id_pieces_line ?>" style="text-align:center" ><?= $t->weight ?></td>
            <td id="area-<?= $t->id_pieces_line ?>" style="text-align:center"><?= round($t->area,2) ?></td>
            <td ></td>
            <td >
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="DetailsPiece(<?= $t->id_pieces_line ?>)"><i class="fa fa-search"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteDetailsPiece(<?= $t->id_pieces_line ?>)"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>