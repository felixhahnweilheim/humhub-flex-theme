<?php

namespace humhub\modules\flexTheme\helpers;

use humhub\modules\flexTheme\models\Config;
use Yii;
use yii\base\ErrorException;

class FileHelper {

    const THEME_PATH = '@flex-theme/themes/FlexTheme';

    public static function getVarsFile()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/variables.css');
    }

    private static function getOptionsPath()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/options');
    }

    private static function getThemeFile()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/theme.css');
    }

    private static function getThemeBaseFile()
    {
        return Yii::getAlias(self::THEME_PATH . '/css/theme_base.css');
    }

    public static function updateThemeFile()
    {
        // Base Theme
        $theme_base = file_get_contents(self::getThemeBaseFile());

        // CSS Variables
        $vars = file_get_contents(self::getVarsFile());

        // Get optional CSS
        $options = '';
        $config = new Config();
        if ($config->showUploadAsButtons) {
            $options .= file_get_contents(self::getOptionsPath() . '/showUploadAsButtons.css');
        }

        // Create/Update theme.css
        $content = $theme_base . $options . $vars;
        
        try {
            file_put_contents(self::getThemeFile(), $content);
        } catch(ErrorException $e) {
            Yii::error($e);
        }

        // Clear Asset Manager to reload theme.css
        Yii::$app->assetManager->clear();
    }
}
