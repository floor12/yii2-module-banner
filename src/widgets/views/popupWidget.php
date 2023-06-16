<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 10.07.2018
 * Time: 22:01
 *
 * @var $this View
 * @var $model AdsPopup
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsPopup;
use floor12\files\components\PictureWidget;
use yii\helpers\Html;
use yii\web\View;

BannerAsset::register($this);

$image = PictureWidget::widget([
    'model' => $model->file_desktop,
    'width' => [
        'min-width: 500px' => '1400',
        'max-width: 500px' => '400',
    ],
    'alt' => $model->title,
]);

$this->registerJs('$("#bannerModal").modal()');

?>

<div class='modal fade' id='bannerModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
    <div class='modal-dialog modal-lg text-center' role='document'>
        <button type='button' class='close popup-btn-close' data-dismiss='modal' aria-label='Close'><span
                    aria-hidden='true'>&times;</span></button>
        <?= $model->href ? Html::a($image, ['/banner/redirect/popup', 'id' => $model->id], ['target' => '_blank', 'id' => '']) : $image ?>
    </div>
</div>
