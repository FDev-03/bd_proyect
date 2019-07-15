<?php

/**
 * 
 */
class ReportsController extends ControllerBase{
	
	function __construct(){
		parent::__construct();
	}

	function render() {
		$this->viewBase->render('Reports/index');
	}

	function getReports() {
		$data = $this->model->getReports();
		echo json_encode($data);
	}
}