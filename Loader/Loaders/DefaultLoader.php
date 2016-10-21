<?php

namespace Niu\Loader\Loaders;

if ( !class_exists('Niu\Loader\AbstractAutoloader') ) {
	require_once(__DIR__ . '/../AbstractAutoloader.php');
}

use \Niu\Loader\AbstractAutoloader;

final class DefaultLoader extends AbstractAutoloader {

	private $namespaces;

	public function __construct($options = null) {
		if ( is_array( $options ) ) {
			if ( isset( $options['ns'] ) ) {
				$this->namespaces = $options['ns'];
			}
		}
	}

	public function autoload($class) {
		$class = str_replace('\\', '/', $class);

		$ns = substr($class, 0, strpos($class, '/'));

		if ( isset( $this->namespaces[ $ns ] ) ) {
			$nsPath = $this->namespaces[ $ns ];
			$class = substr($class, -strlen($class) + strlen($ns));

			include_once($nsPath . '/' . $class . self::FILE_EXTENSION);
		}
	}

}