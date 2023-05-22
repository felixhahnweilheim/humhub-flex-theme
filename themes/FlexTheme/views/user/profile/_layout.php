<?php
use humhub\modules\user\widgets\ProfileHeader;
use humhub\modules\user\widgets\ProfileMenu;
use humhub\widgets\FooterMenu;
$user = $this->context->contentContainer;

// Flex Theme
use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\widgets\TopicListUser;
// Flex Theme end
?>
<div class="container profile-layout-container">
    <div class="row">
        <div class="col-md-12">
            <?= ProfileHeader::widget(['user' => $user]); ?>
        </div>
    </div>
    <div class="row profile-content">
        <div class="col-md-2 layout-nav-container">
            <?= ProfileMenu::widget(['user' => $user]); ?>
<?php // Flex Theme ?>
            <?php if(Config::getSetting('showTopicMenu')): ?>
                <?= TopicListUser::widget(['user' => $user]); ?>
            <?php endif; ?>
<?php // Flex Theme end ?>
        </div>
        <div class="col-md-<?= ($this->hasSidebar()) ? '7' : '10' ?> layout-content-container">
            <?= $content; ?>
            <?php if (!$this->hasSidebar()): ?>
                <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_FULL_PAGE]); ?>
            <?php endif; ?>
        </div>
        <?php if ($this->hasSidebar()): ?>
            <div class="col-md-3 layout-sidebar-container">
                <?= $this->getSidebar() ?>
                <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_SIDEBAR]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
