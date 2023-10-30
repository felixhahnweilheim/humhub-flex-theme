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
    public $showTopicMenu;
    public $showUploadAsButtons;

    const UPLOAD_BUTTONS_CSS = '.upload-buttons .btn-group .fileinput-button {   display: none; } .upload-buttons .btn-group .dropdown-toggle {   display: none; } .upload-buttons .btn-group .dropdown-menu {   display: inline-block;   position: relative;   border: none;   padding: 0;   margin: 0;   width: auto;   min-width: 0;   padding: 0 10px; } .upload-buttons .btn-group .dropdown-menu li {   float: left;   margin: 0 7px;   line-height: 1;   border-radius: 10px; } .upload-buttons .btn-group .dropdown-menu li a {   margin: 0 5px;   padding: 3px 7px; } .upload-buttons .btn-group .dropdown-menu li a i {   margin: 1px; } .upload-buttons .btn-group .dropdown-menu li a[data-action-click="file.uploadByType"] {   font-size: 0;   padding: 5px 3px; } .upload-buttons .btn-group .dropdown-menu li:hover {   border-left-color: transparent !important; }';

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
        $this->showTopicMenu = $settings->get('showTopicMenu');
        $this->showUploadAsButtons = $settings->get('showUploadAsButtons');
    }

    public function attributeLabels() {

        // Note: the attribute name in uppercase is used as fallback
        return [
            'commentLink' => Yii::t('FlexThemeModule.admin', 'Style of Comment Button'),
            'likeLink' => Yii::t('FlexThemeModule.admin', 'Style of Like Button'),
            'likeIcon' => Yii::t('FlexThemeModule.admin', 'Like Icon'),
            'likeIconFull' => Yii::t('FlexThemeModule.admin', 'Like Icon (already liked)'),
            'likeIconColor' => Yii::t('FlexThemeModule.admin', 'Color for Like Icon'),
            'showTopicMenu' => Yii::t('FlexThemeModule.admin', 'Show topic menu in user profiles and spaces.'),
            'showUploadAsButtons' => Yii::t('FlexThemeModule.admin', 'Show File Upload options (image, audio, video...) as buttons instead of dropdown.')
        ];
    }

    public function rules() {

        return [
            [['commentLink', 'likeLink', 'likeIcon', 'likeIconFull'], 'string'],
            [['commentLink', 'likeLink'], 'in', 'range' => ['icon', 'text', 'both']],
            [['likeIcon', 'likeIconFull'], 'required', 'when' => function() {
                return $this->likeLink == 'both' || $this->likeLink == 'icon';
            }],
            [['likeIconColor'], 'validateHexColor'],
            [['showTopicMenu', 'showUploadAsButtons'], 'boolean']
        ];
    }

    public function validateHexColor($attribute, $params, $validator)
    {
        if (!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $this->$attribute)) {
            $this->addError($attribute, Yii::t('FlexThemeModule.admin', 'Invalid Format') . '. ' . Yii::t('FlexThemeModule.admin', 'Must be a color in hexadecimal format, like "#00aaff" or "#FA0"'));
        }
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
        $module->settings->set('showTopicMenu', $this->showTopicMenu);
        $module->settings->set('showUploadAsButtons', $this->showUploadAsButtons);

        // Update variables.css (apply showUploadAsButtons)
        $colors = new ColorSettings();
        $colors->saveVarsToFile();

        return true;
    }

    /* Additional CSS (ColorSettings uses it to generate the variables.css */
    public function additionalCss()
    {
        if ($this->showUploadAsButtons) {
            return self::UPLOAD_BUTTONS_CSS;
        }
        return '';
    }
}
