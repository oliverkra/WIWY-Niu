<?php

namespace Niu\Router\Routes;

use Niu\Router\AbstractRoute,
	Niu\Router\AbstractRedirect;

final class LiteralRoute extends AbstractRoute {

	public function __construct($URI, AbstractRedirect $redirect) {
		parent::__construct($URI, $redirect);
	}

	protected function isValidURI($URI) {
		return (preg_match(self::REGULAR_EXPRESSION_SIMPLE, $URI) || $URI == '/') && preg_match(self::REGULAR_EXPRESSION_PARAMETERS, $URI) === 0;
	}

	public function accepted($URI) {
		return $this->URI == $URI;
	}

}