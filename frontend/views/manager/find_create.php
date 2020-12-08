<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Find */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\News;
use mihaildev\ckeditor\CKEditor;

$this->title = 'Добавление находки';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    ['label' => 'Коллекция', 'url' => ['/manager/find']],
    $this->title,
];

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_find_form', [
    'model' => $model,
    'data' => $data,
]) ?>