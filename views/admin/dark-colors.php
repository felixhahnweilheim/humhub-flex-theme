<?php

use humhub\modules\flexTheme\models\DarkColorSettings;
use humhub\modules\ui\form\widgets\ActiveForm;
use kartik\widgets\ColorInput;
use yii\helpers\Html;
use yii\helpers\Url;

$main_colors = DarkColorSettings::MAIN_COLORS;
$text_colors = DarkColorSettings::TEXT_COLORS;
$background_colors = DarkColorSettings::BACKGROUND_COLORS;

$darkModeUrl = Url::toRoute('/marketplace/browse?keyword=dark-mode&tags=');
$darkModeName = Yii::t('FlexThemeModule.admin', 'Dark Mode');
$link = '<a href=' . $darkModeUrl . '>' . $darkModeName . '</a>';
?>
<div class="panel-body">
    <div class="alert alert-info">
        <p><?= Yii::t('FlexThemeModule.admin', 'Please use the module {darkmode} and select "HumHub (dark)".', [
            'darkmode' => $link,
        ]) ?>
        </p>
    </div>

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
