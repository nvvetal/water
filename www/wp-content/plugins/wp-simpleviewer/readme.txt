=== WP-SimpleViewer ===
Contributors: simpleviewer
Tags: SimpleViewer, photos, photo, images, image, posts, post, pages, page, plugin, gallery, galleries, flash, media
Requires at least: 2.8
Tested up to: 4.0
Stable tag: 2.3.2.4

Allows you to easily create SimpleViewer galleries with WordPress.

== Description ==

The WP-SimpleViewer plugin allows you to easily create [SimpleViewer](http://www.simpleviewer.net/simpleviewer/) galleries with WordPress. SimpleViewer is a free, customizable Flash image gallery. Images and captions can be loaded from the WordPress Media Library or from Flickr.

Get full instructions and support at the [WP-SimpleViewer Homepage](http://www.simpleviewer.net/simpleviewer/support/wp-simpleviewer/).

== Installation ==

= Installation =

1. Download the WP-SimpleViewer plugin. Unzip the plugin folder on your local machine.
2. Upload the complete plugin folder into your WordPress blog's '/wp-content/plugins/' directory.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. If the the '/wp-content/uploads/' folder does not exist, create it and give it write permissions (777) using an FTP program.

= Requirements =

Before installing, please confirm your web server meets the following requirements. If you are not sure, contact your web host tech support.

* WordPress Version 2.8 or higher.
* PHP version 5.2.0 or higher.
* The '/wp-content/uploads/' folder must exist and have full access permissions (777).
* PHP DOM extension is enabled (this is the default, however some web hosts may disable this extension).
* Active theme must call the [wp_head](http://codex.wordpress.org/Plugin_API/Action_Reference/wp_head) function in it's header.php file.

= Upgrading from v1.5.4 =

Please note that upgrading to the new plugin will cause galleries created with the old plugin not to display. [Check here for the solution](http://www.simpleviewer.net/simpleviewer/support/wp-simpleviewer/#v1).

== Changelog ==

= 2.3.2.4 =
* Fixed bug whereby defaults could not be set and galleries could not be edited in WebKit browsers
* Fixed bug whereby 'NextGEN Gallery' and 'Picasa Web Album' galleries did not display
* Fixed bug whereby submission could be performed remotely

= 2.3.2.3 =
* Supports SimpleViewer v2.3.2
* Added support for using Picasa Album Id as well as Picasa Album Name
* Fixed 'PHP Notice' in WordPress Debug Mode
* Improved gallery settings window layout
* Ensured all external CSS and JavaScript files are loaded only when required
* Removed deprecated code

= 2.3.2.2 =
* Added support for adding gallery in QuickPress widget on Dashboard page via media button
* Added support for CKEditor and FCKEditor
* Added support for reversing image order for 'Media Library' galleries
* Added tooltip text on 'Manage Galleries' page
* Fixed bug whereby default Pro Options appeared in gallery Pro Options text area in edit gallery form
* Fixed bug whereby gallery did not display under certain conditions
* Fixed bug whereby Picasa Web Album did not display if Picasa User Id or Picasa Album Name contained whitespace
* Fixed bug whereby plugin did not activate successfully under certain conditions
* Fixed bug whereby XML data was not generated dynamically under certain WordPress installations
* Fixed HTML errors on 'Manage Galleries' page
* Fixed incompatibility with ThemeForest Evermore theme
* Fixed server paths in backup and restore Pro 'svcore' folder routines
* Fixed visual input field issues in WebKit browsers
* Ensured all XML files use UTF-8 encoding
* Ensured only accepted images are included in galleries
* Ensured only required attributes are included in dynamically generated XML files
* Ensured only required resource files are included in administration pages
* Ensured only single SimpleViewer shortcode tag is inserted in page or post when user clicks 'Add Gallery' button multiple times
* Improved support for WordPress capabilities
* Improved error handling when unable to include SimpleViewer shortcode in page or post
* Removed deprecated code
* Removed 'default.xml' file
* Clean color and opacity values
* Clean numeric gallery configuration option values
* Custom default values no longer overwritten when updating plugin
* Disabled non-layout and gallery-specific options on 'Set Default Values' page
* Media Library gallery message displays 'Upload/Insert' or 'Add Media' depending on version of WordPress installed
* Moved all inline CSS to external stylesheets
* Optimized code
* Pro 'svcore' folder no longer overwritten when updating plugin
* Standard Options from the Pro Options text area are no longer entered into the output XML files

= 2.3.2.1 =
* Added support for 'Include Featured Image' in 'Media Library' galleries
* Fixed bug preventing Dashboard menu links from being displayed in certain installations
* Pro Options are now case-insensitive
* 'Delete All Galleries' button changed to 'Delete All Data' as button now cleanly removes all plugin-related data rather than just resetting options

= 2.3.2 =
* Supports SimpleViewer v2.3.1
* Added support for 'Picasa Web Album' as source of images
* Added support for WordPress installations on https:// secure servers
* XML file now created dynamically so no need to edit gallery or post to rebuild static XML file
* Made distinction between pages and posts throughout plugin
* Fixed bug allowing multiple gallery shortcodes to be entered into each post
* Fixed bug whereby duplicate calls were made to certain methods
* Fixed bug whereby corrupt NextGEN Gallery installation caused NextGEN-sourced gallery to fail

= 2.3.1 =
* Added support for 'NextGEN Gallery' as source of images
* Added ability to delete all galleries and reset Gallery Id to zero
* Added ability to set/reset default values for gallery options
* Improved and restructured code
* Removed redundant code
* Fixed incompatibilities with other plugins
* Multiple bug fixes and enhancements

= 2.3.0 =
* Fixed missing 'Add SimpleViewer Gallery' text button
* Fixed debug mode warnings
* Supports SimpleViewer v2.3.0

= 2.2.0 =
* Fixed Gallery Sizing Issues
* Fixed Multiple Flickr Tags
* Multiple bug fixes and enhancements

= 2.1.3 =
* Fixed Gallery Sizing Issues
* Fixed Compatibility with different jQuery versions
* Fixed Page zooming on mobile devices
* Multiple bug fixes and enhancements

= 2.1.2 =
* Added Universal Playback
* Supports SimpleViewer v2.1.2
* Multiple bug-fixes

= 2.0.5 =
* Added ability to delete galleries
* Fixed extra quotes in Pro options

= 2.0.4 =
* Supports SimpleViewer v2.0
* Supports loading images from the WordPress Media Library or via Flickr
* Compatible with WP 3.0

== Upgrade to SimpleViewer-Pro ==

[SimpleViewer-Pro](http://www.simpleviewer.net/simpleviewer/pro) supports advanced customization options, no branding, unlimited images and more. To upgrade the WP-SimpleViewer plugin to SimpleViewer-Pro, [check here](http://simpleviewer.net/simpleviewer/support/wp-simpleviewer/#pro).

== Credits ==

WP-SimpleViewer developed by [SimpleViewer Inc](http://www.simpleviewer.net/).

== Terms Of Use ==

WP-SimpleViewer may be used for personal and/or commercial projects. [View Terms of Use](http://www.simpleviewer.net/terms/)
