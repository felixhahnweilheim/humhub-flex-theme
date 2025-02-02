<?php

namespace humhub\modules\flexTheme\models;

use humhub\modules\ui\view\helpers\ThemeHelper;
use humhub\modules\ui\icon\widgets\Icon;
use Yii;

class ColorSettings extends AbstractColorSettings
{
    // Colors that are not hard coded in default theme
    public const DEFAULT_COLORS = [
        'background_color_highlight' => '#daf0f3',
        'background_color_highlight_soft' => '#f2f9fb',
    ]; 

    /*
     * Base Theme for fallback values
     */
    public const BASE_THEME = 'HumHub';

    /*
     * get all colors, configured, default or fallback to standard theme color
     * mainly used to store them in the variables.less file, see saveVarsToFile()
     */
    public function getColors(): array
    {
        $settings = self::getSettings();
        $base_theme = ThemeHelper::getThemeByName(self::BASE_THEME);

        foreach ($this->configurableColors as $color) {
            $value = $settings->get(static::PREFIX . $color);

            // If empty get default value
            if (empty($value)) {
                $value = self::getDefaultValue($color);
            }
            // If still empty get value from base theme
            if (empty($value)) {
                $theme_var = str_replace('_', '-', $color);
                $value = $base_theme->variable($theme_var);
            }
            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }

        foreach (self::SPECIAL_COLORS as $color) {
            $value = $settings->get(static::PREFIX . $color);
            $color = str_replace('_', '-', $color);
            $result[$color] = $value;
        }

        return $result;
    }

    /*
     * color fallback
     * 1. default value
     * 2. get from standard theme
     */
    protected function getColorFallBack(string $color): string
    {
        $value = self::getDefaultValue($color);
        
        if (empty($value)) {
            $theme_var = str_replace('_', '-', $color);
            $value = ThemeHelper::getThemeByName(self::BASE_THEME)->variable(static::PREFIX . $theme_var);
        }
        return $value;
    }
    
    /*
     * Save color values as theme variables (take default theme's color if value is empty)
     */
    protected function additonalColorSaving(string $color, ?string $value): void
    {
        $theme_var = str_replace('_', '-', $color);
        if (empty($value)) {
            $value = ThemeHelper::getThemeByName(self::BASE_THEME)->variable($theme_var);
        }
        $theme_key = 'theme.var.FlexTheme.' . static::PREFIX . $theme_var;
        Yii::$app->settings->set($theme_key, $value);
    }
    
    public function attributeHints(): array
    {
        $hints = [];

        $base_theme = ThemeHelper::getThemeByName(self::BASE_THEME);

        foreach ($this->configurableColors as $color) {
            $theme_var = str_replace('_', '-', $color);
            $default_value = $base_theme->variable($theme_var);
            $icon = Icon::get('circle', ['color' => $default_value]);
            $hints[$color] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . $default_value . '</code> ' . $icon;
        }
        $icon = Icon::get('circle', ['color' => '#daf0f3']);
        $hints['background_color_highlight'] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . '#daf0f3' . '</code> ' . $icon;
        $icon = Icon::get('circle', ['color' => '#f2f9fb']);
        $hints['background_color_highlight_soft'] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . '#f2f9fb' . '</code> ' . $icon;

        return $hints;
    }
}
