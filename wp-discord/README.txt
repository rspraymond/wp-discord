=== WP Discord ===
Contributors: rspraymond, psigel
Tags: discord, chat, widget
Requires at least: 4.0.0
Tested up to: 4.7
Stable tag: 0.3.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress plugin to integrate discord into your wordpress sites. Currently supports discord widget, and basic channel posting.

== Description ==

Wordpress plugin to integrate discord into your wordpress sites. Currently supports discord widget, and basic channel posting.

== Installation ==

1. Upload the `wp-discord` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
3. Go to Appearance -> Widgets
4. Drag Widget into widget options
5. Paste Widget ID found in your discord server at Server Settings -> Widget. Make sure "Enable Widget" is checked and that a instant invite channel is selected.
6. (Optional) For best results. Create a never ending invite link by going to the Discord Server -> Invite People (Link above Server Settings). Not doing this could result in the Join Server link not working.
7. CHANNEL POSTING- Click "WP Discord" in admin menu and follow the instructions there.

== Screenshots ==

1.  Make sure "Enable Widget" is checked and that a instant invite channel is selected. Copy server id.
2. Configure your widget
3. Widget Display
4. Discord Channel Posting Setup.

== Changelog ==

= 0.3.6 =
* Delete Plugin options when uninstalling plugin.

= 0.3.5 =
* Fix channel posting for future posts.

= 0.3.4 =
* Display a more graceful error message when activating the plugin on unsupported versions of PHP.

= 0.3.3 =
* Bug fix. Replace root relative form path.

= 0.3.2 =
* Make sure to trim saved plugin options

= 0.3.1 =
* Improve error reporting on widget render

= 0.3.0 =
* Discord Channel Posting Release

= 0.2.3 =
* Bug fixes for missing invite links. Adjust setup steps.

= 0.2.2 =
* Force widget box sizing for themes without it

= 0.2.1 =
* Update contributors
* Update widget config screenshot

= 0.2.0 =
* Add ability to declare how many online members should be shown in widget

= 0.1.3 =
* CSS Fixes to prevent wordpress conflicts

= 0.1.2 =
* Fix stable tag

= 0.1.1 =
* Fix layout of shortcode button

= 0.1.0 =
* Widget Release
