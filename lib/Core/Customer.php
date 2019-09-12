<?php

namespace Fripixel\DLocal\Core;

class Customer {
	public function __get ($property) {
		return $this->$property;
	}

	public function __set ($property, $value) {
		$this->$property = $value;
		return $this;
	}
}
