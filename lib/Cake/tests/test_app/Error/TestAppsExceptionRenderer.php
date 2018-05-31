<?php

namespace lib\Cake\Test\test_app\Error;

class TestAppsExceptionRenderer extends ExceptionRenderer {

	protected function _getController($exception) {
		if (!$request = Router::getRequest(true)) {
			$request = new Request();
		}
		$response = new Response(array('charset' => Configure::read('App.encoding')));
		try {
			$controller = new TestAppsErrorController($request, $response);
			$controller->layout = 'banana';
		} catch (Exception $e) {
			$controller = new Controller($request, $response);
			$controller->viewPath = 'Errors';
		}
		return $controller;
	}

}
