<?php
header('Cache-Control: max-age=0, must-revalidate, no-cache, no-store, post-check=0, pre-check=0');
header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Pragma: no-cache');

$dirname = dirname(__file__);
$position = strrpos($dirname, 'wp-content');
$wp_path = $position !== false ? substr($dirname, 0, $position) : rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/';

include_once $wp_path . 'wp-load.php';
include_once $wp_path . 'wp-admin/includes/screen.php';

$sv_add_gallery_nonce = isset($_GET['sv_add_gallery_nonce']) ? $_GET['sv_add_gallery_nonce'] : '';
if (!wp_verify_nonce($sv_add_gallery_nonce, 'sv_add_gallery')) {
	exit();
}

$title = 'Add SimpleViewer Gallery';

$direction = is_rtl() ? 'rtl' : 'ltr';

$options = get_option('simpleviwer_options', array());
$gallery_id = isset($options['last_id']) ? $options['last_id'] + 1 : 1;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php echo get_option('blog_charset'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo admin_url('css/colors-classic.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo admin_url('load-styles.php?c=0&amp;dir=' . $direction . '&amp;load=wp-admin'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('css/generate.css', __FILE__); ?>?ver=<?php echo $SimpleViewer->version; ?>" />
		<script src="<?php echo includes_url('js/jquery/jquery.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo plugins_url('js/generate.js', __FILE__); ?>?ver=<?php echo $SimpleViewer->version; ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo plugins_url('js/edit.js', __FILE__); ?>?ver=<?php echo $SimpleViewer->version; ?>" type="text/javascript" charset="utf-8"></script>
		<title><?php echo esc_html($title); ?> &lsaquo; <?php bloginfo('name') ?> &#8212; WordPress</title>
	</head>
	<body class="no-js wp-admin wp-core-ui">
<?php
		$custom_values = $SimpleViewer->get_default_values();
		$pro_options = $SimpleViewer->get_pro_options($custom_values);
?>
		<div id="sv-add-gallery-container" class="wrap sv-custom-wrap">

			<h2><img src ="<?php echo plugins_url('img/icon_32.png', __FILE__); ?>" width="32" height="32" align="top" alt="logo" /><?php echo esc_html($title); ?> Id <?php echo $gallery_id; ?></h2>

			<form id="sv-add-gallery-form" action="" method="post">
<?php
				include_once plugin_dir_path(__FILE__) . 'fieldset.php';
?>
				<div id="sv-add-action">
					<input id="sv-add-gallery" class="button sv-button" type="button" name="add-gallery" value="Add Gallery" />
					<input id="sv-add-cancel" class="button sv-button" type="button" name="add-cancel" value="Cancel" />
				</div>
<?php
				wp_nonce_field('sv_gallery_added', 'sv_gallery_added_nonce', false);
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
					try {
						SV.Gallery.Generator.postUrl = "<?php echo plugins_url('save-gallery.php', __FILE__); ?>";
						SV.Gallery.Generator.initialize();
					} catch (e) {
						throw "SV is undefined.";
					}
				});

			}());
			// ]]>
		</script>

	</body>

</html>
