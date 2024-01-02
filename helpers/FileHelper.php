<?php

namespace humhub\modules\flexTheme\helpers;

use Yii;
use yii\base\ErrorException;

class FileHelper {

    const THEME_PATH = '@flex-theme/themes/FlexTheme';

    private static function getVarsFile()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/variables.css');
    }

    private static function getThemeFile()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/theme.css');
    }

    private static function getThemeBaseFile()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/theme_base.css');
    }
    
    public static function updateVarsFile(string $content): bool
    {
        try {
            file_put_contents(self::getVarsFile(), $content);
        } catch(ErrorException $e) {
            Yii::error($e, 'flex-theme');
            return false;
        }
        return true;
    }

    public static function updateThemeFile(): bool
    {
        // Base Theme
        $theme_base = file_get_contents(self::getThemeBaseFile());

        // CSS Variables
        $vars = file_get_contents(self::getVarsFile());

        // Create/Update theme.css
        $content = $theme_base . $vars;
        
        try {
            file_put_contents(self::getThemeFile(), $content);
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
