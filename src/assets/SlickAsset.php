<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 18:07
 */

namespace floor12\banner\assets;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $sourcePath = '@vendor/floor12/yii2-module-banner/src/assets/slick';

    public $css = [
        'slick.css',
        'slick-theme.css'
    ];

    public $js = [
        'slick.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
