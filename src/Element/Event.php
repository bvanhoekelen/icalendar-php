<?php namespace Calendar\Element;

use Calendar\Bag\LineBag;
use Calendar\Type\Attendee;
use Calendar\Type\DateTime;
use Calendar\Holder\PropertyHolder;
use Calendar\Type\Geo;
use Calendar\Type\Location;
use Calendar\Type\Property;
use Calendar\Type\RepeatRule;
use Prophecy\Exception\InvalidArgumentException;

class Event extends Element {
	const UID = 'UID';
	const DTSTART = 'DTSTART';
	const DTEND = 'DTEND';
	const DTSTAMP = 'DTSTAMP';
//	const CREATED = 'CREATED'; // FOR APPLICATION DATABASE
//	const LAST_MODIFIED = 'LAST-MODIFIED'; // FOR APPLICATION DATABASE

	// Repeat
	const RRULE = 'RRULE';
//	const PROPERTY_EXDATE = 'EXDATE';

	const SEQUENCE = 'SEQUENCE';
	const TRANSP = 'TRANSP';
	const P_CLASS = 'CLASS';

	const STATUS = 'STATUS';
	const ORGANIZER = 'ORGANIZER';
	const ATTENDEE = 'ATTENDEE'; //

	const PRIORITY = 'PRIORITY';
	const SUMMARY = 'SUMMARY';
	const DESCRIPTION = 'DESCRIPTION';
	const CATEGORIES = 'CATEGORIES';
	const URL = 'URL';

	const LOCATION = 'LOCATION';
	const GEO = 'GEO';

	// Property X
	const X_APPLE_TRAVEL_ADVISORY_BEHAVIOR = 'X-APPLE-TRAVEL-ADVISORY-BEHAVIOR';
	const X_APPLE_STRUCTURED_LOCATION = 'X-APPLE-STRUCTURED-LOCATION';
	const X_APPLE_TRAVEL_DURATION = 'X-APPLE-TRAVEL-DURATION';

	// Transparency
	const TRANSP_OPAQUE = 'OPAQUE';
	const TRANSP_TRANSPARENT = 'TRANSPARENT';

	// Class
	const CLASS_PUBLIC = "PUBLIC";
	const CLASS_PRIVATE = "PRIVATE";
	const CLASS_CONFIDENTIAL = "CONFIDENTIAL";

	// Status
	const STATUS_TENTATIVE = 'TENTATIVE';
	const STATUS_CONFIRMED = 'CONFIRMED';
	const STATUS_CANCELLED = 'CANCELLED';

	// SENT-BY
	const ORGANIZER_CN = 'CN';
	const ORGANIZER_SENT_BY = 'SENT-BY';

	// Date options
	protected $wholeDay;
	protected $dateCustomLayout;

	// Wizard
	protected $attendee = [];

	// Options
	public function setUid(string $value): self {
		$this->property->set(static::UID, $value);
		return $this;
	}

	public function setWholeDay(): self {
		$this->wholeDay = true;
		return $this;
	}

	public function setDateCustomLayout(string $value): self {
		$this->dateCustomLayout = $value;
		return $this;
	}

	public function setDtStart(\DateTime $dateTime): self {
		$dateTimeType = new DateTime($dateTime, $this->wholeDay, $this->dateCustomLayout);
		$this->property->set(static::DTSTART, $dateTimeType->render());
		return $this;
	}

	public function setStart(\DateTime $dateTime): self {
		return $this->setDtStart($dateTime);
	}

	public function setDtEnd(\DateTime $dateTime): self {
		$dateTimeType = new DateTime($dateTime, $this->wholeDay, $this->dateCustomLayout);
		$this->property->set(static::DTEND, $dateTimeType->render());
		return $this;
	}

	public function setEnd(\DateTime $dateTime): self {
		return $this->setDtEnd($dateTime);
	}

	public function setDtStamp(\DateTime $dateTime): self {
		$dateTimeType = new DateTime($dateTime);
		$this->property->set(static::DTSTAMP, $dateTimeType->render());
		return $this;
	}

	public function setRRule($mixed): self {
		if($mixed instanceof RepeatRule){
			$this->property->setProperty($mixed->getProperty());
		}
		elseif($mixed instanceof Property){
			$this->property->setProperty($mixed);
		}
		else{
			throw new InvalidArgumentException("param has to be a instance of RepeatRule or property");
		}
		return $this;
	}

	public function setRepeatRule(RepeatRule $repeatRule): self {
		$this->setRRule($repeatRule);
		return $this;
	}

	public function setRepeatObject(RepeatRule $repeatingRuleType): self {
		$this->repeat = $repeatingRuleType;
		return $this;
	}

	public function setSequence(int $int = 0): self {
		$this->property->set(static::SEQUENCE, $int);
		return $this;
	}

	public function setTransp(string $value): self {
		$this->property->set(static::TRANSP, $value);
		return $this;
	}

	public function setClass(string $value): self {
		$this->property->set(static::P_CLASS, $value);
		return $this;
	}

	public function setStatus(string $value): self {
		$this->property->set(static::STATUS, $value);
		return $this;
	}

	public function setOrganizer(array $params): self {
		$this->property->set(static::ORGANIZER, null, $params);
		return $this;
	}

	public function setOrganizerWizard(string $name, string $email): self {
		$this->property->set(static::ORGANIZER, null, ['CN' => $name . ':MAILTO:' . $email]);
		return $this;
	}

	public function setAttendee(Attendee $attendee, $number = null): self {
		if (!is_int($number)) {
			$number = count($this->attendee);
		}
		$this->attendee[$number] = $attendee;
		return $this;
	}

	public function setPriority(int $priority): self {
		$this->property->set(static::PRIORITY, $priority);
		return $this;
	}

	public function setSummary(string $summery): self {
		$this->property->set(static::SUMMARY, $summery);
		return $this;
	}

	public function setDescription(string $description): self {
		$this->property->set(static::DESCRIPTION, $description);
		return $this;
	}

	public function setCategories(array $categories): self {
		$this->property->set(static::DESCRIPTION, implode(",", $categories));
		return $this;
	}

	public function setUrl(string $url): self {
		$this->property->set(static::URL, $url);
		return $this;
	}

	// Location
	public function setLocation($location): self {
		if($location instanceof Location){
			$location = $location->getLocationLine();
		}
		if(!is_string($location)){
			throw new InvalidArgumentException("location has to be a instance of location class or string");
		}
		$this->property->set(static::LOCATION, $location);
		return $this;
	}

	public function setGeo(Geo $geo): self {
		if($geo == null){
			return $this;
		}
		$this->property->set(static::GEO, $geo->latitude . ";" . $geo->longitude);
		return $this;
	}

	public function setTravelDuration(string $duration): self {
		$this->property->set(static::X_APPLE_TRAVEL_DURATION, null, ["VALUE" => "DURATION:" . $duration]); // PT15M
		return $this;
	}

	public function setLocationWizard(Location $location): self {
		$this->setLocation($location);
		$this->setGeo($location->getGeo());
		$this->property->setProperty($location->getAppleStructuredLocationProperty());
		return $this;
	}

	// Build
	public function __construct($setDefault = true) {
		$this->property = new PropertyHolder();
		$this->property->setStartAndEnd('VEVENT');
		if ($setDefault) {
			$this->setDefault();
		}
	}

	public function setDefault() {
		$this->setUid(md5(random_bytes(20)));
		$this->setDtStamp(new \DateTime('now'));
		$this->setSequence(0);
		$this->setTransp(self::TRANSP_OPAQUE);
		$this->setStatus(self::STATUS_CONFIRMED);

	}

	protected function prepareAttendee() {
		if (count($this->attendee)) {
			foreach ($this->attendee as $key => $attendee) {
				$this->property->set(self::ATTENDEE, null, $attendee->getRules(), false);
			}
		}
	}

	public function build(LineBag $lineBag) {
		$this->prepareAttendee();
		$this->property->buildStartLine($lineBag);
		$this->property->build($lineBag);
		$this->property->buildEndLine($lineBag);
		return $lineBag;
	}
}
