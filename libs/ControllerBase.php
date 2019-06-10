<?php

/**
 * 
 */
class ControllerBase{
	
	function __construct(){
		$this->viewBase = new ViewBase();
	}

	function loadModel($model_name){
		$url = 'model/'.$model_name.'Model.php';

		if (file_exists($url)) {
			require $url;

			$model = $model_name.'Model';
			$this->model = new $model();
		}
	}
}