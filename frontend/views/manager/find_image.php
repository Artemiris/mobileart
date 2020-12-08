<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Find */

use common\models\FindImage;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Дополнительные изображения';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    ['label' => 'Коллекция', 'url' => ['/manager/find']],
    ['label' => $model->name, 'url' => ['/manager/find-update', 'id' => $model->id]],
    $this->title,
];
$host = Yii::$app->urlManager->createAbsoluteUrl(['/']);
$csrf_token = Yii::$app->request->csrfToken;
$script = <<< JS

    host = '$host';
    csrf_token = '$csrf_token';

JS;
$this->registerJs($script, yii\web\View::POS_READY);

\frontend\assets\ImgEdAsset::register($this);

?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="clearfix">
    <?= Html::a('Назад', ['/manager/find-update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
</div>

<br>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'fileImages[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>


<div class="clearfix"></div>
<?php if (!empty($model->images)): ?>
    <div class="row">
        <?php foreach ($model->images as $item): ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div style="position: relative">
                    <?= Html::a('Удалить', ['manager/image-delete', 'id' => $item->id], [
                        'class' => 'btn btn-danger',
                        'style' => 'position: absolute; right: 5px; top: 5px;',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить?',
                            'method' => 'post',
                        ]
                    ]) ?>
                    <?= Html::img(FindImage::SRC_IMAGE . '/' . FindImage::THUMBNAIL_PREFIX . $item->image, ['id' => 'image' . $item->id . ' ' . $item->author .' '. $item->copyright . ' ' . $item->license, 'class' => 'img-responsive img-thumbnail img-preview', 'alt' => $item->image]) ?>
                    <br>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>