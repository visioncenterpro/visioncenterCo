<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Usuarios</h3>

            </div>
            <div class="box-body">
                <div class="row"> 
                    <div class="col-md-12" id="content-table">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>
<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-lg">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">DATOS USUARIO</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombres / Apellidos</label>
                                <input type="text" name="name" class="form-control required" id="name" placeholder="Nombres / Apellidos"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="nombre">Usuario</label>
                                <input type="text" name="user" class="form-control required" id="user"  placeholder="Nombres Usuario"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="nombre">Contraseña</label>
                                <input type="password" name="password" class="form-control required" id="password"  placeholder="Contraseña"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="nombre">Repetir Contraseña</label>
                                <input type="password" name="passworvalida" class="form-control required" id="passworvalida" placeholder="Repetir Contraseña"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register form-email">
                                <label for="nombre">Correo</label>
                                <input type="text" name="email" class="form-control required" id="email"  placeholder="E-mail" onchange="validacorreo()"/>
                                <span id="emailOK" style="font-size: 15px;color: red;"  ></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="rol">Rol</label>
                                <select name="rol" class="form-control required" id="rol">
                                    <option value="">. . .</option>
                                    <?php foreach ($rol as $r) : ?>
                                        <option value="<?= $r->id_roles ?>"><?= $r->rol ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="avatar"> Seleccionar Avatar</label>
                                <select name="avatar" class="form-control required" id="avatar" onchange="validaavatar()" >
                                    <option value="">. . .</option>
                                    <option value="Avatar.png">Avatar</option>  
                                    <option value="Avatar2.png">Avatar2</option>
                                    <option value="Avatar3.png">Avatar3</option>  
                                    <option value="Avatar04.png">Avatar4</option>
                                    <option value="Avatar5.png">Avatar5</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div cclass="box-body" id="div-img-avatar">
                                <div class="box-body box-profile">
                                    <img src="<?= base_url() ?>dist/img/SAvatar.png" id="pngavatar" name="pngavatar">
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                <button type="button" class="btn btn-primary create" onclick="CreateUser()">CREAR</button>
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var column = [{"sWidth": "10%"}, {"sWidth": "8%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "3%"}];
    $(function () {
        CreateDataTable("tabla_user", false, false, true, true, true, column);
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

    function validacorreo() {
        var correo = event.target;
        valido = document.getElementById('emailOK');
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        //Se muestra un texto a modo de ejemplo, luego va a ser un icono
        if (emailRegex.test(correo.value)) {
            var data = new FormData();
            data.append('email', correo);
            $.ajax({
                url: "<?= base_url() ?>Parameters/User/C_User/ValidaCorreo",
                type: 'POST',
                data: data,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res != "OK") {
                        $(".form-email").addClass("has-error").removeClass("has-success");
                        valido.innerText = "incorrecto";

                    } else {
                        $(".form-email").addClass("has-success").removeClass("has-error");

                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});

            });
            //valido.innerText = "";
        } else {
            valido.innerText = "incorrecto";
            $(".form-email").addClass("has-error").removeClass("has-success");
        }


    }
    function Update(id_users) {

        window.location = '<?= base_url(); ?>Parameters/User/C_User/InfoUser/' + id_users;

    }
    function Create() {
        $("#form")[0].reset();
        $(".update").hide();
        $(".create").show();
        $("#menu_form").modal("show");
    }

    function CreateUser() {
        if ($(".form-email").hasClass("has-error")) {
            alertify.error("FAVOR A REVISAR CORREO")
            $("#email").focus();
            return false
        }

        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            var password = $("#password").val();
            var passworvalida = $("#passworvalida").val();
            if (password != passworvalida) {
                var notification = alertify.notify('POR FAVOR REVISAR LAS CONTASEÑAS NO COINCIDEN', 'error', 5,
                        function () {
                            console.log('POR FAVOR REVISAR LAS CONTASEÑAS NO COINCIDEN');
                        });
                return false
            }

            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?= base_url() ?>Parameters/User/C_User/CreateUser",
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
                            var table = CreateDataTable("tabla_user", false, false, true, true, true, column);
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
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        }
    }

    function Delete(id_user, titulo) {
        swal({
            title: 'Esta seguro de eliminar el Usuario ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Parameters/User/C_User/DeleteUser", {id_user: id_user}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                            $("#content-table").html(data.tabla);
                            var table = CreateDataTable("tabla_user", false, false, true, true, true, column);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                        });
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        }).catch(swal.noop)
    }

    function validaavatar() {
        var avatarpng = $("#avatar").val();
        $("#div-img-avatar").html('<img src="<?= base_url() ?>dist/img/' + avatarpng + '">');

    }

</script>