<?php

namespace humhub\modules\flexTheme\models;

use Yii;
use humhub\modules\flexTheme\Module;

/**
 * ConfigureForm defines the configurable fields.
 */
class Config extends \yii\base\Model
{
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
	    $module = Yii::$app->getModule('flex-theme');
		$this->commentLink = $module->settings->get('commentLink', $module->commentLink);
		$this->likeLink = $module->settings->get('likeLink', $module->likeLink);
		$this->likeIcon = $module->settings->get('likeIcon', $module->likeIcon);
		$this->verifiedAccounts = $module->settings->get('verifiedAccounts', $module->verifiedAccounts);
		$this->default = $module->settings->get('default', $module->default);
		$this->primary = $module->settings->get('primary', $module->primary);
		$this->info = $module->settings->get('info', $module->info);
		$this->success = $module->settings->get('success', $module->success);
		$this->danger = $module->settings->get('danger', $module->danger);
		$this->link = $module->settings->get('link', $module->link);
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
                    $this->addError($attribute, 'Invalid Format. Must be a color in hexadecimal format, like "#00aaff" or "#FA0"-');
        }
	}
	
	public function save()
    {
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
        return true;
    }
}
