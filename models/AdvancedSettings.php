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
            $this->addError($attribute, 'JSON could not be converted.');
        }
    }

    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        $settings = json_decode($this->settingsJson);

        $base = $settings->base;
        $colors = $settings->colors;

        // Save base settings
        $config = new Config();
        $config->setAttributes($base);
        $config->save();

        // Save color settings
        $colorSettings = new colorSettings();
        $colorSettings->setAttributes($colors);
        $colorSettings->save();

        return true;
    }

    protected function getSettingsArray()
    {
        $base = [];
        $colors = [];

        $module = Yii::$app->getModule('flex-theme');

        // Get base settings
        $base_names = ['commentLink', 'likeLink', 'likeIcon', 'likeIconFull', 'likeIconColor'];
        foreach( $base_names as $setting) {
            $value = $module->settings->get($setting);

            // exclude empty settings
            if(!empty($value)) {
                $base[$setting] = $value;
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

        return ['base' => $base, 'colors' => $colors];
    }
}
