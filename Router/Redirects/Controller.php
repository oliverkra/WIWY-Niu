<?php

namespace Niu\Router\Redirects;

use Niu\Router\AbstractRedirect,
	Niu\Module\AbstractController,
	Niu\Router\Exceptions\InvalidControllerRoute,
	Niu\Router\Exceptions\InvalidResultValueControllerRoute;

class Controller extends AbstractRedirect {

	private $module;
	private $controller;
	private $action;

	public function __construct($module, $controller, $action) {
		$this->module = $module;
		$this->controller = $controller;
		$this->action = $action;
	}

	public function go($params) {
		$controllerName = 'NiuModule\\' . $this->module . '\Controllers\\' . $this->controller . 'Controller';
		$methodsList = get_class_methods($controllerName);

		if ( $methodsList === NULL ) { # Controller não existe
			throw new InvalidControllerRoute('Controller não existe.');
		}

		$controller = new $controllerName();

		if ( !($controller instanceof AbstractController) ) {
			throw new InvalidControllerRoute('Controller inválido.');
		}

		$action = $this->action . 'Action';

		if ( !in_array($action, $methodsList) ) {
			throw new InvalidControllerRoute('A ação ' . $this->action . ' não existe no Controller ' . $controllerName);
		}

		$return = $controller->$action();

		if ( !is_null($return) ) {
			throw new InvalidResultValueControllerRoute('Não é possível retornar valores na action');
		}
	}

}