<?php

use common\models\ReportRecord;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $r_record ReportRecord*/

?>
<div class="outrage-form">
    <?php $form = ActiveForm::begin()?>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($r_record, 'description')->textarea(['rows'=>6])?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($r_record, 'fb_mail')->input('email')?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($r_record, 'fb_name')->textInput()?>
        </div>
        <div class="col-xs-6">
            <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end()?>
</div>