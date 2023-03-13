# FlexTheme for HumHub

The first free configurable theme for HumHub

## Features

### Social Controls

**Comment Link**

Choose between the text "Comment" / "Reply" (default) and the comment icon or both.

**Like Link**

Similar to Comment Link. But for the icon you can decide between thumbs up (default), heart and star.

### Verified Accounts

Define varified accounts by entering their user IDs.
The verified icon (check-circle) is shown in
- user profiles
- posts
- comments
- people page

## To Do
- add module icon
- add screenshot
- documentation
- CSS
- variables in database

## Rebuild CSS file
Note: In order to rebuild the css file, you have to edit the core file static/less/humhub.less and remove the line `@import "../css/select2Theme/build.less";` The imported file contains a lighten() function which needs a concrete color, not a CSS variable.
...
