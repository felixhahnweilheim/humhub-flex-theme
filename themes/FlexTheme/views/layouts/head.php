<?php
//FlexTheme
use humhub\modules\flexTheme\models\ColorSettings;

$colors = ColorSettings::getColors();

?>
<style>
:root {
<?php foreach($colors as $key => $value) {
    echo '--' . $key . ':' . $value . ';';
}
?>

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
