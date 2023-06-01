<?php
/**
 * @var $this \yii\web\View
 * @var $banner \floor12\banner\models\AdsBanner
 * @var $place \floor12\banner\models\AdsPlace
 */
?>


<div class="banner-video" onclick="<?= $banner->onclick ?>" data-id='<?= $banner->id ?>'>

    <?php if ($banner->href) { ?><a href="<?= $banner->href ?>"><?php } ?>

        <video class="banner-desktop banner-video-desktop" autoplay muted playsinline loop data-id='<?= $banner->id ?>'
               src="<?= $banner->file_desktop->getHref() ?>">
        </video>
        <video class="banner-mobile banner-video-mobile" autoplay muted playsinline loop data-id='<?= $banner->id ?>'
               src="<?= $banner->file_mobile->getHref() ?>">
        </video>

        <?php if ($banner->href){ ?></a><?php } ?>

</div>
