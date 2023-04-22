<?php

namespace humhub\modules\flexTheme\models;

use Yii;
use humhub\modules\flexTheme\helpers\ColorHelper;
use humhub\modules\ui\view\helpers\ThemeHelper;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;

use yii\base\UnknownPropertyException;

/**
 * ConfigureForm defines the configurable fields.
 */
class Config extends \yii\base\Model
{
    // Module settings
    public $commentLink;
    public $likeLink;
    public $likeIcon;
    public $likeIconFull;
    public $likeIconColor;

    public static function getSetting(string $setting_name) {

        // Note: return can be empty
        return Yii::$app->getModule('flex-theme')->settings->get($setting_name);
    }

    public function init() {

        parent::init();

        $settings = Yii::$app->getModule('flex-theme')->settings;

        $this->commentLink = $settings->get('commentLink', 'text');
        $this->likeLink = $settings->get('likeLink', 'text');
        $this->likeIcon = $settings->get('likeIcon', 'thumbs-o-up');
        $this->likeIconFull = $settings->get('likeIconFull', 'thumbs-up');
        $this->likeIconColor = $settings->get('likeIconColor');
    }

    public function attributeLabels() {

        // Note: the attribute name in uppercase is used as fallback
        return [
            'commentLink' => Yii::t('FlexThemeModule.admin', 'Style of Comment Button'),
            'likeLink' => Yii::t('FlexThemeModule.admin', 'Style of Like Button'),
            'likeIcon' => Yii::t('FlexThemeModule.admin', 'Like Icon'),
            'likeIconFull' => Yii::t('FlexThemeModule.admin', 'Like Icon (already liked)'),
            'likeIconColor' => Yii::t('FlexThemeModule.admin', 'Color for Like Icon')
        ];
    }

    public function rules() {

        return [
            [['commentLink', 'likeLink', 'likeIcon', 'likeIconFull'], 'string'],
            [['commentLink', 'likeLink'], 'in', 'range' => ['icon', 'text', 'both']],
            [['likeIcon', 'likeIconFull'], 'required', 'when' => function() {
                return $this->likeLink == 'both' || $this->likeLink == 'icon';
            }]
        ];
    }

    public function save() {

        if(!$this->validate()) {
            return false;
        }

        $module = Yii::$app->getModule('flex-theme');

        // Save configuration for Social Controls and Verified Accounts
        $module->settings->set('commentLink', $this->commentLink);
        $module->settings->set('likeLink', $this->likeLink);
        $module->settings->set('likeIcon', $this->likeIcon);
        $module->settings->set('likeIconFull', $this->likeIconFull);
        $module->settings->set('likeIconColor', $this->likeIconColor);

        return true;
    }
}
