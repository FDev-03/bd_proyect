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
		if (isset($_GET['service'])) {
			$type = ($_GET['service'] === 'true') ? TRUE: FALSE;
		}else{
			$type = FALSE;
		}
		$data = $this->model->getProviders($type);
		echo json_encode($data);
	}

	function deleteProviders() {
		$response = array(
			'status' => FALSE,
			'message' =>'Bad Request!'
		);
		if (isset($_POST['form_input']['value'])) {
			if (isset($_GET['service'])) {
				$type = ($_GET['service'] === 'true') ? TRUE: FALSE;
			}else{
				$type = FALSE;
			}
			$action = $this->model->deleteRow($_POST['form_input']['value'], $type);
			if ($action['status'] == 1) {
				$response['status'] = TRUE;
				$response['message'] = 'Completed.';
				$response['available'] = $action['data']['nAvailable'];
			}
		}
		echo json_encode($response);
		return;
	}
}