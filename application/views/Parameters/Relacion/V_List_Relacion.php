<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Relaciónes Menú - Rol</h3>
                <label style="float: right; margin-right:7%;">
                    <a onclick="Create_modal()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#">
                        <span><i class="fa fa-plus"></i> Crear</span>
                    </a>
                </label>
            </div>
            <div class="box-body">
                <div class="col-md" id="content-table">
                    <?= $table ?>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Relación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group">
              <label>Lista de Menus</label>
              <select class="form-control" id="lista_m" multiple="multiple">
                  <?php foreach ($list_menu as $lm){ ?>
                  <option value="<?php echo $lm->id_menu; ?>"><?php echo $lm->title; ?></option>
                  <?php } ?>
              </select>
            </div>
          
            <div class="form-group">
              <label>Lista de Roles</label>
              <select class="form-control" id="rol">
                  <?php foreach ($list_rol as $lr){ ?>
                  <option value="<?php echo $lr->id_roles; ?>"><?php echo $lr->description; ?></option>
                  <?php } ?>
              </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="Create()">Crear</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Relación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="id_relacion">
            <div class="form-group">
              <label>Lista de Menus</label>
              <select class="form-control" id="lista_m_edit" multiple="multiple">
                  <?php foreach ($list_menu as $lm){ ?>
                  <option value="<?php echo $lm->id_menu; ?>"><?php echo $lm->title; ?></option>
                  <?php } ?>
              </select>
            </div>
          
            <div class="form-group">
              <label>Lista de Roles</label>
              <select class="form-control" id="rol_edit">
                  <?php foreach ($list_rol as $lr){ ?>
                  <option value="<?php echo $lr->id_roles; ?>"><?php echo $lr->description; ?></option>
                  <?php } ?>
              </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="Update()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        var table = $("#tabla_roles").DataTable();
        $('#lista_m').select2({
            width: '100%',
            placeholder: 'Seleccione un menú'
            //maximumSelectionLength: 1
        });
    });
    
    
    function Create_modal(){
        $("#modal_crear").modal("show");
    }
    
    function Create(){
        var menu = $("#lista_m").val();
        var rol = $("#rol").val();
        if(menu.length == 0){
            swal(
                'Atención',
                'Ingrese todos los campos al formulario',
                'error'
            );
        }else{
            $.ajax({
                url:  '<?= base_url('Parameters/Relacion/C_Relacion/create') ?>',
                type: 'POST',
                data: {menu:menu,rol:rol},
                success: function(data){
                    console.log(data);
                    swal(
                        'Exito',
                        'Se han guardado las relaciónes',
                        'success'
                    ).then((result) => {
                        if(result){
                            location.reload();
                        }else{
                            location.reload();
                        }
                        console.log(result);
                    });
                }
            });
        }
    }
    
    function edit_modal(id_relacion){
        $.ajax({
            url:  '<?= base_url('Parameters/Relacion/C_Relacion/getData') ?>',
            type: 'POST',
            data: {id_relacion:id_relacion},
            success: function(data){
                var dato = JSON.parse(data);
                dato.forEach(function(dato){
                    var menu = dato['id_menu'];
                    $("#lista_m_edit").val(menu).change();
                    $("#lista_m_edit").select2({
                        width: '100%'
                    });
                    var elemento = dato['id_roles'];
                    $("#rol_edit").val(elemento).change();
                    $("#modal_editar").modal("show");
                    $("#id_relacion").val(dato['id_roles_menu']);
                }); 
                
            }
        });
    }
    
    function Update(){
        
        var menu = $("#lista_m_edit").val();
        var rol = $("#rol_edit").val();
        var id_relacion = $("#id_relacion").val();
        console.log(menu);
        if(menu.length == 0){
            swal(
                'Atención',
                'Ingrese todos los campos al formulario',
                'error'
            );
        }else{
            $.ajax({
                url:  '<?= base_url('Parameters/Relacion/C_Relacion/Update') ?>',
                type: 'POST',
                data: {menu:menu,rol:rol,id_relacion:id_relacion},
                success: function(data){
                    console.log(data);
                    swal(
                        'Exito',
                        'Se han guardado los cambios',
                        'success'
                    ).then((result) => {
                        if(result){
                            location.reload();
                        }else{
                            location.reload();
                        }
                        console.log(result);
                    });
                }
            });
            //$('#tabla_roles').DataTable().ajax.reload();
        }
    }
    
    function Delete(id_relacion){
        swal({
            title: 'Atencion!',
            text: "Desea eliminar esta relación?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:'No',
            confirmButtonText: 'Si'
          }).then((result) => {
              
            if (result) {
               $.ajax({
                    url:  '<?= base_url('Parameters/Relacion/C_Relacion/Delete') ?>',
                    type: 'POST',
                    data: {id_relacion:id_relacion},
                    success: function(data){
                        console.log(data);
                        swal(
                            'Exito',
                            'Se ha eliminado la relación',
                            'success'
                        ).then((result) => {
                            if(result){
                                location.reload();
                            }else{
                                location.reload();
                            }
                            console.log(result);
                        });
                    }
                });
            }
          });
    }
    
</script>