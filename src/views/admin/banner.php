<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this View
 * @var $model AdsBannerFilter;
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsBannerFilter;
use floor12\banner\widgets\TabWidget;
use floor12\editmodal\EditModalAsset;
use floor12\editmodal\EditModalHelper;
use floor12\editmodal\IconHelper;
use floor12\files\assets\LightboxAsset;
use yii\bootstrap\BootstrapAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

LightboxAsset::register($this);
BootstrapAsset::register($this);
BannerAsset::register($this);
EditModalAsset::register($this);


$this->title = Yii::t('app.f12.banner', 'Banners');

echo Html::tag('h1', Yii::t('app.f12.banner', 'Banners'), ['class' => 'fl12-banner-title']);

echo TabWidget::widget();

echo EditModalHelper::editBtn(
    'banner-form',
    0,
    'btn btn-sm btn-primary btn-banner-add',
    IconHelper::PLUS . ' ' . Yii::t('app.f12.banner', 'Add banner')
);

$form = ActiveForm::begin([
    'method' => 'GET',
    'options' => ['class' => 'autosubmit', 'data-container' => '#items'],
    'enableClientValidation' => false,
]); ?>
    <div class="filter-block">
        <div class="row">

            <div class="col-md-8">
                <?= $form->field($model, 'filter')
                    ->label(false)
                    ->textInput(['placeholder' => Yii::t('app.f12.banner', 'Banner filter'), 'autofocus' => true]) ?>
            </div>

            <div class="col-md-2">
                <?= $form->field($model, "status")
                    ->label(false)
                    ->dropDownList([Yii::t('app.f12.banner', 'Enabled'), Yii::t('app.f12.banner', 'Disabled')], ['prompt' => Yii::t('app.f12.banner', 'any status')]) ?>
            </div>

            <div class="col-md-2">
                <?= $form->field($model, "archive")
                    ->label(false)
                    ->dropDownList([Yii::t('app.f12.banner', 'Non archived'), Yii::t('app.f12.banner', 'Archved')]) ?>
            </div>

        </div>
    </div>

<?php
ActiveForm::end();

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-striped table-banners'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',
        [
            'header' => Yii::t('app.f12.banner', 'Preview'),
            'contentOptions' => ['class' => 'banner-preview'],
            'content' => function (AdsBanner $model) {
                if ($model->file_desktop)
                    return Html::a(Html::img($model->file_desktop->getPreviewWebPath(300)),
                        $model->file_desktop, [
                            'data-lightbox' => 'banner-gallary',
                            'data-pjax' => '0'
                        ]);
            }
        ],
        [
            'attribute' => 'title',
            'content' => function (AdsBanner $model): string {
                if ($model->status == AdsBanner::STATUS_DISABLED)
                    $html = Html::tag('span', $model, ['class' => 'striked']);
                else
                    $html = $model;
                $html .= Html::tag('div', implode(', ', $model->places), ['class' => 'small']);
                return $html;
            }
        ],
        [
            'attribute' => 'type',
            'content' => function (AdsBanner $model) {
                return \floor12\files\models\FileType::getLabel($model->type);
            }
        ],
        'views',
        'clicks',
        ['contentOptions' => [
            'style' => 'min-width:100px; text-align:right;'
        ],
            'content' => function (AdsBanner $model) {
                return
                    EditModalHelper::editBtn('/banner/admin/banner-form', $model->id) .
                    EditModalHelper::deleteBtn('/banner/admin/banner-delete', $model->id);
            },
        ]
    ]
]);

Pjax::end();

