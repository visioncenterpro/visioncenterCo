<style>
    #print-img{border: 1px solid #e0d7d7;}
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
    th{text-align: center;}
    .modal-dialog{width: 60%;}
    .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
        border: 0px solid #f4f4f4;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Order Imos</h3>
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

<div class="modal fade" id="modal">
    <div class="modal-dialog" style="width:300px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parametrizar Etiquetas</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Cantidad Minima De Piezas</label>
                            <input type="number" class="form-control" id="quantity" value="5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Generacion Estandar</label>
                            <select class="form-control" id="type" >
                                <option value="">. . .</option>
                                <option value="D">DOBLE</option>
                                <option value="S">SIMPLE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="table-sheet">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-default pull-right" id="btn-tags2" >Generar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var order, idorder;
    var arrayGeneral = [];

    $(document).ready(function () {
        //TableData("table_order_total");
        $("#table_order_total").DataTable();

    });

    function Report_ALL(){

        var a = document.createElement('a');
        a.href = "<?= base_url()?>Imos/Order/C_Pdf/ConsolidatedTotalOrder/"+arrayGeneral;
        a.setAttribute('target', '_blank');
        a.click();
        swal({title: '', text: '', type: 'success'});
    }

    function Report_All2(){
        var a = document.createElement('a');
        a.href = "<?= base_url()?>Imos/Order/C_Pdf/ConsolidatedTotalOrder2/"+arrayGeneral;
        a.setAttribute('target', '_blank');
        a.click();
        swal({title: '', text: '', type: 'success'});
    }

    function array_total(order,obj){
        if(obj.checked){
            arrayGeneral.push(order);
        }else{
            var index = arrayGeneral.indexOf(order);
            if (index > -1) {
                arrayGeneral.splice(index, 1);
            }
        }
    }
</script>