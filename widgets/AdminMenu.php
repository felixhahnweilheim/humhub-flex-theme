<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\flexTheme\widgets;

use Yii;
use humhub\modules\admin\permissions\ManageSettings;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\menu\widgets\TabMenu;

/**
 * User Administration Menu
 *
 * @author Basti
 */
class AdminMenu extends TabMenu
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'General Settings'),
            'url' => ['/flex-theme/config/index'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('flex-theme', 'config', 'index'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'Colors'),
            'url' => ['/flex-theme/config/colors'],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('flex-theme', 'config', 'colors'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'Dark Mode'),
            'url' => ['/flex-theme/config/dark-colors'],
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('flex-theme', 'config', 'dark-colors'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'Advanced'),
            'url' => ['/flex-theme/config/advanced'],
            'sortOrder' => 400,
            'isActive' => MenuLink::isActiveState('flex-theme', 'config', 'advanced'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        parent::init();
    }
}
