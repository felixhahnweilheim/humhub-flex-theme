<?php

namespace humhub\modules\flexTheme;

use Yii;
use yii\base\Model;
use humhub\modules\ui\view\helpers\ThemeHelper;
use yii\base\Theme;

class Events
{
    /*
     * Callback after Module enabled
     * @param ModuleEvent $event
     */
    public static function onModuleEnabled($event)
    {
        /*Activate Flex Theme*/
        $theme = ThemeHelper::getThemeByName('FlexTheme');
        if ($theme !== null) {
            $theme->activate();
        }
    }
}
