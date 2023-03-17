<?php

use humhub\modules\flexTheme\models\ConfigureForm;
use humhub\modules\flexTheme\Module;
use humhub\modules\ui\form\widgets\ActiveForm;
use yii\helpers\Html;
use yii\base\Theme;
use yii\helpers\Url;

$color_vars = Module::MAIN_COLORS;
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
		
		    <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Social Controls')); ?>
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
		    <?= $form->field($model, 'likeIcon')->radioList([
		        'thumbs_up' => Yii::t('FlexThemeModule.admin', 'Thumbs up'),
	            'heart' => Yii::t('FlexThemeModule.admin', 'Heart'),
	            'star' => Yii::t('FlexThemeModule.admin', 'Star'),
	        ]);?>
		    <?= $form->endCollapsibleFields(); ?>
		    
		    <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Colors')); ?>
	        <?php foreach ($color_vars as $color): ?>
		        <?= '<div id="' . $color . '-field">' ?>
			        <?= $form->field($model, $color)->widget(ColorPicker::class, ['container' => $color . '-field'])->label(false)->hint(false) ?>
                    <?= $form->field($model, $color, ['template' => '
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i></i>
                            </span>
                            {label}
                        </div>
                        {error}{hint}'
                    ]) ?>
	            <?= '</div>' ?>
		    <?php endforeach; ?>
		    <?= $form->endCollapsibleFields(); ?>
			
		    <?= $form->field($model, 'verifiedAccounts'); ?>
		
        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
