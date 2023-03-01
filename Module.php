<?php

namespace humhub\modules\flexTheme;

use humhub\libs\DynamicConfig;
use humhub\modules\ui\view\helpers\ThemeHelper;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;
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
	public $verifiedAccounts = '';
    
    public static function getSetting(string $setting_name) {
		return Yii::$app->getModule('flex-theme')->settings->get($setting_name);
	}
	
	public static function verifiedIcon($user) {
		$verifiedAccounts = explode(',', Module::getSetting('verifiedAccounts'));
		
		if (($user instanceof User) && in_array($user->id, $verifiedAccounts)) {
			return Icon::get('check-circle', ['htmlOptions' => ['class' => 'verified']])->tooltip(Yii::t('FlexThemeModule.base', 'Verified Account'));
		}
		return false;		
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
		$this->save('commentLink');
		$this->save('likeLink');
		$this->save('likeIcon');
		$this->save('verifiedAccounts');
    }
	
	public function save($setting_name) {
		Yii::$app->getModule('flex-theme')->settings->set($setting_name, $this->$setting_name);
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
