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
    public $default = '#0d0d0d';

    public $text_color_main = '#ddd';
    public $text_color_secondary = '#bbb';
    public $text_color_highlight = '#fff';
    public $text_color_soft = '#dddddd';
    public $text_color_soft2 = '#ccc';
    public $text_color_soft3 = '#7b7773';
    public $text_color_contrast = '#000';

    public $background_color_main = '#222';
    public $background_color_secondary = '#333';
    public $background_color_page = '#000';
    public $background_color_highlight = '#2e393a';
    public $background_color_highlight_soft = '#171d1e';
    public $background3 = '#393939';
    public $background4 = '#5e5e5e';

    public function getColors(): array
    {
        $settings = self::getSettings();

        foreach (static::MAIN_COLORS as $color) {
            $value = $settings->get(self::PREFIX . $color);

            // If empty get default value
            if (empty($value)) {
                
                // compatiblity with PHP 7.4 will be removed in next version
                if (version_compare(phpversion(), '8.0.0', '<')) {
                    $value = (new \ReflectionProperty($this))->getDeclaringClass()->getDefaultProperties()[$color] ?? null;
                } else {
                    // min PHP 8.0
                    $value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();
                }
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
                $value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();
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

    public function attributeHints(): array
    {
        $hints = [];

        foreach (static::MAIN_COLORS as $color) {
            $default_value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();

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

            $default_value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();
            $icon = Icon::get('circle', ['color' => $default_value]);
            $hints[$color] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . $default_value . '</code> ' . $icon;
        }
        // @todo check that it works for background_color_highlight and background_color_highlight_soft

        return $hints;
    }

    protected function getColorFallBack(string $color): string
    {
        $value = (new \ReflectionClass($this))->getProperty($color)->getDefaultValue();
        if (empty($value)) {// only main colors can be empty!
            if (!isset($lightColors)) {
                $lightColors = (new ColorSettings())->getColors();
            }
            $value = $lightColors[$color];
        }
        return $value;
    }
}
