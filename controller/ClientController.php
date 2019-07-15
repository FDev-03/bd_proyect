<?php

/**
 * 
 */
class ClientController extends ControllerBase{
	
	function __construct(){
		parent::__construct();
	}

	function render() {
		$this->viewBase->render('Client/index');
	}

	function getClient() {
		$data = $this->model->getClient();
		echo json_encode($data);
	}
}