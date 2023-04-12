<?php
//FlexTheme
use \humhub\modules\flexTheme\models\Config;
use humhub\modules\ui\icon\widgets\Icon;
//FlexTheme end
use yii\helpers\Html;

humhub\modules\like\assets\LikeAsset::register($this);

//FlexTheme
// get Settings
$color = Config::getSetting('likeIconColor');
$iconEmpty = Icon::get(Config::getSetting('likeIcon'), ['color' => $color]);
$iconFull = Icon::get(Config::getSetting('likeIconFull'), ['color' => $color]);
$style = Config::getSetting('likeLink');

// additional CSS class
if ($style == 'text') {
    $likeContainerClass = 'no-icon';
} else {
    $likeContainerClass = Html::encode($iconEmpty) . '-' . 'container';
}

// Like and Unlike Link
if ($style == 'icon') {
    $likeText = $iconEmpty;
    $unlikeText = $iconFull;
} elseif ($style == 'both') {
	$likeText = $iconEmpty . HTML::tag('span', Yii::t('LikeModule.base', 'Like'), ['class' => 'like-label-both']);
	$unlikeText = $iconFull . HTML::tag('span', Yii::t('LikeModule.base', 'Unlike'), ['class' => 'unlike-label-both']);
} else {
    $likeText = Yii::t('LikeModule.base', 'Like');
    $unlikeText = Yii::t('LikeModule.base', 'Unlike');
}

?>

<span class="likeLinkContainer <?= $likeContainerClass ?>" id="likeLinkContainer_<?= $id ?>">
<?php //FlexTheme end ?>
    <?php if (Yii::$app->user->isGuest): ?>
<?php //FlexTheme ?>
        <?= Html::a($likeText, Yii::$app->user->loginUrl, ['data-target' => '#globalModal']); ?>
<?php //FlexTheme end ?>
    <?php else: ?>
<?php //FlexTheme ?>
        <a href="#" data-action-click="like.toggleLike" data-action-url="<?= $likeUrl ?>" class="like likeAnchor<?= !$canLike ? ' disabled' : '' ?>" style="<?= (!$currentUserLiked) ? '' : 'display:none'?>" title="<?= Yii::t('LikeModule.base', 'Like') ?>">
		    <?= $likeText ?>
        </a>
        <a href="#" data-action-click="like.toggleLike" data-action-url="<?= $unlikeUrl ?>" class="unlike likeAnchor<?= !$canLike ? ' disabled' : '' ?>" style="<?= ($currentUserLiked) ? '' : 'display:none'?>" title="<?= Yii::t('LikeModule.base', 'Unlike') ?>">
		    <?= $unlikeText ?>
<?php //FlexTheme end ?>
        </a>
    <?php endif; ?>

        <!-- Create link to show all users, who liked this -->
    <a href="<?= $userListUrl; ?>" data-target="#globalModal">
        <?php if (count($likes)) : ?>
            <span class="likeCount tt" data-placement="top" data-toggle="tooltip" title="<?= $title ?>">(<?= count($likes) ?>)</span>
        <?php else: ?>
            <span class="likeCount"></span>
        <?php endif; ?>
    </a>

</span>
