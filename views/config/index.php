<?php

use humhub\modules\flexTheme\models\ConfigureForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('FlexThemeModule.base', '<b>Orange Theme</b> Configuration'); ?></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form']);?>
		    <?= $form->field($model, 'commentLink')->radioList([
	            'text' => 'Text link',
	            'icon' => 'Only icon',
	            'both' => 'Text and icon'
            ]);?>
		    <?= $form->field($model, 'likeLink')->radioList([
	            'text' => 'Text link',
	            'icon' => 'Only icon',
	            'both' => 'Text and icon'
            ]);?>
		    <?= $form->field($model, 'likeIcon')->radioList([
	            'heart' => 'Heart',
	            'star' => 'Star',
	            'thumbsup' => 'Thumbs up'
	        ]);?>
		
        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
