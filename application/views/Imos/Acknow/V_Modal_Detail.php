<div class="row">
    <?php foreach ($fields as $v) : ?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="<?= $v->COLUMN_NAME ?>"><?= $v->COLUMN_NAME ?></label>
                <input type="text" class="form-control input-sm" id="<?= $v->COLUMN_NAME ?>" value="<?= $values[$v->COLUMN_NAME] ?>">
            </div>
        </div>
    <?php endforeach; ?>
</div>