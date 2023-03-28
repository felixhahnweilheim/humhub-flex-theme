<?php

use flexTheme\AcceptanceTester;

class SettingsCest
{
    public function testSettings(AcceptanceTester $I)
    {
        $I->am('admin');
        $I->amOnRoute(['/flex-theme/config']);
        $I->waitForText('Flex Theme Configuration');
        $I->selectOption('#config-commentlink', 'icon');
        $I->selectOption('#config-likelink', 'icon');
        $I->selectOption('#config-likeicon', 'heart');
        $I->fillField('config-verifiedaccounts', '1');
        $I->click('Save');

        $I->seeSuccess();
    }
}
