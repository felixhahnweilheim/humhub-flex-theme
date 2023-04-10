<?php

namespace humhub\modules\flexTheme\models;

use Yii;
use humhub\modules\flexTheme\Module;
use humhub\modules\flexTheme\helpers\ColorHelper;
use humhub\modules\ui\view\helpers\ThemeHelper;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;

/**
 * ConfigureForm defines the configurable fields.
 */
class Config extends \yii\base\Model {

    // Module settings, see Module.php
    public $commentLink;
    public $likeLink;
    public $likeIcon;

    // Configurable Colors
    public $default;
    public $primary;
    public $info;
    public $link;
    public $success;
    public $warning;
    public $danger;

    // not yet configurable
    public $background_color_secondary;
    public $background_color_page;
    public $text_color_secondary;

    // Special colors
    public $default__darken__2;
    public $default__darken__5;
    public $default__lighten__2;
    public $primary__darken__5;
    public $primary__darken__10;
    public $primary__lighten__5;
    public $primary__lighten__8;
    public $primary__lighten__10;
    public $primary__lighten__20;
    public $primary__lighten__25;
    public $info__darken__5;
    public $info__darken__10;
    public $info__lighten__5;
    public $info__lighten__8;
    public $info__lighten__25;
    public $info__lighten__45;
    public $info__lighten__50;
    public $danger__darken__5;
    public $danger__darken__10;
    public $danger__lighten__5;
    public $danger__lighten__20;
    public $success__darken__5;
    public $success__darken__10;
    public $success__lighten__5;
    public $success__lighten__20;
    public $warning__darken__2;
    public $warning__darken__5;
    public $warning__darken__10;
    public $warning__lighten__5;
    public $warning__lighten__20;
    public $link__darken__2;
    public $link__lighten__5;
    public $background_color_secondary__darken__5;
    public $background_color_page__lighten__3;
    public $background_color_page__darken__5;
    public $background_color_page__darken__8;
    public $text_color_secondary__lighten__25;
    public $link__fade__60;

    public static function getSetting(string $setting_name) {

        $module = Yii::$app->getModule('flex-theme');
        $value = $module->settings->get($setting_name);

        if (empty($value)) {
            $value = $module->$setting_name;
        }

        // Note: $value can still be empty if there is no default in Module.php (or file configuration)
        return $value;
    }

    public function init() {

        parent::init();
        $this->commentLink = $this->getSetting('commentLink');
        $this->likeLink = $this->getSetting('likeLink');
        $this->likeIcon = $this->getSetting('likeIcon');
        $this->default = $this->getSetting('default');
        $this->primary = $this->getSetting('primary');
        $this->info = $this->getSetting('info');
        $this->link = $this->getSetting('link');
        $this->success = $this->getSetting('success');
        $this->warning = $this->getSetting('warning');
        $this->danger = $this->getSetting('danger');

    }

    public function attributeLabels() {

        // Note: the attribute name in uppercase is used as fallback
        return [
            'commentLink' => Yii::t('FlexThemeModule.admin', 'Style of Comment Button'),
            'likeLink' => Yii::t('FlexThemeModule.admin', 'Style of Like Button'),
            'likeIcon' => Yii::t('FlexThemeModule.admin', 'Like Icon')
        ];
    }

    public function attributeHints() {

        $main_colors = Module::MAIN_COLORS;

        $hints = array();

        foreach ($main_colors as $color) {
            $value = ThemeHelper::getThemeByName('HumHub')->variable($color);
            $icon = Icon::get('circle', ['color' => $value ]);
            $hints[$color] = Yii::t('FlexThemeModule.admin', 'Default') . ': ' . '<code>' . $value . '</code> ' . $icon;
        }

        return $hints;
    }

    public function rules() {

        return [
            [['commentLink', 'likeLink', 'likeIcon'], 'string'],
            [['commentLink', 'likeLink'], 'in', 'range' => ['icon', 'text', 'both']],
            ['likeIcon', 'in', 'range' => ['heart', 'star', 'thumbs_up']],
            [['default', 'primary', 'info', 'link', 'success', 'warning', 'danger'], 'validateHexColor']
        ];
    }

    public function validateHexColor($attribute, $params, $validator) {

        if (!preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $this->$attribute)) {
            $this->addError($attribute, Yii::t('FlexThemeModule.admin', 'Invalid Format') . '. ' . Yii::t('FlexThemeModule.admin', 'Must be a color in hexadecimal format, like "#00aaff" or "#FA0"'));
        }
    }

    public function save() {

        if(!$this->validate()) {
            return false;
        }

        $module = Yii::$app->getModule('flex-theme');

        // Save configuration for Social Controls and Verified Accounts
        $module->settings->set('commentLink', $this->commentLink);
        $module->settings->set('likeLink', $this->likeLink);
        $module->settings->set('likeIcon', $this->likeIcon);

        // Save color values
        self::saveMainColors();

        // Calculate and save lightened, darkened and faded colors
        self::saveSpecialColors();

        return true;
    }

    public function saveMainColors() {

        $module = Yii::$app->getModule('flex-theme');

        $main_colors = Module::MAIN_COLORS;

        foreach ($main_colors as $key) {

            $value = $this->$key;

            // Save as module settings (value can be emtpy)
            $module->settings->set($key, $value);

            // Save color values as theme variables (take community theme's color if value is empty)
            if (empty($value)) {
                $theme_var = str_replace('_', '-', $key);
                $value = ThemeHelper::getThemeByName('HumHub')->variable($theme_var);
            }
            $theme_key = 'theme.var.FlexTheme.' . $key;
            Yii::$app->settings->set($theme_key, $value);
        }
    }

    public function saveSpecialColors() {

        $module = Yii::$app->getModule('flex-theme');

        $special_colors = Module::SPECIAL_COLORS;

        foreach ($special_colors as $key) {

            // split color names into base color, manipulation function and amount of manipulation
            list($base_var, $function, $amount) = explode("__", $key);

            // Get value of base color
            $original_color = $this->$base_var;
            if (empty($original_color)) {
                $theme_var = str_replace('_', '-', $base_var);
                $original_color = ThemeHelper::getThemeByName('HumHub')->variable($theme_var);
            }

            // Calculate color value with ColorHelper functions
            if ($function == 'darken') {

                $value = ColorHelper::darken($original_color, $amount);

            } elseif ($function == 'lighten') {

                $value = ColorHelper::lighten($original_color, $amount);

            } elseif ($function == 'fade') {

                $value = ColorHelper::fade($original_color, $amount);

            } elseif ($function == 'fadeout') {

                $value = ColorHelper::fadeout($original_color, $amount);

            } else {
                $value = '';
            }

            // Save calculated value
            $module->settings->set($key, $value);
        }
    }
}
