<?php
include pct_instance()->plugin_path . 'app/components/google_translate/pct_Google_Translate_Model.php';

/**
 * Author: Cody Agent
 */
class pct_Google_Translate {

	public function __construct() {
		add_action( 'pct_settings_addition', array( &$this, 'setting' ), 10, 2 );
		add_filter( 'pct_settings_saved', array( &$this, 'process' ), 10, 2 );
		add_filter( 'pct_translate_enable', array( &$this, 'is_on' ) );
		add_filter( 'pct_do_translate', array( &$this, 'translate' ), 10, 2 );
	}

	function translate( $comment_id, $lang ) {
		$comment = get_comment( $comment_id );
		if ( is_null( $comment ) ) {
			return array(
				'status'        => false,
				'error_message' => __( 'Comment not found!', pct_instance()->domain )
			);
		}

		$text = $comment->comment_content;

		$model  = new pct_Google_Translate_Model();
		$result = $model->translate( $text, $lang );
		$result = json_decode( $result, true );
		if ( isset( $result['error'] ) ) {
			return array(
				'status'        => false,
				'error_message' => __( 'There\' an error when validate your key: ', pct_instance()->domain ) . $result['error']['errors'][0]['reason']
			);
		} else {
			return array(
				'status'     => true,
				'translated' => $result['data']['translations'][0]['translatedText']
			);
		}
	}

	function is_on() {
		$model = new pct_Google_Translate_Model();
		if ( ! empty( $model->google_api ) ) {
			return true;
		}

		return false;
	}

	function process( $return, $pmodel ) {
		$model = new pct_Google_Translate_Model();
		$model->import( $_POST['pct_Google_Translate_Model'] );
		if ( $model->validate() ) {
			$model->save();
			$return = true;
		} else {
			pct_instance()->global['google_model'] = $model;
			$return                                = false;
		}

		return $return;
	}

	function setting( $pmodel, $form ) {
		$model = null;

		if ( isset( pct_instance()->global['google_model'] ) ) {
			$model = pct_instance()->global['google_model'];
		}
		if ( ! $model instanceof pct_Google_Translate_Model ) {
			$model = new pct_Google_Translate_Model();
		}
		?>
		<div class="metabox-holder">
			<div class="postbox">
				<h3 class="hndle" style="cursor:auto;"><span><?php _e( 'Google Api', pct_instance()->domain ) ?></span>
				</h3>

				<div class="inside">
					<table class="form-table">
						<tr>
							<th scope="row"><?php _e( 'Google API', pct_instance()->domain ) ?></th>
							<td>
								<?php $form->textField( $model, "google_api", array( 'class' => 'regular-text' ) ) ?>
								<p><?php _e( 'Google Public Api Key, required for translate job, you can obtain <a target="_blank" href="https://developers.google.com/translate/v2/getting_started">here</a>', pct_instance()->domain ) ?></p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	<?php
	}
}

add_filter('pct_translate_engine','pct_register_google_engine');
function pct_register_google_engine($list){
	$list = array_merge($list,array('pct_Google_Translate'=>'Google Translate'));
	return $list;
}