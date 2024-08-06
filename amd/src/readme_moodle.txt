=======================
botframework-webchat
=======================

Instructions to include 'botframework-webchat' into Moodle:

1. Run `npm install` from the plugin root.
   This should download the 'botframework-webchat' library and it's dependencies and
   place it into a `node_modules` directory.

2. Run `npm run bundle` from the plugin root.
   This should bundle the 'botframework-webchat' library and it's dependencies into
   an ES module and place it into the `amd/src` directory.

3. Run `npm run build` from the plugin root to lint and minify all sources.

