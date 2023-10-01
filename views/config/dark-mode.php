<?php
use yii\helpers\Url;

$darkModeUrl = Url::toRoute('/marketplace/browse?keyword=dark-mode&categoryId=0&tags=');
?>
<div class="panel-body">
    <div class="alert alert-info">
        <p>Please use the module <a href="<?= $darkModeUrl ?>">Dark Mode"</a> and use "HumHub (dark)" as dark theme.</p>
    </div>
</div>
