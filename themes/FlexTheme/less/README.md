## How CSS of this theme works

`build.less` imports `variables-css-properties.less` instead of a normal `variables.less`.
It does not contain concrete colors but CSS variables like `var(--default)`.

The concrete values for those variables are defined in the HTML head which makes dynamic changes possible.

Note: In order to rebuild the css file,
you have to edit the core file `static/less/humhub.less`
and comment out the line `@import "../css/select2Theme/build.less"`.
The imported file contains a lighten() function which needs a concrete color, not a CSS variable. ...

All other core less files that include darken, lighten or fade are excluded by `@prev-...`

The lightend and darkened colors are replaced by variables like `info-darken-5`.

The calculation of those is done via `helpers/ColorHelper`
