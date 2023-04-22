<?php

use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\ui\form\widgets\ActiveForm;
use kartik\widgets\ColorInput;
use yii\helpers\Html;
use yii\base\Theme;
use yii\helpers\Url;

$color_vars = array_merge(ColorSettings::MAIN_COLORS, ColorSettings::TEXT_COLORS);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form']);?>

	         <div class="color-fields">
		        <?php foreach ($color_vars as $color): ?>
			        <?= $form->field($model, $color)->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select color ...')]]); ?>
			    <?php endforeach; ?>
			  </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
