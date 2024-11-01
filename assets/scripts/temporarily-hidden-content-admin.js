
jQuery('document').ready(function($) {

	function temphcSave() {
		$('.temphc-settings-loading').fadeIn(function() {
			var form = $('form#temphc-settings-form');
			var data = {
				'action': 'temphc_save'
			};
			$(form).find(':input').each(function() {
				data[this['name']] = $(this).val();
			});
			$.ajax({
				url: temphc.ajaxurl,
				data: data,
				type: $(form).attr('method'),
				headers: {
					'X-WP-Nonce': temphc.nonce
				},
				complete: function(response) {
					$('.temphc-settings-loading').fadeOut();
				}
			});
		});
	}

	$('#temporarily-hidden-content-admin .admin-block > a').click(function(e) {
		e.preventDefault();
		$('.admin-block').addClass('admin-block-hidden');
		$(this).parents('.admin-block').removeClass('admin-block-hidden');
	});

	$('form#temphc-settings-form :input').change(function(e) {
		e.preventDefault();
		temphcSave();
	});

});
