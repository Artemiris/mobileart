<?php

/* @var $this yii\web\View */

/* @var $find Find */

use yii\helpers\Html;
use yii\helpers\Url;
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
$iauthor = json_encode(Yii::t('find', 'Image authors'));
$icopyright = json_encode(Yii::t('find', 'Image copyright'));
$isource = json_encode(Yii::t('find', 'Image source'));

$script = <<< JS
        
    $('[data-toggle="tooltip"]').tooltip();
    
    $(".tab-header")
    .click(function() {
        $(this).tooltip('hide');
    })
    let iframe = $('iframe');
    if(iframe.length > 0) {
        let modelID = iframe.attr('src').split('/').splice(-1)[0];
        let domain = iframe.attr('src').split('/')[2];
        let modelURL = 'http://' + domain + '/ru/rest/copyright?id=' + modelID + '&lng=' + $lang;
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
    
    $('.img-thumbnail').each(function() {
      let img = $(this);
      $.ajax({
        url: window.origin + '/ru/find/get-image-data?id=' + img.attr('id') + '&lng=' + $lang,
        success: function(data) {
            let d = JSON.parse(data);
            let aVal = (d.image_author || '');
            let cVal = (d.image_copyright || '');
            let sVal = (d.image_source || '');
            let cblock = '<p class="authors-block">'
            if(d.image_author) cblock += $iauthor + ': ' + aVal;
            cblock += '</br>';
            if(d.image_copyright) cblock += $icopyright + ': ' + cVal;
            cblock += '</br>';
            if(d.image_source) cblock += $isource + ': ' + sVal;
            cblock += '</p>';
            img.parent().attr('data-caption', cblock);
            img.attr('title', $iauthor + ': ' + aVal + '; ' + $icopyright + ': ' + cVal + '; ' + $isource + ': ' + sVal + '.');
        },
        error: function() {
          console.log('error');
        }
      })
    })
    
    $('.main-img').each(function() {
      let img = $(this);
      $.ajax({
        url: window.origin + '/ru/find/get-main-image-data?id=' + $find->id + '&lng=' + $lang,
        success: function(data) {
            let d = JSON.parse(data);
            let aVal = (d.image_author || '');
            let cVal = (d.image_copyright || '');
            let sVal = (d.image_source || '');
            let cblock = '<p class="authors-block">'
            if(d.image_author) cblock += $iauthor + ': ' + aVal;
            cblock += '</br>';
            if(d.image_copyright) cblock += $icopyright + ': ' + cVal;
            cblock += '</br>';
            if(d.image_source) cblock += $isource + ': ' + sVal;
            cblock += '</p>';
            img.parent().attr('data-caption', cblock);
            img.attr('title', $iauthor + ': ' + aVal + '; ' + $icopyright + ': ' + cVal + '; ' + $isource + ': ' + sVal + '.');
        },
        error: function() {
          console.log('error');
        }
      })
    })

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
        'beforeShow' => new \yii\web\JsExpression('function(){ this.title = $(this.element).attr("data-caption"); }'),
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
            <?= Html::a(Html::img(Find::SRC_IMAGE . '/' . $find->thumbnailImage, [
                'class' => 'img-responsive'
            ]), Find::SRC_IMAGE . '/' . $find->image, [
                'rel' => 'findImages'
            ]); ?>
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
                    <?= Html::a(Html::img(Find::SRC_IMAGE . '/' . $find->thumbnailImage, [
                        'class' => 'img-responsive main-img'
                    ]), Find::SRC_IMAGE . '/' . $find->image, [
                        'rel' => 'findImages'
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($find->images)): ?>
            <?php foreach ($find->images as $item): ?>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="image">
                        <?= Html::a(Html::img(FindImage::SRC_IMAGE . '/' . FindImage::THUMBNAIL_PREFIX . $item->image, [
                            'class' => 'img-responsive img-thumbnail',
                            'id' => $item->image
                        ]), FindImage::SRC_IMAGE . '/' . $item->image, [
                            'rel' => 'findImages',
                        ]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (isset($find->author_page)): ?>
    <div class="clearfix"></div>
    <p class="page-author"><?= Yii::t('find', 'Page authors') . ': ' . $find->author_page ?></p>
<?php endif; ?>