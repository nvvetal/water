<?php
/**
 Plugin Name: WP-SimpleViewer
 Plugin URI: http://www.simpleviewer.net/simpleviewer/support/wp-simpleviewer/
 Description: Create SimpleViewer galleries with WordPress
 Author: SimpleViewer Inc.
 Version: 2.3.2.4
 Author URI: http://www.simpleviewer.net/
 Text Domain: simpleviewer
 */

/**
 * SimpleViewer plugin class
 */
class SimpleViewer {

	public $version = '2.3.2.4';
	private $required_core = false;

	/**
	 * Initalize plugin by registering hooks
	 */
	function __construct() {

		add_action('admin_init', array(&$this, 'add_setting'));
		add_action('admin_menu', array(&$this, 'add_menu'));
		add_action('admin_head', array(&$this, 'add_javascript'));
		add_action('admin_enqueue_scripts', array(&$this, 'add_scripts_admin'));

		if (!is_admin()) {
			add_action('the_posts', array(&$this, 'shortcode_check'));
		}

		add_action('media_buttons_context', array(&$this, 'add_media_button'));

		add_action('save_post', array(&$this, 'save_post_data'));

		if ($this->is_pro()) {
			add_filter('upgrader_pre_install', array(&$this, 'backup_pro'));
			add_filter('upgrader_post_install', array(&$this, 'restore_pro'));
		}

		add_shortcode('simpleviewer', array(&$this, 'shortcode_handler'));
	}

	/**
	 * Is pro
	 *
	 * @return boolean success
	 */
	function is_pro() {
		$file = plugin_dir_path(__FILE__) . 'svcore/js/simpleviewer.js';
		$contents = file_get_contents($file);
		return strpos($contents, 'SimpleViewer-Pro') !== false;
	}

	/**
	 * Add setting
	 *
	 * @return void
	 */
	function add_setting() {
		register_setting('simpleviewer', 'simpleviwer_options');
	}

	/**
	 * Add menu
	 *
	 * @return void
	 */
	function add_menu() {
		add_menu_page('WP-SimpleViewer', 'SimpleViewer', 'edit_posts', 'sv-manage-galleries', array(&$this, 'manage_galleries_page'), plugins_url('img/icon_16.png', __FILE__));
		add_submenu_page('sv-manage-galleries', 'WP-SimpleViewer - Manage Galleries', 'Manage Galleries', 'edit_posts', 'sv-manage-galleries', array(&$this, 'manage_galleries_page'));
		add_submenu_page('sv-manage-galleries', 'WP-SimpleViewer - Help', 'Help', 'edit_posts', 'sv-help', array(&$this, 'help_page'));
	}

	/**
	 * Add JavaScript
	 *
	 * @return void
	 */
	function add_javascript() {
		$current_screen = get_current_screen();
		$post_type = !empty($current_screen->post_type) ? $current_screen->post_type : 'post';
?>
		<script type="text/javascript">
			// <![CDATA[
			var svPostType = '<?php echo $post_type; ?>';

			(function() {

				if (typeof jQuery === 'undefined') {
					return;
				}

				jQuery(document).ready(function() {
					if (typeof SV === 'undefined' || typeof SV.Gallery === 'undefined') {
						return;
					}
					SV.Gallery.configUrl = "<?php echo wp_nonce_url(plugins_url('sv-config.php', __FILE__), 'sv_add_gallery', 'sv_add_gallery_nonce'); ?>";
					jQuery('#sv-media-button').click(function() {
						if (typeof SV === 'undefined' || typeof SV.Gallery === 'undefined' || typeof SV.Gallery.embed === 'undefined' || typeof SV.Gallery.embed.apply !== 'function') {
							return;
						}
						SV.Gallery.embed.apply(SV.Gallery);
					});
				});

			}());
			// ]]>
		</script>
<?php
	}

	/**
	 * Add scripts admin
	 *
	 * @param string hook
	 * @return
	 */
	function add_scripts_admin($hook) {

		$generate = $hook === 'post.php' || $hook === 'post-new.php';
		$edit = preg_match('/sv-manage-galleries/', $hook);
		$help = preg_match('/sv-help/', $hook);

		if ($generate || $edit) {
			wp_enqueue_script('jquery');
		}

		if ($generate) {
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_register_script('sv_script_admin_generate', plugins_url('js/generate.js', __FILE__), array('jquery', 'thickbox'), $this->version);
			wp_enqueue_script('sv_script_admin_generate');
		}

		if ($edit) {
			wp_register_script('sv_script_admin_table', plugins_url('js/table.js', __FILE__), array('jquery'), $this->version);
			wp_register_script('sv_script_admin_edit', plugins_url('js/edit.js', __FILE__), array('jquery'), $this->version);
			wp_enqueue_script('sv_script_admin_table');
			wp_enqueue_script('sv_script_admin_edit');
			wp_register_style('sv_style_admin_edit', plugins_url('css/edit.css', __FILE__), array(), $this->version);
			wp_enqueue_style('sv_style_admin_edit');
		}

		if ($help) {
			wp_register_style('sv_style_admin_help', plugins_url('css/help.css', __FILE__), array(), $this->version);
			wp_enqueue_style('sv_style_admin_help');
		}
	}

	/**
	 * Shortcode check
	 *
	 * @return array posts
	 */
	function shortcode_check($posts) {
		if (!empty($posts) && !$this->required_core) {
			foreach ($posts as $post) {
				if (preg_match('/\[simpleviewer.*?gallery_id="[1-9][0-9]*".*?\]/i', $post->post_content)) {
					$this->required_core = true;
					$this->add_scripts_wp_core();
					break;
				}
			}
		}
		return $posts;
	}

	/**
	 * Add scripts wp core
	 *
	 * @return void
	 */
	function add_scripts_wp_core() {
		wp_register_script('sv_script_wp_core', plugins_url('svcore/js/simpleviewer.js', __FILE__), array(), $this->version);
		wp_enqueue_script('sv_script_wp_core');
	}

	/**
	 * Add media button
	 *
	 * @return
	 */
	function add_media_button($context) {
		$current_screen = get_current_screen();
		$post_type = !empty($current_screen->post_type) ? $current_screen->post_type : 'post';

		if ($post_type === 'attachment' || ($post_type === 'page' && !current_user_can('edit_pages')) || ($post_type === 'post' && !current_user_can('edit_posts'))) {
			return;
		}

		$context .= '<a id="sv-media-button" class="button" href="#" title="Add a SimpleViewer Gallery to your ' . $post_type . '"><img src="' . plugins_url('img/icon_16.png', __FILE__) . '" width="16" height="16" alt="button" /> Add SimpleViewer Gallery</a>';

		return $context;
	}

	/**
	 * Save post data
	 *
	 * @param string post id
	 * @return
	 */
	function save_post_data($post_id) {

		if ((isset($_POST['post_type']) && $_POST['post_type'] === 'attachment') || !current_user_can('edit_post', $post_id) || ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id))) {
			return;
		}

		$sv_term_id = get_post_meta($post_id, '_sv_term_id', true);
		if ($sv_term_id === '') {
			update_post_meta($post_id, '_sv_term_id', 'update');
			return;
		}

		$post_record = get_post($post_id);

		preg_match_all('/\[simpleviewer.*?gallery_id="([1-9][0-9]*)".*?\]/i', $post_record->post_content, $matches, PREG_SET_ORDER);

		if ($matches) {
			$gallery_path = $this->get_gallery_path();
			for ($i = 0; $i < count($matches); $i++) {
				$gallery_filename = $gallery_path . intval($matches[$i][1]) . '.xml';
				if (file_exists($gallery_filename)) {
					$this->set_post_id($gallery_filename, $post_id);
				}
			}
		}
	}

	/**
	 * Backup pro svcore folder
	 *
	 * @return void
	 */
	function backup_pro() {
		$from = plugin_dir_path(__FILE__) . 'svcore';
		$to = $this->get_upload_dir() . 'svcore_backup';
		$this->copy_directory($from, $to);
	}

	/**
	 * Restore pro svcore folder
	 *
	 * @return void
	 */
	function restore_pro() {
		$to = plugin_dir_path(__FILE__) . 'svcore';
		$from = $this->get_upload_dir() . 'svcore_backup';
		$this->delete_directory($to);
		$this->copy_directory($from, $to);
		$this->delete_directory($from);
	}

	/**
	 * Shortcode handler
	 *
	 * @param array attributes
	 * @return string embed code
	 */
	function shortcode_handler($atts) {
		extract(shortcode_atts(array('gallery_id'=>'0'), $atts));

		$clean_gallery_id = intval($this->clean_integer($gallery_id));

		if ($clean_gallery_id > 0) {

			$gallery_path = $this->get_gallery_path();
			$gallery_filename = $gallery_path . $clean_gallery_id . '.xml';

			if (file_exists($gallery_filename)) {

				$custom_values = $this->get_custom_values($gallery_filename);

				$gallery_width = $custom_values['e_g_width'];

				$gallery_height = $custom_values['e_g_height'];

				$background_color = $custom_values['e_bgColor'];

				$use_flash = $custom_values['e_useFlash'];

				$gallery_url = plugins_url('config.php?gallery_id=' . $clean_gallery_id, __FILE__);

				$string_builder = '<!--START SIMPLEVIEWER EMBED-->' . PHP_EOL;
				$string_builder .= '<script type="text/javascript">' . PHP_EOL;
				$string_builder .= '	var flashvars' . $clean_gallery_id . ' = {};' . PHP_EOL;
				$string_builder .= '	flashvars' . $clean_gallery_id . '.galleryURL = "' . $gallery_url . '";' . PHP_EOL;
				$string_builder .= '	simpleviewer.ready(function() {' . PHP_EOL;
				$string_builder .= '		simpleviewer.load("sv-container-' . $clean_gallery_id . '", "' . $gallery_width . '", "' . $gallery_height . '", "' . $background_color . '", ' . $use_flash . ', flashvars' . $clean_gallery_id . ');' . PHP_EOL;
				$string_builder .= '	});' . PHP_EOL;
				$string_builder .= '</script>' . PHP_EOL;
				$string_builder .= '<div id="sv-container-' . $clean_gallery_id . '"></div>' . PHP_EOL;
				$string_builder .= '<!--END SIMPLEVIEWER EMBED-->' . PHP_EOL;

				return $string_builder;
			} else {
				return '<div><p>SimpleViewer Gallery Id ' . $clean_gallery_id . ' has been deleted.</p></div>' . PHP_EOL;
			}
		} else {
			return '<div><p>SimpleViewer Gallery Id cannot be found.</p></div>' . PHP_EOL;
		}
	}

	/**
	 * Help page
	 *
	 * @return void
	 */
	function help_page() {
?>
		<div id="sv-help-page" class="wrap">

			<h2><img src="<?php echo plugins_url('img/icon_32.png', __FILE__); ?>" width="32" height="32" alt="logo" />&nbsp;WP-SimpleViewer - Help</h2>

			<p>
				<a href = "http://www.simpleviewer.net/simpleviewer/support/wp-simpleviewer/">Get support and view WP-SimpleViewer documentation.</a>
			</p>

		</div>
<?php
	}

	/**
	 * Add footer links
	 *
	 * @return void
	 */
	function add_footer_links() {
		$plugin_data = get_plugin_data(__FILE__);
		printf('%1$s Plugin | Version %2$s | By %3$s<br />', $plugin_data['Title'], $plugin_data['Version'], $plugin_data['Author']);
	}

	/**
	 * Get reset values
	 *
	 * @return array reset values
	 */
	function get_reset_values() {

		$reset_values = array();

		$reset_values['title'] = 'SimpleViewer Gallery';
		$reset_values['useFlickr'] = 'false';
		$reset_values['flickrUserName'] = '';
		$reset_values['flickrTags'] = '';
		$reset_values['galleryStyle'] = 'COMPACT';
		$reset_values['thumbPosition'] = 'BOTTOM';
		$reset_values['frameWidth'] = '20';
		$reset_values['maxImageWidth'] = '800';
		$reset_values['maxImageHeight'] = '600';
		$reset_values['textColor'] = 'ffffff';
		$reset_values['frameColor'] = 'ffffff';
		$reset_values['showOpenButton'] = 'true';
		$reset_values['showFullscreenButton'] = 'true';
		$reset_values['thumbRows'] = '1';
		$reset_values['thumbColumns'] = '5';
		$reset_values['e_library'] = 'media';
		$reset_values['e_featuredImage'] = 'true';
		$reset_values['e_mediaOrder'] = 'ascending';
		$reset_values['e_nextgenGalleryId'] = '';
		$reset_values['e_picasaUserId'] = '';
		$reset_values['e_picasaAlbumName'] = '';
		$reset_values['e_g_width'] = '100%';
		$reset_values['e_g_height'] = '600px';
		$reset_values['e_bgColor'] = '222222';
		$reset_values['e_backgroundTransparent'] = 'false';
		$reset_values['e_useFlash'] = 'true';
		$reset_values['postID'] = '0';

		return $reset_values;
	}

	/**
	 * Get values
	 *
	 * @return array values
	 */
	function get_values($filename) {

		$values = array();

		if (file_exists($filename)) {

			$dom_doc = new DOMDocument('1.0', 'UTF-8');
			$dom_doc->load($filename);

			$settings_tags = $dom_doc->getElementsByTagName('simpleviewergallery');
			$settings_tag = $settings_tags->item(0);

			if ($settings_tag->hasAttributes()) {
				foreach ($settings_tag->attributes as $attribute) {
					$name = $attribute->nodeName;
					$value = $attribute->nodeValue;
					$values[$name] = $value;
				}
			}
		}

		return $values;
	}

	/**
	 * Get default values
	 *
	 * @return array default values
	 */
	function get_default_values() {

		$reset_values = $this->get_reset_values();

		$default_filename = $this->get_default_filename();

		$default_values = file_exists($default_filename) ? $this->get_values($default_filename) : array();

		return array_merge($reset_values, $default_values);
	}

	/**
	 * Get custom values
	 *
	 * @param string gallery filename
	 * @return array custom values
	 */
	function get_custom_values($gallery_filename) {

		$default_values = $this->get_default_values();

		$reset_values = $this->strip_options($default_values, true);

		$custom_values = file_exists($gallery_filename) ? $this->get_values($gallery_filename) : array();

		return array_merge($reset_values, $custom_values);
	}

	/**
	 * Get keys
	 *
	 * @return array keys
	 */
	function get_keys() {
		return array('title', 'useFlickr', 'flickrUserName', 'flickrTags', 'galleryStyle', 'thumbPosition', 'frameWidth', 'maxImageWidth', 'maxImageHeight', 'textColor', 'frameColor', 'showOpenButton', 'showFullscreenButton', 'thumbRows', 'thumbColumns', 'e_library', 'e_featuredImage', 'e_mediaOrder', 'e_nextgenGalleryId', 'e_picasaUserId', 'e_picasaAlbumName', 'e_g_width', 'e_g_height', 'e_bgColor', 'e_backgroundTransparent', 'e_useFlash', 'postID');
	}

	/**
	 * Get pro options
	 *
	 * @param simplexmlelement custom values
	 * @return string pro options
	 */
	function get_pro_options($custom_values) {

		$pro_options = '';

		$keys = $this->get_keys();
		$keys_lower = array_map('strtolower', $keys);

		foreach ($custom_values as $key=>$value) {
			if (!in_array(strtolower($key), $keys_lower, true)) {
				$pro_options .= $key . '="' . $value . '"' . "\n";
			}
		}

		return $pro_options;
	}

	/**
	 * Strip options
	 *
	 * @param simplexmlelement custom values
	 * @return array options
	 */
	function strip_options($custom_values, $type) {

		$options = array();

		$keys = $this->get_keys();
		$keys_lower = array_map('strtolower', $keys);

		foreach ($custom_values as $key=>$value) {
			if (in_array(strtolower($key), $keys_lower, true) === $type) {
				$options[$key] = $value;
			}
		}

		return $options;
	}

	/**
	 * Get post id
	 *
	 * @param string gallery filename
	 * @return string post id
	 */
	function get_post_id($gallery_filename) {

		$post_id = '0';

		if (file_exists($gallery_filename)) {

			$dom_doc = new DOMDocument('1.0', 'UTF-8');
			$dom_doc->load($gallery_filename);

			$settings_tags = $dom_doc->getElementsByTagName('simpleviewergallery');
			$settings_tag = $settings_tags->item(0);

			$post_id = $settings_tag->hasAttribute('postID') ? $settings_tag->getAttribute('postID') : '0';
		}

		return $post_id;
	}

	/**
	 * Get upload directory
	 *
	 * @return string upload directory
	 */
	function get_upload_dir() {
		$upload_dir = wp_upload_dir();
		return $upload_dir['basedir'] . '/';
	}

	/**
	 * Get gallery path
	 *
	 * @return string gallery path
	 */
	function get_gallery_path() {
		return $this->get_upload_dir();
	}

	/**
	 * Get default filename
	 *
	 * @return string default filename
	 */
	function get_default_filename() {
		$gallery_path = $this->get_gallery_path();
		return $gallery_path . 'default.xml';
	}

	/**
	 * Get all galleries
	 *
	 * @param string gallery path
	 * @return array galleries
	 */
	function get_all_galleries($gallery_path) {
		$array = @scandir($gallery_path);
		return $array ? array_filter($array, array(&$this, 'filter_gallery')) : array();
	}

	/**
	 * Sort galleries ascending
	 *
	 * @param string gallery
	 * @param string gallery
	 * @return integer gallery
	 */
	function sort_galleries_ascending($a, $b) {
		$a_intval = intval(pathinfo($a, PATHINFO_FILENAME));
		$b_intval = intval(pathinfo($b, PATHINFO_FILENAME));
		if ($a_intval === $b_intval) {
			return 0;
		}
		return $a_intval < $b_intval ? -1 : 1;
	}

	/**
	 * Sort galleries descending
	 *
	 * @param string gallery
	 * @param string gallery
	 * @return integer gallery
	 */
	function sort_galleries_descending($a, $b) {
		$a_intval = intval(pathinfo($a, PATHINFO_FILENAME));
		$b_intval = intval(pathinfo($b, PATHINFO_FILENAME));
		if ($a_intval === $b_intval) {
			return 0;
		}
		return $a_intval > $b_intval ? -1 : 1;
	}

	/**
	 * Filter element
	 *
	 * @param string value
	 * @return boolean success
	 */
	function filter_element($value) {
		return $value !== '.' && $value !== '..';
	}

	/**
	 * Filter gallery
	 *
	 * @param string value
	 * @return boolean success
	 */
	function filter_gallery($value) {
		return preg_match('/^[1-9][0-9]*\.xml$/i', $value);
	}

	/**
	 * Filter image media
	 *
	 * @param string attachment
	 * @return boolean success
	 */
	function filter_image_media($attachment) {
		$mime = array('image/gif', 'image/jpeg', 'image/png');
		return in_array($attachment->post_mime_type, $mime);
	}

	/**
	 * Clean integer
	 *
	 * @param string integer
	 * @return string clean integer
	 */
	function clean_integer($integer) {
		return strval(abs(intval(filter_var($integer, FILTER_SANITIZE_NUMBER_INT))));
	}

	/**
	 * Clean percentage
	 *
	 * @param string percentage
	 * @return string clean percentage
	 */
	function clean_percentage($percentage) {
		return strval(min(abs(intval(filter_var($percentage, FILTER_SANITIZE_NUMBER_INT))), 100));
	}

	/**
	 * Clean dimension
	 *
	 * @param string dimension
	 * @return string clean dimension
	 */
	function clean_dimension($dimension) {
		$dimension_string = $this->clean_integer($dimension);
		return substr(trim($dimension), -1) === '%' ? $this->clean_percentage($dimension_string) . '%' : $dimension_string . 'px';
	}

	/**
	 * Clean color
	 *
	 * @param string color
	 * @return string clean color
	 */
	function clean_color($color) {
		$output = strtolower(str_replace('0x', '', ltrim(trim($color), '#')));
		$length = strlen($output);
		if ($length < 3) {
			$output = str_pad($output, 3, '0');
		} elseif ($length > 3 && $length < 6) {
			$output = str_pad($output, 6, '0');
		} elseif ($length > 6) {
			$output = substr($output, 0, 6);
		}
		$new_length = strlen($output);
		if ($new_length === 3) {
			$r = dechex(hexdec(substr($output, 0, 1)));
			$g = dechex(hexdec(substr($output, 1, 1)));
			$b = dechex(hexdec(substr($output, 2, 1)));
			$output = $r . $r . $g . $g . $b . $b;
		} elseif ($new_length === 6) {
			$r = str_pad(dechex(hexdec(substr($output, 0, 2))), 2, '0', STR_PAD_LEFT);
			$g = str_pad(dechex(hexdec(substr($output, 2, 2))), 2, '0', STR_PAD_LEFT);
			$b = str_pad(dechex(hexdec(substr($output, 4, 2))), 2, '0', STR_PAD_LEFT);
			$output = $r . $g . $b;
		}
		return $output;
	 }

	/**
	 * Build gallery
	 *
	 * @param string gallery filename
	 * @param array custom values
	 * @return void
	 */
	function build_gallery($gallery_filename, $custom_values) {

		$dom_doc = new DOMDocument('1.0', 'UTF-8');
		$dom_doc->formatOutput = true;

		$settings_tag = $dom_doc->createElement('simpleviewergallery');

		$clean_values = array();
		$clean_values['title'] = trim(strip_tags(stripslashes($custom_values['title']), '<a><b><br><font><i><u>'));
		if ($custom_values['e_library'] === 'flickr') {
			$clean_values['useFlickr'] = 'true';
			$clean_values['flickrUserName'] = trim($custom_values['flickrUserName']);
			$clean_values['flickrTags'] = trim($custom_values['flickrTags']);
		} else {
			$clean_values['useFlickr'] = 'false';
			$clean_values['flickrUserName'] = '';
			$clean_values['flickrTags'] = '';
		}
		$clean_values['galleryStyle'] = $custom_values['galleryStyle'];
		$clean_values['thumbPosition'] = $custom_values['thumbPosition'];
		$clean_values['frameWidth'] = $this->clean_integer($custom_values['frameWidth']);
		$clean_values['maxImageWidth'] = $this->clean_integer($custom_values['maxImageWidth']);
		$clean_values['maxImageHeight'] = $this->clean_integer($custom_values['maxImageHeight']);
		$clean_values['textColor'] = $this->clean_color($custom_values['textColor']);
		$clean_values['frameColor'] = $this->clean_color($custom_values['frameColor']);
		$clean_values['showOpenButton'] = isset($custom_values['showOpenButton']) ? $custom_values['showOpenButton'] : 'false';
		$clean_values['showFullscreenButton'] = isset($custom_values['showFullscreenButton']) ? $custom_values['showFullscreenButton'] : 'false';
		$clean_values['thumbRows'] = $this->clean_integer($custom_values['thumbRows']);
		$clean_values['thumbColumns'] = $this->clean_integer($custom_values['thumbColumns']);
		$clean_values['e_library'] = $custom_values['e_library'];
		$clean_values['e_featuredImage'] = '';
		$clean_values['e_mediaOrder'] = '';
		if ($custom_values['e_library'] === 'media') {
			$clean_values['e_featuredImage'] = isset($custom_values['e_featuredImage']) ? $custom_values['e_featuredImage'] : 'false';
			$clean_values['e_mediaOrder'] = $custom_values['e_mediaOrder'];
		}
		$clean_values['e_nextgenGalleryId'] = '';
		if ($custom_values['e_library'] === 'nextgen') {
			$clean_values['e_nextgenGalleryId'] = trim($custom_values['e_nextgenGalleryId']);
		}
		$clean_values['e_picasaUserId'] = '';
		$clean_values['e_picasaAlbumName'] = '';
		if ($custom_values['e_library'] === 'picasa') {
			$clean_values['e_picasaUserId'] = trim($custom_values['e_picasaUserId']);
			$clean_values['e_picasaAlbumName'] = trim($custom_values['e_picasaAlbumName']);
		}
		$clean_values['e_g_width'] = $this->clean_dimension($custom_values['e_g_width']);
		$clean_values['e_g_height'] = $this->clean_dimension($custom_values['e_g_height']);
		$clean_values['e_bgColor'] = isset($custom_values['e_backgroundTransparent']) && $custom_values['e_backgroundTransparent'] === 'true' ? 'transparent' : $this->clean_color($custom_values['e_bgColor']);
		$clean_values['e_backgroundTransparent'] = isset($custom_values['e_backgroundTransparent']) ? $custom_values['e_backgroundTransparent'] : 'false';
		$clean_values['e_useFlash'] = isset($custom_values['e_useFlash']) ? $custom_values['e_useFlash'] : 'false';

		$pro_options = explode("\n", $custom_values['proOptions']);
		$all_options = array();
		foreach ($pro_options as $pro_option) {
			$attrs = explode('=', trim($pro_option), 2);
			if (count($attrs) === 2) {
				$all_options[$this->remove_whitespace($attrs[0])] = preg_replace('/^([`\'"])(.*)\\1$/', '\\2', trim(stripslashes($attrs[1])));
			}
		}

		$accepted_options = $this->strip_options($all_options, false);

		$complete_options = array_merge($clean_values, $accepted_options);

		foreach ($complete_options as $key=>$value) {
			$settings_tag->setAttribute($key, $value);
		}

		$dom_doc->appendChild($settings_tag);
		$dom_doc->save($gallery_filename);
	}

	/**
	 * Set post id
	 *
	 * @param string gallery filename
	 * @param string post id
	 * @return void
	 */
	function set_post_id($gallery_filename, $post_id) {

		if (file_exists($gallery_filename)) {

			$dom_doc = new DOMDocument('1.0', 'UTF-8');
			$dom_doc->preserveWhiteSpace = false;
			$dom_doc->formatOutput = true;
			$dom_doc->load($gallery_filename);

			$settings_tags = $dom_doc->getElementsByTagName('simpleviewergallery');
			$settings_tag = $settings_tags->item(0);

			$settings_tag->setAttribute('postID', $post_id);
			$dom_doc->save($gallery_filename);
		}
	}

	/**
	 * Get term
	 *
	 * @param string actual
	 * @param string total
	 * @return string term
	 */
	function get_term($actual, $total) {
		$term = '';
		switch ($actual) {
			case 0:
				$term = 'no galleries';
				break;
			case 1:
				$term = $actual === $total ? 'all galleries' : '1 gallery';
				break;
			default:
				$term = $actual === $total ? 'all galleries' : $actual . ' galleries';
				break;
		}
		return $term;
	}

	/**
	 * Manage galleries page
	 *
	 * @return void
	 */
	function manage_galleries_page() {
?>
		<div id="sv-manage-galleries-page" class="wrap">

			<h2><img src="<?php echo plugins_url('img/icon_32.png', __FILE__); ?>" width="32" height="32" alt="logo" />&nbsp;WP-SimpleViewer - Manage Galleries</h2>
<?php
			if (isset($_GET['sv-action']) && $_GET['sv-action'] !== '') {
				switch ($_GET['sv-action']) {
					case 'edit-gallery':
						$sv_edit_gallery_nonce = isset($_GET['sv_edit_gallery_nonce']) ? $_GET['sv_edit_gallery_nonce'] : '';
						if (!wp_verify_nonce($sv_edit_gallery_nonce, 'sv_edit_gallery')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$gallery_id = $_GET['sv-gallery-id'];
						$this->edit_gallery_form($gallery_id);
						break;
					case 'gallery-edited':
						$sv_gallery_edited_nonce = isset($_POST['sv_gallery_edited_nonce']) ? $_POST['sv_gallery_edited_nonce'] : '';
						if (!wp_verify_nonce($sv_gallery_edited_nonce, 'sv_gallery_edited')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$gallery_path = $this->get_gallery_path();
						$gallery_id = $_POST['sv-gallery-id'];
						$gallery_filename = $gallery_path . $gallery_id . '.xml';
						if (file_exists($gallery_filename)) {
							$post_id = $this->get_post_id($gallery_filename);
							$this->build_gallery($gallery_filename, $_POST);
							$this->set_post_id($gallery_filename, $post_id);
							echo '<div class="updated"><p>Gallery Id ' . $gallery_id . ' successfully edited.</p></div>';
						} else {
							echo '<div class="updated"><p>Gallery Id ' . $gallery_id . ' cannot be found.</p></div>';
						}
						$this->gallery_table();
						break;
					case 'delete-gallery':
						$sv_delete_gallery_nonce = isset($_GET['sv_delete_gallery_nonce']) ? $_GET['sv_delete_gallery_nonce'] : '';
						if (!wp_verify_nonce($sv_delete_gallery_nonce, 'sv_delete_gallery')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$gallery_path = $this->get_gallery_path();
						$gallery_id = $_GET['sv-gallery-id'];
						$gallery_filename = $gallery_path . $gallery_id . '.xml';
						if (file_exists($gallery_filename)) {
							if (unlink($gallery_filename)) {
								echo '<div class="updated"><p>Gallery Id ' . $gallery_id . ' successfully deleted.</p></div>';
							} else {
								echo '<div class="updated"><p>Gallery Id ' . $gallery_id . ' cannot be deleted.</p></div>';
							}
						} else {
							echo '<div class="updated"><p>Gallery Id ' . $gallery_id . ' cannot be found.</p></div>';
						}
						$this->gallery_table();
						break;
					case 'set-defaults':
						$sv_set_defaults_nonce = isset($_GET['sv_set_defaults_nonce']) ? $_GET['sv_set_defaults_nonce'] : '';
						if (!wp_verify_nonce($sv_set_defaults_nonce, 'sv_set_defaults')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$this->set_defaults_form();
						break;
					case 'defaults-set':
						$sv_defaults_set_nonce = isset($_POST['sv_defaults_set_nonce']) ? $_POST['sv_defaults_set_nonce'] : '';
						if (!wp_verify_nonce($sv_defaults_set_nonce, 'sv_defaults_set')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$default_filename = $this->get_default_filename();
						$this->build_gallery($default_filename, $_POST);
						echo '<div class="updated"><p>Custom default values successfully set.</p></div>';
						$this->gallery_table();
						break;
					case 'reset-defaults':
						$sv_reset_defaults_nonce = isset($_GET['sv_reset_defaults_nonce']) ? $_GET['sv_reset_defaults_nonce'] : '';
						if (!wp_verify_nonce($sv_reset_defaults_nonce, 'sv_reset_defaults')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$default_filename = $this->get_default_filename();
						if (file_exists($default_filename)) {
							if (unlink($default_filename)) {
								echo '<div class="updated"><p>Default values successfully reset.</p></div>';
							} else {
								echo '<div class="updated"><p>Default values cannot be reset.</p></div>';
							}
						} else {
							echo '<div class="updated"><p>No custom default values to reset.</p></div>';
						}
						$this->gallery_table();
						break;
					case 'delete-all-data':
						$sv_delete_all_data_nonce = isset($_GET['sv_delete_all_data_nonce']) ? $_GET['sv_delete_all_data_nonce'] : '';
						if (!wp_verify_nonce($sv_delete_all_data_nonce, 'sv_delete_all_data')) {
							echo '<div class="error"><p>Remote submission prohibited.</p></div>';
							$this->gallery_table();
							break;
						}
						$gallery_path = $this->get_gallery_path();
						$galleries = $this->get_all_galleries($gallery_path);
						$galleries_text = 'No galleries to delete.';
						if (!empty($galleries)) {
							$actual = 0;
							foreach ($galleries as $gallery) {
								$gallery_filename = $gallery_path . $gallery;
								if (file_exists($gallery_filename)) {
									$actual = unlink($gallery_filename) ? $actual + 1 : $actual;
								}
							}
							$total = count($galleries);
							$term = $this->get_term($actual, $total);
							$formatted_term = ucfirst($term);
							$galleries_text = $formatted_term . ' successfully deleted.';
						}
						$default_filename = $this->get_default_filename();
						$default_text = 'No custom default values to delete.';
						if (file_exists($default_filename)) {
							$default_text = unlink($default_filename) ? 'All custom default values successfully deleted.' : 'All custom default values cannot be deleted.';
						}
						$options = get_option('simpleviwer_options', array());
						$options_text = 'No options to delete.';
						if (!empty($options)) {
							$options_text = delete_option('simpleviwer_options') ? 'All options successfully deleted.' : 'All options cannot be deleted.';
						}
						echo '<div class="updated"><p>' . $galleries_text . ' ' . $default_text . ' ' . $options_text . '</p></div>';
						$this->gallery_table();
						break;
					default:
						$this->gallery_table();
						break;
				}
			} else {
				$this->gallery_table();
			}
?>
		</div>
<?php
		add_action('in_admin_footer', array(&$this, 'add_footer_links'));
	}

	/**
	 * Gallery table
	 *
	 * @return void
	 */
	function gallery_table() {
		$options = get_option('simpleviewer_options', array());
?>
		<div class="sv-table-buttons">
			<form action="<?php echo admin_url('admin.php'); ?>" method="get">
				<input class="button sv-table-set" title="Set custom default values of the gallery configuration options." type="submit" name="table-set-header" value="Set Defaults" />
				<input type="hidden" name="page" value="sv-manage-galleries" />
				<input type="hidden" name="sv-action" value="set-defaults" />
<?php
				wp_nonce_field('sv_set_defaults', 'sv_set_defaults_nonce', false);
?>
			</form>
			<form action="<?php echo admin_url('admin.php'); ?>" method="get">
				<input class="button sv-table-reset" title="Reset the default values of the gallery configuration options to their original values." type="submit" name="table-reset-header" value="Reset Defaults" />
				<input type="hidden" name="page" value="sv-manage-galleries" />
				<input type="hidden" name="sv-action" value="reset-defaults" />
<?php
				wp_nonce_field('sv_reset_defaults', 'sv_reset_defaults_nonce', false);
?>
			</form>
			<form action="<?php echo admin_url('admin.php'); ?>" method="get">
				<input class="button sv-table-delete" title="Delete all galleries, custom default values and options." type="submit" name="table-delete-header" value="Delete All Data" />
				<input type="hidden" name="page" value="sv-manage-galleries" />
				<input type="hidden" name="sv-action" value="delete-all-data" />
<?php
				wp_nonce_field('sv_delete_all_data', 'sv_delete_all_data_nonce', false);
?>
			</form>
		</div>

		<br />

		<div id="sv-bulk">
			<table class="wp-list-table widefat posts">

				<thead>
					<tr>
						<th>Gallery Id</th>
						<th>Last Modified Date</th>
						<th>Page/Post Title</th>
						<th>Gallery Title</th>
						<th>View Page/Post</th>
						<th>Edit Gallery</th>
						<th>Delete Gallery</th>
					</tr>
				</thead>

				<tbody>
<?php
				$gallery_path = $this->get_gallery_path();
				$galleries = $this->get_all_galleries($gallery_path);
				if (!empty($galleries)) {
					if (!isset($options['order']) || $options['order']) {
						usort($galleries, array(&$this, 'sort_galleries_descending'));
					} else {
						usort($galleries, array(&$this, 'sort_galleries_ascending'));
					}
					foreach ($galleries as $gallery) {
						$gallery_id = pathinfo($gallery, PATHINFO_FILENAME);
						$gallery_filename = $gallery_path . $gallery;
						if (file_exists($gallery_filename)) {
							$post_id = $this->get_post_id($gallery_filename);
							$post = get_post($post_id);
							$post_record = $post_id !== '0' && $post;
							$custom_values = $this->get_custom_values($gallery_filename);
							$gallery_title = !empty($custom_values['title']) ? htmlspecialchars($custom_values['title']) : '<i>Untitled</i>';
							$post_type = get_post_type($post_id);
							$post_type_text = ucfirst(strtolower($post_type));
							$post_trashed = get_post_status($post_id) === 'trash';
?>
							<tr>
								<td><?php echo $gallery_id; ?></td>
								<td><?php echo date('d F Y H:i:s', filemtime($gallery_filename)); ?></td>
								<td>
<?php
									if ($post_trashed) {
										echo '<i>' . $post_type_text . ' has been trashed.</i>';
									} elseif ($post_record) {
										$post_title = get_the_title($post_id);
										$post_title = !empty($post_title) ? $post_title : '<i>Untitled</i>';
										echo $post_title;
									} else {
										echo '<i>Page/post does not exist.</i>';
									}
?>
								</td>
								<td><?php echo $gallery_title; ?></td>
								<td>
<?php
									if ($post_trashed) {
										echo '<i>' . $post_type_text . ' has been trashed.</i>';
									} elseif ($post_record) {
										$text = 'View ' . $post_type_text;
										echo '<a href="' . get_permalink($post_id) . '" title="' . $text . '">' . $text . '</a>';
									} else {
										echo '<i>Page/post does not exist.</i>';
									}
?>
								</td>
								<td><?php echo '<a href="' . wp_nonce_url(admin_url('admin.php?page=sv-manage-galleries&amp;sv-action=edit-gallery&amp;sv-gallery-id=' . $gallery_id), 'sv_edit_gallery', 'sv_edit_gallery_nonce') . '" title="Edit Gallery">Edit Gallery</a>'; ?></td>
								<td><?php echo '<a class="sv-delete-gallery" href="' . wp_nonce_url(admin_url('admin.php?page=sv-manage-galleries&amp;sv-action=delete-gallery&amp;sv-gallery-id=' . $gallery_id), 'sv_delete_gallery', 'sv_delete_gallery_nonce') . '" title="Delete Gallery">Delete Gallery</a>'; ?></td>
							</tr>
<?php
						}
					}
				} else {
?>
					<tr>
						<td>No galleries found.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
<?php
				}
?>
				</tbody>

				<tfoot>
					<tr>
						<th>Gallery Id</th>
						<th>Last Modified Date</th>
						<th>Page/Post Title</th>
						<th>Gallery Title</th>
						<th>View Page/Post</th>
						<th>Edit Gallery</th>
						<th>Delete Gallery</th>
					</tr>
				</tfoot>

			</table>
		</div>

		<br />

		<div class="sv-table-buttons">
			<form action="<?php echo admin_url('admin.php'); ?>" method="get">
				<input class="button sv-table-set" title="Set custom default values of the gallery configuration options." type="submit" name="table-set-footer" value="Set Defaults" />
				<input type="hidden" name="page" value="sv-manage-galleries" />
				<input type="hidden" name="sv-action" value="set-defaults" />
<?php
				wp_nonce_field('sv_set_defaults', 'sv_set_defaults_nonce', false);
?>
			</form>
			<form action="<?php echo admin_url('admin.php'); ?>" method="get">
				<input class="button sv-table-reset" title="Reset the default values of the gallery configuration options to their original values." type="submit" name="table-reset-footer" value="Reset Defaults" />
				<input type="hidden" name="page" value="sv-manage-galleries" />
				<input type="hidden" name="sv-action" value="reset-defaults" />
<?php
				wp_nonce_field('sv_reset_defaults', 'sv_reset_defaults_nonce', false);
?>
			</form>
			<form action="<?php echo admin_url('admin.php'); ?>" method="get">
				<input class="button sv-table-delete" title="Delete all galleries, custom default values and options." type="submit" name="table-delete-footer" value="Delete All Data" />
				<input type="hidden" name="page" value="sv-manage-galleries" />
				<input type="hidden" name="sv-action" value="delete-all-data" />
<?php
				wp_nonce_field('sv_delete_all_data', 'sv_delete_all_data_nonce', false);
?>
			</form>
		</div>
<?php
	}

	/**
	 * Edit gallery form
	 *
	 * @return void
	 */
	function edit_gallery_form($gallery_id) {
		$gallery_path = $this->get_gallery_path();
		$gallery_filename = $gallery_path . $gallery_id . '.xml';
		$custom_values = $this->get_custom_values($gallery_filename);
		$pro_options = $this->get_pro_options($custom_values);
?>
		<div id="sv-edit-gallery-container" class="wrap sv-custom-wrap">

			<h3>Edit SimpleViewer Gallery Id <?php echo $gallery_id; ?></h3>

			<form id="sv-edit-gallery-form" action="<?php echo admin_url('admin.php?page=sv-manage-galleries&sv-action=gallery-edited'); ?>" method="post">

				<input type="hidden" name="sv-gallery-id" value="<?php echo $gallery_id; ?>" />
<?php
				include_once plugin_dir_path(__FILE__) . 'fieldset.php';
?>
				<div id="sv-edit-action">
					<input id="sv-edit-gallery" class="button sv-button" type="submit" name="edit-gallery" value="Save" />
					<input id="sv-edit-cancel" class="button sv-button" type="button" name="edit-cancel" value="Cancel" />
				</div>
<?php
				wp_nonce_field('sv_gallery_edited', 'sv_gallery_edited_nonce', false);
?>
			</form>

		</div>

		<script type="text/javascript">
			// <![CDATA[
			(function() {

				if (typeof jQuery === 'undefined') {
					return;
				}

				jQuery(document).ready(function() {
					jQuery('#sv-edit-cancel').click(function() {
						jQuery('#sv-edit-gallery, #sv-edit-cancel').prop('disabled', true);
						window.location.href = '<?php echo admin_url('admin.php?page=sv-manage-galleries'); ?>';
					});
				});

			}());
			// ]]>
		</script>
<?php
	}

	/**
	 * Set default values form
	 *
	 * @return void
	 */
	function set_defaults_form() {
		$custom_values = $this->get_default_values();
		$pro_options = $this->get_pro_options($custom_values);
?>
		<div id="sv-set-defaults-container" class="wrap sv-custom-wrap">

			<h3>Set Default Values</h3>

			<form id="sv-set-defaults-form" action="<?php echo admin_url('admin.php?page=sv-manage-galleries&sv-action=defaults-set'); ?>" method="post">
<?php
				include_once plugin_dir_path(__FILE__) . 'fieldset.php';
?>
				<div id="sv-set-action">
					<input id="sv-set-defaults" class="button sv-button" type="submit" name="set-defaults" value="Set" />
					<input id="sv-set-cancel" class="button sv-button" type="button" name="set-cancel" value="Cancel" />
				</div>
<?php
				wp_nonce_field('sv_defaults_set', 'sv_defaults_set_nonce', false);
?>
			</form>

		</div>

		<script type="text/javascript">
			// <![CDATA[
			(function() {

				if (typeof jQuery === 'undefined') {
					return;
				}

				jQuery(document).ready(function() {
					jQuery('#sv-e-library').prop('disabled', true);
					jQuery(':input', '.sv-toggle-source').prop('disabled', true);
					jQuery('#sv-set-cancel').click(function() {
						jQuery('#sv-set-defaults, #sv-set-cancel').prop('disabled', true);
						window.location.href = '<?php echo admin_url('admin.php?page=sv-manage-galleries'); ?>';
					});
				});

			}());
			// ]]>
		</script>
<?php
	}

	/**
	 * Remove whitespace
	 *
	 * @param string input
	 * @return string output
	 */
	function remove_whitespace($input) {
		return preg_replace('/\\s+/', '', $input);
	}

	/**
	 * Get attachments media
	 *
	 * @param string featured image
	 * @param string post id
	 * @return array attachments
	 */
	function get_attachments_media($featured_image, $post_id) {
		$attachments = array();
		if ($featured_image === 'true') {
			$attachments = get_children(array('post_parent'=>$post_id, 'post_type'=>'attachment', 'post_mime_type'=>'image', 'orderby'=>'menu_order', 'order'=>'ASC'));
		} else {
			$attachments = get_children(array('post_parent'=>$post_id, 'post_type'=>'attachment', 'post_mime_type'=>'image', 'orderby'=>'menu_order', 'order'=>'ASC', 'exclude'=>get_post_thumbnail_id($post_id)));
		}
		return array_values(array_filter($attachments, array(&$this, 'filter_image_media')));
	}

	/**
	 * Get attachments NextGEN
	 *
	 * @param string NextGEN gallery id
	 * @return array attachments
	 */
	function get_attachments_nextgen($nextgen_gallery_id) {
		$attachments = array();
		global $wpdb;
		$ngg_options = get_option('ngg_options', array());
		if (isset($ngg_options['galSort']) && isset($ngg_options['galSortDir'])) {
			$attachments = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$nextgen_gallery_id' AND tt.exclude != 1 ORDER BY tt.$ngg_options[galSort] $ngg_options[galSortDir]");
		} else {
			$attachments = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$nextgen_gallery_id' AND tt.exclude != 1");
		}
		return $attachments;
	}

	/**
	 * Get attachments Picasa
	 *
	 * @param string Picasa user id
	 * @param string Picasa album name
	 * @return array attachments
	 */
	function get_attachments_picasa($picasa_user_id, $picasa_album_name) {
		$attachments = array();
		$name = $this->remove_whitespace($picasa_album_name);
		$term = preg_match('/^[0-9]{19}$/', $name) ? 'albumid' : 'album';
		$picasa_feed = 'http://picasaweb.google.com/data/feed/api/user/' . $this->remove_whitespace($picasa_user_id) . '/' . $term . '/' . $name . '?kind=photo&imgmax=1600';
		$entries = @simplexml_load_file($picasa_feed);
		if ($entries) {
			foreach ($entries->entry as $entry) {
				$attachments[] = $entry;
			}
		}
		return $attachments;
	}

	/**
	 * Copy directory
	 *
	 * @param string source
	 * @param string destination
	 * @return boolean success
	 */
	function copy_directory($source, $destination) {
		if (is_link($source)) {
			return symlink(readlink($source), $destination);
		}
		if (is_file($source)) {
			return copy($source, $destination);
		}
		if (!is_dir($destination)) {
			mkdir($destination);
		}
		$array = @scandir($source);
		if ($array) {
			$files = array_filter($array, array(&$this, 'filter_element'));
			foreach ($files as $file) {
				$this->copy_directory($source . '/' . $file, $destination . '/' . $file);
			}
			return true;
		}
		return false;
	}

	/**
	 * Delete directory
	 *
	 * @param string directory
	 * @return boolean success
	 */
	function delete_directory($directory) {
		if (!file_exists($directory)) {
			return false;
		}
		if (is_file($directory)) {
			return unlink($directory);
		}
		$array = @scandir($directory);
		if ($array) {
			$files = array_filter($array, array(&$this, 'filter_element'));
			foreach ($files as $file) {
				$this->delete_directory($directory . '/' . $file);
			}
			return rmdir($directory);
		}
		return false;
	}
}

/**
 * Main
 *
 * @return void
 */
function SimpleViewer() {
	global $SimpleViewer;
	$SimpleViewer = new SimpleViewer();
}

add_action('init', 'SimpleViewer');

/**
 * Check dependency
 *
 * @return void
 */
function sv_check_dependency() {

	// Check PHP version
	if (version_compare(phpversion(), '5.2', '<')) {
		sv_display_error_message('<b>WP-SimpleViewer</b> requires PHP v5.2 or later.', E_USER_ERROR);
	}

	// Check if DOM extention is enabled
	if (!class_exists('DOMDocument')) {
		sv_display_error_message('<b>WP-SimpleViewer</b> requires the DOM extention to be enabled.', E_USER_ERROR);
	}

	// Check WordPress version
	global $wp_version;
	if (version_compare($wp_version, '2.8', '<')) {
		sv_display_error_message('<b>WP-SimpleViewer</b> requires WordPress v2.8 or later.', E_USER_ERROR);
	}

	// Find path to WordPress uploads directory
	$upload_dir = wp_upload_dir();
	$gallery_path = $upload_dir['basedir'] . '/';

	clearstatcache();

	// Create uploads folder and assign full access permissions
	if (!file_exists($gallery_path))
	{
		$old = umask(0);
		if (!@mkdir($gallery_path, 0755, true)) {
			sv_display_error_message('<b>WP-SimpleViewer</b> cannot create the <b>wp-content/uploads</b> folder. Please do this manually and assign full access permissions (755) to it.', E_USER_ERROR);
		}
		@umask($old);
		if ($old !== umask()) {
			sv_display_error_message('<b>WP-SimpleViewer</b> cannot cannot change back the umask after creating the <b>wp-content/uploads</b> folder.', E_USER_ERROR);
		}
	} else {
		if (strncasecmp(php_uname(), 'win', 3) !== 0 && substr(sprintf('%o', fileperms($gallery_path)), -4) !== 0755) {
			$old = umask(0);
			if (!@chmod($gallery_path, 0755)) {
				sv_display_error_message('<b>WP-SimpleViewer</b> cannot assign full access permissions (755) to the <b>wp-content/uploads</b> folder. Please do this manually.', E_USER_ERROR);
			}
			@umask($old);
			if ($old !== umask()) {
				sv_display_error_message('<b>WP-SimpleViewer</b> cannot cannot change back the umask after assigning full access permissions (755) to the <b>wp-content/uploads</b> folder.', E_USER_ERROR);
			}
		}
	}
}

/**
 * Display error message
 *
 * @param string error message
 * @param integer error type
 */
function sv_display_error_message($error_msg, $error_type) {
	if(isset($_GET['action']) && $_GET['action'] === 'error_scrape') {
		echo $error_msg;
		exit;
    } else {
		trigger_error($error_msg, $error_type);
    }
}

register_activation_hook(__FILE__, 'sv_check_dependency');

?>
