<?php

namespace humhub\modules\flexTheme\helpers;

use Yii;
use yii\base\ErrorException;

/*
 * helper class for safely accessing and modifying files
 */
class FileHelper
{
    public const THEME_PATH = '@flex-theme/themes/FlexTheme';

    /*
     * Update the color variables CSS file with given content
     * @param string $content
     * @param string $prefix, empty for default file or 'dark_'
     */
    public static function updateVarsFile(string $content, string $prefix): bool
    {
        try {
            file_put_contents(self::getVarsFile($prefix), $content);
        } catch(ErrorException $e) {
            Yii::error($e, 'flex-theme');
            return false;
        }
        return true;
    }

    /*
     * Reload the CSS and update the main theme CSS file
     * @param string $prefix, empty for default file or 'dark_'
     */
    public static function updateThemeFile(string $prefix): bool
    {
        // Base Theme
        $content = file_get_contents(self::getThemeBaseFile($prefix));
        // CSS Variables
        $content .= file_get_contents(self::getVarsFile($prefix));

        try {
            file_put_contents(self::getThemeFile($prefix), $content);
        } catch(ErrorException $e) {
            Yii::error($e, 'flex-theme');
            return false;
        }

        // Clear Asset Manager to reload theme.css
        try {
            Yii::$app->assetManager->clear();
        } catch(ErrorException $e) {
            Yii::warning($e, 'flex-theme');
            return false;
        }
        return true;
    }
    
    private static function getVarsFile(string $prefix): string
    {
        return Yii::getAlias(self::THEME_PATH . '/css/' . $prefix . 'variables.css');
    }

    private static function getThemeFile(string $prefix): string
    {
        if ($prefix === 'dark_') {
            $fileName = 'dark';
        } else {
            $fileName = 'theme';
        }
        return Yii::getAlias(self::THEME_PATH . '/css/' . $fileName . '.css');
    }

    private static function getThemeBaseFile(string $prefix): string
    {
        return Yii::getAlias(self::THEME_PATH . '/css/' . $prefix . 'theme_base.css');
    }
}
