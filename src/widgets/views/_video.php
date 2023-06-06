<?php
/**
 * @var $this \yii\web\View
 * @var $banner \floor12\banner\models\AdsBanner
 * @var $place \floor12\banner\models\AdsPlace
 */
$rand = rand(1000, 9999);
?>


<div class="banner-video" onclick="<?= $banner->onclick ?>" data-id='<?= $banner->id ?>'>

    <?php if ($banner->href) { ?><a href="<?= $banner->href ?>"><?php } ?>

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
                    const desktopSrc = videoElement.getAttribute('data-desktop');
                    videoElement.src = desktopSrc;
                }
            </script>
        <?php endif; ?>

        <?php if ($banner->href){ ?></a><?php } ?>

</div>
