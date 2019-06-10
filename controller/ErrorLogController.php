<?php

/**
 * 
 */
class ErrorLogController extends ControllerBase {
	
	function __construct() {
		parent::__construct();
		$this->viewBase->render('Error/index');
	}
}