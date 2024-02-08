#!/bin/bash

# 1) Recompile base CSS (after updating LESS files)
cd themes/FlexTheme
lessc less/build.less css/theme_base.css --clean-css="--s1 --advanced"
cd ../../

# 2) Recompile dark CSS
cd themes/FlexTheme
lessc less/dark_build.less css/dark_theme_base.css
css-color-extractor css/dark_theme.css css/dark_theme.css --format=css
# Re-add CSS variables and compress CSS
cp css/dark_theme.css css/dark_temporary.less
lessc less/dark_build2.less css/dark_theme.css --clean-css="--s1 --advanced"
rm css/dark_temporary.less
cd ../../

# 3) Update message files
cd ../../
php yii message/extract-module flex-theme
cd modules/flex-theme
