<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 20:22
 *
 * @var $model AdsPlace
 * @var $this View
 * @var $places array
 *
 */

use floor12\banner\models\AdsPlace;
use floor12\files\components\FileInputWidget;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$datePickerOptions = [
    'language' => Yii::$app->language,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy'
    ]
];

$form = ActiveForm::begin([
    'options' => ['class' => 'modaledit-form'],
    'enableClientValidation' => true
]);


?>
<div class="modal-header">
    <h2><?= Yii::t('app.f12.banner', $model->isNewRecord ? 'Banner creation' : 'Banner update') ?></h2>
</div>
<div class="modal-body">

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'show_start')->widget(DatePicker::class, $datePickerOptions) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'show_end')->widget(DatePicker::class, $datePickerOptions) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->checkbox() ?>
            <?= $form->field($model, 'archive')->checkbox() ?>
            <?= $form->field($model, 'show_caption')->checkbox() ?>
        </div>
    </div>

    <?= $form->field($model, 'subtitle') ?>

    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'href') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'weight')->textInput(['placeholder' => '0']) ?>
        </div>
    </div>

    <?= $form->field($model, 'onclick') ?>

    <?= $form->field($model, 'place_ids')->widget(Select2::class, [
        'data' => $places,
        'language' => Yii::$app->language,
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'file_desktop')->widget(FileInputWidget::class, []) ?>

    <?= $form->field($model, 'file_mobile')->widget(FileInputWidget::class, []) ?>

</div>

<div class="modal-footer">
    <?= Html::button(Yii::t('app.f12.banner', 'Cancel'), ['class' => 'btn btn-default modaledit-disable']) ?>
    <?= Html::submitButton(Yii::t('app.f12.banner', $model->isNewRecord ? 'Create' : 'Save'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
