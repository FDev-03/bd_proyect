<?php

/**
 * 
 */
class ProviderController extends ControllerBase{
	
	function __construct(){
		parent::__construct();
	}

	function render() {
		$this->viewBase->render('Provider/index');
	}
}