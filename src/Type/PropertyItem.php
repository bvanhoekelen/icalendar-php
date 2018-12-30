<?php namespace Calendar\Type;

class PropertyItem {

	protected $name;
	protected $value;
	protected $params;

	public function __construct($name, $value) {
		$this->setName($name);
		$this->setValue($value);
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name) {
		$this->name = $name;
	}

	public function getValue() {
		return $this->value;
	}

	public function getParams(): array {
		return $this->params;
	}

	public function setParams(array $params): void {
		$this->params = $params;
	}

	public function setValue($mixed) {
		if (is_string($mixed)) {
			$this->value = $mixed;
		}
		elseif (is_array($mixed)) {
			$this->params = $mixed;
		}
		else {
			$className = get_class($mixed);
			throw new \InvalidArgumentException('Invalid property value type: ' . $className . ' by property ' . $this->getName());
		}
	}
}
