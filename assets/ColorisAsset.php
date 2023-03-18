<?php

namespace humhub\modules\flexTheme\assets;

use yii\web\AssetBundle;

class ColorisAsset extends AssetBundle
{
    public $publishOptions = [
        'forceCopy' => false
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_BEGIN];
    public $sourcePath = '@flex-theme/resources';
	  public $css = [
		    'css/coloris.min.css'
	  ];
    public $js = [
        'js/coloris.min.js'
    ];
}
