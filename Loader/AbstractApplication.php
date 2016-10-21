<?php

namespace Niu\Loader;

use Niu\Module\AbstractModule;

abstract class AbstractApplication {

	const STATUS_STARTING_CLASS = 0;
	const STATUS_LOADING_MODULES = 1;
	const STATUS_PROCESS_REQUEST = 2;

	protected $status = self::STATUS_STARTING_CLASS;

	private $listModules = array();

	abstract protected function runApp();
	abstract protected function loadModules();

	public function run() {
		$this->runLoadModules();
		$this->runApp();
	}

	final protected function runLoadModules() {
		$this->status = self::STATUS_LOADING_MODULES;
		$this->loadModules();
	}

	final protected function addModule(AbstractModule $module) {
		if ( $this->status != self::STATUS_LOADING_MODULES ) {
			throw new \Exception('Você não pode inserir modulos neste momento, favor utilizar o método loadModules');
		}

		$this->listModules[] = $module;
	}

	final protected function getModules() {
		return new \ArrayIterator($this->listModules);
	}

}