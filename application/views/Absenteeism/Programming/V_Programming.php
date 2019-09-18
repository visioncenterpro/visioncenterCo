<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <section class="content-header">
                    <h1>
                        PROGRAMACION  || 
                        <small>Listado de operacion - lideres - cuadradores - aux - recuperadores  </small>
                    </h1>

                </section>
            </div>
            <div class="box-body">
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

        </div>
    </section>
</div>
<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-lg">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">NUEVO OPERARIO</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Cedula </label>
                                <input type="text" name="identification" class="form-control required" id="identification" placeholder="Cedula"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombres </label>
                                <input type="text" name="name" class="form-control required" id="name" placeholder="Nombres"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="last_name">Apellido</label>
                                <input type="text" name="last_name" class="form-control required" id="last_name"  placeholder="Apellidos"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="seccion">Seccion</label>
                                <select name="seccion" class="form-control required" id="seccion">
                                    <option value="">. . .</option>
                                    <?php foreach ($seccion as $r) : ?>
                                        <option value="<?= $r->id_pro_area ?>"><?= $r->description ?></option>
                                    <?php endforeach; ?>
                                </select>    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" class="form-control required" id="tipo">
                                    <option value="">. . .</option>
                                    <?php foreach ($tiporoll as $r) : ?>
                                        <option value="<?= $r->id_abs_type_rol ?>"><?= $r->descripcion ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="equipo">Equipo</label>
                                <select name="equipo" class="form-control required" id="equipo">
                                    <option value="">. . .</option>
                                    <?php foreach ($equipos as $e) : ?>
                                        <option value="<?= $e->id_team_work ?>"><?= $e->description ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="turno">Turno</label>
                                <select name="turno" class="form-control required" id="turno">
                                    <option value="">...</option>
                                    <option value="1">1</option> 
                                    <option value="2">2</option> 
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="cat">Categoria</label>
                                <select name="cat" class="form-control required" id="cat">
                                    <option value="">...</option>
                                    <option value="A">A</option> 
                                    <option value="B">B</option> 
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select> 
                            </div>
                        </div>
                    </form>
                </div>
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
    $(function () {
        $(".select2").select2();
        CreateDataTable('tabla_programacion',false,false,true,true);
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


    function Update(id_users) {
        window.location = '<?= base_url(); ?>Absenteeism/Programming/C_Programming/Infoperson/' + id_users;
    }
    function Create() {
        $("#form")[0].reset();
        $(".update").hide();
        $(".create").show();
        $("#menu_form").modal("show");
    }
    function CreateUser() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {

            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?= base_url() ?>Absenteeism/Programming/C_Programming/CreateUser",
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
                            CreateDataTable('tabla_programacion',false,false,true,true);
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
                $.post("<?= base_url() ?>Absenteeism/Programming/C_Programming/DeleteProgramming", {id_user: id_user}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                            $("#content-table").html(data.tabla);
                            CreateDataTable('tabla_programacion',false,false,true,true);
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
    function descargar() {
        window.location = '<?= base_url(); ?>Absenteeism/Programming/home/programacion';
    }


</script>