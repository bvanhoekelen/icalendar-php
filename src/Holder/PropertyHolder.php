<?php namespace Calendar\Holder;

use Calendar\Bag\LineBag;
use Calendar\Type\Property;

class PropertyHolder {
	protected $propertyList;
	protected $propertyPositionList;
	protected $startLine;
	protected $endLine;

	public function __construct() {
		$this->propertyList = [];
	}

	public function setProperty(Property $item, $overwriteOnExist = null): void {
		$position = $this->createPosition($item->name, $overwriteOnExist);
		$this->propertyList[$position] = $item;
	}

	public function set($element, $value, $parameters = null, $overwriteOnExist = null): void {
		$position = $this->createPosition($element, $overwriteOnExist);
		$this->propertyList[$position] = new Property($element, $value, $parameters);
	}

	private function createPosition($element, $overwriteOnExist = true): int {
		$overwrite = is_null($overwriteOnExist) ? true : $overwriteOnExist; // fix null
		$position = count($this->propertyList);
		if ($overwrite and isset($this->propertyPositionList[$element])) {
			$position = $this->propertyPositionList[$element];
		}
		else {
			$this->propertyPositionList[$element] = $position;
		}
		return $position;
	}

	public function setWithValue($element, $value, $params = null, $position = null) {
		$this->propertyList[$position] = new Property($element, $value, $params);
	}

	public function get($element, $position = null) {
		if (!$position and isset($this->propertyPositionList[$element])) {
			$position = $this->propertyPositionList[$element];
		}
		if ($position >= 0) {
			if (isset($this->propertyList[$position])) {
				return $this->propertyList[$position];
			}
			return null;
		}
	}

	public function getPropertyList(): array {
		return $this->propertyList;
	}

	protected function toLine(Property $item): string {
		$line = $item->name;
		// Value
		if (is_array($item->value)) {
			$lines = [];
			foreach ($item->value as $key => $value) {
				$lines[] = $key . '=' . $value;
			}
			$line .= ":" . implode(';', $lines);
		}
		elseif ($item->value) {
			$line .= ":" . $item->value;
		}

		// Params
		if (count($item->params) != 0) {
			$lines = [];
			foreach ($item->params as $key => $value) {
				if (is_array($value)) {
					$value = implode(',', $value);
				}
				if (is_int($key)) {

				}
				else {
					$lines[] = $key . '=' . $value;
				}

			}
			$line .= ';' . implode(';', $lines);
		}

		return $line;
	}

	public function build(LineBag $lineBag): void {
		foreach ($this->propertyList as $item) {
			$lineBag->set($this->toLine($item));
		}
	}

	public function setStartLine($value) {
		$this->startLine = $value;
	}

	public function setEndLine($value) {
		$this->endLine = $value;
	}

	public function setStartAndEnd($element) {
		$this->setStartLine('BEGIN:' . $element);
		$this->setEndLine('END:' . $element);
	}

	public function getStartLine() {
		return $this->startLine;
	}

	public function getEndLine() {
		return $this->endLine;
	}

	public function buildStartLine(LineBag $lineBag): void {
		if ($this->startLine) {
			$lineBag->set($this->startLine);
		}
	}

	public function buildEndLine(LineBag $lineBag): void {
		if ($this->endLine) {
			$lineBag->set($this->endLine);
		}
	}

}
