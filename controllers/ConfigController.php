<?php

namespace humhub\modules\flexTheme\controllers;

use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\models\ColorSettings;
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
            $this->view->saved();
        }

        return $this->render('colors', ['model' => $form]);
    }

    public function actionAdvanced()
    {
        $form = new AdvancedSettings();
        $config = new Config();
        $colorSettings = new ColorSettings();

        if(!empty(Yii::$app->request->post())) {
            $data = json_decode(Yii::$app->request->post()['AdvancedSettings']['settingsJson'], true);

            if ( $config->load($data) && $colorSettings->load($data)) {
                // Check validation
                if ($config->validate() && $colorSettings->validate()) {
                    $config->save();
                    $colorSettings->save();
                    $this->view->saved();
                } else {
                    // @todo Throw error
                    return $this->render('advanced', ['model' => $form]);
                }
            }
        }

        return $this->render('advanced', ['model' => $form]);
    }
}
