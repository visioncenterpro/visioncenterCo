<style>
    td{vertical-align: middle !important;}
    th{text-align: center !important;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><span class="username"><a href="#">ORDER <?= $name ?> (<?= $nameid ?>)</a></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" default>
                        <button type="button"  class="btn btn-default  btn-tabla btn-pieces" onclick=""><i class="fa fa-puzzle-piece"></i> Piezas</button>
                        <button type="button"  class="btn btn-default  btn-tabla btn-ironwork" onclick=""><i class="fa fa-gears"></i> Herrajes</button>
                        <?= $btns ?>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <!-- Custom Tabs (Pulled to the right) -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Piezas</a></li>
                                <li><a href="#tab_2" data-toggle="tab">Herrajes</a></li>
                                <li><a href="#tab_3" data-toggle="tab">Images</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <?= $pieces ?>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <?= $iron ?>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="box box-success">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Perspectiva</h3>
                                                </div>
                                                <div class="box-body">
                                                    <img src="<?=SERVER_IMOS?>/<?= $name ?>/<?= $id ?>_<?= $cpid ?>/PERSP.png" onerror="this.src = '<?= base_url("dist/img/Warning.png") ?>'; this.style='width:50px';" style="max-width: 300px;">
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="box box-success">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Isométrico</h3>
                                                </div>
                                                <div class="box-body">
                                                    <img src="<?=SERVER_IMOS?>/<?= $name ?>/<?= $id ?>_<?= $cpid ?>/EXPLOS_DR.png" onerror="this.src = '<?= base_url("dist/img/Warning.png") ?>'; this.style='width:50px';" style="max-width: 300px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">  
            </div>
        </div>

    </section>

</div>
<div class="modal fade" id="modal-barcode">
    <div class="modal-dialog" style="max-width: 410px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-bar"></h4>
            </div>
            <div class="modal-body" id="body-barcode" style="text-align: center">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header " style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Pieza</h4>
            </div>
            <div class="modal-body">
                <form  method="post" id="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Codigo Pieza</label>
                                <input type="text" class="form-control required" id="code" name="code">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select class="form-control required" id="type" name="type">
                                    <option value="" >. . .</option>
                                    <?php foreach ($typePiece as $v) : ?>
                                        <option value="<?=$v->id_type_pieces?>" ><?=$v->name." (".$v->name_imos.")"?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Acabado</label>
                                <input type="text" class="form-control required" id="finished" name="finished">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control required" id="qty" name="qty">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Calibre</label>
                                <input type="number" class="form-control required" id="caliber" name="caliber">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Alto</label>
                                <input type="number" class="form-control required" id="height" name="height">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ancho</label>
                                <input type="number" class="form-control required" id="width" name="width">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lamina AX</label>
                                <select class="form-control  required" id="code_sheet_ax" name="code_sheet_ax">
                                    <option value="" >. . .</option>
                                    <?php foreach ($sheet as $v) : ?>
                                        <option value="<?=$v->ITEMID?>" ><?=$v->ITEMID." (".$v->ITEMNAME.")"?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Peso</label>
                                <input type="number" class="form-control " id="weight" name="weight">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Canto 1</label>
                                <select class="form-control cantos" id="a1" name="a1">
                                    <option value="N/A" >N/A</option>
                                    <?php foreach ($cantos as $v) : ?>
                                        <option value="<?=$v->ITEMID?>" ><?=$v->ITEMID." (".$v->ITEMNAME.")"?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Canto 2</label>
                                <select class="form-control cantos" id="l1" name="l1">
                                    <option value="N/A" >N/A</option>
                                    <?php foreach ($cantos as $v) : ?>
                                        <option value="<?=$v->ITEMID?>" ><?=$v->ITEMID." (".$v->ITEMNAME.")"?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Canto 3</label>
                                <select class="form-control cantos" id="a2" name="a2">
                                    <option value="N/A" >N/A</option>
                                    <?php foreach ($cantos as $v) : ?>
                                        <option value="<?=$v->ITEMID?>" ><?=$v->ITEMID." (".$v->ITEMNAME.")"?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Canto 4</label>
                                <select class="form-control cantos" id="l2" name="l2">
                                    <option value="N/A" >N/A</option>
                                    <?php foreach ($cantos as $v) : ?>
                                        <option value="<?=$v->ITEMID?>" ><?=$v->ITEMID." (".$v->ITEMNAME.")"?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comentarios</label>
                                <textarea class="form-control" rows="2" id="comments" name="comments" placeholder="..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="create" onclick="AddNewPiece()">Guardar</button>
                <button type="button" class="btn btn-primary pull-right" id="update" style="display:none">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-aditional">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header " style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Adicional</h4>
            </div>
            <div class="modal-body">
                <form  method="post" id="form2" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" class="form-control requiredAd" id="codeAd" name="code">
                            </div>
                        </div>
<!--                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control requiredAd" id="descriptionAd" name="description">
                            </div>
                        </div>-->
<!--                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Unidad</label>
                                <input type="text" class="form-control requiredAd" id="unityAd" name="unity">
                            </div>
                        </div>-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control requiredAd" id="qtyAd" name="qty">
                            </div>
                        </div>
<!--                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Alto</label>
                                <input type="number" class="form-control " id="heightAd" name="height">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ancho</label>
                                <input type="number" class="form-control " id="widthAd" name="width">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Profundidad</label>
                                <input type="number" class="form-control " id="depthAd" name="depth">
                            </div>
                        </div>-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="createAd" onclick="AddNewAditional()">Guardar</button>
                <button type="button" class="btn btn-primary pull-right" id="updateAd" style="display:none">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-com">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-com"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comentarios <label id="warning">(Máximo 80 caracteres permitidos)</label></label>
                            <textarea class="form-control" rows="3" id="comment" placeholder="..."></textarea>
                            <label>Nota: No se permiten los caracteres " y '</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="updateCom">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        TableData("table_pieces");
        $("#table_pieces_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModal()"><i class="fa  fa-plus-circle"></i> Add Piezas</button></label>');
        
        TableData("table_iron");
        $("#table_iron_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModalAdicional()"><i class="fa  fa-plus-circle"></i> Add Adicional</button></label>');

        $(".btn-pieces").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/Pieces/<?= $id ?>/<?= $name ?>/<?= $cpid ?>/<?= $idProadmin ?>/<?= $nameid ?>/<?= $med?>/<?= $pos?>', '_blank');
        });

        $(".btn-ironwork").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/IronWorks/<?= $id ?>/<?= $name ?>/<?= $cpid ?>/<?= $idProadmin ?>/<?= $nameid ?>/<?= $med?>/<?= $pos?>', '_blank');
        });
        
        $(".btn-ironwork-all").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/IronWorksAll/<?= $name ?>', '_blank');
        });
        
        $(".btn-pieces-all").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/PiecesAll/<?= $name ?>', '_blank');
        });
        
        $(".btn-sheets-all").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/ConsolidateSheet/<?= $name ?>', '_blank');
        });
        
        $(".btn-canto-all").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/ConsolidateCanto/<?= $name ?>', '_blank');
        });

        $(".return").click(function () {
            location.href = "<?= base_url() ?>Imos/Order/C_Order/ListItems/<?= $name ?>/<?= $cpid ?>/<?= $idProadmin ?>";
        });
        
        $("#comment").keypress(function(character){
            //console.log(character);
            var characters_count = $("#comment").val().length;
            if(parseInt(characters_count) + 1 > 80){
                $("#warning").attr("style", "color:red");
                return false;
            }
            
        });
         $("#comment").bind('paste', function(e){
            var characters_count = $("#comment").val().length;
            var data = e.originalEvent.clipboardData.getData('Text');
            if(parseInt(data.length) + parseInt(characters_count) > 80){
                $("#warning").attr("style", "color:red");
                return false;
            }
         });
    });
    
    function vali_characters(obj){
        console.log(obj);
    }

    function ShowComments(idproadmin, idbgpl, piece){
        $("#warning").attr("style", "color:black");
        $(".modal-title-com").html("Barcode Referencia : " + piece);
        var data = $("#com-"+idproadmin+"-"+idbgpl).val();
        $("#comment").val(data);
        $("#updateCom").attr("onclick","UpdateComments("+idbgpl+",'"+idproadmin+"')");
        $("#modal-com").modal("show");
    }
    
    function UpdateComments(idbgpl,idproadmin){
        $.post("<?= base_url()?>Imos/Order/C_Order/UpdateComments",{order: '<?= $name ?>', idbgpl: idbgpl, comment:$("#comment").val()},function(data){
           if(data.res == "OK"){
               $("#com-"+idproadmin+"-"+idbgpl).val($("#comment").val());
               $("#modal-com").modal("hide");
               location.reload();
           }else{
               swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
           }
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function Showbarcode(idproadmin, idbgpl, piece) {
        $.post("<?= base_url() ?>Imos/Order/C_Order/ChargedBarcode", {order: '<?= $name ?>', idbgpl: idbgpl}, function (data) {
            var images = "";
            $.each(data, function (i, e) {
                var code = data[i].CNC_NAME.replace(/_/g, "-");
                images += "<img id='bar-" + code + "' class='barcode' code='" + code + "' />";
            });
            $(".modal-title-bar").html("Barcode Referencia : " + piece);
            $("#body-barcode").html(images);

            $(".barcode").each(function () {
                if ($(this).attr("code") != 'null') {
                    JsBarcode("#bar-" + $(this).attr("code"), $(this).attr("code"));
                }
            });

            $("#modal-barcode").modal("show");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function OpenModal(){
        $(".form-group").removeClass("has-error");
        $("#modal-add").modal("show");
        $(".required").val("");
        $(".cantos").val("N/A");
        $("#create").show();
        $("#update").hide();
    }

    function OpenModalAdicional(){
        $(".form-group").removeClass("has-error");
        $("#modal-add-aditional").modal("show");
        $(".requiredAd").val("");
        //$("#heightAd , #widthAd , #depthAd").val(0);
        $("#createAd").show();
        $("#updateAd").hide();
    }
    
    function DetailsAditional(id,table,id_import_salestable){
        $(".form-group").removeClass("has-error");
        $("#createAd").hide();
        $("#updateAd").show();
        $("#updateAd").attr("onclick","UpdateAditional("+id+",'"+table+"',"+id_import_salestable+")");
        
        $.post("<?= base_url() ?>Imos/Order/C_Order/DetailsAditional", {id: id, table:table}, function (data) {
            $.each(data.res,function(e,i){
                $("#"+e+"Ad").val(i);
            });
            $("#modal-add-aditional").modal("show");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    
    function DeleteAditional(id,table) {
        if(table=="sys_import_salesline"){
            var tr = "ac-"+id;
        }else{
            var tr = "ad-"+id;
        }
        
        swal({
            title: 'Esta seguro de eliminar este Item?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Imos/Order/C_Order/DeleteDetailsPiece", {id: id,table:table}, function (data) {
                    if (data.res == "OK") {
                        $('#table_iron').DataTable().destroy();
                        $('#'+tr).remove();
                         
                        TableData("table_iron");
                        $("#table_iron_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModalAdicional()"><i class="fa  fa-plus-circle"></i> Add Adicional</button></label>');
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function DeleteDetailsPiece(id_pieces_line) {
        swal({
            title: 'Esta seguro de eliminar este Item?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Imos/Order/C_Order/DeleteDetailsPiece", {id_pieces_line: id_pieces_line,order:'<?= $name ?>',id_salesline:<?= $id ?>}, function (data) {
                    if (data.res == "OK") {
                        $('#table_pieces').DataTable().destroy();
                        $('#tr-' + id_pieces_line).remove();
                         
                        TableData("table_pieces");
                        $("#table_pieces_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModal()"><i class="fa  fa-plus-circle"></i> Add Piezas</button></label>');
       
                         
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function AddNewAditional(){
        if(ValidateInput("codeAd") && ValidateInput("qtyAd")){
            $("#modal-add-aditional").modal("hide");
            
            var formData = new FormData($('#form2')[0]);
            formData.append("order", '<?= $name ?>');
            formData.append("highart", <?= $id ?>);
            
            $.ajax({
                url: "<?= base_url() ?>Imos/Order/C_Order/AddAditional",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {
                            var table = TableData("table_iron");
                            $("#table_iron_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModalAdicional()"><i class="fa  fa-plus-circle"></i> Add Adicional</button></label>');
                            
                            var rowNode = table.row.add([$("#codeAd").val(),obj.description, $("#qtyAd").val(), obj.und,'<button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="DetailsAditional('+obj.id+',\'imos_aditional_line\')"><i class="fa fa-search"></i></button> <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteAditional('+obj.id+',\'imos_aditional_line\')"><i class="fa fa-trash"></i></button>']).draw().node();
                            $(rowNode).attr("id", "ad-" + obj.id);
                            
                            $("#ad-" + obj.id + " > td")[0].id = "code-ad-" + obj.id;
                            $("#ad-" + obj.id + " > td")[1].id = "desc-ad-" + obj.id;
                            $("#ad-" + obj.id + " > td")[2].id = "qty-ad-" + obj.id;
                            $("#ad-" + obj.id + " > td")[3].id = "uni-ad-" + obj.id;

                        }else{
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: obj.res, type: 'error'});
                        }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
            
        }
    }
    
    function AddNewPiece(){
        if (validatefield()) {
            $("#modal-add").modal("hide");
            var formData = new FormData($('#form')[0]);
            formData.append("order", '<?= $name ?>');
            formData.append("id_salesline", <?= $id ?>);
            formData.append("area", (parseInt($("#width").val())/1000) * (parseInt($("#height").val())/1000));
            $.ajax({
                    url: "<?= base_url() ?>Imos/Order/C_Order/AddPiece",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                            var obj = jQuery.parseJSON(data);
                            if (obj.res == "OK") {
                                
                                var table = TableData("table_pieces");
                                $("#table_pieces_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModal()"><i class="fa  fa-plus-circle"></i> Add Piezas</button></label>');

                                var area = (parseInt($("#height").val())/1000) * (parseInt($("#width").val())/1000);
                                area = Math.round(area * 100) / 100;
                                
                                var a1 = $("#a1").val();
                                var l1 = $("#l1").val();
                                var a2 = $("#a2").val();
                                var l2 = $("#l2").val();
                                
                                var cantos = "1: "+a1+"<br />2: "+l1+"<br />3: "+a2+"<br />4: "+l2+"<br />";
                                var type = $("#type option:selected").text().split(" (");
                                
                                var rowNode = table.row.add([$("#code").val(),type[0], $("#qty").val(),$("#finished").val(), $("#code_sheet_ax").val(),cantos ,$("#height").val(),$("#width").val(),$("#caliber").val(),$("#weight").val(),area ,'','<button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="DetailsPiece('+obj.id+')"><i class="fa fa-search"></i></button> <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteDetailsPiece('+obj.id+')"><i class="fa fa-trash"></i></button>']).draw().node();
                                $(rowNode).attr("id", "tr-" + obj.id);
                                
                                $("#tr-" + obj.id + " > td")[0].id = "code-" + obj.id;
                                $("#tr-" + obj.id + " > td")[1].id = "name-" + obj.id;
                                $("#tr-" + obj.id + " > td")[2].id = "qty-" + obj.id;
                                $("#tr-" + obj.id + " > td")[3].id = "finished-" + obj.id;
                                $("#tr-" + obj.id + " > td")[4].id = "code_sheet_ax-" + obj.id;
                                $("#tr-" + obj.id + " > td")[5].id = "canto-" + obj.id;
                                $("#tr-" + obj.id + " > td")[6].id = "height-" + obj.id;
                                $("#tr-" + obj.id + " > td")[7].id = "width-" + obj.id;
                                $("#tr-" + obj.id + " > td")[8].id = "caliber-" + obj.id;
                                $("#tr-" + obj.id + " > td")[9].id = "weight-" + obj.id;
                                $("#tr-" + obj.id + " > td")[10].id = "area-" + obj.id;
                                
                            }else{
                                swal({title: 'Error Toma un screem y envialo a sistemas!', text: obj.res, type: 'error'});
                            }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
    
    function DetailsPiece(idpieza){
        $(".form-group").removeClass("has-error");
        $("#create").hide();
        $("#update").show();
        $("#update").attr("onclick","UpdatePiece("+idpieza+")");
        $.post("<?= base_url() ?>Imos/Order/C_Order/DetailsPiece", {id: idpieza}, function (data) {
            $(".required").val("");
            $(".cantos").val("N/A");
            $.each(data.res,function(e,i){
                $("#"+e).val(i);
            });
            $("#modal-add").modal("show");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function UpdateAditional(id,table,id_import_salestable){
        if(ValidateInput("codeAd") && ValidateInput("qtyAd")){
            $("#modal-add-aditional").modal("hide");
            var formData = new FormData($('#form2')[0]);
            formData.append("highart", <?=$id?>);
            formData.append("id_table", id);
            formData.append("table", table);
            formData.append("id_import_salestable", id_import_salestable);
            formData.append("order", '<?= $name ?>');

            $.ajax({
                url: "<?= base_url() ?>Imos/Order/C_Order/UpdateAditional",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        
                        var abrev = (table=="sys_import_salesline")?"ac":"ad";
                        
                        var add = (table=="sys_import_salesline")?"(ACK)":"(ADD)";
                        
                        $("#code-"+abrev+"-"+id).text($("#codeAd").val());
                        $("#desc-"+abrev+"-"+id).text(add+" "+obj.description);
                        $("#qty-"+abrev+"-"+id).text($("#qtyAd").val());
                        $("#uni-"+abrev+"-"+id).text(obj.und);
                        
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
    
    function UpdatePiece(idpieza){
        if (validatefield()) {
            $("#modal-add").modal("hide");
            var formData = new FormData($('#form')[0]);
            formData.append("id_piece", idpieza);
            formData.append("order", '<?= $name ?>');
            formData.append("id_salesline", <?= $id ?>);
            formData.append("area", (parseInt($("#width").val())/1000) * (parseInt($("#height").val())/1000));
            $.ajax({
                    url: "<?= base_url() ?>Imos/Order/C_Order/UpdatePiece",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {
                            
                            var area = (parseInt($("#height").val())/1000) * (parseInt($("#width").val())/1000);
                            area = Math.round(area * 100) / 100;

                            var a1 = $("#a1").val();
                            var l1 = $("#l1").val();
                            var a2 = $("#a2").val();
                            var l2 = $("#l2").val();

                            var cantos = "1:"+a1+"<br />2:"+l1+"<br />3:"+a2+"<br />4:"+l2+"<br />";
                            
                            var type = $("#type option:selected").text().split(" (");
                            
                            $("#code-" + idpieza).text($("#code").val());
                            $("#name-" + idpieza).text(type[0]);
                            $("#qty-" + idpieza).text($("#qty").val());
                            $("#finished-" + idpieza).text($("#finished").val());
                            $("#code_sheet_ax-" + idpieza).text($("#code_sheet_ax option:selected").val());
                            $("#canto-" + idpieza).html(cantos);
                            $("#height-" + idpieza).text($("#height").val());
                            $("#width-" + idpieza).text($("#width").val());
                            $("#caliber-" + idpieza).text($("#caliber").val());
                            $("#weight-" + idpieza).text($("#weight").val());
                            $("#area-" + idpieza).text(area);
                        }else{
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: obj.res, type: 'error'});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
</script>
