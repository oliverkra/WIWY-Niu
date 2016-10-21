<?php

namespace Niu\Module\Filters;

class RoutedModuleFilter extends \FilterIterator {

	public function __construct(\Iterator $iterator){
		parent::__construct($iterator);
	}

	public function accept() {
		return ($this->getInnerIterator()->current() instanceof \Niu\Module\Modules\RoutedModule);
	}

}