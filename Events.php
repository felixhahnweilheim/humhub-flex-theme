<?php

namespace humhub\modules\flexTheme;

use humhub\modules\ui\icon\widgets\Icon;
use Yii;
use yii\helpers\Url;

class Events
{
    public static function onConsoleInit($event)
    {
        $event->sender->controllerMap['flex-theme'] = commands\DevController::class;
    }
}
