<?php namespace Calendar\Type;

class RepeatingRuleType {

	protected $frequency;
	protected $count;
	protected $until;
	protected $interval;

	protected $rules;

	// Property
	const FREQ = 'FREQ';
	const COUNT = 'COUNT';
	const UNTIL = 'UNTIL';
	const INTERVAL = 'INTERVAL';

	const BYSECOND = 'BYSECOND';
	const BYMINUTE = 'BYMINUTE';
	const BYHOUR = 'BYHOUR';
	const BYDAY = 'BYDAY';
	const BYMONTHDAY = 'BYMONTHDAY';
	const BYYEARDAY = 'BYYEARDAY';
	const BYWEEKNO = 'BYWEEKNO';
	const BYMONTH = 'BYMONTH';
	const BYSETPOS = 'BYSETPOS';
	const WKST = 'WKST';

	// Frequency
	const FREQ_SECONDLY = 'SECONDLY';
	const FREQ_MINUTELY = 'MINUTELY';
	const FREQ_HOURLY = 'HOURLY';
	const FREQ_DAILY = 'DAILY';
	const FREQ_WEEKLY = 'WEEKLY';
	const FREQ_MONTHLY = 'MONTHLY';
	const FREQ_YEARLY = 'YEARLY';

	// BYDay
	const BYDAY_SU = 'SU';
	const BYDAY_MO = 'MO';
	const BYDAY_TU = 'TU';
	const BYDAY_WE = 'WE';
	const BYDAY_TH = 'TH';
	const BYDAY_FR = 'FR';
	const BYDAY_SA = 'SA';

	public function __construct(array $rules = []) {
		$this->rules = $rules;
	}

	public function setRuleUntilCount($frequency, $count, $interval = 1): void {
		$this->frequency = $frequency;
		$this->count = $count;
		$this->interval = $interval;
	}

	public function setRuleToUntilDate($frequency, \DateTime $until, $interval = 1): void {
		$this->frequency = $frequency;
		$this->until = $until;
		$this->interval = $interval;
	}

	public function getRules(): array {
		$rules = $this->rules;
		if ($this->frequency) {
			$rules[static::FREQ] = $this->frequency;
		}
		if ($this->count) {
			$rules[static::COUNT] = $this->count;
		}
		if ($this->until) {
			$dateTimeType = new DateTimeType($this->until);
			$rules[static::UNTIL] = $dateTimeType->render();
		}
		if ($this->interval) {
			$rules[static::INTERVAL] = $this->interval;
		}

		return $rules;
	}

	public function setFrequency(string $frequency): void {
		$this->frequency = $frequency;
	}

	public function setCount(int $count): void {
		$this->count = $count;
	}

	public function setUntil(\DateTime $until): void {
		$this->until = $until;
	}

	public function setInterval(int $interval): void {
		$this->interval = $interval;
	}

	public function setRules(array $rules): void {
		$this->rules = $rules;
	}
}
