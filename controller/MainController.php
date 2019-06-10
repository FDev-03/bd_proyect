<?php

/**
 *
 */
class MainController extends ControllerBase {

	function __construct() {
		parent::__construct();
	}

	function render(){
		$this->viewBase->render('Main/index');
	}	
}