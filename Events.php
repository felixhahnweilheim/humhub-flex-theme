<?php

namespace humhub\modules\flexTheme;

use Yii;
use yii\base\Model;
use humhub\modules\ui\view\helpers\ThemeHelper;
use yii\base\Theme;
use yii\helpers\Url;

class Events
{
	public static function onAdminMenuInit($event)
    {
		$event->sender->addItem([
            'label' =>  Yii::t('FlexThemeModule.base', 'Flex Theme'),
            'url' => Url::to(['/flex-theme/config']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-eye"></i>',
            'isActive' => (Yii::$app->controller->module
                    && Yii::$app->controller->module->id === 'flex-theme'
                    && (Yii::$app->controller->id === 'page' || Yii::$app->controller->id === 'config')),
            'sortOrder' => 900,
            'isVisible' => true,
        ]);
	}
}
