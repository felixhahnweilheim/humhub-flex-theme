<?php
//FlexTheme
use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\Module;

$color_vars = Module::COLOR_VARS;;
$theme = Yii::$app->view->theme;
?>
<style>
:root {
<?php foreach ($color_vars as $color): ?>
<?php $value = Config::getSetting($color); ?>
--<?= $color . ':' . (!empty($value) ? $value : $theme->variable($color)) . ';'; ?>
<?php endforeach; ?>

<?php //TEST ?>
 --<?= 'info_darken_5' . ':' . Config::getSetting('info_darken_5') . ';'; ?>
    
    
    
/* TEXT COLOR
 * Default body text color.*/
--text-color-main: #555;

/* used for some icons and buttons etc.*/
--text-color-secondary: #7a7a7a;

/* highlighted text like some active links hovered links etc.*/
--text-color-highlight: #000;

/* side information like dates, placeholder, some dropdown headers*/
--text-color-soft: #555555;

/* also side information wall entry links (like/comment), help blocks in forms etc.*/
--text-color-soft2: #aeaeae;

/* used in gridview summary and installer*/
--text-color-soft3: #bac2c7;

/* used as contrast color for --primary, --info, --success, --warning, --danger backgrounds for buttons etc.
 * Note that --default does not use a contrast color --default is normally combined with --text-color-secondary*/
--text-color-contrast: #fff;


/* BACKGROUND COLOR
 * main content background color should be in contrast with --text-color-main, --text-color-secondary and other text colors*/
--background-color-main: #fff;

/* used beside others for tabs*/
--background-color-secondary: #f7f7f7;

/* page background which is also used for other ui components as comment box etc.*/
--background-color-page: #ededed;

/* text highlight*/
--background-color-highlight: #fff8e0;

/* Additional background colors*/
--background3: #d7d7d7;
--background4: #b2b2b2;

/* BOOTSTRAP Alert boxes
 * Alert box success (used in forms)*/
--background-color-success: #f7fbf4;
--text-color-success: #84be5e;
--border-color-success: #97d271;

/* Alert box warning (used in forms)*/
--background-color-warning: #fffbf7;
--text-color-warning: #e9b168;
--border-color-warning: #fdd198;

/* Alert box danger (used in forms)*/
--background-color-danger: #fff6f6;
--text-color-danger: #ff8989;
--border-color-danger: #ff8989;
}
</style>
