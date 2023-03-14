#!/bin/bash

cd themes/FlexTheme
lessc -x ./less/build.less ./css/theme.css
cd ../../
