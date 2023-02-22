<?php

use yii\base\Event;
use humhub\components\ModuleManager;
use humhub\modules\flexTheme\Events;

return [
    'id' => 'flex-theme',
    'class' => 'humhub\modules\flexTheme\Module',
    'namespace' => 'humhub\modules\flexTheme',
    'events' => [
		[
			'class' => ModuleManager::class,
			'event' => ModuleManager::EVENT_AFTER_MODULE_ENABLE,
			'callback' => [Events::class, 'onModuleEnabled']
		]
	]
];
