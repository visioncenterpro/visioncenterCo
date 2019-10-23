<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Entrega De Paquetes SD</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div id="modal_new"  class="modal fade" role="dialog"   >
    <div class="modal-dialog modal-lg" style="width:350px;">
        <div id="" class="modal-content box">
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>X</span></button>
                <h4 class='modal-title text-center'>NUEVA ENTREGA</h4>
            </div>
            <div class='modal-body'>
                <div class='box-body no-padding'>
                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ORDER</label>
                                    <select class="form-control select2 " style="width: 100%;" tabindex="-1" aria-hidden="true" id="order" onchange="">
                                        <option value="">. . .</option>
                                        <?php foreach ($orders as $o) : ?>
                                            <option value="<?= $o->order ?>"><?= $o->order ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="AddDelivery();" type="button" class="btn btn-primary" >ACEPTAR</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(function () {
        TableData("table_delivery", true, false, false);
        $("#table_delivery_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " onclick="OpenModal()"><i class="fa  fa-plus-circle"></i> Crear Entrega</button></label>');

        $(".select2").select2();
    });

    function OpenModal() {
        $("#order").val("").trigger('change.select2');
        $("#modal_new").modal("show");
    }

    function AddDelivery() {
        if (ValidateInput("order")) {
            $("#modal_new").modal("hide");
            swal({
                title: 'Confirma creacion de entrega?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!'
            }).then((result) => {
                if (result) {
                    var order = $("#order").val();
                    $.post("<?= base_url() ?>Production/Delivery/C_Delivery/CreateDeliveryPackage", {order: order}, function (data) {
                        if(data.res == "OK"){
                            window.location.href = "<?= base_url() ?>Production/Delivery/C_Delivery/InfoDeliveryPackage/" + data.id +"/"+ order+"/Delivery";
                        }else if(data.res == "open" || data.res == "zero"){
                            swal({title: 'Error!', text: data.id, type: 'error'});
                        }else if(data.res == "weight"){
                            swal({title: 'Error', text: data.id, type: 'error'});
                        }else{
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                        }
                    }, 'json').fail(function (error) {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    });
                }
            }).catch(swal.noop)
        }
    }
    function InfoDelivery(id_delivery,order) {
        window.location.href = "<?= base_url() ?>Production/Delivery/C_Delivery/InfoDeliveryPackage/" + id_delivery +"/"+ order+"/Delivery";
    }
</script>