<?php

/**
 * 
 */
class GetTestController extends ControllerBase {
	
	function __construct(){
		parent::__construct();
		$this->viewBase->data = "";
	}

	function render() {
		$this->viewBase->render('GetTest/index');
	}

	function gettest() {
		//header('Content-Type: application/json');
		$data = $this->model->getData();
		//$this->render();
		echo json_encode($data);
	}

	function getspecific(){
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);
		if (isset($_POST['form_input']['value'])) {
			$result = $this->model->getSpecific($_POST['form_input']['value']);
			if ($result != FALSE) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
				$response['data'] = $result;
			}
		}
		echo json_encode($response);
		return;	
	}

	function deletetest() {
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);
		if (isset($_POST['form_input']['value'])) {
			$action = $this->model->deleteRow($_POST['form_input']['value']);
			if ($action) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
			}
		}
		echo json_encode($response);
		return;
	}

}