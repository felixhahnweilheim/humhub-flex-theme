<?php

namespace humhub\modules\flexTheme;

use humhub\modules\flexTheme\models\Config;
use humhub\libs\WidgetCreateEvent;
use Yii;

class Events
{
    public static function onConsoleInit($event)
    {
        $event->sender->controllerMap['flex-theme'] = commands\DevController::class;
    }

    public static function onFileHandlerButtonDropdownBeforeRun(WidgetCreateEvent $event)
    {
        if (Yii::$app->view->theme->name !== 'FlexTheme') {
            return;
        }
        $config = new Config();
        if ($config->showUploadAsButtons) {
            $event->config['class'] = widgets\FileHandlerButtons::class;
        }
    }
}
