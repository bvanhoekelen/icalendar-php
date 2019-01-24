<?php namespace Calendar\Type;

class Property {
	public $name;   // string
	public $value;  // string or array
	public $params; // Array

	public function __construct($name, $value, $params = null) {
		$this->name = $name;
		$this->value = $value;
		$this->params = $params;
	}
}
