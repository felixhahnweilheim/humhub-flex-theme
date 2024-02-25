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
            'url' => ['/flex-theme/admin/index'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('flex-theme', 'admin', 'index'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'Colors'),
            'url' => ['/flex-theme/admin/colors'],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('flex-theme', 'admin', 'colors'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'Dark Mode'),
            'url' => ['/flex-theme/admin/dark-colors'],
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('flex-theme', 'admin', 'dark-colors'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        $this->addEntry(new MenuLink([
            'label' => Yii::t('FlexThemeModule.admin', 'Advanced'),
            'url' => ['/flex-theme/admin/advanced'],
            'sortOrder' => 400,
            'isActive' => MenuLink::isActiveState('flex-theme', 'admin', 'advanced'),
            'isVisible' => Yii::$app->user->can([
                ManageSettings::class
            ])
        ]));

        parent::init();
    }
}
