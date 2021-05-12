<?php
/* @var $region Region */

use common\models\Region;

?>

<h1><?= $region->name ?></h1>

<?php if (!empty($region->annotation)): ?>
    <?= $region->annotation ?>
<?php endif; ?>

<?php if (!empty($region->publication)): ?>
<table  style="page-break-inside: avoid" autosize="1">
    <tr>
        <td style="padding-left: -1mm">
            <h3><?= Yii::t('app', 'Publications') ?></h3>
            <?= $region->publication ?>
        </td>
    </tr>
</table>
<?php endif; ?>
