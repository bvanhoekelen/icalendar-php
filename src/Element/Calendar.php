<?php namespace Calendar\Element;

use Calendar\Bag\LineBag;
use Calendar\Type\Property;

class Calendar extends Element {
	protected $debugMode = false;
	protected $eventList;

	// Property
	const PROPERTY_PRODID = 'PRODID';
	const PROPERTY_VERSION = 'VERSION';
	const PROPERTY_CALSCALE = 'CALSCALE';
	const PROPERTY_METHOD = 'METHOD';
	const PROPERTY_NAME = 'NAME';
	const PROPERTY_DESCRIPTION = 'DESCRIPTION';
	const PROPERTY_REFRESH_INTERVAL = 'REFRESH-INTERVAL';

	// X property
	const PROPERTY_X_MICROSOFT_CALSCALE = 'X-MICROSOFT-CALSCALE';
	const PROPERTY_X_APPLE_CALENDAR_COLOR = 'X-APPLE-CALENDAR-COLOR';
	const PROPERTY_X_OUTLOOK_COLOR = 'X-OUTLOOK-COLOR';
	const PROPERTY_X_FUNAMBOL_COLOR = 'X-FUNAMBOL-COLOR';
	const PROPERTY_X_WR_CALNAME = 'X-WR-CALNAME';
	const PROPERTY_X_WR_CALDESC = 'X-WR-CALDESC';
	const PROPERTY_X_WR_RELCALID = 'X-WR-RELCALID';
	const PROPERTY_X_PUBLISHED_TTL = 'X-PUBLISHED-TTL';

	// Method
	const METHOD_REQUEST = 'REQUEST';
	const METHOD_PUBLISH = 'PUBLISH';
	const METHOD_REPLY = 'REPLY';
	const METHOD_ADD = 'ADD';
	const METHOD_CANCEL = 'CANCEL';
	const METHOD_REFRESH = 'REFRESH';
	const METHOD_COUNTER = 'COUNTER';
	const METHOD_DECLINECOUNTER = 'DECLINECOUNTER';

	// Calscale
	const CALSCALE_GREGORIAN = 'GREGORIAN'; // Default

	// Options
	public function setDebugMode(bool $bool): self {
		$this->debugMode = $bool;
		return $this;
	}

	public function setProductId(string $value): self {
		$this->property->set(static::PROPERTY_PRODID, $value);
		return $this;
	}

	public function setVersion(string $value): self {
		$this->property->set(static::PROPERTY_VERSION, $value);
		return $this;
	}

	public function setCalscale(string $value): self {
		$this->property->set(static::PROPERTY_CALSCALE, $value);
		$this->property->set(static::PROPERTY_X_MICROSOFT_CALSCALE, $value);
		return $this;
	}

	public function setMethod(string $value): self {
		$this->property->set(static::PROPERTY_METHOD, $value);
		return $this;
	}

	public function setColor(string $value): self {
		$this->property->set(static::PROPERTY_X_APPLE_CALENDAR_COLOR, $value);
		$this->property->set(static::PROPERTY_X_OUTLOOK_COLOR, $value);
		$this->property->set(static::PROPERTY_X_FUNAMBOL_COLOR, $value);
		return $this;
	}

	public function setName(string $value): self {
		$this->property->set(static::PROPERTY_NAME, $value);
		$this->property->set(static::PROPERTY_X_WR_CALNAME, $value);
		return $this;
	}

	public function setDescription(string $value): self {
		$this->property->set(static::PROPERTY_DESCRIPTION, $value);
		$this->property->set(static::PROPERTY_X_WR_CALDESC, $value);
		return $this;
	}

	public function setId(string $value): self {
		$this->property->set(static::PROPERTY_X_WR_RELCALID, $value);
		return $this;
	}

	public function setRefreshInterval(string $value): self {
		$this->property->set(static::METHOD_REFRESH, ['VALUE' => 'DURATION:' . $value]);
		$this->property->set(static::PROPERTY_X_PUBLISHED_TTL, $value);
		return $this;
	}

	public function setHeader(): self {
		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename=cal.ics');
		return $this;
	}

	// Event
	public function setEvent(Event $event): self {
		$this->eventList[] = $event;
		return $this;
	}

	// Default
	public function setDefault(): self {
		$this->setProductId('-//iCalendar tool//github.com/bvanhoekelen/icalendar-php 1.0.0//EN');
		$this->setVersion('2.0');
		$this->setCalscale(static::CALSCALE_GREGORIAN);
		$this->setMethod(static::METHOD_PUBLISH);
		return $this;
	}

	// Build
	public function __construct() {
		$this->property = new Property();
		$this->property->setStartAndEnd('VCALENDAR');
		$this->eventList = [];
		$this->setDefault();
	}

	public function build(LineBag $lineBag): LineBag {
		$this->property->buildStartLine($lineBag);
		$this->property->build($lineBag);
		$this->buildEvents($lineBag);
		$this->property->buildEndLine($lineBag);
		return $lineBag;
	}

	public function buildEvents(LineBag $lineBag) {
		foreach ($this->eventList as $event) {
			$event->build($lineBag);
		}
	}

	public function serve() {
		$this->setHeader();
		echo $this->render();
	}

}
