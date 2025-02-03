<?php

use humhub\modules\flexTheme\models\DarkColorSettings;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\icon\widgets\Icon;
use kartik\widgets\ColorInput;
use yii\helpers\Html;
use yii\helpers\Url;

$main_colors = DarkColorSettings::MAIN_COLORS;
$text_colors = DarkColorSettings::TEXT_COLORS;
$background_colors = DarkColorSettings::BACKGROUND_COLORS;

$darkModeUrl = Url::toRoute('/marketplace/browse?keyword=dark-mode&tags=');
$darkModeName = Yii::t('FlexThemeModule.admin', 'Dark Mode');
$link = '<a href=' . $darkModeUrl . '>' . $darkModeName . '</a>';
$darkModeConfigUrl = Url::toRoute('/dark-mode/admin');
$darkModeConfigName = Yii::t('FlexThemeModule.admin', 'Dark Mode Settings');
$configLink = '<a href=' . $darkModeConfigUrl . '>' . $darkModeConfigName . '</a>';
?>
<div class="panel-body">
    <?php
    if (! Yii::$app->hasModule('dark-mode')) {
        echo '<div class="alert alert-info">
            <p>' . Yii::t('FlexThemeModule.admin', 'Please use the module {darkmode}.', [
                'darkmode' => $link,
            ]) .
            '</p>
        </div>';
    } else {
        try {
            $darkModeConfig = new \humhub\modules\darkMode\models\Config();
            if ($darkModeConfig->theme !== 'FlexTheme (dark)') {
                echo '<div class="alert alert-info">
                    <p>' . Yii::t('FlexThemeModule.admin', 'Please select "FlexTheme (dark)" in the {link}.', [
                        'link' => $configLink,
                    ]) .
                    '</p>
                </div>';
            }
        } catch (Exception $e) {
            echo '<div class="alert alert-info">
            <p>' . Yii::t('FlexThemeModule.admin', 'Could not check the dark mode module settings, check the logs for details.', [
                'link' => $configLink,
            ]) .
            '</p>';
            Yii::error($e, 'flex-theme');
        }
    }
    ?>

    <?php $form = ActiveForm::begin(['id' => 'colors-form']);?>

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
        <button class="btn btn-sm pull-right" id="refresh-button" style="color:var(--danger);background-color:var(--background-color-main);font-weight:600" href="#" data-action-click="humhub.modules.flex_theme.admin.emptyColors"><?= Icon::get('refresh') ?> <?= Yii::t('FlexThemeModule.admin', 'Reset all colors') ?></button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
