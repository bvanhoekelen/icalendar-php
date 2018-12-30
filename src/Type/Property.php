<?php namespace Calendar\Type;

use Calendar\Bag\LineBag;

class Property {

	protected $propertyList;
	protected $propertyPositionList;
	protected $startLine;
	protected $endLine;

	public function __construct() {
		$this->propertyList = [];
	}

	public function set($element, $value, $position = null): void {
		if (!$position) {
			$position = count($this->propertyList);
		}

		if (isset($this->propertyPositionList[$element])) {
			$position = $this->propertyPositionList[$element];
		}
		else {
			$this->propertyPositionList[$element] = $position;
		}

		$this->propertyList[$position] = new PropertyItem($element, $value);
	}

	public function getPropertyList(): array {
		return $this->propertyList;
	}

	protected function toLine(PropertyItem $item): string {
		if ($item->getValue()) {
			return $item->getName() . ':' . $item->getValue();
		}
		if (count($item->getParams())) {
			$lines = [];
			foreach ($item->getParams() as $paramKey => $paramValue) {
				if ($paramKey) {
					$lines[] = $paramKey . '=' . $paramValue;
				}
				else {
					$lines[] = $paramValue;
				}
			}
			return $item->getName() . ';' . implode(";", $lines);
		}
		return $item->getName();
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
