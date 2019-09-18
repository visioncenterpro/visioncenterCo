<style>
.info-box .progress .progress-bar {
    background: #a24161;}    
    
</style>
<?php foreach ($indicators as $i) : ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-gray-light">
            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"> <?= $i->description ?> </span>
                <span class="info-box-number"><?= $i->total ?></span>

                <div class="progress" >
                    <div class="progress-bar "  style=" width: <?= $i->total ?>%"></div>
                </div>
                <a href="#" ><span  class="progress-description"style="color: #000;" onclick="OpenModal(<?= $i->id_area ?>)">
                        Ver Detalle
                    </span> </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>