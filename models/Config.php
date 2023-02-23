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
	
    public function init()
    {
		parent::init();
        $module = Yii::$app->getModule('flex-theme');
		$this->commentLink = $module->settings->get('commentLink', $module->commentLink);
		$this->likeLink = $module->settings->get('likeLink', $module->likeLink);
		$this->likeIcon = $module->settings->get('likeIcon', $module->likeIcon);
	}
    
	public function attributeLabels()
    {
        return [
            'commentLink' => Yii::t('FlexThemeModule.admin', 'Style of Comment Button'),
			'likeLink' => Yii::t('FlexThemeModule.admin', 'Style of Like Button'),
			'likeIcon' => Yii::t('FlexThemeModule.admin', 'Like Icon'),
        ];
    }

    public function rules()
    {
        return [
		    [['commentLink', 'likeLink', 'likeIcon'], 'string'],
			[['commentLink', 'likeLink'], 'in', 'range' => ['icon', 'text', 'both']],
			['likeIcon', 'in', 'range' => ['heart', 'star', 'thumbsup']],
        ];
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
        return true;
    }
}
