<?php

/**
 * 
 */
class HelpController extends ControllerBase {
	
	function __construct() {
		parent::__construct();
	}

	function render(){
		$this->viewBase->render('Help/index');
	}
}