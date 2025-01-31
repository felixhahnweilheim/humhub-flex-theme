<?php

namespace humhub\modules\flexTheme\controllers;

use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\models\ColorSettings;
use humhub\modules\flexTheme\models\DarkColorSettings;
use humhub\modules\flexTheme\models\AdvancedSettings;
use Yii;

class ConfigController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@flex-theme/views/layouts/admin';

    public function actionIndex()
    {
        $form = new Config();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
            // Redirect instead of render to make browser reload CSS
            return $this->redirect(['/flex-theme/config']);
        }

        return $this->render('index', ['model' => $form]);
    }

    public function actionColors()
    {
        $form = new ColorSettings();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            if ($form->hasWarnings) {
                $this->view->warn(Yii::t('FlexThemeModule.admin', 'Settings were saved with warnings/errors. Please check the logging. (Administration > Information > Logging)'));
            } else {
                $this->view->saved();
            }
            // Redirect instead of render to make browser reload CSS
            return $this->redirect(['/flex-theme/config/colors']);
        }

        return $this->render('colors', ['model' => $form]);
    }

    public function actionDarkColors()
    {
        $form = new DarkColorSettings();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            if ($form->hasWarnings) {
                $this->view->warn(Yii::t('FlexThemeModule.admin', 'Settings were saved with warnings/errors. Please check the logging. (Administration > Information > Logging)'));
            } else {
                $this->view->saved();
            }
            // Redirect instead of render to make browser reload CSS
            return $this->redirect(['/flex-theme/config/dark-colors']);
        }

        return $this->render('dark-colors', ['model' => $form]);
    }

    public function actionAdvanced()
    {
        $form = new AdvancedSettings();

        if (!empty(Yii::$app->request->post())) {

            $form->load(Yii::$app->request->post());

            // Load settings if we should merge or do not load them if we should overwrite all
            $loadSettings = ! $form->overwriteAll;

            $config = new Config($loadSettings);
            $colorSettings = new ColorSettings($loadSettings);
            $darkColorSettings = new DarkColorSettings($loadSettings);

            // Decode the imported json
            $data = json_decode($form->settingsJson, true);

            //$overWriteAll = (bool) Yii::$app->request->post()['AdvancedSettings']['overwriteAll'];
            //$data = json_decode(Yii::$app->request->post()['AdvancedSettings']['settingsJson'], true);

            // Load the imported data into the models
            $config->load($data);
            $colorSettings->load($data);
            $darkColorSettings->load($data);

            // Check validation before saving anything
            if (!$config->validate()) {
                $form->addError('settingsJson', Yii::t('FlexThemeModule.admin', 'There seem to be invalid values!') . ' (Config)');
                return $this->render('advanced', ['model' => $form]);
            }
            if (!$colorSettings->validate()) {
                $form->addError('settingsJson', Yii::t('FlexThemeModule.admin', 'There seem to be invalid values!') . ' (ColorSettings)');
                return $this->render('advanced', ['model' => $form]);
            }
            if (!$darkColorSettings->validate()) {
                $form->addError('settingsJson', Yii::t('FlexThemeModule.admin', 'There seem to be invalid values!') . ' (DarkModeSettings)');
                return $this->render('advanced', ['model' => $form]);
            }
            // Save
            if ($config->save() && $colorSettings->save() && $darkColorSettings->save()) {
                $this->view->saved();
                // Redirect instead of render to make browser reload CSS
                return $this->redirect(['/flex-theme/config/advanced']);
            }
        }

        return $this->render('advanced', ['model' => $form]);
    }
}
