<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this View
 * @var $model AdsPopPlaceFilter;
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsPopPlaceFilter;
use floor12\banner\widgets\TabWidget;
use floor12\editmodal\EditModalAsset;
use floor12\editmodal\EditModalColumn;
use floor12\editmodal\EditModalHelper;
use floor12\editmodal\IconHelper;
use yii\bootstrap\BootstrapAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

BootstrapAsset::register($this);
BannerAsset::register($this);
EditModalAsset::register($this);


$this->title = 'Pop-up';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo EditModalHelper::editBtn(
    'popup-place-form', 
    0, 
    'btn btn-sm btn-primary btn-banner-add', 
    IconHelper::PLUS . " добавить площадку"
);

echo Html::tag('br');

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-striped table-banners'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',
        'title',
        [
            'class' => EditModalColumn::class,
            'editPath' => 'popup-place-form',
            'deletePath' => 'popup-place-delete',
        ]
    ]
]);

Pjax::end();

