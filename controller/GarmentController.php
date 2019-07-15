<?php

/**
 * 
 */
class GarmentController extends ControllerBase{
	
	function __construct(){
		parent::__construct();
	}

	function render() {
		$this->viewBase->render('Garment/index');
	}

	function getGarment() {
		$data = $this->model->getGarment();
		echo json_encode($data);
	}

	function addGarment(){
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);

		if (isset($_POST['form_fields'])) {
			$result = $this->model->addGarment($_POST['form_fields']);
			if ($result != FALSE) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
			}
		}
		echo json_encode($response);
		return;	
	}

	function deleteGarment() {
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);
		if (isset($_POST['form_input']['value'])) {
			$action = $this->model->deleteGarment($_POST['form_input']['value']);
			if ($action) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
			}
		}
		echo json_encode($response);
		return;
	}	
}