<?php

namespace Niu\Loader;

final class AutoloaderFactory {

	const DEFAULT_AUTOLOADER	= 'Niu\Loader\Loaders\DefaultLoader';

	public function __contruct() {
		throw new \Exception('Não é possível instanciar a Classe' . __CLASS__);
	}

	private static $loaders = [];

	public static function factory($options=null) {
		if ( $options === null || self::DEFAULT_AUTOLOADER ) {
			static::register(static::getDefaultLoader());
		}
	}

	private static function getDefaultLoader() {
		require_once __DIR__ . '/Loaders/DefaultLoader.php';

		$defaultAutoloader = self::DEFAULT_AUTOLOADER;
		return new $defaultAutoloader(array(
				'ns' => array(
					'Niu' => dirname(NIU_PATH) . '/Niu',
					'NiuConfig' => 'config',
					'NiuModule' => 'modules'
				)
			));
	}

	private static function register(AbstractAutoloader $loader) {
		if ( !isset( self::$loaders[ get_class($loader) ] ) ) {
			self::$loaders[ get_class($loader) ] = $loader;
			$loader->register();
		}
	}

	public static function getRegistered($loader) {
		if ( isset( self::$loaders[$loader] ) ) {
			return self::$loaders[$loader];
		}

		return FALSE;
	}

}