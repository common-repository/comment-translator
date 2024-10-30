<?php

/**
 * Author: Cody Agent
 */
class pct_Setting_Model extends phpapp_Option_Model {
	public $supported_languages;
	public $pre_translate;

	public $picker_position;
	public $picker_type;

	public $engine;

	public function tbl_name() {
		return pct_instance()->prefix . 'settings';
	}
}