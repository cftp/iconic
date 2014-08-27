<?php
/*
Plugin Name: Iconic
Plugin URI: https://github.com/cftp/iconic
Description: Replace WordPress menu items with a custom icon
Version: 1.0
Author: Code For The People
Author URI: http://codeforthepeople.com
Text Domain: iconic
Domain Path: /assets/languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright © 2013 Code for the People ltd

                _____________
               /      ____   \
         _____/       \   \   \
        /\    \        \___\   \
       /  \    \                \
      /   /    /          _______\
     /   /    /          \       /
    /   /    /            \     /
    \   \    \ _____    ___\   /
     \   \    /\    \  /       \
      \   \  /  \____\/    _____\
       \   \/        /    /    / \
        \           /____/    /___\
         \                        /
          \______________________/


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/**
 * iconic_horizontal_menu
 *
 * A widget with horizontal class - perfect for icon based menus
 *
 * @author Scott Evans
 * @return void
 */
function iconic_horizontal_widget() {
	if ( ! class_exists( 'WP_Horizontal_Nav_Menu_Widget' ) ) {

		class WP_Horizontal_Nav_Menu_Widget extends WP_Nav_Menu_Widget {
			public function __construct() {
				$widget_ops = array( 'description' => __('Add a custom horizontal menu to your sidebar.', 'iconic') );
				WP_Widget::__construct( 'horizontal_nav_menu', __('Custom Horizontal Menu', 'iconic'), $widget_ops );
			}
		}

		register_widget( 'WP_Horizontal_Nav_Menu_Widget' );
	}
}
add_action( 'widgets_init', 'iconic_horizontal_widget' );

/**
 * iconic_dashicons
 *
 * Load the dashicons CSS on the front end
 *
 * @return void
 */
function iconic_dashicons() {
	wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'iconic_dashicons' );

/**
 * iconic_css
 *
 * Add the .sr-only class to the head for screen reader text
 *
 * @return void
 */
function iconic_css() {
?>
<style type="text/css" media="screen"> .sr-only { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0 0 0 0); border: 0; } </style>
<?php
}
add_action( 'wp_head', 'iconic_css' );

/**
 * iconic
 *
 * Register array of icons and new instance of Iconic_Menu_Select
 *
 * @return void
 */
function iconic() {
	$icons = array(
		'no-icon'		     							=> __('None', 'iconic'),
		'menu-icon-dashicons-menu' 						=> __('Menu', 'iconic'),
		'menu-icon-dashicons-dashboard' 				=> __('Dashboard', 'iconic'),
		'menu-icon-dashicons-admin-site' 				=> __('Admin Site', 'iconic'),
		'menu-icon-dashicons-admin-media'				=> __('Admin Media', 'iconic'),
		'menu-icon-dashicons-admin-page'				=> __('Admin Page', 'iconic'),
		'menu-icon-dashicons-admin-comments'			=> __('Admin Comments', 'iconic'),
		'menu-icon-dashicons-admin-appearance'			=> __('Admin Appearance', 'iconic'),
		'menu-icon-dashicons-admin-plugins'				=> __('Admin Plugins', 'iconic'),
		'menu-icon-dashicons-admin-users'				=> __('Admin Users', 'iconic'),
		'menu-icon-dashicons-admin-tools'				=> __('Admin Tools', 'iconic'),
		'menu-icon-dashicons-admin-settings'			=> __('Admin Settings', 'iconic'),
		'menu-icon-dashicons-admin-network'				=> __('Admin Network', 'iconic'),
		'menu-icon-dashicons-admin-generic'				=> __('Admin Generic', 'iconic'),
		'menu-icon-dashicons-admin-home'				=> __('Admin Home', 'iconic'),
		'menu-icon-dashicons-admin-collapse'			=> __('Admin Collapse', 'iconic'),
		'menu-icon-dashicons-admin-links'				=> __('Admin Links', 'iconic'),
		'menu-icon-dashicons-admin-post'				=> __('Admin Post', 'iconic'),
		'menu-icon-dashicons-format-standard'			=> __('Admin Plugins', 'iconic'),
		'menu-icon-dashicons-format-image'				=> __('Image Post Format', 'iconic'),
		'menu-icon-dashicons-format-gallery'			=> __('Gallery Post Format', 'iconic'),
		'menu-icon-dashicons-format-audio'				=> __('Audio Post Format', 'iconic'),
		'menu-icon-dashicons-format-video'				=> __('Video Post Format', 'iconic'),
		'menu-icon-dashicons-format-links'				=> __('Link Post Format', 'iconic'),
		'menu-icon-dashicons-format-chat'				=> __('Chat Post Format', 'iconic'),
		'menu-icon-dashicons-format-status'				=> __('Status Post Format', 'iconic'),
		'menu-icon-dashicons-format-aside'				=> __('Aside Post Format', 'iconic'),
		'menu-icon-dashicons-format-quote'				=> __('Quote Post Format', 'iconic'),
		'menu-icon-dashicons-welcome-write-blog'		=> __('Welcome Write Blog', 'iconic'),
		'menu-icon-dashicons-welcome-edit-page'			=> __('Welcome Edit Page', 'iconic'),
		'menu-icon-dashicons-welcome-add-page'			=> __('Welcome Add Page', 'iconic'),
		'menu-icon-dashicons-welcome-view-site'			=> __('Welcome View Site', 'iconic'),
		'menu-icon-dashicons-welcome-widgets-menus'		=> __('Welcome Widget Menus', 'iconic'),
		'menu-icon-dashicons-welcome-comments'			=> __('Welcome Comments', 'iconic'),
		'menu-icon-dashicons-welcome-learn-more'		=> __('Welcome Learn More', 'iconic'),
		'menu-icon-dashicons-image-crop'				=> __('Image Crop', 'iconic'),
		'menu-icon-dashicons-image-rotate-left'			=> __('Image Rotate Left', 'iconic'),
		'menu-icon-dashicons-image-rotate-right'		=> __('Image Rotate Right', 'iconic'),
		'menu-icon-dashicons-image-flip-vertical'		=> __('Image Flip Vertical', 'iconic'),
		'menu-icon-dashicons-image-flip-horizontal'		=> __('Image Flip Horizontal', 'iconic'),
		'menu-icon-dashicons-undo'						=> __('Undo', 'iconic'),
		'menu-icon-dashicons-redo'						=> __('Redo', 'iconic'),
		'menu-icon-dashicons-editor-bold'				=> __('Editor Bold', 'iconic'),
		'menu-icon-dashicons-editor-italic'				=> __('Editor Italic', 'iconic'),
		'menu-icon-dashicons-editor-ul'					=> __('Editor UL', 'iconic'),
		'menu-icon-dashicons-editor-ol'					=> __('Editor OL', 'iconic'),
		'menu-icon-dashicons-editor-quote'				=> __('Editor Quote', 'iconic'),
		'menu-icon-dashicons-editor-alignleft'			=> __('Editor Align Left', 'iconic'),
		'menu-icon-dashicons-editor-aligncenter'		=> __('Editor Align Center', 'iconic'),
		'menu-icon-dashicons-editor-alignright'			=> __('Editor Align Right', 'iconic'),
		'menu-icon-dashicons-editor-insertmore'			=> __('Editor Insert More', 'iconic'),
		'menu-icon-dashicons-editor-spellcheck'			=> __('Editor Spell Check', 'iconic'),
		'menu-icon-dashicons-editor-distractionfree'	=> __('Editor Distraction Free', 'iconic'),
		'menu-icon-dashicons-editor-expand'				=> __('Editor Expand', 'iconic'),
		'menu-icon-dashicons-editor-contract'			=> __('Editor Contract', 'iconic'),
		'menu-icon-dashicons-editor-kitchensink'		=> __('Editor Kitchen Sink', 'iconic'),
		'menu-icon-dashicons-editor-underline'			=> __('Editor Underline', 'iconic'),
		'menu-icon-dashicons-editor-justify'			=> __('Editor Justify', 'iconic'),
		'menu-icon-dashicons-editor-textcolor'			=> __('Editor Text Colour', 'iconic'),
		'menu-icon-dashicons-editor-paste-word'			=> __('Editor Paste Word', 'iconic'),
		'menu-icon-dashicons-editor-paste-text'			=> __('Editor Paste Text', 'iconic'),
		'menu-icon-dashicons-editor-removeformatting'	=> __('Editor Remove Formatting', 'iconic'),
		'menu-icon-dashicons-editor-video'				=> __('Editor Video', 'iconic'),
		'menu-icon-dashicons-editor-customchar'			=> __('Editor Custom Character', 'iconic'),
		'menu-icon-dashicons-editor-outdent'			=> __('Editor Outdent', 'iconic'),
		'menu-icon-dashicons-editor-indent'				=> __('Editor Indent', 'iconic'),
		'menu-icon-dashicons-editor-help'				=> __('Editor Help', 'iconic'),
		'menu-icon-dashicons-editor-strikethrough'		=> __('Editor Strikethrough', 'iconic'),
		'menu-icon-dashicons-editor-unlink'				=> __('Editor Unlink', 'iconic'),
		'menu-icon-dashicons-editor-rtl'				=> __('Editor RTL', 'iconic'),
		'menu-icon-dashicons-editor-break'				=> __('Editor Break', 'iconic'),
		'menu-icon-dashicons-editor-code'				=> __('Editor Code', 'iconic'),
		'menu-icon-dashicons-editor-paragraph'			=> __('Editor Paragraph', 'iconic'),
		'menu-icon-dashicons-align-left'				=> __('Align Left', 'iconic'),
		'menu-icon-dashicons-align-right'				=> __('Align Right', 'iconic'),
		'menu-icon-dashicons-align-center'				=> __('Align Center', 'iconic'),
		'menu-icon-dashicons-align-none'				=> __('Align None', 'iconic'),
		'menu-icon-dashicons-lock'						=> __('Lock', 'iconic'),
		'menu-icon-dashicons-calendar'					=> __('Calendar', 'iconic'),
		'menu-icon-dashicons-visibility'				=> __('Visibility', 'iconic'),
		'menu-icon-dashicons-post-status'				=> __('Post Status', 'iconic'),
		'menu-icon-dashicons-edit'						=> __('Edit', 'iconic'),
		'menu-icon-dashicons-post-trash'				=> __('Post Trash', 'iconic'),
		'menu-icon-dashicons-trash'						=> __('Trash', 'iconic'),
		'menu-icon-dashicons-external'					=> __('External', 'iconic'),
		'menu-icon-dashicons-arrow-up'					=> __('Arrow Up', 'iconic'),
		'menu-icon-dashicons-arrow-down'				=> __('Arrow Down', 'iconic'),
		'menu-icon-dashicons-arrow-left'				=> __('Arrow Left', 'iconic'),
		'menu-icon-dashicons-arrow-right'				=> __('Arrow Right', 'iconic'),
		'menu-icon-dashicons-arrow-up-alt'				=> __('Arrow Up (alt)', 'iconic'),
		'menu-icon-dashicons-arrow-down-alt'			=> __('Arrow Down (alt)', 'iconic'),
		'menu-icon-dashicons-arrow-left-alt'			=> __('Arrow Left (alt)', 'iconic'),
		'menu-icon-dashicons-arrow-right-alt'			=> __('Arrow Right (alt)', 'iconic'),
		'menu-icon-dashicons-arrow-up-alt2'				=> __('Arrow Up (alt 2)', 'iconic'),
		'menu-icon-dashicons-arrow-down-alt2'			=> __('Arrow Down (alt 2)', 'iconic'),
		'menu-icon-dashicons-arrow-left-alt2'			=> __('Arrow Left (alt 2)', 'iconic'),
		'menu-icon-dashicons-arrow-right-alt2'			=> __('Arrow Right (alt 2)', 'iconic'),
		'menu-icon-dashicons-leftright'					=> __('Arrow Left-Right', 'iconic'),
		'menu-icon-dashicons-sort'						=> __('Sort', 'iconic'),
		'menu-icon-dashicons-randomize'					=> __('Randomise', 'iconic'),
		'menu-icon-dashicons-list-view'					=> __('List View', 'iconic'),
		'menu-icon-dashicons-exerpt-view'				=> __('Excerpt View', 'iconic'),
		'menu-icon-dashicons-hammer'					=> __('Hammer', 'iconic'),
		'menu-icon-dashicons-art'						=> __('Art', 'iconic'),
		'menu-icon-dashicons-migrate'					=> __('Migrate', 'iconic'),
		'menu-icon-dashicons-performance'				=> __('Performance', 'iconic'),
		'menu-icon-dashicons-universal-access'			=> __('Universal Access', 'iconic'),
		'menu-icon-dashicons-universal-access-alt'		=> __('Universal Access (alt)', 'iconic'),
		'menu-icon-dashicons-tickets'					=> __('Tickets', 'iconic'),
		'menu-icon-dashicons-nametag'					=> __('Name Tag', 'iconic'),
		'menu-icon-dashicons-clipboard'					=> __('Clipboard', 'iconic'),
		'menu-icon-dashicons-heart'						=> __('Heart', 'iconic'),
		'menu-icon-dashicons-megaphone'					=> __('Megaphone', 'iconic'),
		'menu-icon-dashicons-schedule'					=> __('Schedule', 'iconic'),
		'menu-icon-dashicons-wordpress'					=> __('WordPress', 'iconic'),
		'menu-icon-dashicons-wordpress-alt'				=> __('WordPress (alt)', 'iconic'),
		'menu-icon-dashicons-pressthis,'				=> __('Press This', 'iconic'),
		'menu-icon-dashicons-update,'					=> __('Update', 'iconic'),
		'menu-icon-dashicons-screenoptions'				=> __('Screen Options', 'iconic'),
		'menu-icon-dashicons-info'						=> __('Info', 'iconic'),
		'menu-icon-dashicons-cart'						=> __('Cart', 'iconic'),
		'menu-icon-dashicons-feedback'					=> __('Feedback', 'iconic'),
		'menu-icon-dashicons-cloud'						=> __('Cloud', 'iconic'),
		'menu-icon-dashicons-translation'				=> __('Translation', 'iconic'),
		'menu-icon-dashicons-tag'						=> __('Tag', 'iconic'),
		'menu-icon-dashicons-category'					=> __('Category', 'iconic'),
		'menu-icon-dashicons-archive'					=> __('Archive', 'iconic'),
		'menu-icon-dashicons-tagcloud'					=> __('Tag Cloud', 'iconic'),
		'menu-icon-dashicons-text'						=> __('Text', 'iconic'),
		'menu-icon-dashicons-media-archive'				=> __('Media Archive', 'iconic'),
		'menu-icon-dashicons-media-audio'				=> __('Media Audio', 'iconic'),
		'menu-icon-dashicons-media-code'				=> __('Media Code)', 'iconic'),
		'menu-icon-dashicons-media-default'				=> __('Media Default', 'iconic'),
		'menu-icon-dashicons-media-document'			=> __('Media Document', 'iconic'),
		'menu-icon-dashicons-media-interactive'			=> __('Media Interactive', 'iconic'),
		'menu-icon-dashicons-media-spreadsheet'			=> __('Media Spreadsheet', 'iconic'),
		'menu-icon-dashicons-media-text'				=> __('Media Text', 'iconic'),
		'menu-icon-dashicons-media-video'				=> __('Media Video', 'iconic'),
		'menu-icon-dashicons-playlist-audio'			=> __('Audio Playlist', 'iconic'),
		'menu-icon-dashicons-playlist-video'			=> __('Video Playlist', 'iconic'),
		'menu-icon-dashicons-yes'						=> __('Yes', 'iconic'),
		'menu-icon-dashicons-no'						=> __('No', 'iconic'),
		'menu-icon-dashicons-no-alt'					=> __('No (alt)', 'iconic'),
		'menu-icon-dashicons-plus'						=> __('Plus', 'iconic'),
		'menu-icon-dashicons-plus-alt'					=> __('Plus (alt)', 'iconic'),
		'menu-icon-dashicons-minus'						=> __('Minus', 'iconic'),
		'menu-icon-dashicons-dismiss'					=> __('Dismiss', 'iconic'),
		'menu-icon-dashicons-marker'					=> __('Marker', 'iconic'),
		'menu-icon-dashicons-star-filled'				=> __('Star Filled', 'iconic'),
		'menu-icon-dashicons-star-half'					=> __('Star Half', 'iconic'),
		'menu-icon-dashicons-star-empty'				=> __('Star Empty', 'iconic'),
		'menu-icon-dashicons-flag'						=> __('Flag', 'iconic'),
		'menu-icon-dashicons-share'						=> __('Share', 'iconic'),
		'menu-icon-dashicons-share1'					=> __('Share 1', 'iconic'),
		'menu-icon-dashicons-share-alt'					=> __('Share (alt)', 'iconic'),
		'menu-icon-dashicons-share-alt2'				=> __('Share (alt 2)', 'iconic'),
		'menu-icon-dashicons-twitter'					=> __('twitter', 'iconic'),
		'menu-icon-dashicons-rss'						=> __('RSS', 'iconic'),
		'menu-icon-dashicons-email'						=> __('Email', 'iconic'),
		'menu-icon-dashicons-email-alt'					=> __('Email (alt)', 'iconic'),
		'menu-icon-dashicons-facebook'					=> __('Facebook', 'iconic'),
		'menu-icon-dashicons-facebook-alt'				=> __('Facebook (alt)', 'iconic'),
		'menu-icon-dashicons-networking'				=> __('Networking', 'iconic'),
		'menu-icon-dashicons-googleplus'				=> __('Google+', 'iconic'),
		'menu-icon-dashicons-location'					=> __('Location', 'iconic'),
		'menu-icon-dashicons-location-alt'				=> __('Location (alt)', 'iconic'),
		'menu-icon-dashicons-camera'					=> __('Camera', 'iconic'),
		'menu-icon-dashicons-images-alt'				=> __('Images', 'iconic'),
		'menu-icon-dashicons-images-alt2'				=> __('Images Alt', 'iconic'),
		'menu-icon-dashicons-video-alt'					=> __('Video (alt)', 'iconic'),
		'menu-icon-dashicons-video-alt2'				=> __('Video (alt 2)', 'iconic'),
		'menu-icon-dashicons-video-alt3'				=> __('Video (alt 3)', 'iconic'),
		'menu-icon-dashicons-vault'						=> __('Vault', 'iconic'),
		'menu-icon-dashicons-shield'					=> __('Shield', 'iconic'),
		'menu-icon-dashicons-shield-alt'				=> __('Shield (alt)', 'iconic'),
		'menu-icon-dashicons-sos'						=> __('SOS', 'iconic'),
		'menu-icon-dashicons-search'					=> __('Search', 'iconic'),
		'menu-icon-dashicons-slides'					=> __('Slides', 'iconic'),
		'menu-icon-dashicons-analytics'					=> __('Analytics', 'iconic'),
		'menu-icon-dashicons-chart-pie'					=> __('Pie Chart', 'iconic'),
		'menu-icon-dashicons-chart-bar'					=> __('Bar Chart', 'iconic'),
		'menu-icon-dashicons-chart-line'				=> __('Line Chart', 'iconic'),
		'menu-icon-dashicons-chart-area'				=> __('Area Chart', 'iconic'),
		'menu-icon-dashicons-groups'					=> __('Groups', 'iconic'),
		'menu-icon-dashicons-businessman'				=> __('Businessman', 'iconic'),
		'menu-icon-dashicons-id'						=> __('ID', 'iconic'),
		'menu-icon-dashicons-id-alt'					=> __('ID (alt)', 'iconic'),
		'menu-icon-dashicons-products'					=> __('Products', 'iconic'),
		'menu-icon-dashicons-awards'					=> __('Awards', 'iconic'),
		'menu-icon-dashicons-forms'						=> __('Forms', 'iconic'),
		'menu-icon-dashicons-testimonial'				=> __('Testimonial', 'iconic'),
		'menu-icon-dashicons-portfolio'					=> __('Portfolio', 'iconic'),
		'menu-icon-dashicons-book'						=> __('Book', 'iconic'),
		'menu-icon-dashicons-book-alt'					=> __('Book (alt)', 'iconic'),
		'menu-icon-dashicons-download'					=> __('Download', 'iconic'),
		'menu-icon-dashicons-upload'					=> __('Upload', 'iconic'),
		'menu-icon-dashicons-backup'					=> __('Backup', 'iconic'),
		'menu-icon-dashicons-clock'						=> __('Clock', 'iconic'),
		'menu-icon-dashicons-lightbulb'					=> __('Lightbulb', 'iconic'),
		'menu-icon-dashicons-microphone'				=> __('Microphone', 'iconic'),
		'menu-icon-dashicons-desktop'					=> __('Desktop', 'iconic'),
		'menu-icon-dashicons-tablet'					=> __('Tablet', 'iconic'),
		'menu-icon-dashicons-smartphone'				=> __('Smartphone', 'iconic'),
		'menu-icon-dashicons-smiley'					=> __('Smiley', 'iconic')
	);
	$icons = apply_filters('iconic_icons', $icons );
	$icon_menu_select = new Iconic_Menu_Select( 'menu-item-icon', __('Menu Icon', 'iconic'), $icons);
}
add_action( 'init', 'iconic' );

/**
 * Custom select field for menu editor
 */
class Iconic_Menu_Select {

	public $fieldname = '';
	public $fieldtitle = '';
	public $fields = '';

	public function __construct( $field_name, $field_title, $fields = array() ) {

		$this->fieldname = $field_name;
		$this->fieldtitle = $field_title;
		$this->fields = $fields;

		add_action( 'menu_item_fields', array( $this, 'field' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'col_nav_menus_init' ) );

		add_filter( 'wp_nav_menu_objects', array( $this, 'set_nav_class' ) );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'replace_with_icon' ), 10, 4 );
	}

	/**
	 * Sets the navigation class
	 *
	 * @param $items
	 * @return mixed
	 */
	function set_nav_class( $items ) {
		foreach ( $items as &$item ) {
			$classes = get_post_meta( $item->ID, '_'.$this->fieldname, true );
			if ( !empty( $classes ) ) {
				$item->classes[] = $classes;
			}
		}
		return $items;
	}

	/**
	 * replace_with_icon
	 *
	 * Replaces a menu item with a span icon
	 *
	 * @param  string $item_output
	 * @param  object $item
	 * @param  int $depth
	 * @param  array $args
	 * @return string
	 */
	function replace_with_icon($item_output, $item, $depth, $args) {

		// does this item have a menu icon associated?
		if (preg_grep ('/^menu-icon/i', $item->classes) ) {

			// grab the custom icon class
			$class = str_replace( 'menu-icon-', '', get_post_meta( $item->ID, '_'.$this->fieldname, true ) );

			// add the dashicon class when using dashicons
			if ( strpos($class, 'dashicons' ) !== false ) $class .= ' dashicons';

			// find the anchor text
			preg_match('#<a.*?>(.*)?<\/a>#', $item_output, $matches);

			// replace the anchor text with an icon span
			$item_output = str_replace('>'.$matches[1].'</a>', '>'.'<span class="'.$class.'"></span><span class="sr-only">'.$matches[1].'</span>'.'</a>', $item_output);

		}

		return $item_output;
	}

	/**
	 * We may be able to add our extra fields in the PHP side of things, but this doesnt fix new menu entries,
	 * which need JS help
	 */
	function col_nav_menus_init() {
		global $pagenow;

		// if menus screen
		if ( 'nav-menus.php' == $pagenow ) {
			add_action( 'admin_print_footer_scripts', array( $this, 'nav_menus_js' ), 1000 );
		}
	}

	/**
	 * Creates this field in new menu items as they're added via the frontend UI
	 */
	function nav_menus_js() {
		$options = '';
		foreach ( $this->fields as $option => $prettyname ) {
			$options .= '<option value="'.$option.'">'.$prettyname.'</option>';
		}
		?>
		<script type="application/javascript">
			(function($){
				$(document).ajaxStop(function(){
					var menutoedit = $('#menu-to-edit');
					menutoedit.find('.menu-item').each(function(){
						if ( !$(this).has('.<?php echo $this->fieldname; ?>-id').length ) {
							var item_id = $('.menu-item-data-db-id', this).val();
							$(".field-description", this).after(
								'<p class="field-<?php echo $this->fieldname; ?> description-wide"><label for="<?php echo $this->fieldname; ?>-'+item_id+'"><?php echo $this->fieldtitle; ?><br><select id="<?php echo $this->fieldname; ?>--'+item_id+'" class="<?php echo $this->fieldname; ?>-id" name="<?php echo $this->fieldname; ?>[' + item_id + ']"><?php echo $options; ?></select></label></p>'
							);
						}
					});
				});
			})(jQuery);
		</script>
		<?php
	}

	/**
	 * @param $item_id
	 * @param $item
	 */
	function field( $item_id, $item ) {
		$value = get_post_meta( $item_id, '_'.$this->fieldname, true );
		?>
		<p class="field-<?php echo $this->fieldname; ?> description-wide">
			<label for="<?php echo $this->fieldname; ?>-<?php echo $item_id; ?>">
				<?php echo $this->fieldtitle; ?><br>
				<select id="<?php echo $this->fieldname; ?>-<?php echo $item_id; ?>" class="<?php echo $this->fieldname; ?>-id" name="<?php echo $this->fieldname; ?>[<?php echo $item_id; ?>]">
					<?php
					foreach ( $this->fields as $option => $prettyname ) {
						?><option value="<?php echo $option; ?>" <?php selected( $value, $option ); ?>><?php echo $prettyname; ?></option><?php
					}
					?>
				</select>
			</label>
		</p>
	<?php
	}

	/**
	 * @param $post_id
	 * @param $post
	 * @return mixed
	 */
	function save( $post_id, $post ) {

		if ( ! current_user_can( 'edit_posts' ) )
			return $post_id;

		if ( ! isset( $_POST[ '_wp_http_referer' ] ) || ! preg_match( "/nav-menus\.php/", $_POST[ '_wp_http_referer' ] ) )
			return $post_id;

		// not autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		if ( $post->post_type != 'nav_menu_item' )
			return $post_id;

		if ( isset( $_POST[$this->fieldname][$post_id] ) ) {
			update_post_meta( $post_id, '_'.$this->fieldname, $_POST[$this->fieldname][$post_id] );
		} else {
			delete_post_meta( $post_id, '_'.$this->fieldname );
		}

	}
}

/**
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
function iconic_nav_menu_edit_walker( $class, $menu_id ) {
	return 'Iconic_Walker_Nav_Menu_Edit';
}
add_filter( 'wp_edit_nav_menu_walker', 'iconic_nav_menu_edit_walker', 11, 2 );

class Iconic_Walker_Nav_Menu_Edit extends Walker_Nav_Menu  {

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)'), $item->title );
		}

		$title = empty( $item->label ) ? $title : $item->label;

		?>
	<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
		<dl class="menu-item-bar">
			<dt class="menu-item-handle">
				<span class="item-title"><?php echo esc_html( $title ); ?></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
							echo wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'move-up-menu-item',
										'menu-item' => $item_id,
									),
									remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
								),
								'move-menu_item'
							);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
							echo wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'move-down-menu-item',
										'menu-item' => $item_id,
									),
									remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
								),
								'move-menu_item'
							);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
						echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e( 'Edit Menu Item' ); ?></a>
					</span>
			</dt>
		</dl>

		<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
			<?php if( 'custom' == $item->type ) : ?>
				<p class="field-url description description-wide">
					<label for="edit-menu-item-url-<?php echo $item_id; ?>">
						<?php _e( 'URL' ); ?><br />
						<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
					</label>
				</p>
			<?php endif; ?>
			<p class="description description-thin">
				<label for="edit-menu-item-title-<?php echo $item_id; ?>">
					<?php _e( 'Navigation Label' ); ?><br />
					<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
				</label>
			</p>
			<p class="description description-thin">
				<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
					<?php _e( 'Title Attribute' ); ?><br />
					<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
				</label>
			</p>
			<p class="field-link-target description">
				<label for="edit-menu-item-target-<?php echo $item_id; ?>">
					<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
					<?php _e( 'Open link in a new window/tab' ); ?>
				</label>
			</p>
			<p class="field-css-classes description description-thin">
				<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
					<?php _e( 'CSS Classes (optional)' ); ?><br />
					<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
				</label>
			</p>
			<p class="field-xfn description description-thin">
				<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
					<?php _e( 'Link Relationship (XFN)' ); ?><br />
					<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
				</label>
			</p>
			<p class="field-description description description-wide">
				<label for="edit-menu-item-description-<?php echo $item_id; ?>">
					<?php _e( 'Description' ); ?><br />
					<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
					<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
				</label>
			</p>

			<?php do_action( 'menu_item_fields', $item_id, $item ); ?>

			<div class="menu-item-actions description-wide submitbox">
				<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
					<p class="link-to-original">
						<?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
					</p>
				<?php endif; ?>
				<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
				echo wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'delete-menu-item',
							'menu-item' => $item_id,
						),
						remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
					),
					'delete-menu_item_' . $item_id
				); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php	echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
				?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
			</div>

			<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
			<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
			<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
			<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
			<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
			<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
		</div><!-- .menu-item-settings-->
		<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
}
?>