<?php namespace Calendar\Type;

use Calendar\Element\Event;

class RepeatingRule {
	protected $frequency;
	protected $count;
	protected $until;
	protected $interval;
	protected $byDay;
	protected $byMonth;
	protected $byMonthDay;
	protected $bySetPos;

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
	const BYMONTH = 'BYMONTH';
	const BYWEEKNO = 'BYWEEKNO';
	const BYMONTHDAY = 'BYMONTHDAY';
	const BYYEARDAY = 'BYYEARDAY';
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

	// ByDay
	const BYDAY_SU = 'SU';
	const BYDAY_MO = 'MO';
	const BYDAY_TU = 'TU';
	const BYDAY_WE = 'WE';
	const BYDAY_TH = 'TH';
	const BYDAY_FR = 'FR';
	const BYDAY_SA = 'SA';

	// ByMonth
	const BYMONTH_JAN = 1;
	const BYMONTH_FEB = 2;
	const BYMONTH_MAR = 3;
	const BYMONTH_APR = 4;
	const BYMONTH_MAY = 5;
	const BYMONTH_JUN = 6;
	const BYMONTH_JUL = 7;
	const BYMONTH_AUG = 8;
	const BYMONTH_SEP = 9;
	const BYMONTH_OCT = 10;
	const BYMONTH_NOV = 11;
	const BYMONTH_DEC = 12;

	// Set pos
	const BYSETPOS_FIRST = 1;
	const BYSETPOS_SECOND = 2;
	const BYSETPOS_THIRD = 3;
	const BYSETPOS_FOURTH = 4;
	const BYSETPOS_LAST = -1;

	public function __construct($frequency = null, array $rules = []) {
		$this->rules = $rules;
		$this->frequency = $frequency;
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

	public function setFrequency(string $frequency): self {
		$this->frequency = $frequency;
		return $this;
	}

	public function setCount(int $count): self {
		$this->count = $count;
		return $this;
	}

	public function setUntil(\DateTime $until): self {
		$this->until = $until;
		return $this;
	}

	public function setInterval(int $interval): self {
		$this->interval = $interval;
		return $this;
	}

	public function setByDay($mixed): self {
		$this->byDay = $mixed;
		return $this;
	}

	public function setByMonth(int $monthNumber): self {
		$this->byMonth = $monthNumber;
		return $this;
	}

	public function setByMonthDay(int $dayNumber): self {
		$this->byMonthDay = $dayNumber;
		return $this;
	}

	public function setBySetPos(int $value): self {
		$this->bySetPos = $value;
		return $this;
	}

	// Rules
	public function setRules(array $rules): self {
		$this->rules = $rules;
		return $this;
	}

	public function getProperty(): Property {
		// Check Frequencies
		if (!$this->frequency) {
			throw new \InvalidArgumentException("missing frequency by repeating rule");
		}
		$rules = $this->rules;
		if ($this->byDay) {
			$rules[static::BYDAY] = $this->byDay;
		}
		if ($this->byMonth) {
			$rules[static::BYMONTH] = $this->byMonth;
		}
		if ($this->byMonthDay) {
			$rules[static::BYMONTHDAY] = $this->byMonthDay;
		}
		if ($this->bySetPos) {
			$rules[static::BYSETPOS] = $this->bySetPos;
		}
		if ($this->count) {
			$rules[static::COUNT] = $this->count;
		}
		if ($this->until) {
			$dateTimeType = new DateTime($this->until);
			$rules[static::UNTIL] = $dateTimeType->render();
		}
		if ($this->interval) {
			$rules[static::INTERVAL] = $this->interval;
		}
		return new Property(Event::RRULE, [static::FREQ => $this->frequency], $rules);
	}
}
