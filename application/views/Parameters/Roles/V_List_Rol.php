<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Roles</h3>

            </div>
            <div class="box-body">
                <div class="col-md-8" id="content-table">
                    <?= $table ?>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-mini ">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">DATOS ROL</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" name="descripcion" class="form-control required" id="descripcion"  />
                            </div>
                        </div>
                        <div class="col-md-12">
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
                <button type="button" class="btn btn-primary create" onclick="CreateRol()">CREAR</button>
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>

    var column = [{"sWidth": "60%"}, {"sWidth": "25%"}, {"sWidth": "15%"}];

    $(document).ready(function () {
        CreateDataTable("tabla_roles", false, false, true, true, true, column);
        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
    });

    function Update(id_roles) {
        $("#form")[0].reset();

        $("#descripcion").val($("#desc" + id_roles).text());
        $("#status").val($("#status" + id_roles).attr("val"));
        $(".update").show();
        $(".create").hide();
        $("#menu_form").modal("show");
        $(".update").attr("onclick", "UpdateRol(" + id_roles + ")");
    }

    function UpdateRol(id_roles) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_roles", id_roles);
        $.ajax({
            url: "<?= base_url() ?>Parameters/Roles/C_Roles/UpdateRol",
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({
                        title: 'Operacion Exitosa!',
                            text: "Registro Actualizado.",
                        type: 'success'
                    }).then((result) => {
                        $("#content-table").html(obj.tabla);
                        var table = CreateDataTable("tabla_roles", false, false, true, true, true, column);
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                        $("#menu_form").modal("hide");
                    });
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
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
    }

    function CreateRol() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            var formData = new FormData($('#form')[0]);

            $.ajax({
                url: "<?= base_url() ?>Parameters/Roles/C_Roles/CreateRol",
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
                            var table = CreateDataTable("tabla_roles", false, false, true, true, true, column);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');                            
                            $("#menu_form").modal("hide");
                        });
                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                if(error.status == 200){
                    RedirectLogin();
                }else{
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        }
    }

    function Delete(id_roles, titulo) {
        swal({
            title: 'Esta seguro de eliminar el Rol ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Parameters/Roles/C_Roles/DeleteRol", {id_roles: id_roles}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                            $("#content-table").html(data.tabla);
                            var table = CreateDataTable("tabla_roles", false, false, true, true, true, column);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                        });
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
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