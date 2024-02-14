<?php

namespace humhub\modules\flexTheme\widgets;

use humhub\modules\topic\models\Topic;
use humhub\modules\content\helpers\ContentContainerHelper;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\menu\widgets\LeftNavigation;
use Yii;

class TopicListSpace extends LeftNavigation
{
    /**
     * @var Space
     */
    public $space;

    /**
     * @inheritdoc
     */
    public $id = 'space-topic-menu';

    /**
    * @inheritdoc
    */
    public function init()
    {
        if (!$this->space) {
            $this->space = ContentContainerHelper::getCurrent(Space::class);
        }

        $this->panelTitle = "<b>" . Yii::t('TopicModule.base', 'Topics') . "</b>";
        $topics = Topic::findByContainer($this->space)->all();

        foreach ($topics as $topic) {
            /* @var $topic Topic */
            $this->addEntry(new MenuLink([
                'label' => $topic->name,
                'url' => $topic->getUrl(),
                'icon' => 'fa-star',
                'sortOrder' => $topic->sort_order,
            ]));
        }

        parent::init();
    }
}
