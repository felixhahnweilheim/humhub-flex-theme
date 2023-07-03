<?php
//FlexTheme
use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\flexTheme\models\DarkMode;

/*
 * TO DO: Caching / Performance Improvements
 */

$colors = ColorSettings::getColors();
$darkColors = DarkMode::getColors();
$darkModeEnabled = DarkMode::isEnabled();
?>
<style>
:root {
<?php foreach($colors as $key => $value) {
    echo '--' . $key . ':' . $value . ';';
}
?>
}
<?php if ($darkModeEnabled) {
    echo '@media (prefers-color-scheme: dark) {:root {';
    foreach($darkColors as $key => $value) {
        echo '--' . $key . ':' . $value . ';';
    }
    echo '}}';
}
?>
</style>
