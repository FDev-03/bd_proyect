<?php

/**
 * 
 */
class RawMaterialController extends ControllerBase{
	
	function __construct(){
		parent::__construct();
	}

	function render() {
		$this->viewBase->render('RawMaterial/index');
	}

	function getRawMaterials() {
		$data = $this->model->getMaterials();
		echo json_encode($data);
	}

	function getCategories() {
		$data = $this->model->getCategories();
		echo json_encode($data);
	}

	function addMaterial(){
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);

		if (isset($_POST['form_fields'])) {
			$result = $this->model->addMaterial($_POST['form_fields']);
			if ($result != FALSE) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
			}
		}
		echo json_encode($response);
		return;	
	}
}