<?php

require_once('../vendor/autoload.php');

use Calendar\Element\Calendar;
use Calendar\Type\Location;
use Calendar\Type\Geo;

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
	// Add Location
	->setLocationWizard(((new Location())
		->setTitle('Koninklijk Paleis Amsterdam')
		->setStreetAddress('Nieuwezijds Voorburgwal 147')
		->setZipCode('1012 RJ')
		->setCity('Amsterdam')
		->setCountry('Nederland')
		->setGeo(new Geo(52.373149,4.891342))
	))
;

// Render to string with headers
echo $calender->serve();
