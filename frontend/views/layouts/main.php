<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\Lang;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    ?>



    <?php
    $menuItems[] = ['label' => Yii::t('app', 'Regions'), 'url' => ['/region']];

    if (Yii::$app->user->can('manager')) {
        $menuItems[] = ['label' => Yii::t('app', 'Management'), 'url' => ['/manager']];

    }
    //    if (Yii::$app->user->isGuest) {
    //        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    //        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    //    } else {
    //        $menuItems[] = '<li>'
    //            . Html::beginForm(['/site/logout'], 'post')
    //            . Html::submitButton(
    //                'Logout (' . Yii::$app->user->identity->username . ')',
    //                ['class' => 'btn btn-link logout']
    //            )
    //            . Html::endForm()
    //            . '</li>';
    //    }
    ?>

    <?php
    $menuLang = (new Lang)->run([
            'widget_type' => 'classic', // classic or selector
            'image_type' => 'rounded', // classic or rounded
            'width' => '18',
        ]);

    $menuItems = array_merge($menuItems, $menuLang);
    ?>


    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]) ?>

    <?php NavBar::end(); ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <p class="col-xs-8">
                &copy;
                <a href="https://www.nsu.ru/n/" target="_blank"><?= Yii::t('app', 'Novosibirsk State University') ?></a>
                ↦
                <a href="http://artemir.nsu.ru/" target="_blank"><?= Yii::t('app', 'Lab "LIA ARTEMIR"') ?></a>
            </p>
            <div class="col-xs-4 pull-right" style="font-size: 12px; text-align: right;">
                <?= Yii::t('app', 'Incorrect description or copyright infringement?')?> <br>
                <a id="report_link" target="_blank"><?= Yii::t('app', 'Click to report') ?></a>
            </div>
            <p class="col-xs-6"><?= Yii::t('app', 'Project supported by RNF #18-78-10079') ?> </p>
        </div>
    </div>
</footer>

<?= $this->render('_counter') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
