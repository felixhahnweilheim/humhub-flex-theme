<?php

namespace humhub\modules\flexTheme\models;

use humhub\modules\ui\icon\widgets\Icon;
use Yii;

class DarkColorSettings extends AbstractColorSettings
{
    public $prefix = 'dark_';
    
    // @todo
    public $background_color_highlight = '#daf0f3';
    public $background_color_highlight_soft = '#f2f9fb';
    
    public function getColors(): array
    {
        $settings = self::getSettings();

        foreach ($this->configurableColors as $color) {
            $value = $settings->get($this->prefix . $color);
            
            // If empty get default value
            if (empty($value)) {
                $value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();
            }
            
            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }
        
        foreach (self::SPECIAL_COLORS as $color) {
            $value = $settings->get($this->prefix . $color);
            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }

        return $result;
    }

    public function attributeHints(): array
    {
        $hints = [];

        foreach ($this->configurableColors as $color) {
            
            $default_value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();
            $icon = Icon::get('circle', ['color' => $default_value]);
            $hints[$color] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . $default_value . '</code> ' . $icon;
        }
        // @todo check that it works for background_color_highlight and background_color_highlight_soft
		
        return $hints;
    }
}
