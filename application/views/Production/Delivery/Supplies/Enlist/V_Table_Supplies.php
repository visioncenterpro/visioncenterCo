<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Insumos</a></li>
        <li><a href="#tab_2" data-toggle="tab">Paquetes</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-8" >
                    <table id="table_supplies"  class="display table table-bordered table-striped table-condensed ">
                        <thead>
                            <tr>
                                <th style="width: 70px">CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th style="width: 70px">CANTIDAD</th>
                                <th style="width: 50px">MEDIDA</th>
                                <th style="width: 50px">ENTREGADO</th>
                                <th style="width: 50px">SALDO</th>
                                <th style="width: 50px">EXCLUIR</th>
                                <th style="width: 50px">DETALLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($record as $key => $t) : 
                                if($t->replaced_supplies != "" || $t->additional == 2){
                                    if($t->replaced_supplies != ""){
                                        $btn = '<button type="button" class="btn btn-success btn-xs btn-tabla" onclick="Detail_replaced('.$t->order.','.$t->id_order_supplies.')" title="Detalle item reemplazado"><i class="fa fa-search"></i></button>';
                                    }else{
                                        $btn = "";
                                    }
                                    $color = "#8aa3dc";
                                    
                                }else{
                                    $color = "white";
                                    $btn = "No hay detalle relacionado";
                                }
                                ?>
                                
                                <tr style="background-color:<?=$color?>;">
                                    <td style="text-align: center"><?= $t->code ?></td>
                                    <td><?= $t->name ?></td>
                                    <td style="text-align: center"><?= $t->quantity ?></td>
                                    <td style="text-align: center"><?= $t->cd." (".$t->description.")" ?></td>
                                    <td style="text-align: center"><?=$delivered[$key]?></td>
                                    <?php if($t->quantity - $delivered[$key] == 0){ ?>
                                        <td style="text-align: center; background-color: #b6ef9e;"><?=$t->quantity - $delivered[$key]?></td>
                                    <?php }else{ ?>
                                        <td style="text-align: center"><?=$t->quantity - $delivered[$key]?></td>
                                    <?php } ?>
                                    <td style="text-align: center">
                                        <input type="checkbox" class="minimal" value="<?=$t->id_order_supplies?>"  <?=($t->exclude == 1)?"checked":""?> > 
                                    </td>
                                    <td style="text-align: center">
                                    <?=$btn?>
                                    </td>
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
                                <h3 id="order-lbl">0</h3>

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

                                <p>Paquetes Creados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-social-dropbox"></i>
                            </div>
                            <a onclick="GeneratePacks('<?=$this->input->post("order")?>')" href="#" class="small-box-footer" style="background: rgb(38, 101, 167);">Calcular Paquetes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <div class="row">
                <div class="col-md-8" id="content-pack">
                    <?=$table_pack?>
                </div>
                <div class="col-md-4">
                    <div class="col-lg-8 col-xs-12">
                        <!-- small box -->
                        <div class="small-box">
                            <div class="inner">
                                <h3 id="order-lbl2">0</h3>

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
                                <?php
                                $total_packed = 0;
                                foreach ($packs as $value) {
                                    $total_packed = $total_packed + $value->quantity_supplies;
                                }
                                $perc = (100 * $total_packed) / $total_quantity; 
                                ?>
                                <h3 id="supplies_per"><?= round($perc)?>%</h3>

                                <p>(<?=$total_packed?> de <?=$total_quantity?>)<br>Porcentaje insumos cargados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-social-dropbox"></i>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

