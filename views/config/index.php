<?php

use humhub\modules\flexTheme\models\Config;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\form\widgets\IconPicker;
use kartik\widgets\ColorInput;
use yii\helpers\Html;
use yii\base\Theme;
use yii\helpers\Url;

$color_vars = Config::MAIN_COLORS;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('FlexThemeModule.admin', '<b>Flex Theme</b> Configuration'); ?></div>
    <div class="panel-body">
	    <?php if (Yii::$app->view->theme->name != 'FlexTheme'): ?>
		    <div class="alert alert-danger">
                <p>
                    <strong><?= Yii::t('FlexThemeModule.admin', 'Warning: Flex Theme is not active, settings on this page won\'t have any effect!'); ?></strong><br>
					<?= Yii::t('FlexThemeModule.admin', 'Please go to Administration > Settings > Design and select "Flex Theme".'); ?><br>
                </p>
            </div>
	    <?php endif; ?>
        <?php $form = ActiveForm::begin(['id' => 'configure-form']);?>

		    <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Like and Comment links')); ?>
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
            <?= $form->field($model, 'likeIcon')->widget(IconPicker::class, ['options' => ['placeholder' => \Yii::t('VerifiedModule.base', 'Select icon ...')]]); ?>
            <?= $form->field($model, 'likeIconFull')->widget(IconPicker::class, ['options' => ['placeholder' => \Yii::t('VerifiedModule.base', 'Select icon ...')]]); ?>
            <?= $form->field($model, 'iconColor')->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('VerifiedModule.base', 'Select color ...')]]); ?>
            <?= $form->endCollapsibleFields(); ?>

		    <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Main Colors')); ?>
	          <div class="color-fields">
		        <?php foreach ($color_vars as $color): ?>
				     <?= $form->field($model, $color)->widget(ColorInput::class, ['options' => ['placeholder' => \Yii::t('FlexThemeModule.admin', 'Select color ...')]]); ?>
			    <?php endforeach; ?>
			  </div>
		    <?= $form->endCollapsibleFields(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
