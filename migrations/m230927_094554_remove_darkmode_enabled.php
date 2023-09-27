<?php

use yii\db\Migration;

class m230927_094554_remove_darkmode_enabled extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->getModule('flex-theme')->settings->delete('darkModeEnabled');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230927_094554_remove_darkmode_enabled cannot be reverted.\n";

        return false;
    }
}
