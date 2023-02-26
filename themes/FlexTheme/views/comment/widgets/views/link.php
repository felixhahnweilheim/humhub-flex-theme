<?php

//FlexTheme
use \humhub\modules\flexTheme\Module;
//FlexTheme end
use humhub\modules\comment\widgets\CommentLink;
use humhub\widgets\Button;
use yii\helpers\Html;
use yii\helpers\Url;
use \humhub\modules\comment\models\Comment;

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $objectModel string */
/* @var $objectId integer */
/* @var $id string unique object id */
/* @var $commentCount integer */
/* @var $mode string */
/* @var $isNestedComment boolean */
/* @var $comment \humhub\modules\comment\models\Comment */
/* @var $module \humhub\modules\comment\Module */

//FlexTheme
$style = Module::getSetting('commentLink');
if ($style == 'text') {
	$additionalClass = 'no-icon';
} else {
	$additionalClass = '';
}
//FlexTheme end

$hasComments = ($commentCount > 0);
$commentCountSpan = Html::tag('span', ' (' . $commentCount . ')', [
    'class' => 'comment-count ' . $additionalClass,
    'data-count' => $commentCount,
    'style' => ($hasComments) ? null : 'display:none'
]);

//FlexTheme
/* Html tags */
$commentIcon = HTML::tag('i', '', ['class' => 'fa fa-comment-o', 'title' => Yii::t('CommentModule.base', "Comment")]);
$replyIcon = HTML::tag('i', '', ['class' => 'fa fa-comment-o', 'title' => Yii::t('CommentModule.base', "Reply")]);
$commentLabel = HTML::tag('span', Yii::t('CommentModule.base', "Comment"), ['class' => 'comment-label']);
$replyLabel = HTML::tag('span', Yii::t('CommentModule.base', "Reply"), ['class' => 'reply-label']);
$commentLabelBoth  = HTML::tag('span', Yii::t('CommentModule.base', "Comment"), ['class' => 'comment-label-both']);
$replyLabelBoth = HTML::tag('span', Yii::t('CommentModule.base', "Reply"), ['class' => 'reply-label-both']);

/* Comment Label */
if($isNestedComment) {
    if ($style == 'icon') {
        $label = $replyIcon;
    } elseif ($style == 'both') {
        $label = $replyIcon . $replyLabelBoth;
    } else {
        $label = $replyLabel;
    }
} else {
    if ($style == 'icon') {
        $label = $commentIcon;
    } elseif ($style == 'both') {
        $label = $commentIcon . $commentLabelBoth;
    } else {
        $label = $commentLabel;
    }
}
//FlexTheme end

if ($mode == CommentLink::MODE_POPUP): ?>
    <?php $url = Url::to(['/comment/comment/show', 'objectModel' => $objectModel, 'objectId' => $objectId, 'mode' => 'popup']); ?>
    <a href="#" data-action-click="ui.modal.load" data-action-url="<?= $url ?>">
	<?= $label . ' (' . $commentCount . ')' ?>
    </a>
<?php elseif (Yii::$app->user->isGuest): ?>
    <?= Html::a(
        $label . $commentCountSpan,
        Yii::$app->user->loginUrl,
        ['data-target' => '#globalModal']) ?>
<?php else : ?>
    <?= Button::asLink($label . $commentCountSpan)
        ->action('comment.toggleComment', null, '#comment_' . $id) ?>
<?php endif; ?>
