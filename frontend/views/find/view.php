<?php

/* @var $this yii\web\View */

/* @var $find Find */

use yii\helpers\Html;
use common\models\Find;
use yii\bootstrap\Tabs;
use common\models\FindImage;

$this->title = $find->name;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Regions'), 'url' => ['region/index']],
    ['label' => $find->site->region->name, 'url' => ['region/view', 'id' => $find->site->region->id]],
    ['label' => $find->site->name, 'url' => ['site/view', 'id' => $find->site->id]],
    $this->title,
];
$lang = json_encode(Yii::$app->language);
$author = json_encode(Yii::t('find', 'Model authors'));
$copyright = json_encode(Yii::t('find', 'Model copyright'));
$iauthor = Yii::t('find', 'Image authors');
$icopyright = Yii::t('find', 'Image copyright');
$isource = Yii::t('find', 'Image source');

$script = <<< JS
        
    $('[data-toggle="tooltip"]').tooltip();
    
    $(".tab-header")
    .click(function() {
        $(this).tooltip('hide');
    })
    let iframe = $('iframe');
    if(iframe.length > 0) {
        let modelID = iframe.attr('src').split('/').splice(-1)[0];
        let domain = iframe.attr('src').split('/');
        let modelURL = domain[0] + '//' + domain[2] + '/ru/rest/copyright?id=' + modelID + '&lng=' + $lang;
        $.ajax({
            url: modelURL,
            success: function(data) {
                let d = JSON.parse(data);
                let aVal = (d.author || '');
                let cVal = (d.copyright || '');
                if(d.author || d.copyright){
                    let cblock = '<p class="authors-block">'
                    if(d.author) cblock += $author + ': ' + aVal;
                    if(d.author && d.copyright) cblock += '</br>';
                    if(d.copyright) cblock += $copyright + ': ' + cVal;
                    cblock += '</p>';
                    $('#copyright').html(cblock);
                }
            }
        });
    }

JS;

$this->registerJs($script, yii\web\View::POS_READY);
$this->registerCssFile('css/find.css?201902191707', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);

$tabs = [];

if (!empty($find->technique)) {
    $tabs[] = [
        'label' => '<i class="fas fa-swatchbook hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Manufacturing technique') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Manufacturing technique'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Manufacturing technique'),
            'content' => $find->technique
        ]),
    ];
}

if (!empty($find->traces_disposal)) {
    $tabs[] = [
        'label' => '<i class="fas fa-bone hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Use-wear traces') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Use-wear traces'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Use-wear traces'),
            'content' => $find->traces_disposal
        ]),
    ];
}

if (!empty($find->storage_location)) {
    $tabs[] = [
        'label' => '<i class="fas fa-warehouse  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Storage location') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Storage location'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Storage location'),
            'content' => $find->storage_location
        ]),
    ];
}

if (!empty($find->inventory_number)) {
    $tabs[] = [
        'label' => '<i class="fas fa-barcode  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Inventory number') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Inventory number'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Inventory number'),
            'content' => $find->inventory_number
        ]),
    ];
}

if (!empty($find->museum_kamis)) {
    $tabs[] = [
        'label' => '<i class="fas fa-external-link-square-alt  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'The Museum KAMIS') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'The Museum KAMIS'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'The Museum KAMIS'),
            'content' => $find->museum_kamis
        ]),
    ];
}

if (!empty($find->size)) {
    $tabs[] = [
        'label' => '<i class="fas fa-ruler-combined  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Size') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Size'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Size'),
            'content' => $find->size
        ]),
    ];
}

if (!empty($find->material)) {
    $tabs[] = [
        'label' => '<i class="fas fa-splotch  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Material') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Material'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Material'),
            'content' => $find->material
        ]),
    ];
}

if (!empty($find->dating)) {
    $tabs[] = [
        'label' => '<i class="fas fa-hourglass-half  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Dating') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Dating'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Dating'),
            'content' => $find->dating
        ]),
    ];
}

if (!empty($find->culture)) {
    $tabs[] = [
        'label' => '<i class="fas fa-archway  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Culture') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Culture'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Culture'),
            'content' => $find->culture
        ]),
    ];
}

if (!empty($find->author_excavation)) {
    $tabs[] = [
        'label' => '<i class="fas fa-male  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'The author of the excavations') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'The author of the excavations'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'The author of the excavations'),
            'content' => $find->author_excavation . (!empty($find->year) ? '<br>' . $find->year : null)
        ]),
    ];
}

if (!empty($find->link)) {
    $tabs[] = [
        'label' => '<i class="fas fa-link  hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Links') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Links'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Links'),
            'content' => $find->link
        ]),
    ];
}

if (!empty($find->publication)) {
    $tabs[] = [
        'label' => '<i class="fas fa-book hidden-xs hidden-sm"></i>' . '<span class="visible-xs visible-sm"> ' . Yii::t('find', 'Publications') . '</span>',
        'headerOptions' => [
            'class' => 'tab-header',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => Yii::t('find', 'Publications'),
        ],
        'content' => $this->render('_find_tab', [
            'title' => Yii::t('find', 'Publications'),
            'content' => $find->publication
        ]),
    ];
}

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
        'beforeShow' => new \yii\web\JsExpression("function(){ if($(this.element).attr('data-caption') !== '') {this.title =" . "'<p class=\"authors-block\">' + " . " $(this.element).attr('data-caption') " . "+ '</p>'};}"),
        'helpers' => [
            'title' => ['type' => 'inside'],
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

<?php if (empty($find->image) and empty($find->three_d)): ?>
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/find-update', 'id' => $find->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>
    <h1><?= Html::encode($find->name) ?></h1>
    <?= $find->description ?>
<?php else: ?>
    <div class="pull-left poster">
        <?php if (empty($find->three_d)): ?>
            <?php
                $fauthorset = isset($find->image_author) && !empty($find->image_author);
                $fcopyrightset = isset($find->image_copyright) && !empty($find->image_copyright);
                $fsourceset = isset($find->image_source) && !empty($find->image_source);
            ?>
            <?=Html::a(Html::img(Find::SRC_IMAGE . '/' . $find->thumbnailImage, [
                'class' => 'img-responsive',
                'title' => ($fauthorset ? "© " . $find->image_author : "")
                         . ($fcopyrightset ? "\n© " . $find->image_copyright : "")
                         . ($fsourceset ? "\n© " . $find->image_source : "")
            ]), Find::SRC_IMAGE . '/' . $find->image, [
                'rel' => 'findImages',
                'data-caption' => ($fauthorset ? $iauthor . ": " . $find->image_author : "")
                                . ($fcopyrightset ? "<br>" . $icopyright . ": " .  $find->image_copyright : "")
                                . ($fsourceset ? "<br>" . $isource . ": " . $find->image_source : ""),
            ]); ?>
            <div id="icopyright" style="width:100%">
                <?= '<p class="authors-block">' . ($fauthorset ? $iauthor . ": " . $find->image_author : "")
                 . ($fcopyrightset ? "<br>" . $icopyright . ": " .  $find->image_copyright : "")
                 . ($fsourceset ? "<br>" . $isource . ": " . $find->image_source : "") . '</p>'?>
            </div>
        <?php else: ?>
            <?= $find->three_d ?>
            <div id="copyright" style="width:100%"></div>
        <?php endif; ?>
    </div>
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/find-update', 'id' => $find->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>

    <h1><?= Html::encode($find->name) ?></h1>

    <?= $find->description ?>

<?php endif; ?>

    <div class="clearfix"></div>

<?php if (!empty($tabs)): ?>
    <?= Tabs::widget([
        'encodeLabels' => false,
        'items' => $tabs,
    ]) ?>
    <div class="clearfix"></div>

    <br>
<?php endif; ?>

<?php if (!empty($find->images) or !empty($find->three_d)): ?>
    <div class="row images">
        <?php if (!empty($find->three_d)): ?>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="image">
                    <?php
                        $fauthorset = isset($find->image_author) && !empty($find->image_author);
                        $fcopyrightset = isset($find->image_copyright) && !empty($find->image_copyright);
                        $fsourceset = isset($find->image_source) && !empty($find->image_source);
                    ?>
                    <?=Html::a(Html::img(Find::SRC_IMAGE . '/' . $find->thumbnailImage, [
                        'class' => 'img-responsive main-img',
                        'title' => ($fauthorset ? "© " . $find->image_author : "")
                                 . ($fcopyrightset ? "\n© " . $find->image_copyright : "")
                                 . ($fsourceset ? "\n© " . $find->image_source : ""),
                    ]), Find::SRC_IMAGE . '/' . $find->image, [
                        'rel' => 'findImages',
                        'data-caption' => ($fauthorset ? $iauthor . ": " . $find->image_author : "")
                                        . ($fcopyrightset ? "<br>" . $icopyright . ": " .  $find->image_copyright : "")
                                        . ($fsourceset ? "<br>" . $isource . ": " . $find->image_source : ""),
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($find->images)): ?>
            <?php foreach ($find->images as $item): ?>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="image">
                        <?php
                            $iauthorset = isset($item->image_author) && !empty($item->image_author);
                            $icopyrightset = isset($item->image_copyright) && !empty($item->image_copyright);
                            $isourceset = isset($item->image_source) && !empty($item->image_source);
                        ?>
                        <?=Html::a(Html::img(FindImage::SRC_IMAGE . '/' . FindImage::THUMBNAIL_PREFIX . $item->image, [
                            'class' => 'img-responsive img-thumbnail',
                            'id' => $item->image,
                            'title' => ($iauthorset ? "© " . $item->image_author : "")
                                     . ($icopyrightset ? "\n© " . $item->image_copyright : "")
                                     . ($isourceset ? "\n© " . $item->image_source : ""),
                        ]), FindImage::SRC_IMAGE . '/' . $item->image, [
                            'rel' => 'findImages',
                            'data-caption' => ($iauthorset ? $iauthor . ": " . $item->image_author : "")
                                            . ($icopyrightset ?  "<br>" . $icopyright . ": " .  $item->image_copyright : "")
                                            . ($isourceset ? "<br>" . $isource . ": " . $item->image_source : ""),
                        ]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (isset($find->author_page) && !empty($find->author_page)): ?>
    <div class="clearfix"></div>
    <p class="page-author"><?= Yii::t('find', 'Page authors') . ': ' . $find->author_page ?></p>
<?php endif; ?>