<?php

namespace humhub\modules\flexTheme\models;

use Yii;
use humhub\modules\flexTheme\Module;

/**
 * ConfigureForm defines the configurable fields.
 */
class Config extends \yii\base\Model
{
	public $settings = array('commentLink', 'likeLink', 'likeIcon', 'verifiedAccounts', 'default', 'primary', 'info', 'success', 'warning', 'danger', 'link');
    public $commentLink;
    public $likeLink;
    public $likeIcon;
	public $verifiedAccounts;
	/* Color variables */
	public $default;
	public $primary;
	public $info;
	public $success;
	public $warning;
	public $danger;
	public $link;
	
    public function init()
    {
		parent::init();
	
		foreach($this->settings as $value) {
			$this->$value = Yii::$app->getModule('flex-theme')->settings->get($value, $module->$value);
	    }
	}
    
	public function attributeLabels()
    {
        return [
            'commentLink' => Yii::t('FlexThemeModule.admin', 'Style of Comment Button'),
			'likeLink' => Yii::t('FlexThemeModule.admin', 'Style of Like Button'),
			'likeIcon' => Yii::t('FlexThemeModule.admin', 'Like Icon'),
			'verifiedAccounts' => Yii::t('ThemeOrangeModule.base', 'Verified Accounts'),
        ];
    }
	
	public function attributeHints()
    {
        return [
			'verifiedAccounts' => Yii::t('FlexThemeModule.admin.php', 'Enter the user IDs seperated by comma, e.g. "1,21"'),
	    ];
	}

    public function rules()
    {
        return [
		    [['commentLink', 'likeLink', 'likeIcon'], 'string'],
			[['commentLink', 'likeLink'], 'in', 'range' => ['icon', 'text', 'both']],
			['likeIcon', 'in', 'range' => ['heart', 'star', 'thumbs_up']],
			['verifiedAccounts', 'validateNumbersString'],
        ];
    }
	
	public function validateNumbersString($attribute, $params, $validator) {
		if (!preg_match("/^[0-9, ]*+$/", $this->$attribute)) {
                    $this->addError($attribute, 'Invalid Format');
        }
	}
	
	public function save()
    {
        if(!$this->validate()) {
            return false;
        }
		
		foreach($this->settings as $value) {
			Yii::$app->getModule('flex-theme')>settings->set($value, $this->$value);
	    }
        return true;
    }
}
