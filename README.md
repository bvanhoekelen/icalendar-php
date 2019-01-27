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

## Simple example
```php
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

```
[See more examples](https://github.com/bvanhoekelen/icalendar-php/tree/master/examples).

# Help, docs and links
- [Packagist](https://packagist.org/packages/bvanhoekelen/icalendar-php)
