<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Find */

use common\models\FindImage;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Дополнительные изображения';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    ['label' => 'Коллекция', 'url' => ['/manager/find']],
    ['label' => $model->name, 'url' => ['/manager/find-update', 'id' => $model->id]],
    $this->title,
];
$script = <<< JS
    $(document).ready(function () {
        $('.save-btn').each(
            function () {
                $(this).click(
                    function () {
                        let id = $(this).attr('id');
    
                        $.ajax({
                            url: window.origin + '/ru/manager/find-image-save/',
                            type: 'post',
                            data:{
                                id : id,
                                author : $('#author_' + id).val(),
                                author_en : $('#author_en_' + id).val(),
                                copyright : $('#copyright_' + id).val(),
                                copyright_en : $('#copyright_en_' + id).val(),
                                source : $('#source_' + id).val(),
                                source_en : $('#source_en_' + id).val()
                            },
                            success: function (data) {
                                $('#'+id).attr('style','background-color:#337AB7;');
                                alert('Изменения сохранены');
                            },
                            error: function (x, e, c) {
                                console.log(e);
                                console.log(c);
                            }
                        });
                        return false;
                    })
            });
        $('.img_inpt').each(function () {
            $(this).keyup(function () {
                let id = $(this).attr('id').split('_').splice(-1)[0];
                $('#' + id).attr('style', 'background-color:#FFAA00;');
            })
        })
    });
JS;

$this->registerJs($script, View::POS_READY);

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
    <?php foreach ($model->getImagesData() as $item): ?>
        <div class="row pull-right">
            <div class="col-xs-6">
                <?= Html::img(FindImage::SRC_IMAGE . '/' . FindImage::THUMBNAIL_PREFIX . $item->image, ['class' => 'img-responsive img-thumbnail']) ?>
            </div>
            <div class="col-xs-6">
                <label>Автор</label>
                <?= Html::input('text','author',$item->image_author, ['class'=>'form-control img_inpt', 'id' => 'author_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Правообладатель</label>
                <?= Html::input('text','copyright',$item->image_copyright, ['class'=>'form-control img_inpt', 'id' => 'copyright_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Автор на англ</label>
                <?= Html::input('text','author_en',$item->image_author_en, ['class'=>'form-control img_inpt', 'id' => 'author_en_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Правообладатель на англ</label>
                <?= Html::input('text','copyright_en',$item->image_copyright_en, ['class'=>'form-control img_inpt', 'id' => 'copyright_en_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Источник</label>
                <?= Html::input('text','source',$item->image_source, ['class'=>'form-control img_inpt', 'id' => 'source_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Источник на англ</label>
                <?= Html::input('text','source_en',$item->image_source_en, ['class'=>'form-control img_inpt', 'id' => 'source_en_' . $item->id]) ?>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 pull-right">
                <?= Html::a('Удалить', ['manager/image-delete', 'id' => $item->id], [
                    'class' => 'btn btn-danger pull-right',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить?',
                        'method' => 'post',
                    ]
                ]) ?>
                <button class="btn btn-primary pull-right save-btn" type="button" id="<?= $item->id ?>">Сохранить</button>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
<?php endif; ?>
