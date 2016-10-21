<?php

namespace Niu\Security;

class XSSSecure {

	public static function validURI($URI) {
		return preg_match('/(\<|%3C).*(.*)(\>|%3E)/', $URI) == 0;
	}

}