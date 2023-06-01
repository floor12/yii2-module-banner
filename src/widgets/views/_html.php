<?php
/**
 * @var $this \yii\web\View
 * @var $banner \floor12\banner\models\AdsBanner
 * @var $place \floor12\banner\models\AdsPlace
 */

use yii\helpers\Html;

$style = "border:0; height: {$place->desktop_height}px; ";
if ($place->desktop_width_max) {
    $style .= " width: 100%; ";
} else {
    $style .= " width: {$place->desktop_width}px; ";
}

$img = Html::tag('iframe', null, [
    'src' => $banners->webPath,
    'class' => 'f12-rich-banner',
    'style' => $style,
    'data-href' => $banners->href ? Url::toRoute(['/banner/redirect', 'id' => $banners->id]) : '',
]);