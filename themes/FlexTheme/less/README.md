## How CSS of this theme works

The variables.less file defines CSS variables like `var(--default)` instead of concrete colors.  
The concrete values are defined in the HTML head, like `<style>:root {--default:#00ff00; ... }</style>`.

This makes it possible to switch colors without changes to the theme.css.
 
### Replaced LESS functions

HumHub uses LESS functions as lighten(), darken() or fade(). Those do not work when color variables contain CSS variables instead of concrete colors.  
That's why the import of some files is prevented via `@prev-...` in css-vars.less.  
Those files are replaced and the lightened, darkened and faded colors are replaced by LESS variables like `info-darken-5`.

The calculation of those is done via `helpers/ColorHelper`.

When the module is enabled those "special color variables" are calculated using the colors of the Community Theme as base.
