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
                        <th style="width: 70px">ITEM</th>
                        <th>DESCRIPCION</th>
                        <th style="width: 70px">PACK</th>
                        <th style="width: 70px">CANTIDAD</th>
                        <th style="width: 50px">ENTREGADO</th>
                        <th style="width: 50px">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($packets as $key => $p) : ?>
                        <tr>
                            <td style="text-align: center"><?= $p->item ?></td>
                            <td><?= $p->description ?></td>
                            <td style="text-align: center"><?= $p->number_pack."".$p->code ?></td>
                            <td style="text-align: center"><?=$p->quantity_packets?></td>
                            <td style="text-align: center"><?=$p->delivered_quantity?></td>
                            <?php if($p->quantity_packets - $p->delivered_quantity == 0){ ?>
                                    <td style="text-align: center; background-color: #b6ef9e;"><?=$p->quantity_packets - $p->delivered_quantity?></td>
                            <?php    }else{ ?>
                                    <td style="text-align: center"><?=$p->quantity_packets - $p->delivered_quantity?></td>
                            <?php    } ?>
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
                        <?php
                            $count = 0;
                            foreach ($off['data'] as $value) {
                                $count = $count + $value->quantity_packets;
                            } 
                        ?>
                        <h3 id="count"><?=$count?></h3>

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