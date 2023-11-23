<?php

use humhub\modules\flexTheme\Events;
use humhub\components\console\Application;

return [
    'id' => 'flex-theme',
    'class' => 'humhub\modules\flexTheme\Module',
    'namespace' => 'humhub\modules\flexTheme',
    'events' => [
	    	[
			'class' => Application::class,
			'event' => Application::EVENT_ON_INIT,
			'callback' => [Events::class, 'onConsoleInit']
		],
	]
];
