#!/bin/bash

cd themes/FlexTheme
lessc -x ./less/build.less ./css/theme.css

lessc -x ./less/dark/build.less ./css/dark-base.css

cd ../../
