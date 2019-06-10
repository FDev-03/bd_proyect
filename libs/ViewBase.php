<?php

/**
 * 
 */
class ViewBase {
	
	function __construct() {
	}

	public function render($view_name) {
		require 'view/'.$view_name.'.php';
	}
}