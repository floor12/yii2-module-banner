<?php
/**
 * @var $this View
 * @var $banner AdsBanner
 * @var $place AdsPlace
 */

use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use floor12\files\components\PictureWidget;
use yii\helpers\Url;
use yii\web\View;

?>


<div class="banner-image" onclick="<?= $banner->onclick ?>" data-id='<?= $banner->id ?>'>

    <?php if ($banner->href) { ?><a
            href="<?= Url::toRoute(['/banner/redirect', 'id' => $banner->id]) ?>"><?php } ?>

        <?= PictureWidget::widget([
            'model' => $banner->file_desktop,
            'width' => $place->desktop_width,
            'classPicture' => $banner->file_mobile ? 'banner-desktop' : 'banner-common',
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
