<?php namespace Calendar\Type;

class DateTimeType {

	const LAYOUT_DATE = 'Ymd';
	const LAYOUT_DATE_TIME_ZONE = 'Ymd\THis\Z';

	protected $dateTime;
	protected $customLayout;
	protected $noTime;

	public function __construct(\DateTime $dateTime, $noTime = null, $customLayout = false) {
		$this->dateTime = $dateTime;
		$this->customLayout = $customLayout;
		$this->noTime = $noTime;
	}

	public function render(): string {
		if ($this->noTime) {
			return $this->dateTime->format(static::LAYOUT_DATE);
		}
		if ($this->customLayout) {
			return $this->dateTime->format($this->customLayout);
		}
		$dateTime = clone $this->dateTime;
		$dateTime->setTimezone(new \DateTimeZone('UTC'));
		return $dateTime->format(static::LAYOUT_DATE_TIME_ZONE);
	}

}
