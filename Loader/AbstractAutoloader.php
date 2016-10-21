<?php

namespace Niu\Loader;

abstract class AbstractAutoloader {

	const FILE_EXTENSION = '.php';

	abstract public function autoload($class);

	final public function register() {
		spl_autoload_register(array($this, 'autoload'));
	}

}