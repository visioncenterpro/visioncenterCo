<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Piezas</a></li>
        <li><a href="#tab_2" data-toggle="tab">Paquetes</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-8" >
                    <table id="table_pieces"  class="display table table-bordered table-striped table-condensed ">
                        <thead>
                            <tr>
                                <th style="width: 100px">REFERENCIA</th>
                                <th >LAMINA</th>
                                <th style="width: 70px">CANTIDAD</th>
                                <th style="width: 50px">LARGO</th>
                                <th style="width: 50px">ANCHO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($record as $t) : ?>
                                <tr>
                                    <td><?= $t->piece ?></td>
                                    <td><?= $t->description ?></td>
                                    <td style="text-align: center"><?= $t->quantity ?></td>
                                    <td style="text-align: center"><?= $t->long ?></td>
                                    <td style="text-align: center"><?= $t->width ?></td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="col-lg-8 col-xs-12">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <h3 id="order-lbl"></h3>

                                <p>Order</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-social-dropbox"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <h3 id="count">0</h3>

                                <p>Paquetes</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-social-dropbox"></i>
                            </div>
<!--                            <a onclick="GeneratePacks('<?=$this->input->post("order")?>')" href="#" class="small-box-footer" style="background: rgb(38, 101, 167);">Calcular Paquetes <i class="fa fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <h3 id="count-weight">0</h3>

                                <p>Peso total</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <h3 id="count-integral">0</h3>

                                <p>Peso integral</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calculator"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <div class="row">
                <div class="col-md-12" id="content-pack">
                    <?=$table_pack?>
                </div>
            </div>
        </div>
    </div>
</div>

