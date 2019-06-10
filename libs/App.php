<?php

require_once 'controller/ErrorLogController.php';

/**
 *  Main Class.
 */
class App {

	function __construct(){
		$url = (isset($_GET['url'])) ? $_GET['url'] : null;
		$url = rtrim($url);
		$url = explode('/', $url);

		if (empty($url[0])) {
			$controller_file = 'controller/MainController.php';
			require_once $controller_file;
			$main = new MainController();
			$main->loadModel('Main');
			$main->render();
			return false;
		}

		$controller_file = 'controller/' . $url[0] . 'Controller.php';
		
		if (file_exists($controller_file)) {	
			require_once $controller_file;
			$controller_name = $url[0].'Controller';
			$controller = new $controller_name();
			$controller->loadModel($url[0]);

			if (isset($url[1])) {

				if (!method_exists($controller, $url[1]))
					return new ErrorLogController();

				$controller->{$url[1]}();
			}else
				$controller->render();

		}else{
			return new ErrorLogController();
		}
	}
}
