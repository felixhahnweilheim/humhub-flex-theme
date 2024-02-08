#!/bin/bash

# 1) Recompile base CSS (after updating LESS files)
cd themes/FlexTheme
lessc less/build.less css/theme_base.css --clean-css="--s1 --advanced"
cd ../../

# 2) Dark Mode
cd themes/FlexTheme
lessc less/dark_build.less css/dark_theme_base.css --clean-css="--s1 --advanced"
cd ../../

# 2) Update message files
cd ../../
php yii message/extract-module flex-theme
cd modules/flex-theme
