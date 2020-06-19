<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Reiniciar orden</h3>

            </div>
            <div class="box-body">
                <div class="col-md-10" id="content-table">
                    <label>Order</label>
                    <input type="text" id="order">
                    <button type="button" onclick="RE_ORDER()" class="btn btn-primary">Reiniciar</button>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    function RE_ORDER(){
        if($("#order").val() != ""){
            swal({
                title: 'Desea reiniciar la orden '+$("#order").val(),
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {
                if (result) {
                    $.post("<?= base_url() ?>/Parameters/RE/C_RE_La/RE_ORDER", {order:$("#order").val()}, function (data) {
                        swal(
                          'Exito',
                          'Orden reiniciada',
                          'success'
                        )
                    }, 'json').fail(function (error) {});
                }
            }).catch(swal.noop);
        }else{
            swal(
              'Atención',
              'Ingrese una orden',
              'error'
            )
        }
        
    }

</script>