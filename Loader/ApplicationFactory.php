<?php

namespace Niu\Loader;

use Niu\Loader\AbstractApplication;

final class ApplicationFactory {

	public function __construct() {
		throw new \Exception('Não é possível instanciar a Classe' . __CLASS__);
	}

	public static function init(AbstractApplication $application) {
		return $application;
	}

}