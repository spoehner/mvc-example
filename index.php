<?php
// simple autoloader
spl_autoload_register(function ($className) {
	if (substr($className, 0, 4) !== 'Mvc\\') {
		// not our business
		return;
	}

	$fileName = __DIR__.'/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 4)).'.php';

	if (file_exists($fileName)) {
		include $fileName;
	}
});

// get the requested url
$url      = (isset($_GET['_url']) ? $_GET['_url'] : '');
$urlParts = explode('/', $url);

// build the controller class
$controllerName      = (isset($urlParts[0]) && $urlParts[0] ? $urlParts[0] : 'index');
$controllerClassName = '\\Mvc\\Controller\\'.ucfirst($controllerName).'Controller';

// build the action method
$actionName       = (isset($urlParts[1]) && $urlParts[1] ? $urlParts[1] : 'index');
$actionMethodName = $actionName.'Action';

try {
	if (!class_exists($controllerClassName)) {
		throw new \Mvc\Library\NotFoundException();
	}

	$controller = new $controllerClassName();

	if (!$controller instanceof \Mvc\Controller\Controller || !method_exists($controller, $actionMethodName)) {
		throw new \Mvc\Library\NotFoundException();
	}

	$view = new \Mvc\Library\View(__DIR__.DIRECTORY_SEPARATOR.'views', $controllerName, $actionName);
	$controller->setView($view);

	$controller->$actionMethodName();
	$view->render();

} catch (\Mvc\Library\NotFoundException $e) {
	http_response_code(404);
	echo 'Page not found: '.$controllerClassName.'::'.$actionMethodName;
} catch (\Exception $e) {
	http_response_code(500);
	echo 'Exception: <b>'.$e->getMessage().'</b><br><pre>'.$e->getTraceAsString().'</pre>';
}