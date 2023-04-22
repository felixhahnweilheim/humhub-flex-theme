<?php

use flexTheme\AcceptanceTester;

class SettingsCest
{
    public function testSettings(AcceptanceTester $I)
    {
        $I->amAdmin();
        $I->amOnRoute(['/flex-theme/config']);
        $I->waitForText('Flex Theme');
        $I->selectOption('#config-commentlink', 'icon');
        $I->selectOption('#config-likelink', 'icon');

        $I->fillField('#select2-config-likeicon-container', 'heart-o');
        $I->waitForText('heart-o', 30);
        $I->pressKey('#select2-config-likeicon-container', \Facebook\WebDriver\WebDriverKeys::ENTER);

        $I->fillField('#select2-config-likeiconfull-container', 'heart-o');
        $I->waitForText('heart-o', 30);
        $I->pressKey('#select2-config-likeiconfull-container', \Facebook\WebDriver\WebDriverKeys::ENTER);

        $I->click('Save');

        $I->seeSuccess();
    }
}
