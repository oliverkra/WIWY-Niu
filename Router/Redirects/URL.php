<?php

namespace Niu\Router\Redirects;

use Niu\Router\AbstractRedirect;

class URL extends AbstractRedirect {

	private $URI;

	public function __construct($URI) {
		$this->URI = $URI;
	}

	public function go($params) {
		header('Location: ' . $this->URI);
		exit();
	}

}