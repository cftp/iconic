=== WP Instagram Widget ===
Contributors: scottsweb, tjnowell, codeforthepeople
Tags: icon, menu, icon font, font, custom, dashicon, social, media, share, buttons, badges
Requires at least: 3.8
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Replace WordPress menu items with a custom icon from the dashicon font.

== Description ==

Replace WordPress menu items with a custom icon from the dashicon font.

== Installation ==

To install this plugin:

1. Upload the `iconic` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That's it!

== Frequently Asked Questions ==

= Hooks & Filters =

The plugin has one filter that allows you adjust the classes and icons available to a user:

`add_filter('iconic_icons', 'custom_icon_font');

function custom_icon_font() {
	
	// IMPORTANT: prefix your icon class with 'menu-icon-'
	// You will need to have added your icon definitions to your own CSS
	// Leave the no-icon option as a default

	$icons = array(
		'no-icon'		     		=> __('None', 'iconic'),
		'menu-icon-icon-facebook' 	=> __('Facebook', 'iconic'),
		'menu-icon-icon-twitter'  	=> __('Twitter', 'iconic'),
		'menu-icon-icon-google'	 	=> __('Google+', 'iconic'),
		'menu-icon-icon-linkedin'	=> __('Linked In', 'iconic'),
		'menu-icon-icon-rss'		=> __('RSS', 'iconic'),
		'menu-icon-icon-mail'		=> __('Email', 'iconic')
	);

	return $icons;
}
`

== Screenshots ==

1. Menu icon option
2. Social media menu with using dashicons 

== Changelog ==

= 1.0 =
* Initial release
