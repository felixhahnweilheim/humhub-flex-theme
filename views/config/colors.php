<?php

use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\ui\form\widgets\ActiveForm;
use kartik\widgets\ColorInput;
use yii\helpers\Html;

$main_colors = ColorSettings::MAIN_COLORS;
$text_colors = ColorSettings::TEXT_COLORS;
$background_colors = ColorSettings::BACKGROUND_COLORS;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form']);?>

            <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Main Colors')); ?>
		        <?php foreach ($main_colors as $color): ?>
			        <?= $form->field($model, $color)->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select color ...')]]); ?>
			    <?php endforeach; ?>
            <?= $form->endCollapsibleFields(); ?>

			<?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Text Colors')); ?>
		        <?php foreach ($text_colors as $color): ?>
			        <?= $form->field($model, $color)->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select color ...')]]); ?>
			    <?php endforeach; ?>
            <?= $form->endCollapsibleFields(); ?>

			<?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Background Colors')); ?>
		        <?php foreach ($background_colors as $color): ?>
			        <?= $form->field($model, $color)->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select color ...')]]); ?>
			    <?php endforeach; ?>
            <?= $form->endCollapsibleFields(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
