<?php

use flexTheme\AcceptanceTester;

class SettingsCest
{
    public function testSettings(AcceptanceTester $I)
    {
        $I->amAdmin();
        $I->enableModule(1, 'flex-theme');
        $I->amOnRoute(['/flex-theme/config']);
        $I->waitForText('Flex Theme');
        $I->selectOption('#config-commentlink', 'icon');
        $I->selectOption('#config-likelink', 'icon');
        $I->selectOption('#config-likeicon', 'star');
        $I->fillField('config-verifiedaccounts', '1');
        $I->click('Save');

        $I->seeSuccess();
    }
}
