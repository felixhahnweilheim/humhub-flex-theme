<?php

namespace humhub\modules\flexTheme\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;

class DevController extends Controller
{
    const SRC = '@webroot/static/less';
    const DST = '@flex-theme/themes/FlexTheme/less/humhub';
    const FLEX_LESS = '@flex-theme/themes/FlexTheme/less';

    const SUPPORTED = ['darken', 'lighten', 'fade', 'fadein', 'fadeout'];
    const UNSOPPORTED = ['saturate', 'desaturate', 'spin'];
    
    const SELECT2_SRC = '@webroot/static/css/select2Theme';
    const SELECT2_DST = '@flex-theme/themes/FlexTheme/less/css/select2Theme';
    
    const DARK_FILE_SRC = '@dark-mode/resources/DarkHumHub/less/theme.less';
    const DARK_FILE_DST = '@flex-theme/themes/FlexTheme/less/dark/theme.less';

    // Special colors
    public $special_colors = [];

    public $unsopportedLines = [];

    public function actionRebuild()
    {
        if (!$this->confirm('This action is only for developping. Continue?')) {
            $this->stdout("Cancelled\n");
            return ExitCode::OK;
        }            

        // Copy HumHub LESS files
        $src = Yii::getAlias(self::SRC);
        $dst = Yii::getAlias(self::DST);
        FileHelper::copyDirectory($src, $dst);
        self::message("Copied $src to $dst", 'success');

        // Check and correct copied files
        $files = FileHelper::findFiles($dst);
        foreach ($files as $file)
        {
            if (basename($file) !== 'variables.less') {
                self::checkAndCorrectFile($file);
            }
        }
        
        // Select2
        self::handleSelect2();
        
        // Dark Mode 
        // @todo variables.less of the module has a few more CSS rules that should be imported, too
        if ($this->confirm('Also update Dark Mode file? Dark Mode Module needs to be installed!')) {
            $src = Yii::getAlias(self::DARK_FILE_SRC);
            $dst = Yii::getAlias(self::DARK_FILE_DST);
            copy($src, $dst);
            self::message("Copied $src to $dst", 'success');
            self::checkAndCorrectFile($dst);
        }  
        

        // special-colors.less
        sort($this->special_colors);
        self::createSpecialColorsLess();
        
        // Output special colors array for manually updating AbstractColorSettings.php
        self::message("\nSuccessfully rebuilt theme files", 'success');
        self::message('*** Special colors to be copied:', 'warning');
        self::message('    const SPECIAL_COLORS = [', 'no-break');
        foreach ($this->special_colors as $color)
        {
            self::message("'" . $color . "',", 'no-break');
        }
        self::message("];\n");
        
        // Warning about unsopported lines
        if ($this->unsopportedLines !== []) {
            self::message("***\n Unsopported Lines: ", 'warning');
            foreach($this->unsopportedLines as $line)
            {
                self::message("$line[2] at $line[1]: $line[0]");
            }
        }        

        return ExitCode::OK;
    }
    
    /*
     * Checks the given file line by line for LESS functions
     * and replaces them with special color variables
     */
    private function checkAndCorrectFile($file): void
    {
        //self::message("Going through: $file");

        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach($lines as $key => $line)
        {
            $lines[$key] = self::checkAndCorrectLine($key, $line, $file);
        }
        $data = implode(PHP_EOL, $lines);
        file_put_contents($file, $data);
    }

    /*
     * returns string the corrected line
     * and fills $this->special_colors and $this->unsopportedLines
     */
    private function checkAndCorrectLine($lineNumber, $line, $file): string
    {
        // Return unchanged if line is a comment
        if (substr($line, 0, 2) === '//') {
            return $line;
        }

        foreach (self::UNSOPPORTED as $less_function)
        {
            // Do not change lines with unsopported function but display a warning
            if (strpos($line, $less_function . '(') !== false) {
                self::message("Manual correction required!\nUnsopported function in line ++$lineNumber in $file", 'warning');

                $this->unsopportedLines[] = [$line, $lineNumber, $file];

                // Return unchanged
                return $line;
            }
        }
        foreach (self::SUPPORTED as $less_function)
        {
            // Replace lines with supported function
            while ($pos = strpos($line, $less_function . '(') !== false) {

                $parts = explode($less_function . '(@', $line, 2);

                // Line beginning until LESS function
                $first = $parts[0];

                $rest = explode(',', $parts[1], 2);

                // Color variable (the @ symbol has been removed above)
                $color = $rest[0];

                $rest = explode(')', $rest[1], 2);

                // amount
                $amount = trim($rest[0], ' %');

                // Line ending (e.g. "!important;")
                $end = $rest[1];

                $special_color = str_replace('-', '_', $color) . '__' . $less_function . '__' . $amount;

                $this->special_colors[$special_color] = $special_color;

                $line = $first . '@' . str_replace(['__', '_'], '-', $special_color) . $end;
            }
        }

        return $line;
    }
    
    /*
     * Creates the file special-colors.less
     * LESS variables referring to CSS variables
     * e.g. @primary-darken-5: var(--primary--darken--5);
     */
    private function createSpecialColorsLess(): void
    {
        $content = '';

        foreach ($this->special_colors as $color)
        {
            $colorAsLessVar = '@' . str_replace(['__', '_'], '-', $color);
            $color = str_replace('_', '-', $color);
            $content .= $colorAsLessVar . ': var(--' . $color . ');';
        }

        $file = Yii::getAlias(self::FLEX_LESS . '/special-colors.less');
        file_put_contents($file, $content);
        self::message("Rebuilt file: $file", 'success');
    }
    
    private function handleSelect2(): void
    {
        // Copy files
        $src = Yii::getAlias(self::SELECT2_SRC);
        $dst = Yii::getAlias(self::SELECT2_DST);
        FileHelper::copyDirectory($src, $dst);
        self::message("Copied $src to $dst", 'success');
        
        // Go through copied files
        self::correctSelect2Build($dst . '/build.less');
        self::correctSelect2Theme($dst . '/select2-humhub.less');
        self::checkAndCorrectFile($dst . '/select2-humhub.less');
    }
    
    private function correctSelect2Build($file): void
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach($lines as $key => $line)
        {
            if (strpos($line, '@import "../../../protected/') !== false) {
                // Correct import because of subfolder
                $lines[$key] = str_replace('@import "../../../protected/', '@import "../../../../../../../', $line);
            }
        }
        $data = implode(PHP_EOL, $lines);
        file_put_contents($file, $data);
    }
    
    private function correctSelect2Theme($file): void
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach($lines as $key => $line)
        {
            if (!isset($pattern)) {
                if (isset($copyEnd)) {
                    $pattern = implode(PHP_EOL, array_slice($lines, $copyStart + 1, $copyEnd - $copyStart - 1));
                } elseif (isset($copyStart)) {
                    if ($line === '}') {
                        $copyEnd = (int) $key;
                    }
                } elseif (strpos($line, '.validation-state-focus(@color) {') !== false) {
                    $copyStart = (int) $key;
                }
            } else {
                if (strpos($line, '.validation-state-focus(') !== false) {
                    $parts = explode('(',  $line, 2);
                    $color = trim($parts[1], ");");
                    
                    $lines[$key] = str_replace('@color', $color, $pattern);
                }
            }
        }
        
        // Comment out pattern
        $i = $copyStart;
        while ($i <= $copyEnd) {
            $lines[$i] = '//' . $lines[$i];
            $i++;
        }
        
        $data = implode(PHP_EOL, $lines);
        file_put_contents($file, $data);
    }
    
    /*
     * Helper function to output messages with a defined level
     */
    private function message($text, $level = 'info'): void
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

