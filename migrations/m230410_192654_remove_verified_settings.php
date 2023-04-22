<?php

use yii\db\Migration;

class m230410_192654_remove_verified_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->getModule('flex-theme')->settings->delete('verifiedAccounts');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230410_192654_remove_verified_settings cannot be reverted.\n";

        return false;
    }
}
