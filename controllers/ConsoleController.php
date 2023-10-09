<?php

namespace humhub\modules\flexTheme\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\FileHelper;

class ConsoleController extends Controller
{
    const SRC = '@webroot/static/less';
    const DEST = '@flex-theme/themes/FlexTheme/less/humhub';
    const FLEXLESS = '@flex-theme/themes/FlexTheme/less';

    const SUPPORTED = ['darken', 'lighten', 'fade', 'fadein', 'fadeout'];
    const UNSOPPORTED = ['saturate', 'desaturate', 'spin', 'red', 'green', 'blue'];

    public function actionRebuild()
    {
        // Array of special colors, e.g. 'primary-darken-10'
        $special_colors = [];
        // Array of unsopported lines, e.g. [
        $unsopported = [];
        // Integer changed files
        $changedFiles = 0;

        self::message('Starting to rebuild LESS files of FlexTheme.', 'warning');

        // Copy LESS files
        $src = Yii::getAlias(self::SRC);
        $dst = Yii::getAlias(self::DEST);
        FileHelper::copyDirectory($src, $dst);
        self::message("Copied $src to $dst", 'success');

        // Go through copied files
        $files = FileHelper::findFiles($dst);
        foreach ($files as $file)
        {
            if (basename($file) !== 'variables.less') {
                $result = self::checkAndCorrectFile($file);//returns array [array special colors, array unsopported lines, bool changed]

                foreach ($result[0] as $special_color)
                {
                    $special_colors[$special_color] = $special_color;
                }
                foreach ($result[1] as $unsopported_line)
                {
                    $unsopported[] = "$file at line $unsopported_line";
                }
                if ($result[2]) {
                    $changedFiles++;
                }
            }
        }

        sort($special_colors);

        self::createSpecialColorsLess($special_colors);

        self::message("\nSuccessfully rebuilt theme files", 'success');
        self::message("Changed Files: $changedFiles", 'success');
        self::message('*** Special colors to be copied:', 'warning');
        self::message('    const SPECIAL_COLORS = [', 'no-break');
        foreach ($special_colors as $color)
        {
            self::message("'" . $color . "',", 'no-break');
        }
        self::message("];\n");
        foreach ($special_colors as $color)
        {
            self::message('    public $' . $color . ';');
        }

        self::message("***\n Unsopported Lines: ", 'warning');
        foreach($unsopported as $fileAndLine) {
            self::message($fileAndLine);
        }

        return self::EXIT_CODE_NORMAL;
    }

    private function checkAndCorrectFile($file)
    {
        //self::message("Going through: $file");

        // Array of special colors, e.g. 'primary-darken-10'
        $special_colors = [];
        // Array Unsopported lines
        $unsopportedLines = [];
        // Integer changed files
        $changed = false;

        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach($lines as $key => $line)
        {
            $result = self::checkAndCorrectLine($key, $line, $file); // returns array [line, bool or string]
            $lines[$key] = $result[0];

            if ($result[1] == false) {
                $unsopportedLines[$key] = $key;
            } elseif ($result[1] !== true) {
                $special_colors[] = $result[1];
                $changed = true;
            }
        }
        $data = implode(PHP_EOL, $lines);
        file_put_contents($file, $data);

        return [$special_colors, $unsopportedLines, $changed];
    }

    /*
     * returns array
     * * First value: line (changed or not)
     * * Second value:
     * * * false: unsopported function recognized (line not changed)
     * * * true: no function recognized (line not changed)
     * * * string: special color, e.g. 'primary-darken-10'
     */
    private function checkAndCorrectLine($lineNumber, $line, $file)
    {
        foreach (self::UNSOPPORTED as $less_function)
        {
            // Do not change lines with unsopported function but display a warning
            if (strpos($line, $less_function . '(') !== false) {
                self::message("Manual correction required!\nUnsopported function in line ++$lineNumber in $file", 'warning');
                return [$line, false];
            }
        }
        foreach (self::SUPPORTED as $less_function)
        {
            // Replace lines with supported function
            if($pos = strpos($line, $less_function . '(') !== false) {

                $parts = explode($less_function . '(@', $line);

                // Line beginning until LESS function
                $first = $parts[0];

                $rest = explode(',', $parts[1]);

                // Color variable (the @ symbol has been removed above)
                $color = $rest[0];

                $rest = explode(')', $rest[1]);

                // amount
                $amount = trim($rest[0], ' %');

                // Line ending (e.g. "!important;")
                $end = $rest[1];

                $special_color = str_replace('-', '_', $color) . '__' . $less_function . '__' . $amount;

                $line = $first . $special_color . $end;

                return [$line, $special_color];
            }
        }
        return [$line, true];
    }

    private function createSpecialColorsLess($special_colors)
    {
        $content = '';

        foreach ($special_colors as $color)
        {
            $colorAsLessVar = '@' . str_replace(['__', '_'], '-', $color);
            $content .= $colorAsLessVar . ': var(--' . $color . ');';
        }

        $file = Yii::getAlias(self::FLEXLESS . '/special-colors.less');
        file_put_contents($file, $content);
        self::message('Rebuilt file: ' . $file);
    }

    private function message($text, $level = 'info')
    {
        $color = '';
        if ($level == 'success') {
            $color = Console::FG_GREEN;
            $text = "$text\n";
        } elseif ($level == 'warning') {
            $color = Console::FG_YELLOW;
        } elseif ($level == 'error') {
            $color = Console::FG_RED;
            $text = "\n*** $text";
        }
        if ($level != 'no-break')
        {
            $text .= "\n";
        }
        $this->stdout("$text", $color);
    }
}
