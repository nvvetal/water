=== Custom Post Type Creator === 

Contributors: reflectionmedia, madalin.ungureanu
Donate link: http://www.cozmoslabs.com/wordpress-creation-kit/custom-post-type-creator/
Tags: post type creator, custom post type creator, custom post type, post type, custom post type builder, post type builder
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: 1.0.2

WCK Post Type Creator gives you the possibility to create and edit custom post types for WordPress.
 
== Description ==

**IMPORTANT: The plugin Custom Post Type Creator will no longer be supported or updated.**

**Custom Post Type Creator is now part of [WCK - Custom Fields and Custom Post Types Creator plugin](http://wordpress.org/extend/plugins/wck-custom-fields-and-custom-post-types-creator/ "download link"), which is fully compatible. [Download it](http://wordpress.org/extend/plugins/wck-custom-fields-and-custom-post-types-creator/ "download link") and install it instead of the current plugin.**

WCK Custom Post Type Creator allows you to easily create custom post types for WordPress without any programming knowledge. It provides an UI for most of the arguments of register_post_type() function.

Features:

* Create and edit Custom Post Types from the Admin UI
* Advanced Labeling Options
* Attach built in or custom taxonomies to post types

== Installation ==

1. Upload the wck-cptc folder to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Then navigate to WCK => Post Type Creator tab and start creating your custom post types.

== Frequently Asked Questions ==

= Querying by post type in the frontend? =

You can create new queries to display posts from a specific post type. This is done via the �post_type� parameter to a WP_Query.

Example:

`<?php $args = array( 'post_type' => 'product', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
	the_title();
	echo '<div class="entry-content">';
	the_content();
	echo '</div>';
endwhile;?>`

This simply loops through the latest 10 product posts and displays the title and content of them. 

== Screenshots ==
1. Post Type Creator UI: screenshot-1.jpg
2. Post Type Creator UI and listing: screenshot-2.jpg

== Changelog ==
= 1.0.2 =
* Important notice: This plugin will no longer be supported or updated. Use [WCK - Custom Fields and Custom Post Types Creator plugin](http://wordpress.org/extend/plugins/wck-custom-fields-and-custom-post-types-creator/) instead.

= 1.0.1 =
* Compatible with WordPress 3.5