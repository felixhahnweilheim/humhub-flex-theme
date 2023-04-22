<?php

use humhub\modules\flexTheme\models\Config;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\form\widgets\IconPicker;
use kartik\widgets\ColorInput;
use yii\helpers\Html;
use yii\base\Theme;
use yii\helpers\Url;

?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form']);?>

		    <?= $form->field($model, 'commentLink')->radioList([
	            'text' => Yii::t('FlexThemeModule.admin', 'Text link'),
	            'icon' => Yii::t('FlexThemeModule.admin', 'Only icon'),
	            'both' => Yii::t('FlexThemeModule.admin', 'Text and icon'),
            ]);?>
		    <?= $form->field($model, 'likeLink')->radioList([
	            'text' => Yii::t('FlexThemeModule.admin', 'Text link'),
	            'icon' => Yii::t('FlexThemeModule.admin', 'Only icon'),
	            'both' => Yii::t('FlexThemeModule.admin', 'Text and icon'),
            ]);?>
            <?= $form->field($model, 'likeIcon')->widget(IconPicker::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select icon ...')]]); ?>
            <?= $form->field($model, 'likeIconFull')->widget(IconPicker::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select icon ...')]]); ?>
            <?= $form->field($model, 'likeIconColor')->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select color ...')]]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
