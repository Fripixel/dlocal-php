<?php

namespace Fripixel\DLocal\Data;

class Card {
	public function __get ($property) {
		if ($property === "bin") {
			return $this->getBin();
		} else {
			return $this->$property;
		}
		return $this->$property;
	}

	public function __set ($property, $value) {
		$this->$property = $value;
		return $this;
	}	

	public function getBin () {
		return getCreditCardBin($this->number);		
	}
}
