<?php
//FlexTheme
use \humhub\modules\flexTheme\models\Config;
//FlexTheme end
use yii\helpers\Html;

humhub\modules\like\assets\LikeAsset::register($this);

//FlexTheme
// get Settings
$icon = Config::getSetting('likeIcon');
$style = Config::getSetting('likeLink');

// Like icon
if ($icon == 'thumbs_up') {
    $iconEmpty = '<i class="fa fa-thumbs-o-up"></i>';
    $iconFull = '<i class="fa fa-thumbs-up"></i>';
} elseif ($icon == 'heart') {
    $iconEmpty = '<i class="fa fa-heart-o"></i>';
    $iconFull = '<i class="fa fa-heart"></i>';
} elseif ($icon == 'star') {
    $iconEmpty = '<i class="fa fa-star-o"></i>';
    $iconFull = '<i class="fa fa-star"></i>';
}

// additional CSS class
if ($style == 'text') {
    $likeContainerClass = 'no-icon';
} else {
    $likeContainerClass = $icon . '-' . 'container';
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
