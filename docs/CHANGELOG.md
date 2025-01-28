## TBA
- Fix #39: rounding issue in ColorHelper - thanks to @marc-farre
- Fix #42: Division by zero (when trying to lighten white color)
- Fix #43: Invalid faded color calculated from 3 digits base color

## 0.3.0 (14 february 2024)
**NOTE** Files in themes/FlexTheme/css now need to be writable by the PHP process (see https://docs.humhub.org/docs/admin/installation/#file-permissions)

- New: Dark Mode (compatibility with the Dark Mode module)
- Enh: move variable declaration from HTML into CSS file (performance improvement)
- remove admin menu item
- Maintainance: update for HumHub 1.15
- New option: show file upload options as buttons instead of dropdown) - experimental
- New controller action: flex-theme/rebuild - only for developping!
- Enh: various code style improvements

## 0.2.1 (22 may 2023)
- Fix: save likeIconColor
- Enh: Import/Export (JSON)
- Enh: Show topic menu in spaces and user profiles (optional)

## 0.2.0 (26 april 2023)
- Enh: make like icon color configurable
- Enh: use color and icon pickers
- drop support for file configuration
- Remove verified icon (use https://marketplace.humhub.com/module/verified/description instead)
- Enh: split settings form into general and colors
- Enh: text colors
- Enh: background colors

## 0.1.0 (27 march 2023)
First release
