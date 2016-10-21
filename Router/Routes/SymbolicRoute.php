<?php

namespace Niu\Router\Routes;

use Niu\Router\AbstractRoute,
	Niu\Router\AbstractRedirect;

final class SymbolicRoute extends AbstractRoute {

	private $params;

	public function __construct($URI, $params, AbstractRedirect $redirect) {
		parent::__construct($URI, $redirect);
		$this->params = $params;
	}

	protected function isValidURI($URI) {
		return preg_match(self::REGULAR_EXPRESSION_PARAMETERS, $URI);
	}

	public function accepted($URI) {
		$model = preg_split(self::REGULAR_EXPRESSION_PARAMETERS, $this->URI, -1, PREG_SPLIT_DELIM_CAPTURE);

		$parsedURI = explode('/', $URI);

		array_shift($parsedURI);

		if ( $parsedURI[count($parsedURI)-1] == '' ) {
			array_pop($parsedURI);
		}

		if ( count($parsedURI) > count(explode('/', $this->URI))-1 ) {
			throw new \Exception('URL inválida 2');
		}

		$urlValida = '';

		$nivelParametro = 0;
		while ( count($model) > 0 ) {
			$valueTeste = str_replace('/', '', array_shift($model));

			if ( $valueTeste == '[' ) {
				$nivelParametro++;
				continue;
			} elseif ( $valueTeste == '' ) {
				continue;
			}

			$valueURI = array_shift($parsedURI);

			# Validar os valores dos parâmetros
			if ( $valueURI == '' ) {
				break;
			} elseif ( $valueTeste[0] == ':' ) {
				$valueTeste = substr($valueTeste, -(strlen($valueTeste)-1));

				if ( preg_match('/^' . $this->params[$valueTeste] . '$/i', $valueURI) === 0 ) {
					return false;
				} else {
					$urlValida .= '/' . $valueURI;
				}
			} else {
				# Caso contrário, verificar se os valores são iguais, se sim, show, caso não, throw Exception
				if ( $valueTeste != $valueURI ) {
					return false;
				} else {
					$urlValida .= '/' . $valueTeste;
				}
			}
		}

		if ( $urlValida == '' ) {
			return false;
		}

		if ( $urlValida[strlen($urlValida)-1] != '/' ) {
			$urlValida .= '/';
		}

		if ( $URI[strlen($URI)-1] != '/' ) {
			$URI .= '/';
		}

		return $urlValida === $URI;
	}

	public function getParams() {
		//
	}

}