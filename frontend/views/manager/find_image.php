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

$script = "$('.save-btn').each(
    function (){
        let elem = $(this);
        elem.click(
            function () {
                let id = elem.attr('id');
                let obj = {};
                obj.id = id;
                obj.author = $('#author_' + id).val();
                obj.copyright = $('#copyright_' + id).val();
                obj.author_en = $('#author_en_' + id).val();
                obj.copyright_en = $('#copyright_en_' + id).val();
                obj.source = $('#source_' + id).val();
                $.ajax({
                    method: 'post',
                    url: 'http://mobileart/rest-test/find-image-save?id=' + id,
                    data: obj,
                    error: function (x,e,c){
                        console.log(e);
                        console.log(c);
                    }
                });
            }
        );
    }
);";

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
        <div class="row">
            <div class="col-xs-6">
                <?= Html::img(FindImage::SRC_IMAGE . '/' . FindImage::THUMBNAIL_PREFIX . $item->image, ['class' => 'img-responsive img-thumbnail']) ?>
            </div>
            <div class="col-xs-6">
                <?= Html::a('Удалить', ['manager/image-delete', 'id' => $item->id], [
                    'class' => 'btn btn-danger pull-right',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить?',
                        'method' => 'post',
                    ]
                ]) ?>
                <button class="btn btn-primary pull-right save-btn" type="button" id="<?= $item->id ?>">Сохранить</button>
            </div>
            <div class="col-xs-6">
                <label>Автор</label>
                <?= Html::input('text','author',$item->image_author, ['class'=>'form-control', 'id' => 'author_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Правообладатель</label>
                <?= Html::input('text','copyright',$item->image_copyright, ['class'=>'form-control', 'id' => 'copyright_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Author_en</label>
                <?= Html::input('text','author_en',$item->image_author_en, ['class'=>'form-control', 'id' => 'author_en_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Copyright_en</label>
                <?= Html::input('text','copyright_en',$item->image_copyright_en, ['class'=>'form-control', 'id' => 'copyright_en_' . $item->id]) ?>
            </div>
            <div class="col-xs-6">
                <label>Source</label>
                <?= Html::input('text','source',$item->image_source, ['class'=>'form-control', 'id' => 'source_' . $item->id]) ?>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
<?php endif; ?>
