<?php

namespace humhub\modules\flexTheme;

use humhub\modules\ui\view\helpers\ThemeHelper;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{

    /*Module settings and their default values*/
    /*@var string defines the style of comment links (options: icon, text, both)*/
    public $commentLink = 'text';
    /*@var string defines the style of like links (options: icon, text, both)*/
    public $likeLink = 'text';
    /*@var string defines the like icon (options: heart, thumbs_up, star)*/
    public $likeIcon = 'thumbs_up';
    /*@var array defines IDs of verified accounts*/
    public $verifiedAccounts = '';
    /* color variables*/
    public $default;
    public $primary;
    public $info;
    public $success;
    public $warning;
    public $danger;
    public $link;
    
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
