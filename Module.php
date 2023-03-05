<?php

namespace humhub\modules\flexTheme;

use humhub\modules\ui\view\helpers\ThemeHelper;
use Yii;

// to be done : fix/move enable function

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
		$this->save('default');
		$this->save('primary');
		$this->save('info');
		$this->save('success');
		$this->save('warning');
		$this->save('danger');
		$this->save('link');
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
