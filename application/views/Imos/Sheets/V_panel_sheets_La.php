<style>
    .small-box:hover { color: #040202;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista laminas</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" id="content">
                        <?=$table?>
                    </div>
                </div>
                <hr style="border-top: 2px solid #b7b5b5;">
                <div class="row" style=" margin-top: 25px;">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs" id="tabs_dinamic">
                                
                            </ul>
                            <div class="tab-content" id="content-table">
                                
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

<div class="modal fade bd-example-modal-lg" id="modal_new">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parametros</h4>
            </div>
            <div class="modal-body" id="content">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Código Lámina<label id="alt"> (Solo alfanuméricos)</label></label>
                            <input type="text" class="form-control" id="code">
                        </div>
                        <div class="form-group">
                            <label>Modelo (Formato Lámina)</label>
                            <select class="form-control" id="format">
                                <?php foreach ($formats as $value){ ?>
                                    <option value="<?=$value->id_pro_shet_area?>"><?=$value->format?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Calibre</label>
                            <select class="form-control" id="caliber">
                                <?php foreach ($calibers as $value){ ?>
                                    <option value="<?=$value->id_caliber?>"><?=$value->caliber?></option>
                                <?php } ?>
                            </select>
<!--                            <input type="number" class="form-control" id="caliber">-->
                        </div>
                        <div class="form-group">
                            <label>Desperdicio</label>
                            <input type="number" class="form-control" id="waste">
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" class="form-control" id="description">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="save()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Parametros</h4>
            </div>
            <div class="modal-body" id="content-edit">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Código Lámina <label id="alte"> (Solo alfanuméricos)</label></label>
                            <input type="hidden" class="form-control" id="id-wood-edit">
                            <input type="text" class="form-control" id="code-edit">
                        </div>
                        <div class="form-group">
                            <label>Modelo (Formato Lámina)</label>
                            <select class="form-control" id="format-edit">
                                <?php foreach ($formats as $value){ ?>
                                    <option value="<?=$value->id_pro_shet_area?>"><?=$value->format?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Calibre</label>
<!--                            <input type="number" class="form-control" id="caliber-edit">-->
                            <select class="form-control" id="caliber-edit">
                                <?php foreach ($calibers as $value){ ?>
                                    <option value="<?=$value->id_caliber?>"><?=$value->caliber?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" class="form-control" id="description-edit">
                        </div>
                        <div class="form-group">
                            <label>Desperdicio</label>
                            <input type="number" class="form-control" id="waste-edit">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="update()">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_sheet_data">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sincronizar Datos Láminas</h4>
            </div>
            <div class="modal-body" id="content-edit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-inline">
                            <label>Fecha 1</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-inline">
                            <label>Fecha 2</label>
                            <input type="date" class="form-control" id="date2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="sync_sheet_data()">Sincronizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function(){
        $("#table_sheets").DataTable({});
        $("#alt").hide();
        $("#alte").hide();
        var valids = "QWERTYUIOPASDFGHJKLÑZXCVBNMabcdefghijklmnñopqrstuvwxyz0123456789-_ ";
        $("#code").keypress(function(character){
            var vali = 0;
            for(var i = 0; i < valids.length; i++){
                if(valids.charAt(i) == character.key){
                    vali = 1;
                }
            }
            if(vali == 0){
                $("#alt").show();
                $("#alt").attr('style', 'color:red');
                return false;
            }
        });
        
        $("#code-edit").keypress(function(character){
            var vali = 0;
            for(var i = 0; i < valids.length; i++){
                if(valids.charAt(i).toLowerCase() == character.key.toLowerCase()){
                    vali = 1;
                }
            }
            if(vali == 0){
                $("#alte").show();
                $("#alte").attr('style', 'color:red');
                return false;
            }
        });
    });
    
    function modal_new(){
        $("#code").val("");
        $("#format").val("");
        $("#caliber").val("");
        $("#description").val("");
        $("#waste").val("");
        
        $("#modal_new").modal("show");
    }
    
    function modal_sheet_data(){
        $("#modal_sheet_data").modal("show");
    }
    
    function sync_sheet_data(){
        if($("#date").val() == "" || $("#date2").val() == ""){
            swal({title: 'Atención!', text: "por favor ingrese todos los datos al formulario", type: 'error'});
        }else{
            $.post("<?= base_url()?>Imos/Sheets/C_Sheets_La/sync_sheet_data",{date:$("#date").val(),date2:$("#date2").val()},function(data){
                if(data.res == "OK"){
                    swal({title: 'Éxito', text: "Datos sincronizados", type: 'success'});
                }
            },'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }
    
    function save(){
        var code = $("#code").val();
        var id_format = $("#format").val();
        var format = $( "#format option:selected" ).text();
        var caliber = $("#caliber").val();
        var description = $("#description").val();
        var waste = $("#waste").val();
        if(code == "" || format == "" || caliber == "" || waste == ""){
            swal({title: 'Atención', text: "Ingrese todos los campos", type: 'error'});
        }else{
            $.post("<?= base_url()?>Imos/Sheets/C_Sheets_La/save_sheet",{code:code,id_format:id_format,format:format,caliber:caliber,description:description,waste:waste},function(data){
                if(data.rs == "RE"){
                    swal({title: 'Atención', text: "El código de lámina ya existe", type: 'error'});
                }else{
                    $("#content").html(data.table);
                    $('#table_sheets').DataTable({});
                    if($("#description").val() == ""){
                        $("#description").val(data.rs['description']);
                    }
                    swal({title: 'Exito', text: "Registro guardado", type: 'success'});
                    $("#modal_new").modal("hide");
                }

            },'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
        
    }
    
    function modal_edit(id_wood_sheet){
        $.post("<?= base_url()?>Imos/Sheets/C_Sheets_La/get_data_edit",{id_wood_sheet:id_wood_sheet},function(data){
            data.sheet.forEach(function(element){
                $("#before-id").val(element.id_pro_sheet_area);
                $("#id-wood-edit").val(element.id_wood_sheet);
                $("#code-edit").val(element.code);
                $("#description-edit").val(element.description);
                $("#format-edit").val(element.format);
                $("#waste-edit").val(element.waste);
                $("#caliber-edit").val(element.caliber);
                
                $("#format-edit option[value="+ element.id_pro_sheet_area +"]").prop("selected",true);
                $("#caliber-edit option[value="+ element.id_caliber +"]").prop("selected",true);
            });
            $("#modal_edit").modal("show");
            
        },'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });
    }
    
    function update(){
        var id = $("#id-wood-edit").val();
        var code = $("#code-edit").val();
        var id_format = $("#format-edit").val();
        var format = $("#format-edit option:selected").text();
        var caliber = $("#caliber-edit").val();
        var description = $("#description-edit").val();
        var waste = $("#waste-edit").val();
        
        if(code == "" || format == "" || caliber == "" || description == "" || waste == ""){
            swal({title: 'Atención', text: "Ingrese todos los campos", type: 'error'});
        }else{
            $.post("<?= base_url()?>Imos/Sheets/C_Sheets_La/update_sheet",{id:id,code:code,id_format:id_format,format:format,caliber:caliber,description:description,waste:waste},function(data){
                if(data.rs == "RE"){
                    swal({title: 'Atención', text: "El código de lámina ya existe", type: 'error'});
                }else{
                    $("#content").html(data.table);
                    $('#table_sheets').DataTable({});
                    swal({title: 'Exito', text: "Registro actualizado", type: 'success'});
                    $("#modal_edit").modal("hide");
                }

            },'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

</script>
