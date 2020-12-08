<?php


namespace frontend\assets;


class ImgEdAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/jquery.fancybox.min.js',
        'js/cropper.min.js',
        'js/imged.js?3'
    ];

    public $css = [
        'css/jquery.fancybox.min.css',
        'css/cropper.min.css'
    ];

    public $depends = [
        'frontend\assets\AppAsset'
    ];
}