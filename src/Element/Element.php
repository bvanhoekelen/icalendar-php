<?php namespace Calendar\Element;

use Calendar\Bag\LineBag;
use Calendar\Holder\PropertyHolder;

abstract class Element {
	protected $property;

	abstract public function build(LineBag $lineBag);

	public function property(): PropertyHolder {
		return $this->property;
	}

	public function render(): string {
		$lineBag = new LineBag();
		$this->build($lineBag);
		return $lineBag->render();
	}
}
