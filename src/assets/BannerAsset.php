<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 18:07
 */

namespace floor12\banner\assets;

use yii\web\AssetBundle;

class BannerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/floor12/yii2-module-banner/src/assets';

    public $css = [
        'banner.css'
    ];

    public $js = [
        'autosubmit.js',
        'banner.js'
    ];

    public $depends = [
       // 'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset'
    ];
}
