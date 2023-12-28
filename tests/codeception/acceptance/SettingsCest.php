<?php

use flexTheme\AcceptanceTester;

class SettingsCest
{
    $bg_color_pg = '#cfe2f3';
    
    public function testSettings(AcceptanceTester $I)
    {
        $I->amAdmin();
        $I->amOnRoute(['/flex-theme/config']);
        $I->waitForText('Flex Theme');
        $I->selectOption('#config-commentlink', 'icon');
        $I->selectOption('#config-likelink', 'icon');

        $I->click('Save');

        $I->seeSuccess();
    }
    
    public function testSettingsColor(AcceptanceTester $I)
    {
        $I->amAdmin();
        $I->amOnRoute(['/flex-theme/config/colors']);
        $I->waitForText('Flex Theme');
        $I->fillField('Background Color Page', $this->bg-color-pg);

        $I->click('Save');

        $I->seeSuccess();
    }
    
    public function testEffectOfPreviousSettings(AcceptanceTester $I)
    {
        $I->amOnRoute(['/dashboard']);
        $I->waitForElementVisible('#wallStream');

        $color = $I->executeJS("getComputedStyle(document.documentElement).getPropertyValue('--background_color_page');");
        
        if ($color !== $this->bg_color_pg) {
            return false;
        }
    }
}
