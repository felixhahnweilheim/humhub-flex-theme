<?php

/** Taken from github to show the topic list on the left side of a space
 * works in combination with … views/space/widgets/TopicList.php*/

use humhub\modules\space\widgets\Header;
use humhub\modules\space\widgets\Menu;
use humhub\modules\space\widgets\SpaceContent;
use humhub\widgets\FooterMenu;

// Flex Theme
use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\widgets\TopicListSpace;
// Flex Theme end

/**
 * @var \humhub\modules\space\models\Space $space
 * @var string $content
 */

/** @var \humhub\modules\content\components\ContentContainerController $context */
$context = $this->context;
$space = $context->contentContainer;

?>
<div class="container space-layout-container">
    <div class="row">
        <div class="col-md-12">
            <?= Header::widget(['space' => $space]); ?>
        </div>
    </div>
    <div class="row space-content">
        <div class="col-md-2 layout-nav-container">
            <?= Menu::widget(['space' => $space]); ?>
<?php // Flex Theme ?>
            <?php if(Config::getSetting('showTopicMenu')): ?>
                <?= TopicListSpace::widget(['space' => $space]); ?>
            <?php endif; ?>
<?php // Flex Theme end ?>
        </div>
        <div class="col-md-<?= ($this->hasSidebar()) ? '7' : '10' ?> layout-content-container">
            <?= SpaceContent::widget(['contentContainer' => $space, 'content' => $content]) ?>
        </div>
        <?php if ($this->hasSidebar()): ?>
            <div class="col-md-3 layout-sidebar-container">
                <?= $this->getSidebar() ?>
                <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_SIDEBAR]); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!$this->hasSidebar()): ?>
        <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_FULL_PAGE]); ?>
    <?php endif; ?>
</div>
