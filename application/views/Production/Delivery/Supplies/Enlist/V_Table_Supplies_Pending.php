<?php if($index == 0){ ?>
    <div class="tab-pane active" id="tab_<?=$order?>">
<?php }else{ ?>
    <div class="tab-pane" id="tab_<?=$order?>">
<?php } ?>    
    <div class="row">
        <div class="col-md-8" >
            <table id="table_supplies_<?=$order?>"  class="display table table-bordered table-striped table-condensed ">
                <thead>
                    <tr>
                        <th style="width: 70px">CODIGO</th>
                        <th>DESCRIPCION</th>
                        <th style="width: 70px">CANTIDAD</th>
                        <th style="width: 50px">ENTREGADO</th>
                        <th style="width: 50px">SALDO</th>
                        <th style="width: 50px">DETALLE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($supplies as $key => $t) :
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
                            <td style="text-align: center"><?=$data['quantity_packaged'][$key]?></td>
                            <?php if($data['quantity_pending'][$key] == 0){ ?>
                                    <td style="text-align: center; background-color: #b6ef9e;"><?=$data['quantity_pending'][$key]?></td>
                            <?php    }else{ ?>
                                    <td style="text-align: center"><?=$data['quantity_pending'][$key]?></td>
                            <?php    } ?>
                            <td style="text-align: center"><?=$btn?></td>
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
                        <h4 style="font-weight: bold;">
                        <?php
                            foreach ($data_order as $value) {
                                echo $value->client;
                            }
                        ?>
                        </h4>

                        <p>Cliente</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xs-12">
                <!-- small box -->
                <div class="small-box">
                    <div class="inner">
                        <h4 style="font-weight: bold;">
                        <?php
                            foreach ($data_order as $value) {
                                echo $value->project;
                            }
                        ?>
                        </h4>

                        <p>Proyecto</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-folder-open-o"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xs-12">
                <!-- small box -->
                <div class="small-box">
                    <div class="inner">
                        <h3 id="count"><?=$packs?></h3>

                        <p>Paquetes Creados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




