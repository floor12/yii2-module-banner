<?php
/**
 * @var $this View
 * @var $banner AdsBanner
 * @var $place AdsPlace
 */

use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use yii\helpers\Url;
use yii\web\View;

$rand = rand(1000, 9999);
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

</div>
