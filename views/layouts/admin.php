<?php $this->beginContent('@admin/views/layouts/main.php') ?>
<div class="panel panel-default">
    <div class="panel-heading">
         <?= Yii::t('FlexThemeModule.admin', '<b>Flex Theme</b> Configuration'); ?>
    </div>
    <?php if (Yii::$app->view->theme->name != 'FlexTheme'): ?>
		    <div class="alert alert-danger">
                <p>
                    <strong><?= Yii::t('FlexThemeModule.admin', 'Warning: Flex Theme is not active, settings on this page won\'t have any effect!'); ?></strong><br>
					<?= Yii::t('FlexThemeModule.admin', 'Please go to Administration > Settings > Appearance and select "Flex Theme".'); ?><br>
                </p>
            </div>
	<?php endif; ?>

    <?= \humhub\modules\flexTheme\widgets\AdminMenu::widget(); ?>

    <?= $content; ?>
</div>
<?php $this->endContent(); ?>
