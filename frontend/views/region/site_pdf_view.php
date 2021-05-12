<?php
/* @var $site Site */

use common\models\Site;
use yii\helpers\Html;

?>

<h1><?= $site->region->name . '. ' . $site->name ?></h1>

<?php if (!empty($site->image)): ?>
    <?=Html::img(Site::SRC_IMAGE . '/' . $site->thumbnailImage)?>
<?php endif; ?>

<?php if (!empty($site->description)): ?>
    <h3><?= Yii::t('find', 'Description') ?></h3>
    <?= $site->description ?>
<?php endif; ?>

<?php if (!empty($site->publication)): ?>
<table  style="page-break-inside: avoid" autosize="1">
    <tr>
        <td style="padding-left: -1mm">
            <h3><?= Yii::t('find', 'Publications') ?></h3>
            <?= $site->publication ?>
        </td>
    </tr>
</table>
<?php endif; ?>
