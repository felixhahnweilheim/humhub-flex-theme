<?php

namespace humhub\modules\flexTheme;

use humhub\modules\ui\view\helpers\ThemeHelper;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module {

    const COLOR_VARS = array('default', 'primary', 'info', 'success', 'warning', 'danger', 'link');
    const SPECIAL_COLORS = array('default_darken_2', 'default_darken_5', 'default_lighten_2', 'primary_darken_5', 'primary_lighten_5', 'info_darken_5', 'info_lighten_5', 'danger_darken_5', 'danger_lighten_5', 'success_darken_5', 'success_lighten_5', 'warning_darken_2', 'warning_lighten_5', 'link_darken_2', 'link_lighten_5');
    /*Module settings and their default values*/
    /*@var string defines the style of comment links (options: icon, text, both)*/
    public $commentLink = 'text';
    /*@var string defines the style of like links (options: icon, text, both)*/
    public $likeLink = 'text';
    /*@var string defines the like icon (options: heart, thumbs_up, star)*/
    public $likeIcon = 'thumbs_up';
    /*@var string defines IDs of verified accounts*/
    public $verifiedAccounts = '';
    /* color variables*/
    public $default;
    public $primary;
    public $info;
    public $success;
    public $warning;
    public $danger;
    public $link;
    
    
    public $default_darken_2;public $default_darken_5;public $default_lighten_2;public $primary_darken_5;public $primary_lighten_5;public $info_darken_5;public $info_lighten_5;public $danger_darken_5;public $danger_lighten_5;public $success_darken_5;public $success_lighten_5;public $warning_darken_2;public $warning_lighten_5;public $link_darken_2;public $link_lighten_5;
    
    
    // Translatable Module Description
    public function getDescription() {
        return Yii::t('FlexThemeModule.admin', 'Flexible Theme for HumHub');
    }
    
    // Link to configuration page
    public function getConfigUrl() {
        return Url::to(['/flex-theme/config']);
    }
    
    // Module Activation: Activate Flex Theme
    public function enable() {
        if (parent::enable()) {
            $theme = ThemeHelper::getThemeByName('FlexTheme');
            if ($theme !== null) {
                $theme->activate();
            }
        }	
    }
	
    // Module Deactivarion: Deselect Flex Theme (activate community theme)
    public function disable() {
        if (Yii::$app->view->theme->name == 'FlexTheme') {
            $theme = ThemeHelper::getThemeByName('HumHub');
            if ($theme !== null) {
                $theme->activate();
            }
        }
	
        parent::disable();
    }
}
