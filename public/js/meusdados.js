		$(document).ready(function() {
			$.fn.editable.defaults.mode = 'inline';

			$('.editable_field').editable({
				escape: true
			});
		});