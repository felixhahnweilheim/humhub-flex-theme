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

    const SUPPORTED = ['darken', 'lighten', 'fade', 'fadein', 'fadeout'];
    const UNSOPPORTED = ['saturate', 'desaturate', 'red', 'green', 'blue'];

    public function actionRebuild()
    {
        self::message('Starting to rebuild LESS files of FlexTheme.', 'important');

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
                self::checkAndCorrectFile($file);
            }
        }

        self::message('Successfully rebuilt theme files', 'success');

        return self::EXIT_CODE_NORMAL;
    }

    private function checkAndCorrectFile($file)
    {
        self::message("Going through: $file");

        $special_colors = [];

        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach($lines as $key => $line)
        {
            $result = self::checkAndCorrectLine($key, $line, $file);
            $lines[$key] = $result[0];
            $special_colors[] = $result[1];
        }
        $data = implode(PHP_EOL, $lines);
        file_put_contents($file, $data);

        self::message('Special colors: ' . implode(', ', $special_colors));
    }

    private function checkAndCorrectLine($lineNumber, $line, $file)
    {
        foreach (self::UNSOPPORTED as $less_function)
        {
            // Do not change lines with unsopported function but display a warning
            if (strpos($line, $less_function . '(') !== false) {
                self::message("Manual correction required!\nUnsopported function in line $lineNumber + 1 in $file", 'warning');
                return [$line, null];
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

                $newLine = $first . '@' . $color . '-' . $less_function . '-' . $amount . $end;

                self::message("New Line: $newLine");

                return [$newLine, null];
            }
        }
        return [$line, null];
    }

    private function message($text, $level = 'info')
    {
        $color = '';
        if ($level == 'success') {
            $color = Console::FG_GREEN;
            $text = "$text\n";
        } elseif ($level == 'important') {
            $color = Console::FG_YELLOW;
            $text = "$text\n";
        } elseif ($level == 'error') {
            $color = Console::FG_RED;
            $text = "\n*** $text\n";
        }
        $this->stdout("$text\n", $color);
    }
}
