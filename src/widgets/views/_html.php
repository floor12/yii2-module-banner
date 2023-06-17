<?php
/**
 * @var $this View
 * @var $banner AdsBanner
 * @var $place AdsPlace
 */

use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$style = "border:0; height: {$place->desktop_height}px; ";
if ($place->desktop_width_max) {
    $style .= " width: 100%; ";
} else {
    $style .= " width: {$place->desktop_width}px; ";
}

$img = Html::tag('iframe', null, [
    'src' => $banner->webPath,
    'class' => 'f12-rich-banner',
    'style' => $style,
    'data-href' => $banner->href ? Url::toRoute(['/banner/redirect', 'id' => $banner->id]) : '',
]);