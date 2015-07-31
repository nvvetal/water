<?php
$dirname = dirname(__file__);
$position = strrpos($dirname, 'wp-content');
$wp_path = $position !== false ? substr($dirname, 0, $position) : rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/';

include_once $wp_path . 'wp-load.php';

$sv_gallery_added_nonce = isset($_POST['sv_gallery_added_nonce']) ? $_POST['sv_gallery_added_nonce'] : '';
if (!wp_verify_nonce($sv_gallery_added_nonce, 'sv_gallery_added')) {
	exit();
}

$options = get_option('simpleviwer_options', array());
$options['last_id'] = isset($options['last_id']) ? $options['last_id'] + 1 : 1;
update_option('simpleviwer_options', $options);

$gallery_path = $SimpleViewer->get_gallery_path();
$gallery_id = $options['last_id'];
$gallery_filename = $gallery_path . $gallery_id . '.xml';

echo $gallery_id;

$SimpleViewer->build_gallery($gallery_filename, $_POST);
?>
