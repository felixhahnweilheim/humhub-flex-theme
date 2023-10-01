<?php

namespace humhub\modules\flexTheme\controllers;

use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\flexTheme\models\DarkMode;
use humhub\modules\flexTheme\models\AdvancedSettings;
use Yii;

class ConfigController extends \humhub\modules\admin\components\Controller
{

    public function init()
    {
        parent::init();

        $this->subLayout = '@flex-theme/views/layouts/admin';
    }

    public function actionIndex()
    {
        $form = new Config();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }

        return $this->render('index', ['model' => $form]);
    }

    public function actionColors()
    {
        $form = new ColorSettings();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            Yii::$app->assetManager->clear();
            Yii::$app->view->theme->variables->flushCache();
            $this->view->saved();
            return $this->redirect(['/flex-theme/config/colors']);
        }

        return $this->render('colors', ['model' => $form]);
    }

    public function actionDarkMode()
    {
        return $this->render('dark-mode');
    }

    public function actionAdvanced()
    {
        $form = new AdvancedSettings();
        $config = new Config();
        $colorSettings = new ColorSettings();
        $darkModeSettings = new DarkMode();

        if(!empty(Yii::$app->request->post())) {
            $data = json_decode(Yii::$app->request->post()['AdvancedSettings']['settingsJson'], true);

            $config->load($data);
            $colorSettings->load($data);
            $darkModeSettings->load($data);

            // Check validation
            if (!$config->validate()) {
                $form->addError('settingsJson', Yii::t('FlexThemeModule.admin', 'There seem to be invalid values!') . ' (Config)');
                return $this->render('advanced', ['model' => $form]);
            }
            if (!$colorSettings->validate()) {
                $form->addError('settingsJson', Yii::t('FlexThemeModule.admin', 'There seem to be invalid values!') . ' (ColorSettings)');
			    return $this->render('advanced', ['model' => $form]);
            }
            // Save
            if ($config->save() && $colorSettings->save() && $darkModeSettings->save() && $form->load(Yii::$app->request->post()) && $form->save()) {
                Yii::$app->assetManager->clear();
                Yii::$app->view->theme->variables->flushCache();
                $this->view->saved();
                return $this->redirect(['/flex-theme/config/advanced']);
            }
        }

        return $this->render('advanced', ['model' => $form]);
    }
}
