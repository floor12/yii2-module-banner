<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 20.06.2018
 * Time: 9:23
 *
 * @var $this View
 * @var $banners AdsBanner[]
 * @var $place AdsPlace
 * @var $id string
 * @var $targetBlank bool
 * @var $adaptiveBreakpoint integer
 */

use floor12\banner\assets\SlickAsset;
use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use yii\web\View;

SlickAsset::register($this);

$id = 'banner' . $place->id;

$jsCode = <<< JS

    $('#{$id}').slick({
        vertical :  {$place->vertical},
        arrows: {$place->arrows},
        dots: {$place->dots},
        autoplay: true,
        accessibility: false,
        adaptiveHeight: true,
        pauseOnHover: false,
        autoplaySpeed: {$place->slider_time},
    })   
JS;

$this->registerJs($jsCode, View::POS_READY, 'floor12-banner-slider-' . $id);

echo "<div id='{$id}'>";

foreach ($banners as $key => $banner) {
   echo $this->render('bannerWidgetSingle', [
        'banner' => $banner,
        'place' => $place,
        'targetBlank' => $targetBlank,
    ]);
}

echo "</div>";
