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
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['class' => 'modaledit-form'],
    'enableClientValidation' => true
]);
?>

<div class="modal-header">
    <h2><?= $model->isNewRecord ? "Добавление pop-up площадки" : "Редактирование pop-up площадки"; ?></h2>
</div>

<div class="modal-body">

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-3" style="padding-top: 31px;">
            <?= $form->field($model, 'status')->checkbox() ?>
        </div>
    </div>

</div>

<div class="modal-footer">
    <?= Html::a('Отмена', '', ['class' => 'btn btn-default modaledit-disable']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
