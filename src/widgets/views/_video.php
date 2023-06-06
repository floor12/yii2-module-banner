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
            <video id="video<?= $rand ?>"  autoplay muted playsinline loop data-id='<?= $banner->id ?>'
                   src="<?= $banner->file_mobile->getHref() ?>"
                   data-desktop="<?= $banner->file_desktop->getHref() ?>">
            </video>
            <script>
                // Получаем ссылку на элемент video
                const videoElement = document.getElementById('video<?= $rand ?>');

                // Получаем ширину окна браузера
                const windowWidth = window.innerWidth;

                // Заданный порог ширины окна браузера
                const thresholdWidth = 800;

                // Проверяем, является ли ширина окна больше порогового значения
                if (windowWidth > thresholdWidth) {
                    // Получаем значение атрибута data-desktop
                    const desktopSrc = videoElement.getAttribute('data-desktop');

                    // Устанавливаем значение атрибута src равным значению data-desktop
                    videoElement.src = desktopSrc;
                }
            </script>
        <?php endif; ?>

        <?php if ($banner->href){ ?></a><?php } ?>

</div>
