<?php

use common\models\ReportRecord;

/* @var ReportRecord[] $r_records */

?>

<?php if (is_array($r_records) && !empty($r_records)):?>
    <?php foreach ($r_records as $record):?>
        <div class="row btn btn-block" style="border-radius: 0.4em; border: 0.1em solid #3c3c3c;">
            <a href="<?= \yii\helpers\Url::toRoute(['report/view', 'id' => $record->id])?>">
                <div class="col-xs-1"><?= $record->id ?></div>
                <div class="col-xs-3"><?= $record->fb_name ?></div>
                <div class="col-xs-8"><?= $record->page_ref ?></div>
            </a>
        </div>
    <?php endforeach;?>
<?php else: ?>
    <div class="row">
        <p class="col-xs-12 text-center text-warning">Никто ничего не зарепортил</p>
    </div>
<?php endif; ?>
