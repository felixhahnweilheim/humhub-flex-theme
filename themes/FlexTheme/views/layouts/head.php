<?php
//FlexTheme
use humhub\modules\flexTheme\Module;

$color_vars = array('default', 'primary', 'info', 'success', 'warning', 'danger', 'link');
$theme = Yii::$app->view->theme;
?>
<style>
:root {
<?php foreach ($color_vars as $color): ?>
--<?= $color . ':' . (Module::getSetting($color) ??  $theme->variable($color)) . ';'; ?>
<?php endforeach; ?>
}
</style>
