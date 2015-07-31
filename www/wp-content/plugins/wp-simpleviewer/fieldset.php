<fieldset>

	<legend class="sv-legend"><b>Gallery Options</b></legend>

	<div id="sv-gallery-options">

		<div class="sv-column-1">
			<label for="sv-title">Gallery Title</label>
		</div>
		<div class="sv-column-2">
			<input id="sv-title" type="text" name="title" value="<?php echo htmlspecialchars($custom_values['title']); ?>" />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-e-library">Image Source</label>
		</div>
		<div class="sv-column-3">
			<select id="sv-e-library" name="e_library">
				<option value="media" <?php selected($custom_values['e_library'] === 'media'); ?>>Media Library</option>
				<option value="flickr" <?php selected($custom_values['e_library'] === 'flickr'); ?>>Flickr</option>
				<option value="nextgen" <?php selected($custom_values['e_library'] === 'nextgen'); ?>>NextGEN Gallery</option>
				<option value="picasa" <?php selected($custom_values['e_library'] === 'picasa'); ?>>Picasa Web Album</option>
			</select>
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div id="sv-toggle-source-media" class="sv-toggle-source">
			<div class="sv-column-1">
				<label for="sv-e-featured-image">Include Featured Image</label>
			</div>
			<div class="sv-column-3">
				<input id="sv-e-featured-image" type="checkbox" name="e_featuredImage" value="true" <?php checked($custom_values['e_featuredImage'] === 'true' || $custom_values['e_featuredImage'] === ''); ?> />
			</div>

			<div class="sv-column-1">
				<label for="sv-e-media-order">Image Order</label>
			</div>
			<div class="sv-column-3">
				<select id="sv-e-media-order" name="e_mediaOrder">
					<option value="ascending" <?php selected($custom_values['e_mediaOrder'] === 'ascending' || $custom_values['e_mediaOrder'] === ''); ?>>Ascending</option>
					<option value="descending" <?php selected($custom_values['e_mediaOrder'] === 'descending'); ?>>Descending</option>
				</select>
			</div>

			<div class="sv-column-clear">&nbsp;</div>

			<div class="sv-column-4">
<?php
				global $wp_version;
				$media_text = version_compare($wp_version, '3.5', '>=') ? 'Add Media' : 'Upload/Insert';
?>
				<span>Use the <?php echo $media_text;?>&nbsp;&nbsp;<img src="<?php echo admin_url() . 'images/media-button.png'; ?>" width="15" height="15" alt="<?php echo $media_text;?>" />&nbsp;&nbsp;button to add images</span>
			</div>
		</div>

		<div id="sv-toggle-source-flickr" class="sv-toggle-source">
			<div class="sv-column-1">
				<label for="sv-flickr-user-name">Flickr Username</label>
			</div>
			<div class="sv-column-3">
				<input id="sv-flickr-user-name" type="text" name="flickrUserName" value="<?php echo $custom_values['flickrUserName']; ?>" />
			</div>

			<div class="sv-column-1">
				<label for="sv-flickr-tags">Flickr Tags</label>
			</div>
			<div class="sv-column-3">
				<input id="sv-flickr-tags" type="text" name="flickrTags" value="<?php echo $custom_values['flickrTags']; ?>" />
			</div>
		</div>

		<div id="sv-toggle-source-nextgen" class="sv-toggle-source">
			<div class="sv-column-1">
				<label for="sv-e-nextgen-gallery-id">NextGEN Gallery Id</label>
			</div>
			<div class="sv-column-3">
				<input id="sv-e-nextgen-gallery-id" type="text" name="e_nextgenGalleryId" value="<?php echo $custom_values['e_nextgenGalleryId']; ?>" />
			</div>
		</div>

		<div id="sv-toggle-source-picasa" class="sv-toggle-source">
			<div class="sv-column-1">
				<label for="sv-e-picasa-user-id">Picasa User Id</label>
			</div>
			<div class="sv-column-3">
				<input id="sv-e-picasa-user-id" type="text" name="e_picasaUserId" value="<?php echo $custom_values['e_picasaUserId']; ?>" />
			</div>

			<div class="sv-column-1">
				<label for="sv-e-picasa-album-name">Picasa Album Id/Name</label>
			</div>
			<div class="sv-column-3">
				<input id="sv-e-picasa-album-name" type="text" name="e_picasaAlbumName" value="<?php echo $custom_values['e_picasaAlbumName']; ?>" />
			</div>
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-gallery-style">Gallery Style</label>
		</div>
		<div class="sv-column-3">
			<select id="sv-gallery-style" name="galleryStyle">
				<option value="MODERN" <?php selected($custom_values['galleryStyle'] === 'MODERN'); ?>>Modern</option>
				<option value="CLASSIC" <?php selected($custom_values['galleryStyle'] === 'CLASSIC'); ?>>Classic</option>
				<option value="COMPACT" <?php selected($custom_values['galleryStyle'] === 'COMPACT'); ?>>Compact</option>
			</select>
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-thumb-position">Thumb Position</label>
		</div>
		<div class="sv-column-3">
			<select id="sv-thumb-position" name="thumbPosition">
				<option value="TOP" <?php selected($custom_values['thumbPosition'] === 'TOP'); ?>>Top</option>
				<option value="BOTTOM" <?php selected($custom_values['thumbPosition'] === 'BOTTOM'); ?>>Bottom</option>
				<option value="LEFT" <?php selected($custom_values['thumbPosition'] === 'LEFT'); ?>>Left</option>
				<option value="RIGHT" <?php selected($custom_values['thumbPosition'] === 'RIGHT'); ?>>Right</option>
				<option value="NONE" <?php selected($custom_values['thumbPosition'] === 'NONE'); ?>>None</option>
			</select>
		</div>

		<div class="sv-column-1">
			<label for="sv-frame-width">Frame Width, px</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-frame-width" type="text" name="frameWidth" value="<?php echo $custom_values['frameWidth']; ?>" />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-max-image-width">Max Image Width, px</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-max-image-width" type="text" name="maxImageWidth" value="<?php echo $custom_values['maxImageWidth'] ?>" />
		</div>

		<div class="sv-column-1">
			<label for="sv-max-image-height">Max Image Height, px</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-max-image-height" type="text" name="maxImageHeight" value="<?php echo $custom_values['maxImageHeight'] ?>" />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-text-color">Text Color</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-text-color" type="text" name="textColor" value="<?php echo str_replace('0x', '', $custom_values['textColor']); ?>" />
		</div>

		<div class="sv-column-1">
			<label for="sv-frame-color">Frame Color</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-frame-color" type="text" name="frameColor" value="<?php echo str_replace('0x', '', $custom_values['frameColor']); ?>" />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-show-open-button">Open Button</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-show-open-button" type="checkbox" name="showOpenButton" value="true" <?php checked($custom_values['showOpenButton'] === 'true'); ?> />
		</div>

		<div class="sv-column-1">
			<label for="sv-show-fullscreen-button">Fullscreen Button</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-show-fullscreen-button" type="checkbox" name="showFullscreenButton" value="true" <?php checked($custom_values['showFullscreenButton'] === 'true'); ?> />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-thumb-rows">Thumbnail Rows</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-thumb-rows" type="text" name="thumbRows" value="<?php echo $custom_values['thumbRows']; ?>" />
		</div>

		<div class="sv-column-1">
			<label for="sv-thumb-column-s">Thumbnail Columns</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-thumb-column-s" type="text" name="thumbColumns" value="<?php echo $custom_values['thumbColumns']; ?>" />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-e-g_width">Gallery Width</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-e-g_width" type="text" name="e_g_width" value="<?php echo $custom_values['e_g_width']; ?>" />
		</div>

		<div class="sv-column-1">
			<label for="sv-e-g_height">Gallery Height</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-e-g_height" type="text" name="e_g_height" value="<?php echo $custom_values['e_g_height']; ?>" />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-e-bg-color">Background Color</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-e-bg-color" type="text" name="e_bgColor" value="<?php echo ($custom_values['e_backgroundTransparent'] === 'true') ? '' : $custom_values['e_bgColor']; ?>" />
		</div>

		<div class="sv-column-1">
			<label for="sv-background-transparent">Background Transparent</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-background-transparent" type="checkbox" name="e_backgroundTransparent" value="true" <?php checked($custom_values['e_backgroundTransparent'] === 'true'); ?> />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-e-use-flash">Use Flash</label>
		</div>
		<div class="sv-column-3">
			<input id="sv-e-use-flash" type="checkbox" name="e_useFlash" value="true" <?php checked($custom_values['e_useFlash'] === 'true'); ?> />
		</div>

		<div class="sv-column-clear">&nbsp;</div>

		<div class="sv-column-1">
			<label for="sv-pro-options">Pro Options</label>
		</div>
		<div class="sv-column-2">
			<textarea id="sv-pro-options" name="proOptions" cols="50" rows="5"><?php echo $pro_options; ?></textarea>
		</div>

		<div class="sv-column-clear">&nbsp;</div>

	</div>

</fieldset>
