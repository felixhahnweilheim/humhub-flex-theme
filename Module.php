<?php

namespace humhub\modules\flexTheme;

use humhub\libs\DynamicConfig;
use humhub\modules\ui\view\helpers\ThemeHelper;
use Yii;

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
	public $verifiedAccounts = '1';
    
    public static function getSetting(string $setting_name) {
		return Yii::$app->getModule('flex-theme')->settings->get($setting_name);
	}
	
	public function getDescription() {
        return Yii::t('FlexThemeModule.admin', 'Flexible Theme for HumHub');
    }
	
	public function enable() {
		// Activate Flex Theme
        if (parent::enable()) {
            $theme = ThemeHelper::getThemeByName('FlexTheme');
            if ($theme !== null) {
                $theme->activate();
                DynamicConfig::rewrite();
	        }
        }
		
        /*Add Module settings*/
		$module = Yii::$app->getModule('flex-theme');
		$module->settings->set('commentLink', $this->commentLink);
	    $module->settings->set('likeLink', $this->likeLink);
		$module->settings->set('likeIcon', $this->likeIcon);
		$module->settings->set('verifiedAccounts', $this->verifiedAccounts);
    }
	
	public function disable() {
    
	    // Deselect theme (select community theme)
		if (Yii::$app->view->theme->name == 'FlexTheme') {
		    $theme = ThemeHelper::getThemeByName('HumHub');
		    if ($theme !== null) {
		    	$theme->activate();
			}
		}
	
        parent::disable();
    }
}
