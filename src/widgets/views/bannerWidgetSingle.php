<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 20.06.2018
 * Time: 9:23
 *
 * @var $this View
 * @var $banners AdsBanner
 * @var $place AdsPlace
 * @var $id string
 * @var $targetBlank bool
 * @var $adaptiveBreakpoint integer
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

BannerAsset::register($this);


if ($banners->type == AdsBanner::TYPE_IMAGE
    && $banners->file_desktop &&
    is_file($banners->file_desktop->getRootPath()))

    if ($banners->file_mobile)
        $img = "<picture class='banner-widget'>
                    <source 
                        type='image/webp' 
                        media='(min-width: {$adaptiveBreakpoint}px)' 
                        srcset='
                            {$banners->file_desktop->getPreviewWebPath($place->desktop_width,true)} 1x, 
                            {$banners->file_desktop->getPreviewWebPath(($place->desktop_width * 2),true)} 2x'>
                                          
                    <source 
                        type='image/webp' 
                        media='(max-width: {$adaptiveBreakpoint}px)' 
                        srcset='
                            {$banners->file_mobile->getPreviewWebPath($place->mobile_width,true)} 1x, 
                            {$banners->file_mobile->getPreviewWebPath(($place->mobile_width * 2),true)} 2x'>
                    <source 
                        type='{$banners->file_desktop->content_type}' 
                        media='(min-width: {$adaptiveBreakpoint}px)' 
                        srcset='
                            {$banners->file_desktop->getPreviewWebPath($place->desktop_width)} 1x, 
                            {$banners->file_desktop->getPreviewWebPath(($place->desktop_width * 2), )} 2x'>
                    <source 
                        type='{$banners->file_desktop->content_type}' 
                        media='(max-width: {$adaptiveBreakpoint}px)' 
                        srcset='
                            {$banners->file_mobile->getPreviewWebPath($place->mobile_width)} 1x, 
                            {$banners->file_mobile->getPreviewWebPath(($place->mobile_width * 2))} 2x'>
                    <img 
                        src='{$banners->file_desktop->getPreviewWebPath($place->desktop_width)}' 
                        class='img-responsive' 
                        data-id='{$banners->id}'
                        alt='{$banners->title}'>
                </picture>";
    else
        $img = "<picture class='banner-widget'>
                    <source 
                        type='image/webp' 
                        srcset='
                            {$banners->file_desktop->getPreviewWebPath($place->desktop_width,true)} 1x, 
                            {$banners->file_desktop->getPreviewWebPath(($place->desktop_width * 2),true)} 2x'>              
                    <source 
                        type='{$banners->file_desktop->content_type}'
                        srcset='
                            {$banners->file_desktop->getPreviewWebPath($place->desktop_width)} 1x, 
                            {$banners->file_desktop->getPreviewWebPath(($place->desktop_width * 2),)} 2x'>
                    <img 
                        src='{$banners->file_desktop->getPreviewWebPath($place->desktop_width)}' 
                        class='img-responsive' 
                        data-id='{$banners->id}'
                        alt='{$banners->title}'>
                </picture>";

elseif ($banners->type == AdsBanner::TYPE_VIDEO) {

    $img = "<video autoplay muted playsinline loop data-id='{$banners->id}'>";
    if ($banners->file_mobile) {
        $img .= "<source src='{$banners->file_mobile->getHref()}' type='video/mp4'>";
    }
    $img .= "<source src='{$banners->file_desktop->getHref()}' type='video/mp4'>";
    $img .= '</video>';

} else {
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
}


if ($banners->href && $banners->type == AdsBanner::TYPE_IMAGE)
    echo Html::a($img, ['/banner/redirect', 'id' => $banners->id], $targetBlank ? ['target' => '_blank', 'id' => ''] : []);
elseif ($banners->onclick && $banners->type == AdsBanner::TYPE_IMAGE)
    echo Html::tag('span', $img, ['onclick' => $banners->onclick]);
else
    echo $img;

