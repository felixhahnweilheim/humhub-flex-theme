<?php

namespace humhub\modules\flexTheme\assets;

class AdminAssets extends \humhub\components\assets\AssetBundle
{
    public $publishOptions = [
        'forceCopy' => true
    ];
    
    public $sourcePath = '@flex-theme/resources';
    
    public $js = [
        'js/flex-theme-admin.js',
    ];
}