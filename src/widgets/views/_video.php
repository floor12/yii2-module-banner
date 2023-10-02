<?php
/**
 * @var $this View
 * @var $banner AdsBanner
 * @var $place AdsPlace
 * @var $showTitle bool
 * @var $showSubtitle bool
 */

use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$rand = rand(1000, 9999);

// register video file to preload
$this->registerLinkTag(
    [
        'rel' => 'preload',
        'href' => $banner->file_mobile->getHref(),
        'as' => 'video',
    ]
);
?>


<div class="banner-video" onclick="<?= $banner->onclick ?>" data-id='<?= $banner->id ?>'>

    <?php if ($banner->href) { ?><a href="<?= Url::toRoute(['/banner/redirect', 'id' => $banner->id]) ?>"><?php } ?>

        <?php if (!$banner->file_mobile): ?>
            <video id="video<?= $rand ?>" autoplay muted playsinline loop data-id='<?= $banner->id ?>'
                   src="<?= $banner->file_desktop->getHref() ?>">
            </video>
        <?php else: ?>
            <video id="video<?= $rand ?>" autoplay muted playsinline loop data-id='<?= $banner->id ?>'
                   src="<?= $banner->file_mobile->getHref() ?>"
                   data-desktop="<?= $banner->file_desktop->getHref() ?>">
            </video>
            <script>
                const videoElement = document.getElementById('video<?= $rand ?>');
                if (window.innerWidth > 800) {
                    videoElement.src = videoElement.getAttribute('data-desktop');
                }
            </script>
        <?php endif; ?>

        <?php if ($banner->href){ ?></a><?php } ?>

    <div class="banner-meta">
        <?= ((($showTitle == null && $banner->show_caption)) && $banner->title) ? Html::tag('div', $banner->title, ['class' => 'banner-title']) : null ?>
        <?= $showSubtitle && $banner->subtitle ? Html::tag('div', $banner->subtitle, ['class' => 'banner-subtitle']) : null ?>
    </div>

</div>
