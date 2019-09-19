<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Menu</h3>

            </div>
            <div class="box-body">
                <div class="col-md-10" id="content-table">
                    <?= $table ?>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">DATOS MENU</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titulo">Titulo</label>
                                <input type="text" name="titulo" class="form-control required" id="titulo"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input type="text" name="url" class="form-control required" id="url" />
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" class="form-control required" id="tipo" >
                                    <option value="">. . .</option>
                                    <?php foreach ($type_menu as $t) : ?>
                                        <option value="<?= $t->id_type_menu ?>"><?= $t->description ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="tipo">Padre</label>
                                <select name="padre" class="form-control required" id="padre">
                                    <option value="">. . .</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group register">
                                <label for="icon">Icon</label>
                                <select name="icon" class="form-control required" id="icon">
                                    <option value="">. . .</option>
                                    <?php foreach ($icons as $i) : ?>
                                        <option value="<?= $i->icon ?>"><?= $i->icon ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group register">
                                <label for="nombre">Status</label>
                                <select name="status" class="form-control required" id="status">
                                    <option value="">. . .</option>
                                    <?php foreach ($status as $e) : ?>
                                        <option value="<?= $e->id_status ?>"><?= $e->description ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary create" onclick="CreateMenu()">CREAR</button>
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>

    var column = [{"sWidth": "35%"}, {"sWidth": "26%"}, {"sWidth": "14%"}, {"sWidth": "10%"}, {"sWidth": "15%"}];

    $(document).ready(function () {
        CreateDataTable("tabla_menu", false, false, true, true, true, column);
        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
    });

    function LoadFathers(id_menu, tipo) {
        $("#padre").html("<option value='' >...</option>");
        var items = "";

        var root = (id_menu != 0) ? $("#menu" + id_menu).attr("father") : "";

        if (tipo == 2 || tipo == 4) {
            $.post("<?= base_url('Parameters/Menu/C_Menu/LoadFathers') ?>", {}, function (data) {
                for (var i = 0; i < data.datos.length; i++) {
                    if (id_menu != data.datos[i].id_menu) {
                        items += "<option value='" + data.datos[i].id_menu + "'>" + data.datos[i].title + "</option>";
                    }
                }
                $(items).appendTo("#padre");
                $("#padre").val(root);
            }, 'json');
        } else {
            $("#padre").append("<option value='0' selected >Raiz</option>");
            $("#padre").val(root);
        }
    }

    function Update(id_menu) {
        $("#form")[0].reset();

        $("#titulo").val($("#title" + id_menu).text());
        $("#url").val($("#url" + id_menu).text());
        $("#icon").val($("#icon" + id_menu).attr("val"));
        $("#status").val($("#status" + id_menu).attr("val"));
        $("#tipo").val($("#menu" + id_menu).attr("type"));
        var tipo = $("#menu" + id_menu).attr("type");
        LoadFathers(id_menu, tipo);
        $("#padre").val($("#menu" + id_menu).attr("father"));

        $(".update").show();
        $(".create").hide();

        $("#menu_form").modal("show");
        $(".update").attr("onclick", "UpdateMenu(" + id_menu + ")");
        $("#tipo").attr("onchange", "LoadFathers(" + id_menu + ",this.value)");
    }

    function UpdateMenu(id_menu) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_menu", id_menu);
        $.ajax({
            url: "<?= base_url() ?>Parameters/Menu/C_Menu/UpdateMenu",
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                if (data == "OK") {
                    swal({
                        title: 'Operacion Exitosa!',
                        text: "Registro Actualizado",
                        type: 'success'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    swal({
                        title: 'Error!',
                        text: data,
                        type: 'error'
                    }).then((result) => {

                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function(error) {
            if(error.status == 200){
                RedirectLogin();
            }else{
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }

    function Create() {
        $("#form")[0].reset();
        $(".update").hide();
        $(".create").show();
        $("#menu_form").modal("show");
        $("#tipo").attr("onchange", "LoadFathers(0,this.value)");
    }

    function CreateMenu() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            var formData = new FormData($('#form')[0]);

            $.ajax({
                url: "<?= base_url() ?>Parameters/Menu/C_Menu/CreateMenu",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido creado.",
                            type: 'success'
                        }).then((result) => {
                            $("#content-table").html(obj.tabla);
                            var table = CreateDataTable("tabla_menu", false, false, true, true, true, column);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                            $("#menu_form").modal("hide");
                        });
                    } else {
                        swal({ title: 'Error!',text: obj.res,type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function(error) {
                if(error.status == 200){
                    RedirectLogin();
                }else{
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        }
    }

    function Delete(id_menu,titulo) {
        swal({
            title: 'Esta seguro de eliminar el Menu '+titulo+'!',
            text: "Se eliminaran los Sub-menus dependientes de este!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Parameters/Menu/C_Menu/DeleteMenu",{id_menu:id_menu},function(data){
                    if(data.res == "OK"){
                        swal('Operacion Exitosa!','El registro ha sido eliminado.','success').then((result) => {
                            $("#content-table").html(data.tabla);
                            var table = CreateDataTable("tabla_menu", false, false, true, true, true, column);
                            $("#tabla_menu_filter").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="Create()"><i class="fa  fa-user-plus"></i> CREAR</button></label>');
                        });
                    }else{
                        swal({title: 'Error!',text: data,type: 'error'});
                    }
                },'json').fail(function(error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });
                
              }
        }).catch(swal.noop)
    }

</script>