#!/bin/bash

cd themes/FlexTheme
lessc -x ./less/build.less ./css/theme.css

// TO DO css-color-extractor ??
//lessc -x ./less/dark/build.less ./css/dark-base.css

cd ../../
