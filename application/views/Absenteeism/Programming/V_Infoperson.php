<div class="content-wrapper">
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Actualizar Infomacion de Personal</h1>
                        <button type="button" class="btn btn-default  pull-right" onclick="UpdateMachine(<?= $programacion->id_abs_employee ?>)" ><i class="fa fa-fw fa-refresh"></i> ACTUALIZAR</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form role="form" id="form" method="POST" enctype="multipart/form-data">
                                <div class="col-md-3">  
                                    <div class="form-group">
                                        <label for="identification">Cedula</label>
                                        <input type="text"  value="<?= $programacion->identification ?>" name="identification" class="form-control required" id="identification"  />
                                    </div>
                                </div>
                                <div class="col-md-3">  
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text"  value="<?= $programacion->name ?>" name="name" class="form-control required" id="name"  />
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group register">
                                        <label for="last_name">Apellidos</label>
                                        <input type="text"  value="<?= $programacion->last_name ?>" name="last_name" class="form-control required" id="last_name"  />
                                    </div>
                                </div>
                                <div class="col-md-2">   
                                    <div class="form-group">
                                        <label>Area</label>
                                        <select name="seccion" class="form-control required" id="seccion">
                                            <option value="">. . .</option>
                                            <?php foreach ($seccion as $r) : ?>
                                                <option value="<?= $r->id_pro_area ?>" <?= ($programacion->description == $r->description) ? "selected" : "" ?> > <?= $r->description ?></option>

                                            <?php endforeach; ?>
                                        </select>   

                                    </div>
                                </div>
                                <div class="col-md-2">   
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select name="tipo" class="form-control required" id="tipo">
                                            <option value="">. . .</option>
                                            <?php foreach ($tiporoll as $a) : ?>
                                                <option value="<?= $a->id_abs_type_rol ?>" <?= ($programacion->code == $a->code) ? "selected" : "" ?> > <?= $a->descripcion ?></option>

                                            <?php endforeach; ?>
                                        </select>   

                                    </div>
                                </div>
                                <div class="col-md-3">   
                                    <div class="form-group">
                                        <label>Equipo</label>
                                        <select name="equipo" class="form-control required" id="equipo">
                                            <option value="">. . .</option>
                                            <?php foreach ($equipos as $a) : ?>
                                                <option value="<?= $a->id_team_work ?>" <?= ($programacion->tipodescrip == $a->description) ? "selected" : "" ?> > <?= $a->description ?></option>
                                            <?php endforeach; ?>
                                        </select>  

                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group register">
                                        <label for="turno">Turno</label>
                                        <select name="turno" class="form-control required" id="turno">
                                            <option value="">. . .</option>
                                            <?php foreach ($turno as $a) : ?>
                                                <option value="<?= $a->id_work_shift ?>" <?= ($programacion->work_shift == $a->id_work_shift) ? "selected" : "" ?> > <?= $a->id_work_shift ?></option>
                                            <?php endforeach; ?>
                                        </select>  

                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group register">
                                        <label for="cat">Categoria</label>
                                        <select name="cat" class="form-control required" id="cat">
                                            <option value="">. . .</option>
                                            <option value="A" <?= ($programacion->category == 'A') ? "selected" : "" ?>  > A</option>
                                            <option value="B" <?= ($programacion->category == 'B') ? "selected" : "" ?>  > B</option>
                                            <option value="C" <?= ($programacion->category == 'C') ? "selected" : "" ?>  > C</option>
                                            <option value="D" <?= ($programacion->category == 'D') ? "selected" : "" ?>  > D</option>

                                        </select> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12"> 

                                    </div> 
                                </div>      
                            </form>
                        </div> 
                    </div> 
                    <div class="modal-footer">

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<script>


    function UpdateMachine(id_users) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_users", id_users);
        $.ajax({
            url: "<?= base_url() ?>Absenteeism/Programming/C_Programming/UpdatePerson",
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
                    });
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
            if (error.status == 200) {
                RedirectLogin();
            } else {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }


</script>