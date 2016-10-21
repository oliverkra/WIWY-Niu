<?php

namespace Niu\Router;

final class Router {
	
	private $routes = array();

	public function addRoute(AbstractRoute $route) {
		$this->routes[] = $route;
	}

	public function findRouteByURL($URI) {
		$routeReturn = false;

		foreach ( $this->routes as $route ) {
			if ( $route->accepted( $URI ) ) {
				if ( $routeReturn !== false ) {
					throw new Exceptions\DuplicateRoute('Rota duplicada, reveja as rotas.');
				}

				$routeReturn = $route;
			}
		}

		return $routeReturn;
	}

}