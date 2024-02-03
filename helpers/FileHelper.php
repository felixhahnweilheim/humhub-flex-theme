<?php

namespace humhub\modules\flexTheme\helpers;

use Yii;
use yii\base\ErrorException;

class FileHelper {

    const THEME_PATH = '@flex-theme/themes/FlexTheme';

    private static function getVarsFile(string $prefix)
    {
        return Yii::getAlias(self::THEME_PATH . '/css/' . $prefix . 'variables.css');
    }

    private static function getThemeFile(string $prefix)
    {
        if ($prefix === 'dark_') {
            $fileName = 'dark';
        } else {
            $fileName = 'theme';
        }
        return Yii::getAlias(self::THEME_PATH . '/css/' . $fileName . '.css');
    }

    private static function getThemeBaseFile(string $prefix)
    {
        return Yii::getAlias(self::THEME_PATH . '/css/' . $prefix . 'theme_base.css');
    }
    
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

    public static function updateThemeFile( string $prefix ): bool
    {
        // Base Theme
        $theme_base = file_get_contents(self::getThemeBaseFile($prefix));

        // CSS Variables
        $vars = file_get_contents(self::getVarsFile($prefix));

        // Create/Update theme.css
        $content = $theme_base . $vars;
        
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
}
