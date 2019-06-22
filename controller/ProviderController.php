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

	function getProviders() {
		$data = $this->model->getProviders();
		echo json_encode($data);
	}
}