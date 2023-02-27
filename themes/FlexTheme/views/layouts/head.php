<?php
//FlexTheme
use humhub\modules\flexTheme\Module;

$theme = Yii::$app->view->theme;
?>
<style>
:root {
--default:<?= (Module::getSetting('var_default') ??  $theme->variable('default')). ';'; ?>
--primary:<?= (Module::getSetting('var_primary') ?? $theme->variable('primary')) . ';'; ?>
--info:<?= (Module::getSetting('var_info') ?? $theme->variable('info')) . ';'; ?>
--success:<?= (Module::getSetting('var_success') ?? $theme->variable('success')) . ';'; ?>
--warning:<?= (Module::getSetting('var_warning') ?? $theme->variable('warning')) . ';'; ?>
--danger:<?= (Module::getSetting('var_danger') ?? $theme->variable('danger')) . ';'; ?>
--link:<?= (Module::getSetting('var_link') ?? $theme->variable('link')) . ';'; ?>
}
</style>
