<?php
/**
 * @var $this \yii\web\View
 * @var $banner \floor12\banner\models\AdsBanner
 * @var $place \floor12\banner\models\AdsPlace
 */

use floor12\files\components\PictureWidget;

?>


<div class="banner-image" onclick="<?= $banner->onclick ?>" data-id='<?= $banner->id ?>'>

    <?php if ($banner->href) { ?><a href="<?= $banner->href ?>"><?php } ?>

        <?= PictureWidget::widget([
            'model' => $banner->file_desktop,
            'width' => $place->desktop_width,
            'classPicture' => 'banner-desktop',
            'alt' => $banner->title,
        ]) ?>

        <?= PictureWidget::widget([
            'model' => $banner->file_mobile,
            'width' => $place->mobile_width,
            'classPicture' => 'banner-mobile',
            'alt' => $banner->title,
        ]) ?>

        <?php if ($banner->href){ ?></a><?php } ?>

</div>
