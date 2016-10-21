<?php

namespace Niu\Module\Modules;

use Niu\Module\AbstractModule,
	Niu\Router\Router,
	Niu\Router\AbstractRoute;

abstract class RoutedModule extends AbstractModule {

	const STATUS_STARTING_CLASS = 0;
	const STATUS_LOADING_ROUTES = 1;
	const STATUS_PROCESS_REQUEST = 2;

	private $router = null;

	private $status = self::STATUS_STARTING_CLASS;

	final public function __construct() {}

	abstract protected function loadRoutes();

	final protected function addRoute(AbstractRoute $route) {
		if ( $this->status != self::STATUS_LOADING_ROUTES ) {
			throw new \Exception('Você não pode inserir rotas neste momento, favor utilizar o método loadRoutes');
		}

		$this->router->addRoute($route);
	}

	final private function runLoadRoutes() {
		if ( $this->router == null ) {
			$this->router = new Router();

			$this->status = self::STATUS_LOADING_ROUTES;
			$this->loadRoutes();
		}
	}

	final public function findRouteByURL($URI) {
		$this->runLoadRoutes();

		return $this->router->findRouteByURL($URI);
	}

}