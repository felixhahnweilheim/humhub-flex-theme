<?php

use flexTheme\AcceptanceTester;

class SettingsCest
{
    public const BG_COLOR_PG = '#cfe2f3';
    public const BG_COLOR_PG_D_5 = '#c3d5e5';

    public function testSettings(AcceptanceTester $I)
    {
        $I->amAdmin();
        $I->amOnRoute(['/flex-theme/admin']);
        $I->waitForText('Flex Theme');
        $I->selectOption('#config-commentlink', 'icon');
        $I->selectOption('#config-likelink', 'icon');

        $I->click('Save');
        $I->seeSuccess();
    }

    public function testSettingsColor(AcceptanceTester $I)
    {
        $I->amAdmin();
        $I->amOnRoute(['/flex-theme/admin/colors']);
        $I->waitForText('Flex Theme');
        $I->jsClick('.form-collapsible-fields:nth-of-type(3) > div');
        $I->see('Background Color Page');
        $I->fillField('ColorSettings[background_color_page]', self::BG_COLOR_PG);

        $I->click('Save');
        $I->seeSuccess();

        // Test effect
        $color = $I->executeJS("return getComputedStyle(document.documentElement).getPropertyValue('--background-color-page');");
        $colorDarkened = $I->executeJS("return getComputedStyle(document.documentElement).getPropertyValue('--background-color-page--darken--5');");

        if ($color !== self::BG_COLOR_PG) {
            throw new Exception("Unexpected color: $color");
        }

        if ($colorDarkened !== self::BG_COLOR_PG_D_5) {
            throw new Exception("Unexpected color (darkened): $colorDarkened");
        }
    }
}
