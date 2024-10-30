<?php

/**
 * Author: Cody Agent
 */
class pct_Translate_Controller {
	public function __construct() {
		//append translate dropdown
		add_filter( 'get_comment_text', array( &$this, 'append_dropdown_comment' ), 10, 3 );
		add_action( 'wp_footer', array( &$this, 'footer_scripts' ), 50 );
		add_action( 'wp_ajax_nopriv_' . pct_instance()->prefix . 'translate', array( &$this, 'do_translate' ) );
		add_action( 'wp_ajax_' . pct_instance()->prefix . 'translate', array( &$this, 'do_translate' ) );
	}

	function do_translate() {
		if ( isset( $_POST['_nonce'] ) && wp_verify_nonce( $_POST['_nonce'], pct_instance()->prefix . 'translate' ) ) {
			//$result = $this->translate( $_POST['comment_id'], $_POST['lang'] );
			$result = apply_filters( 'pct_do_translate', $_POST['comment_id'], $_POST['lang'] );
			if ( $result['status'] == false ) {
				echo json_encode( array(
					'status' => 0,
					'msg'    => __( $result['error_message'], pct_instance()->domain )
				) );
				exit;
			}

			echo json_encode( array(
				'status' => 1,
				'msg'    => stripslashes( $result['translated'] )
			) );
		}
		exit;
	}


	function footer_scripts() {
		$location = '';
		if ( pct_setting()->pre_translate == 1 ) {
			$lang = LocationLib::language_code( $_SERVER['REMOTE_ADDR'] );
			if ( ! empty( $lang ) ) {
				//check does this enable
				$langs_tmp = array_filter( explode( ',', pct_setting()->supported_languages ) );
				$langs_tmp = array_map( 'trim', $langs_tmp );
				$languages = pct_instance()->get_languages();
				$lang_name = $languages[$lang];
				if ( in_array( $lang_name, $langs_tmp ) ) {
					$location = $lang;
				}
			}
		}

		pct_instance()->render_view( 'picker/' . pct_setting()->picker_type . '_script', array(
			'location' => $location
		) )
		?>

	<?php
	}

	function append_dropdown_comment( $comment_text, $comment, $args ) {
		if ( apply_filters( 'pct_translate_enable', false ) ) {
			wp_enqueue_style( pct_instance()->prefix . 'style' );

			$langs_tmp = array_filter( explode( ',', pct_setting()->supported_languages ) );
			$langs_tmp = array_map( 'trim', $langs_tmp );
			if ( ! empty( $langs_tmp ) ) {
				$lang_picker = pct_instance()->render_view( 'picker/' . pct_setting()->picker_type, array(
					'langs_tmp' => $langs_tmp
				), true );

				$comment_text = '<div class="pct_c_holder">' . $lang_picker . '<div data-id="' . $comment->comment_ID . '" class="' . pct_instance()->prefix . 'text' . '">' . $comment_text . '</div></div>';
			}
		}

		return $comment_text;
	}
}

new pct_Translate_Controller();