<?php

namespace humhub\modules\flexTheme\models;

use humhub\modules\ui\icon\widgets\Icon;
use Yii;

class DarkColorSettings extends AbstractColorSettings
{
    public const PREFIX = 'dark_';
    /* @todo
    --background-color-success:#3e423b;--text-color-success:#84be5e;--border-color-success:#97d271;--background-color-warning:#4d443b;--text-color-warning:#e9b168;--border-color-warning:#fdd198;--background-color-danger:#372a2a;--text-color-danger:#ff8989;--border-color-danger:#ff8989;}

    */
    
    /*
     * As we can't fallback to the standard theme's colors,
     * in dark mode all colors need a default color except from main colors (primary etc.)
     * the main color default needs also a dark default color
     */
    public const DEFAULT_COLORS = 
    [
        'default' => '#0d0d0d',

        'text_color_main' => '#ddd',
        'text_color_secondary' => '#bbb',
        'text_color_highlight' => '#fff',
        'text_color_soft' => '#dddddd',
        'text_color_soft2' => '#ccc',
        'text_color_soft3' => '#7b7773',
        'text_color_contrast' => '#000',
    
        'background_color_main' => '#222',
        'background_color_secondary' => '#333',
        'background_color_page' => '#000',
        'background_color_highlight' => '#2e393a',
        'background_color_highlight_soft' => '#171d1e',
        'background3' => '#393939',
        'background4' => '#5e5e5e',
    ];
    
    /*
     * caching light colors array
     */
    private array $_lightColors;

    public function getColors(): array
    {
        $settings = self::getSettings();

        foreach (static::MAIN_COLORS as $color) {
            $value = $settings->get(self::PREFIX . $color);

            // If empty get default value
            if (empty($value)) {
                $value = self::getDefaultValue($color);
            }
            // For the main colors we can take the light theme as fallback
            if (empty($value)) {
                if (!isset($lightColors)) {
                    $lightColors = (new ColorSettings())->getColors();
                }
                $value = $lightColors[$color];
            }

            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }

        $otherColors = array_merge(static::TEXT_COLORS, static::BACKGROUND_COLORS);
        foreach ($otherColors as $color) {
            $value = $settings->get(self::PREFIX . $color);

            // If empty get default value
            if (empty($value)) {
                $value = self::getDefaultValue($color);
            }

            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }

        foreach (self::SPECIAL_COLORS as $color) {
            $value = $settings->get(self::PREFIX . $color);
            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }

        return $result;
    }
    
    /*
     * color fallback
     * 1. default value
     * 2. get from light theme settings (should only happen to main colors like primary, link etc.)
     */
    protected function getColorFallBack(string $color): string
    {
        $value = self::getDefaultValue($color);
        
        if (empty($value)) {
            if (!isset($this->_lightColors)) {
                $this->_lightColors = (new ColorSettings())->getColors();
            }
            $color = str_replace('_', '-', $color);// getColors() returns the string-replaced color keys as array keys, so we need this here also
            $value = $this->_lightColors[$color];
        }
        return $value;
    }
    
    public function attributeHints(): array
    {
        $hints = [];

        foreach (static::MAIN_COLORS as $color) {
            $default_value = self::getDefaultValue($color);

            // For the main colors we use the light theme as default
            if (empty($default_value)) {
                if (!isset($lightColors)) {
                    $lightColors = (new ColorSettings())->getColors();
                }
                $default_value = $lightColors[$color];
            }
            $icon = Icon::get('circle', ['color' => $default_value]);
            $hints[$color] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . $default_value . '</code> ' . $icon;
        }

        $otherColors = array_merge(static::TEXT_COLORS, static::BACKGROUND_COLORS);
        foreach ($otherColors as $color) {

            $default_value = self::getDefaultValue($color);
            $icon = Icon::get('circle', ['color' => $default_value]);
            $hints[$color] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . $default_value . '</code> ' . $icon;
        }

        return $hints;
    }
}
