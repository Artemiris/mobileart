<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use common\models\Find;

/* @var $this yii\web\View */
/* @var $model common\models\Find */
/* @var $form ActiveForm */   $script = <<< JS
        
    $("textarea[name='Find[three_d]'").keyup(function() {
        $(this).val($(this).val().replace(/width: 400px/gi, 'width: 100%'));
    });

JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>
<div class="manager-_find_form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'site_id')->dropDownList($data) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'name_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'annotation')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'annotation_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'description')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>

            <div class="col-xs-6">
                <?= $form->field($model, 'description_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'technique')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>

            <div class="col-xs-6">
                <?= $form->field($model, 'technique_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'traces_disposal')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>

            <div class="col-xs-6">
                <?= $form->field($model, 'traces_disposal_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'storage_location')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'storage_location_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'inventory_number')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'inventory_number_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'museum_kamis')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'museum_kamis_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'size')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>

            <div class="col-xs-6">
                <?= $form->field($model, 'size_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'material')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'material_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'dating')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'dating_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'culture')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'culture_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'author_excavation')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'author_excavation_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'year')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'year_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'publication')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>

            <div class="col-xs-6">
                <?= $form->field($model, 'publication_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'link')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>

            <div class="col-xs-6">
                <?= $form->field($model, 'link_en')->widget(CKEditor::className(),
                    [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'allowedContent' => true,
                        ],

                    ]) ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'author_page')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'author_page_en')->textInput() ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($model, 'fileImage')->fileInput() ?>
            </div>
        </div>
        <div class="row">
            <?php if (isset($model->image) and !empty($model->image)): ?>
                <div class="col-xs-6">
                    <?= Html::img(Find::SRC_IMAGE . '/' . $model->thumbnailImage, ['class' => 'img-responsive']) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'image_author')->textInput() ?>
                    <?= $form->field($model, 'image_author_en')->textInput() ?>
                    <?= $form->field($model, 'image_copyright')->textInput() ?>
                    <?= $form->field($model, 'image_copyright_en')->textInput() ?>
                    <?= $form->field($model, 'image_source')->textInput() ?>
                </div>
            <?php endif; ?>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-6">
                <button data-toggle="collapse" data-target="#instruction-3d" type="button" class="btn-link pull-right">Инструкция добавление 3D модели</button>

                <div id="instruction-3d" class="collapse">
                    <ol>
                        <li>
                            На сайте <a href="https://3d.nsu.ru" target="_blank">3d.nsu.ru</a> находим нужную модель
                        </li>
                        <li>
                            После загрузки модели жмем на кнопку настройки <img src="/img/3d-setting.png">
                        </li>
                        <li>
                            Развернется спиок инструментов.
                        </li>
                        <li>
                            Жмем на кнопку подделиться <img src="/img/3d-share.png">
                        </li>
                        <li>
                            Появится модальное окно с кодом
                        </li>
                        <li>
                            Нажмите на текст кода
                        </li>
                        <li>
                            Текст кода должен автоматически выделиться и скопироваться в буфер
                        </li>
                        <li>
                            Вставляем скопированный текст кода в поле "3D модель"
                        </li>
                    </ol>
                </div>
                <?= $form->field($model, 'three_d')->textarea(['rows' => 6]) ?>

            </div>
            <?php if (isset($model->three_d) and !empty($model->three_d)): ?>
                <div class="col-xs-6">
                    <?= $model->three_d ?>
                    <br>
                </div>
            <?php endif; ?>
        </div>
    </div>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<!-- manager-_find_form -->