<?php

require_once('../vendor/autoload.php');

use Calendar\Element\Calendar;
use Calendar\Type\RepeatRule;

$calender = (new Calendar())
	->setColor('#00A677')
	->setName('Custom name')
	->setDescription('Custom description')
	->setRefreshInterval('P1H')
;

// Add Event
$calender->newEvent()
	->setDtStart(new DateTime('now'))
	->setDtEnd(new DateTime('+1 day'))
	->setDtStamp(new DateTime('now'))
	->setSummary('short summary of the event')
	->setDescription('full description of the event')
	->setUrl('https://www.google.nl')
	// Repeat
	->setRepeatRule((new RepeatRule(RepeatRule::FREQ_YEARLY))
		->setByDay(RepeatRule::BYDAY_TH)
		->setBySetPos(RepeatRule::BYSETPOS_FIRST)
		->setByMonth(RepeatRule::BYMONTH_NOV)
		->setCount(7)
	)
;

// Render to string with headers
echo $calender->serve();
