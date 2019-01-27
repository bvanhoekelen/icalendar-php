# 📆 PHP iCalendar simple parser tool 🛠

[![Hex.pm](https://img.shields.io/hexpm/l/plug.svg?maxAge=2592000&style=flat-square)](https://github.com/bvanhoekelen/icalendar-php/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/bvanhoekelen/icalendar-php.svg?style=flat-square)](https://github.com/bvanhoekelen/icalendar-php/releases)
[![Packagist](https://img.shields.io/packagist/dt/bvanhoekelen/icalendar-php.svg?style=flat-square)](https://packagist.org/packages/bvanhoekelen/icalendar-php)
[![Github issues](https://img.shields.io/github/issues/bvanhoekelen/icalendar-php.svg?style=flat-square)](https://github.com/bvanhoekelen/icalendar-php/issues)
```
composer require bvanhoekelen/icalendar-php
```

## Highlight
- Generate simpel ical sub

## Example
```php
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
	)
	// Add organizer
	->setOrganizerWizard('Bart', 'exemple@gmail.com')
	// Add attended
	->setAttendee((new Attendee())
		->wizard(Attendee::PARTSTAT_ACCEPTED, 'Bart', 'exemple@gmail.com')
	)
	->setAttendee((new Attendee())
		->wizard(Attendee::PARTSTAT_ACCEPTED, 'Henk', 'exemple2@gmail.com')
	)
	// Add repeat
	->setRepeatRule((new RepeatRule(RepeatRule::FREQ_YEARLY))
		->setByDay(RepeatRule::BYDAY_TH)
		->setBySetPos(RepeatRule::BYSETPOS_FIRST)
		->setByMonth(RepeatRule::BYMONTH_NOV)
		->setCount(7)
	)
);

// Render to string with headers
echo $calender->serve();

```

[See more examples](https://github.com/bvanhoekelen/icalendar-php/tree/master/examples).

# Help, docs and links
- [Packagist](https://packagist.org/packages/bvanhoekelen/icalendar-php)
