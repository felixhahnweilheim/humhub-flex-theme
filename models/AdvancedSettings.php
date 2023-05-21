<?php

namespace humhub\modules\flexTheme\models;

use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\models\ColorSettings;

use Yii;

class AdvancedSettings extends \yii\base\Model
{

    public $settingsJson;

    public function init()
    {
        parent::init();

        $settings = Yii::$app->getModule('flex-theme')->settings;

        $this->settingsJson = json_encode(self::getSettingsArray(), JSON_PRETTY_PRINT);
    }

    public function attributeLabels()
    {
        $labels['settingsJson'] = 'Settings JSON';

        return $labels;
    }

    public function attributeHints()
    {
        $hints['settingsJson'] = '<b>' . Yii::t('FlexThemeModule.admin', 'WARNING') . '</b>' . ': ' . Yii::t('FlexThemeModule.admin', 'Your settings will be overwritten!');

        return $hints;
    }

    public function rules()
    {
        return [
            [['settingsJson'], 'isValidJSON']
		];
    }

    public function isValidJSON($attribute, $params, $validator)
    {
        if(json_decode($this->$attribute) === null) {
            $this->addError($attribute, Yii::t('FlexThemeModule.admin', 'JSON could not be converted!'));
        }
    }

    public function save()
    {
        if(!$this->validate()) {
            return false;
        }

        return true;
    }

    protected function getSettingsArray()
    {
        $config = [];
        $colors = [];

        $module = Yii::$app->getModule('flex-theme');

        // Get base settings
        $config_names = ['commentLink', 'likeLink', 'likeIcon', 'likeIconFull', 'likeIconColor'];
        foreach( $config_names as $setting) {
            $value = $module->settings->get($setting);

            // exclude empty settings
            if(!empty($value)) {
                $config[$setting] = $value;
            }
        }

        // Get color settings
        $color_names = array_merge(ColorSettings::MAIN_COLORS, ColorSettings::TEXT_COLORS, ColorSettings::BACKGROUND_COLORS);
        foreach( $color_names as $color) {
            $value = $module->settings->get($color);

            // exclude empty settings
            if(!empty($value)) {
                $colors[$color] = $value;
            }
        }

        return ['Config' => $config, 'ColorSettings' => $colors];
    }
}
