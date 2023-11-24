<?php
namespace humhub\modules\flexTheme;

use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\flexTheme\helpers\FileHelper;
use humhub\modules\ui\view\helpers\ThemeHelper;
use humhub\libs\DynamicConfig;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module {

    public $resourcesPath = 'resources';

    const FLEX_THEME_NAME = 'FlexTheme';

    // Translatable Module Description
    public function getDescription() {
        return Yii::t('FlexThemeModule.admin', 'Flexible Theme for HumHub');
    }

    // Link to configuration page
    public function getConfigUrl() {
        return Url::to(['/flex-theme/config']);
    }

    // Module Activation
    public function enable() {
        if (parent::enable()) {
            $this->enableTheme();
            return true;
        }
        return false;
    }

    private function enableTheme() {

        // see https://community.humhub.com/s/module-development/wiki/Theme+Modules
        $theme = ThemeHelper::getThemeByName(self::FLEX_THEME_NAME);
        if ($theme !== null) {
            $theme->activate();
            DynamicConfig::rewrite();
        }

        // Save special colors (lightened, darkened, faded colors)
        $model = new ColorSettings();
        $model->saveSpecialColors();
        
        // Create theme.css
        FileHelper::updateThemeFile();
    }

    // Module Deactivation
    public function disable() {
        $this->disableTheme();
        parent::disable();
    }

    // see https://community.humhub.com/s/module-development/wiki/Theme+Modules
    private function disableTheme() {
        foreach (ThemeHelper::getThemeTree(Yii::$app->view->theme) as $theme) {
            if ($theme->name === self::FLEX_THEME_NAME) {
                $theme = ThemeHelper::getThemeByName('HumHub');
                $theme->activate();
                break;
            }
        }
    }
}
