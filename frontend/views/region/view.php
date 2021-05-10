<?php

/* @var $this yii\web\View */

/* @var $region Region */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Region;
use common\models\Site;

$this->title = $region->name;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Regions'), 'url' => ['region/index']],
    $this->title,
];

$this->registerCssFile('css/region.css', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$script = <<< JS

$(document).ready(function () {
    var container = $('.collection');

    container.imagesLoaded(function () {
        container.masonry();
    });
});

JS;

$this->registerJsFile('/js/masonry.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/imagesloaded.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJs($script, yii\web\View::POS_READY);
?>

<?= newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=findImages]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]) ?>


<h1><?= Html::encode($region->name) ?></h1>
<?= Html::a('PDF', ['region/pdf', 'id' => $region->id], ['class' => 'btn btn-primary pull-right']) ?>
<?php if (Yii::$app->user->can('manager')): ?>
    <?= Html::a(Yii::t('app', 'Edit'), ['manager/region-update', 'id' => $region->id], ['class' => 'btn btn-primary pull-right']) ?>
<?php endif; ?>

<?= $region->annotation ?>

<?php if (!empty($region->sites)): ?>
    <h2><?= Yii::t('app', 'Sites') ?></h2>
    <div class="row collection">
        <?php foreach ($region->sites as $site): ?>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <a href="<?= Url::to(['site/view', 'id' => $site->id]) ?>" class="site-item">
                    <?php if (!empty($site->image)): ?>
                        <div class="row">
                            <?= Html::img(Site::SRC_IMAGE . '/' . $site->thumbnailImage, ['class' => 'img-responsive']) ?>
                        </div>
                    <?php endif; ?>
                    <h3>
                        <?= $site->name ?>
                    </h3>
                    <?= $site->annotation ?>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>

<?php if (!empty($region->publication)): ?>
    <h3><?= Yii::t('app', 'Publications') ?></h3>
    <?= $region->publication ?>
<?php endif; ?>

