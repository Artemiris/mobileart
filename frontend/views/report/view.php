<?php

use common\models\ReportRecord;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var ReportRecord $record*/

?>
<div class="row">
    <div class="col-xs-6">
        <p class="report-head">
            Описание:
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <p>
            <?= $record->description ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p class="report-head">
            Ссылка:
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p>
            <a href="<?= $record->page_ref ?>" target="_blank"><?= $record->page_ref ?></a>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p class="report-head">
            Отправитель:
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p>
            <?= $record->fb_name ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p class="report-head">
            E-Mail:
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p>
            <?= $record->fb_mail ?>
        </p>
    </div>
</div>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-xs-2"><?= $form->field($record, 'solved')->checkbox() ?></div>
    <div class="col-xs-2"><?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary']) ?></div>
</div>
<?php ActiveForm::end() ?>
