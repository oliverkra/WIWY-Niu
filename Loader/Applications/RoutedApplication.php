<?php

namespace Niu\Loader\Applications;

use Niu\Loader\AbstractApplication,
	Niu\Module\Filters\RoutedModuleFilter,
	Niu\Router\Exceptions\InvalidURLError404,
	Niu\Security\XSSSecure;

abstract class RoutedApplication extends AbstractApplication {
	
	final protected function runApp() {
		$route = false;

		if ( !XSSSecure::validURI($_SERVER['REQUEST_URI']) ) {
			throw new \Exception('Warning! XSS Cross Browser detected!');
		}

		foreach ( new RoutedModuleFilter($this->getModules()) as $module ) {
			list( $URI ) = explode('?', $_SERVER['REQUEST_URI']);

			$route = $module->findRouteByURL( $URI );
			if ( $route !== false )
			{
				break;
			}
		}

		if ( $route === false ) {
			throw new InvalidURLError404('URL ' . $URI . ' não encontrada');
		} else {
			$route->open(array());
		}
	}

}