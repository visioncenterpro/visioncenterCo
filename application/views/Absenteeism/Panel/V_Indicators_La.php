<div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $programing ?></h3>

                <p>Personal Programado</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="<?= base_url() ?>Absenteeism/Programming/C_Programming_La" class="small-box-footer">Programar <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $total ?></h3>

                <p>Ausentismo</p>
            </div>
            <div class="icon">
                <i class="ion ion-calendar">Hoy</i>
            </div>
            <a href="#" id="addAbs" class="small-box-footer">Add Ausentismo Total <i class="fa fa-plus-circle"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $partial ?></h3>
                <p>Ausentismo Parcial
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-clock">Hrs</i>
            </div>
            <a href="#" id="addAbs-nov" class="small-box-footer">Add Ausentismo Parcial <i class="fa fa-plus"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?= number_format($porcent,0,',','' )?><sup style="font-size: 20px">%</sup></h3>
                <p>Actividad</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars">Pro</i>
            </div>
            <a href="#" class="small-box-footer">. . . </a>
        </div>
    </div>
