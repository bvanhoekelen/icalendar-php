<?php

require_once('../vendor/autoload.php');

use Calendar\Element\Calendar;
use Calendar\Element\Event;
use Calendar\Type\RepeatingRuleType;

$calender = (new Calendar())
	->setDebugMode(true)
	->setProductId('-//Custom//Id')
	->setVersion('2.0')
	->setCalscale(Calendar::CALSCALE_GREGORIAN)
	->setMethod(Calendar::METHOD_PUBLISH)
	->setColor('#00A699')
	->setName('Custom name')
	->setDescription('Custom description')
	->setId('Custom id')
	->setRefreshInterval('P1H');

// Add custom not existed element
$calender->property()->set('NOT-EXISTED-ELEMENT-A', 'Test');
$calender->property()->set('NOT-EXISTED-ELEMENT-B', ['CN' => 'A', 'CN' => 'A:B', 'B']);
$calender->property()->set('NOT-EXISTED-ELEMENT-C', ['CN' => ['A','B']]);

// Add event
$event = (new Event())
	->setUid('com.domain.test.E1283')
	->setNoTime(true)
	->setDtStart(new DateTime('now'))
	->setDtEnd(new DateTime('+1 day'))
	->setCreated(new DateTime('-1 day'))
	->setLastModified(new DateTime('-1 day'));

// Repeating
$event->repeat()->setRuleUntilCount(RepeatingRuleType::FREQ_DAILY, 10, 2);

// Status
$event->setStatus(Event::STATUS_CONFIRMED);

// Organizer
//$event->setOrganizer('');
$event->setOrganizerWizard('Bart','bart@gmail.nl');


$calender->setEvent($event);

//$calender->serve();
echo $calender->render();
//dd($calender, $calender->render());
