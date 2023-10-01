<?php
use yii\helpers\Url;

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
</div>
