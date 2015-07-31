(function() {

	if (typeof jQuery === 'undefined') {
		return;
	}

	jQuery(document).ready(function() {

		jQuery('#sv-edit-gallery-form, #sv-set-defaults-form').submit(function() {
			jQuery('.sv-button', this).prop('disabled', true);
			jQuery(':input', this).not('.sv-button', this).prop('disabled', false);
		});

		jQuery('#sv-e-library').change(function() {
			switch (jQuery('#sv-e-library').val()) {
				case 'media':
					jQuery('#sv-toggle-source-media').show();
					jQuery('#sv-toggle-source-flickr, #sv-toggle-source-nextgen, #sv-toggle-source-picasa').hide();
					break;
				case 'flickr':
					jQuery('#sv-toggle-source-flickr').show();
					jQuery('#sv-toggle-source-media, #sv-toggle-source-nextgen, #sv-toggle-source-picasa').hide();
					break;
				case 'nextgen':
					jQuery('#sv-toggle-source-nextgen').show();
					jQuery('#sv-toggle-source-media, #sv-toggle-source-flickr, #sv-toggle-source-picasa').hide();
					break;
				case 'picasa':
					jQuery('#sv-toggle-source-picasa').show();
					jQuery('#sv-toggle-source-media, #sv-toggle-source-flickr, #sv-toggle-source-nextgen').hide();
					break;
				default:
					break;
			}
		});

		jQuery('#sv-e-library').triggerHandler('change');

	});

}());
