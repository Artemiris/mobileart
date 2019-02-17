<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Регионы';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    $this->title,
];
?>

<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="clearfix">
        <div class="pull-right">
            <?= Html::a('Добавить регион', ['manager/region-create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <br>

    <?php if (!empty($regions)): ?>
        <table class="table table-responsive table-hover">
            <thead>
            <tr>
                <th>№</th>
                <th>Название</th>
                <th></th>
            </tr>
            </thead>
            <?php /** @var \common\models\Region $item */
            foreach ($regions as $i => $item): ?>
                <tr>
                    <td>
                        <?= ($i + 1) ?>
                    <td>
                        <?= $item->name ?>
                    </td>
                    </td>
                    <td>
                        <?= Html::a('Перейти', ['manager/region-update', 'id' => $item->id], ['class' => 'btn btn-primary']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>