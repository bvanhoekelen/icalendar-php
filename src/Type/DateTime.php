<?php namespace Calendar\Type;

class DateTime {
	const LAYOUT_DATE = 'Ymd';
	const LAYOUT_DATE_TIME_ZONE = 'Ymd\THis\Z';

	protected $dateTime;
	protected $customLayout;
	protected $wholeDay;

	public function __construct(\DateTime $dateTime, $wholeDay = false, $customLayout = false) {
		$this->dateTime = $dateTime;
		$this->customLayout = $customLayout;
		$this->wholeDay = $wholeDay;
	}

	public function render(): string {
		if ($this->wholeDay) {
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
