<div class="nav-tabs-custom">
    <ul class="nav nav-tabs" id="content">
        <li class="active"><a href="#tab_content" data-toggle="tab">Contenedor</a></li>
        <?php foreach ($orders as $key => $v):
         //print_r($validation['modulate'][$key]);
            if($if[$v->order] == 0 || $validation['supplies'][$key] == 0){ ?>
            <li><a href="#tab_<?= $v->order ?>" id="a_<?=$v->order?>" data-toggle="tab"><?= $v->order ?></a></li>
        <?php 
            }
            endforeach; 
        ?>
        
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_content">
            <div class="row">
                <div class="col-md-6">
                    <?= $content ?>
                </div>
                <div class="col-md-6">
                    <?= $contentS ?>
                </div>
            </div>
        </div>
        <?= $tab_pane ?>
    </div>
</div>
