<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-truck "></i> Remisiones</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                Footer
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-dispatch">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ordenes relacionadas al pedido # <label id="request"></label></h4>
            </div>
            <div class="modal-body" id="modal-weight">
                <table id="myTable" class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Cliente</th>
                            <th>Proyecto</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>