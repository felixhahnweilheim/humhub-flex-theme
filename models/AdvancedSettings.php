<?php

namespace humhub\modules\flexTheme\models;

use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\flexTheme\models\DarkColorSettings;
use Yii;

class AdvancedSettings extends \yii\base\Model
{
    public $settingsJson;
    public bool $overwriteAll = false;

    public function init()
    {
        parent::init();

        $settings = Yii::$app->getModule('flex-theme')->settings;

        $this->settingsJson = json_encode(self::getSettingsArray(), JSON_PRETTY_PRINT);
    }

    public function attributeLabels()
    {
        $labels['settingsJson'] = 'Settings JSON';
        $labels['overwriteAll'] = Yii::t('FlexThemeModule.admin', 'Overwrite all Settings');

        return $labels;
    }

    public function attributeHints()
    {
        $hints['settingsJson'] = '<b>' . Yii::t('FlexThemeModule.admin', 'WARNING') . '</b>' . ': ' . Yii::t('FlexThemeModule.admin', 'Your settings will be overwritten!');
        $hints['overwriteAll'] = Yii::t('FlexThemeModule.admin', 'With this option all stored settings will be deleted, only the imported settings remain.');
        
        return $hints;
    }

    public function rules()
    {
        return [
            [['settingsJson'], 'isValidJSON'],
            [['overwriteAll'], 'boolean'],
        ];
    }

    public function isValidJSON(string $attribute, $params, $validator)
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

    protected function getSettingsArray(): array
    {
        $config = [];
        $colors = [];
        $darkColors = [];

        $module = Yii::$app->getModule('flex-theme');

        // Get base settings
        $config_names = Config::CONFIG_NAMES;
        foreach($config_names as $setting) {
            $value = $module->settings->get($setting);

            // exclude empty settings
            if(!empty($value)) {
                $config[$setting] = $value;
            }
        }

        // Get color settings
        $color_names = array_merge(ColorSettings::MAIN_COLORS, ColorSettings::TEXT_COLORS, ColorSettings::BACKGROUND_COLORS);
        foreach($color_names as $color) {
            $value = $module->settings->get($color);

            // exclude empty settings
            if(!empty($value)) {
                $colors[$color] = $value;
            }
        }

        // Get dark colors
        $color_names = array_merge(DarkColorSettings::MAIN_COLORS, DarkColorSettings::TEXT_COLORS, DarkColorSettings::BACKGROUND_COLORS);
        foreach($color_names as $color) {
            $value = $module->settings->get(DarkColorSettings::PREFIX . $color);

            // exclude empty settings
            if(!empty($value)) {
                $darkColors[$color] = $value;
            }
        }

        return ['Config' => $config, 'ColorSettings' => $colors, 'DarkColorSettings' => $darkColors];
    }
}
