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

		$userSession = new UserSession();
		// Session Validations.
		if(isset($_SESSION['user'])){
			if($url[0] == 'login'){
				require 'view/Main/index.php';
				return;
			}
		}elseif(isset($_POST['username']) && isset($_POST['password'])){
			if (constant('SESSION_USERNAME') == $_POST['username'] &&
				constant('SESSION_PASSWORD') == $_POST['password']) {
				$userSession->setCurrentUser($_POST['username']);
				require 'view/Main/index.php';
			}else{
				require 'view/Login.php';
			}
			return;
		}else{
			require 'view/Login.php';
			return;
		}

		if (empty($url[0])) {
			$controller_file = 'controller/MainController.php';
			require_once $controller_file;
			$main = new MainController();
			$main->loadModel('Main');
			$main->render();
			return false;
		}elseif($url[0] == 'logout'){
			$userSession->closeSession();
			require 'view/Login.php';
			return;
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
