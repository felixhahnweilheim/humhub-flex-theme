<?php

namespace humhub\modules\flexTheme\models;

use humhub\modules\flexTheme\models\ColorSettings;

use Yii;

class AdvancedSettings extends \yii\base\Model
{

    public $settingsJson;

    public function init()
    {
        parent::init();

        $settings = Yii::$app->getModule('flex-theme')->settings;

        $this->settingsJson = json_encode(self::getSettingsArray());
    }

    public function attributeLabels()
    {
        $hints['settingsJson'] = 'Settings JSON';

        return $hints;
    }

    public function rules()
    {
        return [
            [['settingsJson'], 'string']
		];
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
