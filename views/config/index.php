<?php

use humhub\modules\flexTheme\models\Config;
use humhub\modules\ui\form\widgets\ActiveForm;
use yii\helpers\Html;
use yii\base\Theme;
use yii\helpers\Url;

\humhub\modules\flexTheme\assets\ColorisAsset::register($this);

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
		    <?= $form->field($model, 'likeIcon')->radioList([
		        'thumbs_up' => Yii::t('FlexThemeModule.admin', 'Thumbs up'),
	            'heart' => Yii::t('FlexThemeModule.admin', 'Heart'),
	            'star' => Yii::t('FlexThemeModule.admin', 'Star'),
	        ]);?>
		    <?= $form->endCollapsibleFields(); ?>

		    <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Main Colors')); ?>
	          <div class="color-fields">
		        <?php foreach ($color_vars as $color): ?>
				     <?= $form->field($model, $color); ?>
			    <?php endforeach; ?>
			  </div>
		    <?= $form->endCollapsibleFields(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<script type="text/javascript">
    Coloris({
      el: '.color-fields .form-control',
      alpha: false,
      clearButton: true,
      swatches: [
        '#264653',
        '#2a9d8f',
        '#e9c46a',
        '#f4a261',
        '#e76f51',
        '#d62828',
        '#023e8a',
        '#0077b6',
        '#0096c7',
        '#00b4d8',
        '#48cae4'
      ]
    });
</script>

<style type="text/css">
	.color-fields .form-group {min-width: 150px; float:left; margin-right: 20px;}
    .color-fields label  {display: block}
    .color-fields .clr-field {width: 115px}
</style>
