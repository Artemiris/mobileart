<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $r_record ReportRecord*/

use common\models\ReportRecord;

$this->title = Yii::t('app', 'Report');
?>

<?=
    $this->render('_report_form', ['r_record' => $r_record]);
?>
