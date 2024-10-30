<div class="wrap" style="position:relative;">
	<h2><?php _e( 'Settings', pct_instance()->domain ) ?>
	</h2>
	<form style="position: absolute;top:0;right:0" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="HDUG7JAYLMVLY">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>

	<?php $form = phpapp_Active_Form::generateForm( $model );
	$form->openForm( '#', 'POST' );
	?>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle" style="cursor:auto;">
				<span><?php _e( 'Translation Settings', pct_instance()->domain ) ?></span></h3>
			<div class="inside">
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e( 'Supported Languages', pct_instance()->domain ) ?></th>
						<td>
							<?php $form->textField( $model, "supported_languages", array( 'class' => 'regular-text', 'id' => 'support_lang' ) ) ?>
							<p class="description"><?php _e( 'This is the languages your reader can translate', pct_instance()->domain ) ?></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle" style="cursor:auto;">
				<span><?php _e( 'Languages Picker Look', pct_instance()->domain ) ?></span></h3>

			<div class="inside">
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e( 'Position', pct_instance()->domain ) ?></th>
						<td>
							<?php $form->dropDownList( $model, "picker_position", array( 'top-left' => 'Top Left', 'top-right' => 'Top Right', 'bottom-left' => 'Bottom Left', 'bottom-right' => 'Bottom Right' ) ) ?>
							<p class="description"><?php _e( 'Where you want the languages picker placed?', pct_instance()->domain ) ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e( 'Display as', pct_instance()->domain ) ?></th>
						<td>
							<?php $form->dropDownList( $model, "picker_type", array( 'dropdown' => 'Drop down', 'link' => 'Link' ) ) ?>
							<p class="description"><?php _e( 'We can display it as links or drop down.', pct_instance()->domain ) ?></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle" style="cursor:auto;">
				<span><?php _e( 'Translate Engine', pct_instance()->domain ) ?></span></h3>

			<div class="inside">
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e( 'Which is', pct_instance()->domain ) ?></th>
						<td>
							<?php $form->dropDownList( $model, "engine", apply_filters( 'pct_translate_engine', array() ) ) ?>
							<p class="description"><?php _e( 'This is where you can get the translate engine.', pct_instance()->domain ) ?></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php do_action( 'pct_settings_addition', $model, $form ) ?>
	<?php wp_nonce_field( pct_instance()->prefix . 'settings' ) ?>
	<p class="submit">
		<button type="submit" name="<?php echo pct_instance()->prefix . 'setting' ?>" class="button button-primary"><?php _e( 'Save Changes', pct_instance()->domain ) ?></button>
	</p>
	<?php echo $form->endForm() ?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		var sources = <?php echo json_encode(array_values(pct_instance()->get_languages())) ?>;

		function split(val) {
			return val.split(/,\s*/);
		}

		function extractLast(term) {
			return split(term).pop();
		}

		$('#support_lang, #default_lang')
			.bind("keydown", function (event) {
				if (event.keyCode === $.ui.keyCode.TAB &&
					$(this).data("ui-autocomplete").menu.active) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source   : function (request, response) {
					// delegate back to autocomplete, but extract the last term
					response($.ui.autocomplete.filter(
						sources, extractLast(request.term)));
				},
				focus    : function () {
					// prevent value inserted on focus
					return false;
				},
				select   : function (event, ui) {
					var terms = split(this.value);
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push(ui.item.value);
					// add placeholder to get the comma-and-space at the end
					terms.push("");
					this.value = terms.join(", ");
					return false;
				}
			});

	})
</script>