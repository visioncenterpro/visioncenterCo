<style>
    #print-img{border: 1px solid #e0d7d7;}
</style>
<div class="content-wrapper">
    <section class="content">

        <!-- Default box  87330-50 -->
        <div class="box">
            <div class="box-header with-border">
                <input type="hidden" id="order_p" value="<?= $name?>">
                <h3 class="box-title"><span class="username"><a href="#">ORDER <?= $name ?></a></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Imos</a></li>
                                <li><a href="#tab_2" data-toggle="tab">Acknowledgment</a></li>
                                <li><a href="#tab_3" data-toggle="tab">Imagen</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-12" default>
                                            <button type="button" url="<?= base_url() ?>" class="btn btn-default  btn-tabla btn-add" onclick="showinputs('P')"><i class="fa fa-plus"></i> Agregar Item</button>
                                            <?= $btns ?>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $table ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-12">
                                                <?= $ack ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <img src="<?= SERVER_IMOS ?>/<?= $name . "/" . $name ?>.png" onerror="this.src = '<?= base_url("dist/img/Warning.png") ?>'; this.style='width:50';" class="" style="max-width: 70%;" id="zoom_01">
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

<div class="modal fade" id="modal-add">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header " style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Item</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo Item</label>
                            <select class="form-control" id="type" onchange="showinputs(this.value)">
                                <option value="P" selected>Pieza</option>
                                <option value="H">Herraje</option>
                                <option value="E">Empaque</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" class="form-control required" id="code">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label id="lbl_qty">Cantidad</label>
                            <input type="number" class="form-control required" id="qty">
                        </div>
                    </div>
                    <div class="col-md-4 weight">
                        <div class="form-group">
                            <label>Peso</label>
                            <input type="number" class="form-control " id="weight">
                        </div>
                    </div>
                    <div class="col-md-4 forniture">
                        <div class="form-group">
                            <label>Alto</label>
                            <input type="number" class="form-control required" id="height">
                        </div>
                    </div>
                    <div class="col-md-4 forniture">
                        <div class="form-group">
                            <label>Ancho</label>
                            <input type="number" class="form-control required" id="width">
                        </div>
                    </div>
                    <div class="col-md-4 forniture">
                        <div class="form-group">
                            <label>Profundo</label>
                            <input type="number" class="form-control required" id="depth">
                        </div>
                    </div>
                    <div class="col-md-4 forniture">
                        <div class="form-group">
                            <label>Tipo Pieza</label>
                            <select class="form-control required" id="typepiece" name="typepiece">
                                <option value="" >. . .</option>
                                <?php foreach ($typePiece as $v) : ?>
                                    <option value="<?=$v->id_type_pieces?>" ><?=$v->name." (".$v->name_imos.")"?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 package">
                        <div class="form-group">
                            <label>Volumen Total (M³)</label>
                            <input type="number" class="form-control required" id="volume" disabled="true">
                        </div>
                    </div>
                    <div class="col-md-4 package">
                        <div class="form-group">
                            <label>Porcentaje Adicional</label>
                            <select class="form-control required" id="proportion" onchange="additional_percentage('V',this.value)">
                                <option value="1">1%</option>
                                <option value="2">2%</option>
                                <option value="3">3%</option>
                                <option value="4">4%</option>
                                <option value="5">5%</option>
                                <option value="6">6%</option>
                                <option value="7">7%</option>
                                <option value="8">8%</option>
                                <option value="9">9%</option>
                                <option value="10">10%</option>
                            </select>
<!--                            <label>Porcentaje Adicional</label>
                            <input type="number" class="form-control required" id="proportion">-->
                        </div>
                    </div>
                </div>
                <hr style="border-top: 2px solid #9c9c9e;" id="hr">
                <div class="row">
                    <div class="col-md-4 wc">
                        <div class="form-group">
                            <label>Peso Total (Kg)</label>
                            <input type="number" class="form-control required" id="weight2" disabled="true">
                        </div>
                    </div>
                    <div class="col-md-4 wc">
                        <div class="form-group">
                            <label>Porcentaje Adicional</label>
                            <select class="form-control required" id="proportion-w" onchange="additional_percentage('W',this.value)">
                                <option value="1">1%</option>
                                <option value="2">2%</option>
                                <option value="3">3%</option>
                                <option value="4">4%</option>
                                <option value="5">5%</option>
                                <option value="6">6%</option>
                                <option value="7">7%</option>
                                <option value="8">8%</option>
                                <option value="9">9%</option>
                                <option value="10">10%</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 wc">
                        <div class="form-group">
                            <label>Peso Calculado (Kg)</label>
                            <input type="number" class="form-control required" id="weight_c" disabled="true">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="AddNewItem()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-update">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modificar Adicional</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" class="form-control" id="codeU">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control" id="qtyU">
                        </div>
                    </div>
                    <div class="col-md-4 fornit">
                        <div class="form-group">
                            <label>Alto</label>
                            <input type="number" class="form-control " id="heightU">
                        </div>
                    </div>
                    <div class="col-md-4 fornit">
                        <div class="form-group">
                            <label>Ancho</label>
                            <input type="number" class="form-control " id="widthU">
                        </div>
                    </div>
                    <div class="col-md-4 fornit">
                        <div class="form-group">
                            <label>Profundo</label>
                            <input type="number" class="form-control " id="depthU">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Péso</label>
                            <input type="number" class="form-control" id="weightU">
                        </div>
                    </div>
                    <div class="col-md-4 fornit">
                        <div class="form-group">
                            <label>Tipo Pieza</label>
                            <select class="form-control" id="typepieceU" >
                                <option value="" >. . .</option>
                                <?php foreach ($typePiece as $v) : ?>
                                    <option value="<?=$v->id_type_pieces?>" ><?=$v->name." (".$v->name_imos.")"?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="btn-update">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ajaxStart(function () {
        $(".overlay_ajax").show();
    }).ajaxStop(function () {
        $(".overlay_ajax").hide();
        $(".loader_ajax2").text("");
    });
    
    $(function () {
        $(".package").hide();
        $(".wc").hide();
        $("#hr").hide();
        var table = $('.table').DataTable({
            "scrollY": "400px",
            "paging": false,
            fixedHeader: true,
            sScrollX: true,
            scrollCollapse: true
        });
        
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            table.columns.adjust();
        });
        
        $("#table-asoc_filter").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="sendData()"><i class="fa  fa-save"></i> Guardar</button></label>');


        $(".btn-add").click(function () {
            $("#modal-add").modal("show");
            $(".required").val("");
            $("#weight").val("");
        });

        $(".return").click(function () {
            location.href = "<?= base_url() ?>Imos/Order/C_Order_La";
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
        
        $(".btn-consolidated_total").click(function () {
            window.open('<?= base_url() ?>Imos/Order/C_Pdf/ConsolidatedTotal/<?= $name ?>', '_blank');
        });
        
        $(".btn-export-lmat").click(function () {
            $.post("<?= base_url() ?>Imos/Order/C_Pdf/validate_LMAT", {name: $("#order_p").val()}, function (data) {
               if(data == 0){
                   window.location = "<?= URL_PROJETC ?>Imos/Order/C_Pdf/ExportLMAT?name="+$("#order_p").val();
               }else{
                   swal({title: 'Atención', text: 'No se puede generar el reporte, no se encontraron datos en Imos por favor agregarlos', type: 'error'});
               }
                
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
            //window.open('<?= base_url() ?>Imos/Order/C_Pdf/ExportLMAT/<?= $name ?>', '_blank');
        });

    });

    function ShowDetailsItem(id, order, cpid, idProadmin, nameid, med, pos) {
        location.href = "<?= base_url() ?>Imos/Order/C_Order_La/ShowDetailsItem/" + id + "/" + order + "/" + cpid + "/" + idProadmin + "/" + nameid+ "/" + med+ "/" + pos;
    }

    function ShowDetailsItemLocal(id, order) {
        location.href = "<?= base_url() ?>Imos/Order/C_Order_La/ShowDetailsItemLocal/" + id + "/" + order;
    }

    function showinputs(valor) {
        
        switch (valor) {
            case 'P':
                document.getElementById("type").options.selectedIndex = 'P';
                $(".weight").show();
                $(".forniture").show();
                $(".package").hide();
                $(".package > .form-group > .form-control").removeClass("required");
                $(".forniture > .form-group > .form-control").addClass("required");
                $(".wc").hide();
                $(".wc > .form-group > .form-control").removeClass("required");
                $("#hr").hide();
                $("#qty").removeAttr("disabled");
                
                $("#lbl_qty").text("Cantidad");
                $("#qty").val("");
                $("#volume_c").val("");
                $("#weight").val("");
              break;
            case 'H':
                $(".weight").show();
                $(".forniture").hide();
                $(".forniture > .form-group > .form-control").removeClass("required");
                $(".package").hide();
                $(".package > .form-group > .form-control").removeClass("required");
                $(".wc").hide();
                $(".wc > .form-group > .form-control").removeClass("required");
                $("#hr").hide();
                $("#qty").removeAttr("disabled");
                
                $("#lbl_qty").text("Cantidad");
                $("#qty").val("");
                $("#volume_c").val("");
                $("#weight").val(""); 
              break;
            case 'E':
                $(".weight").hide();
                $(".package").show();
                $(".package > .form-group > .form-control").addClass("required");
                $(".forniture").hide();
                $(".forniture > .form-group > .form-control").removeClass("required");
                $(".wc").show();
                $(".wc > .form-group > .form-control").addClass("required");
                $("#hr").show();
                $("#qty").attr("disabled","disabled");
                $("#lbl_qty").text("Volumen Calculado (M³)");
                
                var array_h = document.querySelectorAll("input[id=height_h]");
                var array_height = [];
                array_h.forEach(function(element){
                   array_height.push(element.value);
                });
                
                var array_w = document.querySelectorAll("input[id=width_h]");
                var array_width = [];
                array_w.forEach(function(element){
                   array_width.push(element.value);
                });
                
                var array_we = document.querySelectorAll("input[id=weight_h]");
                var array_weight = [];
                array_we.forEach(function(element){
                   array_weight.push(element.value);
                });
                
                var array_D = document.querySelectorAll("input[id=depth_h]");
                var count = 0;
                var volume = 0;
                var weight_total = 0;
                array_D.forEach(function(element){
                   volume = parseFloat(volume) + ((parseInt(array_height[count]) / parseInt(1000)) * (parseInt(array_width[count]) / parseInt(1000)) * (parseInt(element.value) / parseInt(1000)));
                   weight_total = parseInt(weight_total) +  parseInt(array_weight[count]);
                   count++;
                   //console.log(volume);
                });
                //$("#qty").val(volume);
                $("#volume").val(volume);
                $("#weight2").val(weight_total);
                
                $("#qty").val("");
                $("#weight_c").val("");
                document.getElementById("proportion").options.selectedIndex = '0';
                document.getElementById("proportion-w").options.selectedIndex = '0';
                for(var i = 0; i < 2; i++){
                    if(i == 0){
                        var type = 'V';
                    }else{
                        var type = 'W';
                    }
                    additional_percentage(type,1);
                }
              break;
        }
        //if (valor == 'P') {
//            $(".forniture").show();
//            $(".forniture > .form-group > .form-control").addClass("required");
        //} else {
//            $(".forniture").hide();
//            $(".forniture > .form-group > .form-control").removeClass("required");
        //}
    }
    
    function additional_percentage(type,number){
        switch(type){
            case 'V':
                var volume_c = $("#volume").val();
                var total = (parseFloat(number) * parseFloat(volume_c)) / 100; // porcentaje adicional calculado al volumen total 
                $("#qty").val(parseFloat(total) + parseFloat(volume_c));
                //console.log(total);
                break;
            case 'W':
                var quantity = $("#weight2").val();
                var total = (parseInt(number) * parseInt(quantity)) / 100;
                $("#weight_c").val(parseInt(total) + parseInt(quantity));
                break;
        }
    }

    function AddNewItem() {
        $(".form-group").removeClass("has-error");
        if (validatefield()) {
            $.post("<?= base_url() ?>Imos/Order/C_Order/AddNewItem", {order: '<?= $name ?>', type: $("#type").val(), code: $("#code").val(), qty: $("#qty").val(), weight: $("#weight").val(), height: $("#height").val(), width: $("#width").val(), depth: $("#depth").val(), typepiece: $("#typepiece").val(), weight_c: $("#weight_c").val()}, function (data) {
                if (data.res == "OK") {
                    $('#table_items').DataTable().destroy();

                    var table = $('#table_items').DataTable({
                        "scrollY": "500px",
                        "paging": false,
                        fixedHeader: true,
                        sScrollX: true,
                        scrollCollapse: true
                    });
                    $('a[data-toggle="tab"]').off('shown.bs.tab');
                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                        table.columns.adjust();
                    });
                    
                    item = parseInt($("#max-item").val()) + 1;

                    var item = '' + item;
                    while (item.length < 3) {
                        item = '0' + item;
                    }

                    $("#max-item").val(item);

                    var code = $("#code").val();

                    var type = $("#type").val();

                    var btn = '<button type="button"  class="btn btn-primary btn-xs btn-tabla" onclick="OpenModalDetailsItem(' + data.id + ',\'' + type + '\')"><i class="fa fa-edit"></i></button>';

                    var btn = btn + ' <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteDetailsItem(' + data.id + ')"><i class="fa fa-trash"></i></button>';
                    
                    if($("#type").val() == "E"){
                        var rowNode = table.row.add([item, $("#code").val(), $("#height").val(), $("#width").val(), $("#depth").val(), $("#weight").val(),"1", '',btn]).draw().node();
                    }else{
                        var rowNode = table.row.add([item, $("#code").val(), $("#height").val(), $("#width").val(), $("#depth").val(), $("#weight").val(),$("#qty").val(), '',btn]).draw().node();
                    }
                    

                    $(rowNode).attr("id", "tr-" + data.id);


                    $("#tr-" + data.id + " > td")[1].id = "code-" + data.id;
                    $("#tr-" + data.id + " > td")[2].id = "height-" + data.id;
                    $("#tr-" + data.id + " > td")[3].id = "width-" + data.id;
                    $("#tr-" + data.id + " > td")[4].id = "depth-" + data.id;
                    $("#tr-" + data.id + " > td")[5].id = "weight-" + data.id;
                    $("#tr-" + data.id + " > td")[6].id = "qty-" + data.id;


                    $("#modal-add").modal("hide");
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function OpenModalDetailsItem(id_salesline, type) {
        $("#btn-update").attr("onclick", "UpdateDetailsItem(" + id_salesline + ",\"" + type + "\")");

        $.post("<?= base_url() ?>Imos/Order/C_Order/LoadDetailsItem", {id_salesline: id_salesline}, function (data) {
            $("#codeU").val(data.res.code);
            $("#heightU").val(data.res.height);
            $("#widthU").val(data.res.width);
            $("#depthU").val(data.res.depth);
            $("#weightU").val(data.res.weight);
            $("#qtyU").val(data.res.qty);
            $("#typepieceU").val(data.res.typepiece);

            if (type == "P") {
                $(".fornit").show();
            } else {
                $(".fornit").hide();
            }

            $("#modal-update").modal("show");
        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }

    function UpdateDetailsItem(id_salesline, type) {

        if (type == "P") {
            if (ValidateInput("codeU") && ValidateInput("widthU") && ValidateInput("heightU") && ValidateInput("depthU") && ValidateInput("qtyU") && ValidateInput("typepieceU")) {
                $.post("<?= base_url() ?>Imos/Order/C_Order/UpdateDetailsItem", {type: type, id_salesline: id_salesline, code: $("#codeU").val(), qty: $("#qtyU").val(), typepiece: $("#typepieceU").val(), weight: $("#weightU").val(), width: $("#widthU").val(), height: $("#heightU").val(), depth: $("#depthU").val()}, function (data) {
                    $("#weight-" + id_salesline).text($("#weightU").val());
                    $("#code-" + id_salesline).text($("#codeU").val());
                    $("#qty-" + id_salesline).text($("#qtyU").val());
                    $("#width-" + id_salesline).text($("#widthU").val());
                    $("#height-" + id_salesline).text($("#heightU").val());
                    $("#depth-" + id_salesline).text($("#depthU").val());
                    $("#modal-update").modal("hide");
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        } else {
            if (ValidateInput("codeU") && ValidateInput("qtyU")) {
                $.post("<?= base_url() ?>Imos/Order/C_Order/UpdateDetailsItem", {type: type, id_salesline: id_salesline,qty: $("#qtyU").val(), code: $("#codeU").val(), typepiece: $("#typepieceU").val(), weight: $("#weightU").val()}, function (data) {
                    $("#code-" + id_salesline).text($("#codeU").val());
                    $("#weight-" + id_salesline).text($("#weightU").val());
                    $("#qty-" + id_salesline).text($("#qtyU").val());
                    $("#modal-update").modal("hide");
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }
    }

    function DeleteDetailsItem(id_salesline) {
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
                $.post("<?= base_url() ?>Imos/Order/C_Order/DeleteDetailsItem", {id_salesline: id_salesline}, function (data) {
                    if (data.res == "OK") {
                        $('#table_items').DataTable().destroy();
                        $('#tr-' + id_salesline).remove();
                        
                        var table = $('.table').DataTable({
                            "scrollY": "400px",
                            "paging": false,
                            fixedHeader: true,
                            sScrollX: true,
                            scrollCollapse: true
                        });
                        $('a[data-toggle="tab"]').off('shown.bs.tab');
                        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                            table.columns.adjust();
                        });
                        
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }
    
    function UpdataItemImport(id_salestable, id_salesline) {
       
        var type = $("#type-"+id_salesline).val();
        
        if(type == "AO"){
            $("#highart-"+id_salesline).val("").attr("disabled",true);
        }else{
            $("#highart-"+id_salesline).attr("disabled",false);
        }
    }
    
    function sendData(){
        var array_body = [];
        $("#table-asoc tbody tr").each(function () {
            var array_body_hijo = [];
            var id = $(this).attr("id").substring(5);
            array_body_hijo.push(id);
            array_body_hijo.push($("#type-"+id).val());
            array_body_hijo.push($("#highart-"+id).val());

            array_body.push(array_body_hijo);
        });
        if(array_body.length > 0){
            $.post("<?= base_url() ?>Imos/Order/C_Order_La/ValidateItemImport", {array_body: array_body}, function (data) {
                if (data.res == "OK") {
                    swal({title: 'Exito!', text: "Registros Actualizados", type: 'success'});
                }else{
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
        
    }

</script>