<?php namespace Calendar\Element;

use Calendar\Bag\LineBag;
use Calendar\Type\DateTimeType;
use Calendar\Type\Property;
use Calendar\Type\RepeatingRuleType;

class Event {
	protected $property;

	const PROPERTY_UID = 'UID';
	const PROPERTY_DTSTART = 'DTSTART';
	const PROPERTY_DTEND = 'DTEND';
	const PROPERTY_CREATED = 'CREATED';
	const PROPERTY_LAST_MODIFIED = 'LAST-MODIFIED';

	// Repeat
	const PROPERTY_RRULE = 'RRULE';
//	const PROPERTY_DTSTAMP = 'DTSTAMP';
//	const PROPERTY_EXDATE = 'EXDATE';

	const PROPERTY_SEQUENCE = 'SEQUENCE';
	const PROPERTY_TRANSP = 'TRANSP';
	const PROPERTY_CLASS = 'CLASS';

	const PROPERTY_STATUS = 'STATUS';
	const PROPERTY_ORGANIZER = 'ORGANIZER';
	const PROPERTY_ATTENDEE = 'ATTENDEE';

	const PROPERTY_PRIORITY = 'PRIORITY';
	const PROPERTY_SUMMARY = 'SUMMARY';
	const PROPERTY_DESCRIPTION = 'DESCRIPTION';
	const PROPERTY_CATEGORIES = 'CATEGORIES';
	const PROPERTY_URL = 'URL';

	const PROPERTY_LOCATION = 'LOCATION';
	const PROPERTY_GEO = 'GEO';

	// Property X
	const PROPERTY_X_APPLE_TRAVEL_ADVISORY_BEHAVIOR = 'X-APPLE-TRAVEL-ADVISORY-BEHAVIOR';
	const PROPERTY_X_APPLE_STRUCTURED_LOCATION = 'X-APPLE-STRUCTURED-LOCATION';

	// Transparency
	const TIME_TRANSP_OPAQUE = 'OPAQUE';
	const TIME_TRANSP_TRANSPARENT = 'TRANSPARENT';

	// Status
	const STATUS_TENTATIVE = 'TENTATIVE';
	const STATUS_CONFIRMED = 'CONFIRMED';
	const STATUS_CANCELLED = 'CANCELLED';

	// Date options
	protected $noTime;
	protected $dateCustomLayout;

	// More
	protected $repeat;

	// Options
	public function setUid(string $value): self {
		$this->property->set(static::PROPERTY_UID, $value);
		return $this;
	}

	public function setNoTime(): self {
		$this->noTime = true;
		return $this;
	}

	public function setDateCustomLayout(string $value): self {
		$this->dateCustomLayout = $value;
		return $this;
	}

	public function setDtStart(\DateTime $dateTime): self {
		$dateTimeType = new DateTimeType($dateTime, $this->noTime, $this->dateCustomLayout);
		$this->property->set(static::PROPERTY_DTSTART, $dateTimeType->render());
		return $this;
	}

	public function setStart(\DateTime $dateTime): self {
		return $this->setDtStart($dateTime);
	}

	public function setDtEnd(\DateTime $dateTime): self {
		$dateTimeType = new DateTimeType($dateTime, $this->noTime, $this->dateCustomLayout);
		$this->property->set(static::PROPERTY_DTEND, $dateTimeType->render());
		return $this;
	}

	public function setEnd(\DateTime $dateTime): self {
		return $this->setDtEnd($dateTime);
	}

	public function setLastModified(\DateTime $dateTime): self {
		$dateTimeType = new DateTimeType($dateTime);
		$this->property->set(static::PROPERTY_LAST_MODIFIED, $dateTimeType->render());
		return $this;
	}

	public function setCreated(\DateTime $dateTime): self {
		$dateTimeType = new DateTimeType($dateTime);
		$this->property->set(static::PROPERTY_CREATED, $dateTimeType->render());
		return $this;
	}

	public function setRRule($value): self {
		$this->property->set(static::PROPERTY_RRULE, $value);
		return $this;
	}

	public function repeat(): RepeatingRuleType {
		if ($this->repeat) {
			return $this->repeat;
		}
		$this->repeat = new RepeatingRuleType();
		return $this->repeat;
	}

	public function setSequence(int $int): self {
		$this->property->set(static::PROPERTY_SEQUENCE, $int);
		return $this;
	}

	public function setTransp(string $value): self {
		$this->property->set(static::TIME_TRANSP_TRANSPARENT, $value);
		return $this;
	}

	public function setClass(string $value): self {
		$this->property->set(static::PROPERTY_CLASS, $value);
		return $this;
	}

	public function setStatus(string $value): self {
		$this->property->set(static::PROPERTY_STATUS, $value);
		return $this;
	}

	public function setOrganizer(string $value): self {
		$this->property->set(static::PROPERTY_ORGANIZER, $value);
		return $this;
	}

	public function setOrganizerWizard(string $name, string $email): self {
		$this->property->set(static::PROPERTY_ORGANIZER, ['CN' => $name . ':MAILTO:' . $email, 'G' => $email,]);
		return $this;
	}

	// Build
	public function __construct() {
		$this->property = new Property();
		$this->property->setStartAndEnd('VEVENT');
	}

	protected function prepareUid() {
		if (!$this->property->get(self::PROPERTY_UID)) {
			$this->setUid(md5(random_bytes(20)));
		}
	}

	protected function prepareRepeat() {
		if ($this->repeat) {
			$this->setRRule($this->repeat->getRules());
		}
	}

	public function build(LineBag $lineBag) {
		$this->prepareUid();
		$this->prepareRepeat();
		$this->property->buildStartLine($lineBag);
		$this->property->build($lineBag);
		$this->property->buildEndLine($lineBag);
		return $lineBag;
	}
}
