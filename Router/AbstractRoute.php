<?php

namespace Niu\Router;

use Niu\Router\AbstractRedirect;

abstract class AbstractRoute {

	protected $URI;
	private $redirect;

	// http://www.regular-expressions.info/refcharclass.html
	// http://www.pinceladasdaweb.com.br/blog/2008/01/21/8-expressoes-regulares-para-php-consideradas-uteis/
	// http://www.devmedia.com.br/expressoes-regulares-em-php/25076

	const REGULAR_EXPRESSION_PARAMETERS = '/(:[a-zA-Z0-9]+|\[)/';	# /aa:aa/:bb[/:cc/[:dd]]
	const REGULAR_EXPRESSION_SIMPLE = '/(\/([a-zA-Z0-9]+))/';	# /aa/bb/cc/dd | /aa | /b/c
	
	public function __construct($URI, AbstractRedirect $redirect) {
		if ( !$this->isValidURI($URI) ) {
			throw new \Exception('URI inválida.');
		}

		$this->URI = $URI;
		$this->redirect = $redirect;
		

		// Interpreta /teste/:param1/post/:param2/oi:param3_tchau/ttc
		// vl( preg_split('/(:[a-zA-Z0-9]+)/', $url, -1, PREG_SPLIT_DELIM_CAPTURE) );
	}

	abstract protected function isValidURI($URI);

	abstract public function accepted($URI);

	public function open($params) {
		$this->redirect->go($params);
	}

}