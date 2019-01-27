<?php

require_once('../vendor/autoload.php');

use Calendar\Element\Calendar;

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
	->setUrl('https://www.google.nl');

// Render
echo $calender->serve(); // Render to string with headers
