<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this View
 * @var $model AdsPlaceFilter;
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsPlace;
use floor12\banner\models\AdsPlaceFilter;
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

$this->title = 'Баннерные площадки';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo EditModalHelper::editBtn(
    'place-form',
    0,
    'btn btn-sm btn-primary btn-banner-add',
    IconHelper::PLUS . " добавить площадку"
);

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-stiped'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',

        [
            'attribute' => 'title',
            'content' => function (AdsPlace $model): string {
                if ($model->status == AdsPlace::STATUS_DISABLED)
                    return Html::tag('span', $model->title, ['class' => 'striked']);
                return $model->title;
            }
        ],
        [
            'header' => 'Десктоп',
            'content' => function (AdsPlace $model): string {
                return "{$model->desktop_width}x{$model->desktop_height}px";
            }
        ],
        [
            'header' => 'Мобильный',
            'content' => function (AdsPlace $model): string {
                return "{$model->mobile_width}x{$model->mobile_height}px";
            }
        ],
        [
            'class' => EditModalColumn::class,
            'editPath' => 'place-form',
            'deletePath' => 'place-delete',
        ]
    ]
]);

Pjax::end();

