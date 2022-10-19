<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CJosefin+Sans:600,700',
        'css/font-awesome.min.css',
        'css/materialize.css',
        'css/bootstrap.css',
        'css/style.css',
        'css/style-mob.css',
//        'css/site.css',
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
        'js/main.min.js',
        'js/bootstrap.min.js',
        'js/materialize.min.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
