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

        $this->settingsJson = self::getSettingsAsJSON();
    }

    public function attributeHints()
    {
        $hints = array();

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

    protected function getSettingsAsJSON()
    {
        return json_encode(self::getSettingsArray());
    }

    protected function getSettingsArray()
    {
        $settings = [];
    }
}
