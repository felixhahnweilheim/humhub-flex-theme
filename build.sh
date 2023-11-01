#!/bin/bash

cd themes/FlexTheme
lessc -x ./less/build.less ./css/theme_base.css
cd ../../
