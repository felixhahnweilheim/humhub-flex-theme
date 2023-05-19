<?php

use humhub\modules\flexTheme\models\AdvancedSettings;
use humhub\modules\ui\form\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form']);?>

            <?= $form->beginCollapsibleFields(Yii::t('FlexThemeModule.admin', 'Import/Export')); ?>
		        <?= $form->field($model, 'settingsJson')->textarea(['rows' => '12']); ?>
            <?= $form->endCollapsibleFields(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
