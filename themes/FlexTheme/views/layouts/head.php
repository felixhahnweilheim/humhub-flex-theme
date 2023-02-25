<?php

$base = Yii::$app->getModule('base');
$theme = Yii::$app->view->theme;


?>
<style>
	:root {
--default:<?= $theme->variable('default') . ';'; ?>
--primary:<?= $theme->variable('primary') . ';'; ?>
--info:<?= $theme->variable('info') . ';'; ?>
--success:<?= $theme->variable('success') . ';'; ?>
--warning:<?= $theme->variable('warning') . ';'; ?>
--danger:<?= $theme->variable('danger') . ';'; ?>
--link:<?= $theme->variable('info') . ';'; ?>
</style>
