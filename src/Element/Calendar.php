<?php namespace Calendar\Element;

use Calendar\Bag\LineBag;
use Calendar\Holder\PropertyHolder;

class Calendar extends Element {
	protected $debugMode = false;
	protected $eventList;

	// Property
	const PRODID = 'PRODID';
	const VERSION = 'VERSION';
	const CALSCALE = 'CALSCALE';
	const METHOD = 'METHOD';
	const NAME = 'NAME';
	const DESCRIPTION = 'DESCRIPTION';
	const REFRESH_INTERVAL = 'REFRESH-INTERVAL';

	// X property
	const X_MICROSOFT_CALSCALE = 'X-MICROSOFT-CALSCALE';
	const X_APPLE_CALENDAR_COLOR = 'X-APPLE-CALENDAR-COLOR';
	const X_OUTLOOK_COLOR = 'X-OUTLOOK-COLOR';
	const X_FUNAMBOL_COLOR = 'X-FUNAMBOL-COLOR';
	const X_WR_CALNAME = 'X-WR-CALNAME';
	const X_WR_CALDESC = 'X-WR-CALDESC';
	const X_WR_RELCALID = 'X-WR-RELCALID';
	const X_PUBLISHED_TTL = 'X-PUBLISHED-TTL';

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
		$this->property->set(static::PRODID, $value);
		return $this;
	}

	public function setVersion(string $value): self {
		$this->property->set(static::VERSION, $value);
		return $this;
	}

	public function setCalscale(string $value): self {
		$this->property->set(static::CALSCALE, $value);
		$this->property->set(static::X_MICROSOFT_CALSCALE, $value);
		return $this;
	}

	public function setMethod(string $value): self {
		$this->property->set(static::METHOD, $value);
		return $this;
	}

	public function setColor(string $value): self {
		$this->property->set(static::X_APPLE_CALENDAR_COLOR, $value);
		$this->property->set(static::X_OUTLOOK_COLOR, $value);
		$this->property->set(static::X_FUNAMBOL_COLOR, $value);
		return $this;
	}

	public function setName(string $value): self {
		$this->property->set(static::NAME, $value);
		$this->property->set(static::X_WR_CALNAME, $value);
		return $this;
	}

	public function setDescription(string $value): self {
		$this->property->set(static::DESCRIPTION, $value);
		$this->property->set(static::X_WR_CALDESC, $value);
		return $this;
	}

	public function setId(string $value): self {
		$this->property->set(static::X_WR_RELCALID, $value);
		return $this;
	}

	public function setRefreshInterval(string $value): self {
		$this->property->set(static::METHOD_REFRESH, ['VALUE' => 'DURATION:' . $value]);
		$this->property->set(static::X_PUBLISHED_TTL, $value);
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

	public function newEvent(): Event {
		$event = new Event();
		$this->eventList[] = $event;
		return $event;
	}

	// Default
	public function setDefault(): self {
		$this->setVersion('2.0');
		$this->setProductId('-//iCalendar tool//github.com/bvanhoekelen/icalendar-php 1.0.0//EN');
		$this->setCalscale(static::CALSCALE_GREGORIAN);
		$this->setMethod(static::METHOD_PUBLISH);
		return $this;
	}

	// Build
	public function __construct($setDefault = true) {
		$this->property = new PropertyHolder();
		$this->property->setStartAndEnd('VCALENDAR');
		$this->eventList = [];
		if($setDefault){
			$this->setDefault();
		}
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

	public function serve(): string {
		$this->setHeader();
		return $this->render();
	}

}
