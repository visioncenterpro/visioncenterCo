<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Tipo De Daño De Maquina</h3>
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

<div id="type_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">TIPOS</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <input type="text" name="description" class="form-control required" id="description"  />
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="type">Tipo</label>
                                <select name="type" class="form-control required" id="type" >
                                    <option value="MAQUINA">Maquina</option>
                                    <option value="LOCATIVO">Locativo</option>
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
                <button type="button" class="btn btn-primary create" onclick="CreateType()">CREAR</button>
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    var column = [{"sWidth": "45%"}, {"sWidth": "20%"}, {"sWidth": "20%"}, {"sWidth": "15%"}];

    $(document).ready(function () {
        CreateDataTable("table_damage", false, false, true, true, true, column);
        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
    });

    function Create() {
        $("#form")[0].reset();
        $(".update").hide();
        $(".create").show();
        $("#type_form").modal("show");
    }

    function CreateType() {
        var error = false;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });
        if (!error) {
            var formData = new FormData($('#form')[0]);

            $.ajax({
                url: "<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/CreateTypeDamage",
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
                            var table = CreateDataTable("table_damage", false, false, true, true, true, column);
                            $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                            $("#type_form").modal("hide");
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
    
    function Update(id_type_damage) {
        $("#form")[0].reset();

        $("#description").val($("#desc" + id_type_damage).text());
        $("#type").val($("#type" + id_type_damage).text());
        $("#status").val($("#status" + id_type_damage).attr("val"));
        $(".update").show();
        $(".create").hide();
        $("#type_form").modal("show");
        $(".update").attr("onclick", "Updatetype(" + id_type_damage + ")");
    }

    function Updatetype(id_type_damage) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_type_damage", id_type_damage);
        $.ajax({
            url: "<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/UpdateTypeDamage",
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
                        var table = CreateDataTable("table_damage", false, false, true, true, true, column);
                        $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');
                        $("#type_form").modal("hide");
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
    
    function Delete(id_type_damage, titulo) {
        swal({
            title: 'Esta seguro de eliminar el Tipo ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/DeleteTypeDamage", {id_type_damage: id_type_damage}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                            $("#content-table").html(data.tabla);
                            var table = CreateDataTable("table_damage", false, false, true, true, true, column);
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