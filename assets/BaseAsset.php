<?php

namespace humhub\modules\flexTheme\assets;

use yii\web\AssetBundle;

/*
 * BaseAsset adds the generated CSS file containing the CSS variable declarations
 */
class BaseAsset extends AssetBundle
{
    public $publishOptions = [
        'forceCopy' => false
    ];
    public $sourcePath = '@flex-theme/themes/FlexTheme';
    public $css = ['css/variables.css'];
}
