<?php

namespace humhub\modules\flexTheme;

class Events
{
    public static function onConsoleInit($event)
    {
        $event->sender->controllerMap['flex-theme'] = commands\DevController::class;
    }
}
