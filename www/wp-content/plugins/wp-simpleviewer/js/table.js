(function() {

	if (typeof jQuery === 'undefined') {
		return;
	}

	jQuery(document).ready(function() {

		jQuery('.sv-delete-gallery').click(function() {
			return confirm('Are you sure you want to delete this gallery?');
		});
		jQuery('.sv-table-reset').click(function() {
			return confirm('Are you sure you want to reset the default values of the gallery configuration options to their original values?');
		});
		jQuery('.sv-table-delete').click(function() {
			return confirm('Are you sure you want to delete all galleries, custom default values and options?');
		});

	});

}());
