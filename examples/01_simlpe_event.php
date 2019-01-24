<?php

require_once('../vendor/autoload.php');

use Calendar\Element\Calendar;
use Calendar\Element\Event;
use Calendar\Type\RepeatingRule;

$calender = (new Calendar())
	->setColor('#00A677')
	->setName('Custom name')
	->setDescription('Custom description')
	->setId('Custom id')
	->setRefreshInterval('P1H')
;

// Add custom not existed element
$calender->property()->set('NOT-EXISTED-ELEMENT-FOR-CALENDAR', ['A' => 'A1'], ['B' => 'B1:B2', 'C' => [1,2,3]]);

// Add event
$event = (new Event())
	->setUid('com.domain.test.E1283')
	->setWholeDay(false)
	->setDtStart(new DateTime('now'))
	->setDtEnd(new DateTime('+1 day'))
	->setDtStamp(new DateTime('now'))
	->setSequence(0)
	->setTransp(Event::TRANSP_OPAQUE)
	->setClass(Event::CLASS_PUBLIC)
	->setStatus(Event::STATUS_CONFIRMED)
	->setPriority(0)
	->setSummary("short summary of the event")
	->setDescription("full description of the event")
	->setCategories(["Ical", "Simple"])
	->setUrl("https://www.google.nl")
	->setGeo(new \Calendar\Type\Geo(52.373149,4.891342))
	->setLocationWizard(
		"Koninklijk Paleis Amsterdam",
		"Koninklijk Paleis Amsterdam, Nieuwezijds Voorburgwal 147, 1012 RJ Amsterdam, Nederland",
		new \Calendar\Type\Geo(52.373149,4.891342 )
	)
;

// Custom
$event->property()->set('NOT-EXISTED-ELEMENT-FOR-EVENT', ['A' => 'A1'], ['B' => 'B1:B2', 'C' => [1,2,3]]);

// Repeating
//$event->repeat()->setRuleUntilCount(RepeatingRuleType::FREQ_DAILY, 10, 2);
$event->repeat()
	->setFrequency(RepeatingRule::FREQ_YEARLY)
	->setByDay([
		RepeatingRule::BYDAY_MO,
		RepeatingRule::BYDAY_FR,
	])
	->setBySetPos(RepeatingRule::BYSETPOS_LAST)
	->setByMonth(RepeatingRule::BYMONTH_NOV)
	->setUntil(new \DateTime('+4 weeks'));

// Organizer
//$event->setOrganizer(['CN' => 'Bart:MAILTO:bart@gmail.nl']);
$event->setOrganizerWizard('Bart','bart@gmail.nl');

// Attendee
$event->attendee()->wizard(\Calendar\Type\Attendee::PARTSTAT_ACCEPTED, "Bart", "bart@gmail.com");
$event->attendee()->wizard(\Calendar\Type\Attendee::PARTSTAT_NEEDS_ACTION, "Lisa", "lisa@gmail.com");

// Set event
$calender->setEvent($event);

// Render
//echo $calender->render(); // Render to string
echo $calender->serve(); // Render to string with headers
