<?php

namespace humhub\modules\flexTheme\models;

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
        $settings = [];

        $module = Yii::$app->getModule('flex-theme');

        $base_settings = ['commentLink', 'likeLink', 'likeIcon', 'likeIconFull', 'likeIconColor'];

        foreach( $base_settings as $setting) {
             $settings[$setting] = $module->settings->get($setting);
        }

        return $settings;
    }
}
