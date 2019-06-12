<?php

/**
 * 
 */
class SetTestController extends ControllerBase {
	
	function __construct(){
		parent::__construct();
		$this->viewBase->message = '';
	}

	function render(){
		$this->viewBase->render('SetTest/index');
	}

	function settest() {

		$form_values = array(
			'name' => $_POST['name'],
			'lastname' => $_POST['lastname'],
			'number' => $_POST['number']
		);

		$message = "Error en la insersión.";

		if ($this->model->insertData($form_values))
			$message = "Se agregaron los datos correctamente.";

		$this->viewBase->message = $message;

		$this->render();
	}

	function updateFields(){
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);

		if (isset($_POST['form_fields'])) {
			$result = $this->model->UpdateRow($_POST['form_fields']);
			if ($result != FALSE) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
			}
		}
		echo json_encode($response);
		return;	
	}
}