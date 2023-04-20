<?php

namespace humhub\modules\flexTheme\controllers;

use humhub\modules\flexTheme\models\Config;
use humhub\modules\flexTheme\models\ColorSettings;
use Yii;

class ConfigController extends \humhub\modules\admin\components\Controller
{

    public function init()
    {
        parent::init();

        $this->appendPageTitle(Yii::t('FlexThemeModule.base', '<strong>Flex Theme</strong> Configuration'));
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
}
