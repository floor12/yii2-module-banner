<?php

/**
 * @var $this View
 * @var $banner AdsBanner
 * @var $place AdsPlace
 * @var $targetBlank bool
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use floor12\files\models\FileType;
use yii\web\View;

BannerAsset::register($this);

if ($banner->type == FileType::IMAGE) {
    echo $this->render('_image', [
        'banner' => $banner,
        'place' => $place,
        'targetBlank' => $targetBlank,
    ]);
}

if ($banner->type == FileType::VIDEO) {
    echo $this->render('_video', [
        'banner' => $banner,
        'place' => $place,
        'targetBlank' => $targetBlank,
    ]);
}

if ($banner->type == FileType::FILE) {
    echo $this->render('_html', [
        'banner' => $banner,
        'place' => $place,
        'targetBlank' => $targetBlank,
    ]);
}
