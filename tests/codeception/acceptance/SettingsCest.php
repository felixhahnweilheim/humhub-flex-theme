<?php

use flexTheme\AcceptanceTester;

class SettingsCest
{
    public const BG_COLOR_PG = '#cfe2f3';
    public const BG_COLOR_PG_D_5 = '#c3d5e5';
    public const JSON_SAMPLE_1 = '{
        "Config": {
            "commentLink": "icon",
            "likeLink": "icon",
            "likeIcon": "heart-o",
            "likeIconFull": "heart",
            "likeIconColor": "#cc0000",
            "showTopicMenu": 1,
            "showUploadAsButtons": 1
        },
        "ColorSettings": {
            "default": "#cccccc",
            "primary": "#ff9900",
            "info": "#783f04",
            "link": "#45818e",
            "text_color_main": "#3d2323",
            "text_color_secondary": "#554646",
            "text_color_highlight": "#000000",
            "background_color_main": "#fdb8b8",
            "background_color_secondary": "#e7d1d1"
        },
        "DarkColorSettings": []
    }';

    // do not change indentation
    public const JSON_RESULT_1 = '{
    "Config": {
        "commentLink": "icon",
        "likeLink": "icon",
        "likeIcon": "heart-o",
        "likeIconFull": "heart",
        "likeIconColor": "#cc0000",
        "showTopicMenu": 1,
        "showUploadAsButtons": 1
    },
    "ColorSettings": {
        "default": "#cccccc",
        "primary": "#ff9900",
        "info": "#783f04",
        "link": "#45818e",
        "text_color_main": "#3d2323",
        "text_color_secondary": "#554646",
        "text_color_highlight": "#000000",
        "background_color_main": "#fdb8b8",
        "background_color_secondary": "#e7d1d1",
        "background_color_page": "#cfe2f3"
    },
    "DarkColorSettings": []
}';

    // do not change indentation (we also use it to test the result)
    public const JSON_SAMPLE_2 = '{
    "Config": [],
    "ColorSettings": {
        "background4": "#0c343d"
    },
    "DarkColorSettings": []
}';

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

    public function testJsonImport(AcceptanceTester $I)
    {
        // Test merging (background-color-page was already set in testSettingsColor())
        $I->amAdmin();
        $I->amOnRoute(['/flex-theme/admin/advanced']);
        $I->waitForText('Flex Theme');
        $I->fillField('AdvancedSettings[settingsJson]', self::JSON_SAMPLE_1);
        $I->click('Save');
        $I->seeSuccess();

        // Test effect
        $I->seeInField('AdvancedSettings[settingsJson]', self::JSON_RESULT_1);

        // Now test with overwrite
        $I->fillField('AdvancedSettings[settingsJson]', self::JSON_SAMPLE_2);
        $I->checkOption('AdvancedSettings[overwriteAll]');
        $I->click('Save');
        $I->seeSuccess();

        // Test effect
        $I->seeInField('AdvancedSettings[settingsJson]', self::JSON_SAMPLE_2);
    }
}
