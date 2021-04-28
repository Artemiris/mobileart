<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $r_record ReportRecord*/

use common\models\ReportRecord;

$this->title = Yii::t('app', 'Report');
?>

<div class="row">
    <p class="col-xs-8">
        <?= Yii::t('app', 'Please inform us about errors in the description, not specified or incorrectly specified authors or copyright holder of materials, and in the absence of permission to publish the materials or other copyright infringement. We will respond immediately.')?>
    </p>
</div>

<?=
    $this->render('_report_form', ['r_record' => $r_record]);
?>
