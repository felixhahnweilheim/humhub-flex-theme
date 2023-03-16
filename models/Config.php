<?php

namespace humhub\modules\flexTheme\models;

use Yii;
use humhub\modules\flexTheme\Module;
use humhub\modules\flexTheme\helpers\ColorHelper;
use humhub\modules\ui\view\helpers\ThemeHelper;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;

/**
 * ConfigureForm defines the configurable fields.
 */
class Config extends \yii\base\Model {
	
	/*Module settings, see Module.php*/
	public $commentLink;
	public $likeLink;
	public $likeIcon;
	public $verifiedAccounts;
	public $default;
	public $primary;
	public $info;
	public $success;
	public $warning;
	public $danger;
	public $link;
    
    public $background_color_secondary;
    public $background_color_page;
    public $text_color_secondary;
    
    // Special colors (under development)
    public $default__darken__2;
    public $default__darken__5;
    public $default__lighten__2;
    public $primary__darken__5;
    public $primary__darken__10;
    public $primary__lighten__5;
    public $primary__lighten__8;
    public $primary__lighten__10;
    public $primary__lighten__20;
    public $primary__lighten__25;
    public $info__darken__5;
    public $info__darken__10;
    public $info__lighten__5;
    public $info__lighten__8;
    public $info__lighten__25;
    public $info__lighten__45;
    public $info__lighten__50;
    public $danger__darken__5;
    public $danger__darken__10;
    public $danger__lighten__5;
    public $danger__lighten__20;
    public $success__darken__5;
    public $success__darken__10;
    public $success__lighten__5;
    public $success__lighten__20;
    public $warning__darken__2;
    public $warning__darken__5;
    public $warning__darken__10;
    public $warning__lighten__5;
    public $warning__lighten__20;
    public $link__darken__2;
    public $link__lighten__5;
    public $background_color_secondary__darken__5;
    public $background_color_page__lighten__3;
    public $background_color_page__darken__5;
    public $background_color_page__darken__8;
    public $text_color_secondary__lighten__25;
    public $warning__fade__25;
    public $link__fade__60;
    
    public static function getSetting(string $setting_name) {
	    
		$module = Yii::$app->getModule('flex-theme');
		$value = $module->settings->get($setting_name);
		
		if (empty($value)) {
			$value = $module->$setting_name;
		}
		
	    return $value;
    }
	
	public static function verifiedIcon($user) {
		$verifiedAccounts = explode(',', Config::getSetting('verifiedAccounts'));
		
		if (($user instanceof User) && in_array($user->id, $verifiedAccounts)) {
			return Icon::get('check-circle', ['htmlOptions' => ['class' => 'verified']])->tooltip(Yii::t('FlexThemeModule.base', 'Verified Account'));
		}
		return false;		
	}
	
    public function init() {
    
		parent::init();
		$this->commentLink = $this->getSetting('commentLink');
		$this->likeLink = $this->getSetting('likeLink');
		$this->likeIcon = $this->getSetting('likeIcon');
		$this->verifiedAccounts = $this->getSetting('verifiedAccounts');
		$this->default = $this->getSetting('default');
		$this->primary = $this->getSetting('primary');
		$this->info = $this->getSetting('info');
		$this->success = $this->getSetting('success');
		$this->danger = $this->getSetting('danger');
		$this->link = $this->getSetting('link');
	}
    
	public function attributeLabels() {
    
        return [
            'commentLink' => Yii::t('FlexThemeModule.admin', 'Style of Comment Button'),
			'likeLink' => Yii::t('FlexThemeModule.admin', 'Style of Like Button'),
			'likeIcon' => Yii::t('FlexThemeModule.admin', 'Like Icon'),
			'verifiedAccounts' => Yii::t('ThemeOrangeModule.admin', 'Verified Accounts'),
        ];
    }
	
	public function attributeHints() {
		
        $color_vars = Module::COLOR_VARS;
		
		$hints = array();
		$hints['verifiedAccounts'] = Yii::t('FlexThemeModule.admin.php', 'Enter the user IDs seperated by comma, e.g. <code>1,21</code>');
		foreach ($color_vars as $color) {
			$value = Yii::$app->view->theme->variable($color);
			$icon = Icon::get('circle', ['color' => $value ]);
			$hints[$color] = Yii::t('FlexThemeModule.admin.php', 'Default: ') . '<code>' . $value . '</code> ' . $icon;
		}
		
		return $hints;
	}

    public function rules() {
    
        return [
		    [['commentLink', 'likeLink', 'likeIcon'], 'string'],
			[['commentLink', 'likeLink'], 'in', 'range' => ['icon', 'text', 'both']],
			['likeIcon', 'in', 'range' => ['heart', 'star', 'thumbs_up']],
			['verifiedAccounts', 'validateNumbersString'],
			[['default', 'primary', 'info', 'success', 'warning', 'danger', 'link'], 'validateHexColor'],
        ];
    }
	
	public function validateNumbersString($attribute, $params, $validator) {
		
        if (!preg_match("/^[0-9, ]*+$/", $this->$attribute)) {
                    $this->addError($attribute, 'Invalid Format. Must be a list of numbers, seperated by commas.');
        }
	}
		
	public function validateHexColor($attribute, $params, $validator) {
		
        if (!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $this->$attribute)) {
                    $this->addError($attribute, 'Invalid Format. Must be a color in hexadecimal format, like "#00aaff" or "#FA0"');
        }
	}
	
	public function save() {
    
        if(!$this->validate()) {
            return false;
        }
		
        $module = Yii::$app->getModule('flex-theme');
        $module->settings->set('commentLink', $this->commentLink);
	    $module->settings->set('likeLink', $this->likeLink);
		$module->settings->set('likeIcon', $this->likeIcon);
		$module->settings->set('verifiedAccounts', $this->verifiedAccounts);
	    $module->settings->set('default', $this->default);
		$module->settings->set('primary', $this->primary);
		$module->settings->set('info', $this->info);
		$module->settings->set('success', $this->success);
		$module->settings->set('danger', $this->danger);
		$module->settings->set('link', $this->link);
        
        // Test - WIP
        $special_colors = Module::SPECIAL_COLORS;
		
		foreach ($special_colors as $color) {
			list($base_var, $function, $amount) = explode("__", $color);
			$original_color = $this->$base_var;
			if (empty($original_color)) {
				$original_color = Config::getSetting($base_var);
            }
			if (empty($original_color)) {
                $theme_var = str_replace('_', '-', $base_var);
				$original_color = ThemeHelper::getThemeByName('HumHub')->variable($theme_var);
			}
			if ($function == 'darken') {
			    $value = ColorHelper::darken($original_color, $amount);
			} elseif ($function == 'lighten') {
				  $value = ColorHelper::lighten($original_color, $amount);
			} elseif ($function == 'fade') {
                $value = ColorHelper::fade($original_color, $amount);
            } elseif ($function == 'fadeout') {
                $value = ColorHelper::fadeout($original_color, $amount);
            }
			$module->settings->set($color, $value);
			
		}
        return true;
    }
}
