<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$('.<?php echo pct_instance()->prefix ?>lang_picker a').click(function (e) {
			e.preventDefault();
			var lang = $(this).attr('href').replace('#', '');
			if (lang.length > 0) {
				var parent = $(this).closest('ul');

				var text_container = parent.closest('div').find('.<?php echo pct_instance()->prefix ?>text').first();
				$.ajax({
					type      : 'POST',
					url       : '<?php echo admin_url('admin-ajax.php') ?>',
					data      : {
						_nonce    : '<?php echo wp_create_nonce(pct_instance()->prefix.'translate') ?>',
						lang      : lang,
						action    : '<?php echo pct_instance()->prefix ?>translate',
						comment_id: text_container.data('id')
					},
					beforeSend: function () {
						text_container.css('opacity', '0.5');
					},
					success   : function (data) {
						text_container.css('opacity', '1');
						data = jQuery.parseJSON(data);
						if (data.status == 1) {
							text_container.html(data.msg);
						} else {
							alert(data.msg);
						}
					}
				})
			}
		});
		$('.pct_c_holder').closest('li').css('position','relative');
		<?php if(!empty($location)): ?>
		$('.<?php echo pct_instance()->prefix ?>lang_picker a').each(function () {
			if ($(this).attr('href').replace('#','') == '<?php echo $location ?>') {
				$(this).trigger('click');
			}
		})
		<?php endif; ?>
	})
</script>