# 📆 PHP iCalendar simple parser tool 🛠

[![Hex.pm](https://img.shields.io/hexpm/l/plug.svg?maxAge=2592000&style=flat-square)](https://github.com/bvanhoekelen/icalendar-php/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/bvanhoekelen/icalendar-php.svg?style=flat-square)](https://github.com/bvanhoekelen/icalendar-php/releases)
[![Packagist](https://img.shields.io/packagist/dt/bvanhoekelen/icalendar-php.svg?style=flat-square)](https://packagist.org/packages/bvanhoekelen/icalendar-php)
[![Github issues](https://img.shields.io/github/issues/bvanhoekelen/icalendar-php.svg?style=flat-square)](https://github.com/bvanhoekelen/icalendar-php/issues)
[![Travis branch](https://img.shields.io/travis/bvanhoekelen/icalendar-php/master.svg?style=flat-square)](https://travis-ci.org/bvanhoekelen/icalendar-php)
[![Travis branch](https://img.shields.io/travis/bvanhoekelen/icalendar-php/develop.svg?style=flat-square)](https://travis-ci.org/bvanhoekelen/icalendar-php) Build: Master|Develop
```
composer require bvanhoekelen/icalendar-php
```

## Highlight
- Generate simpel ical sub

## Example
```php
require_once('../vendor/autoload.php');

use Calendar\Element\Calendar;
use Calendar\Element\Event;
use Calendar\Type\RepeatingRule;

$calender = (new Calendar())
	->setMethod(Calendar::METHOD_PUBLISH)
	->setColor('#00A677')
	->setName('Custom name')
	->setDescription('Custom description')
	->setId('Custom id')
	->setRefreshInterval('P1H')
;

// Add event
$event = (new Event())
	->setUid('com.domain.test.E1283')
	->setDtStart(new DateTime('now'))
	->setDtEnd(new DateTime('+1 day'))
	->setDtStamp(new DateTime('now'))
	->setSummery("short summary of the event")
	->setDescription("full description of the event")
	->setStatus(Event::STATUS_CONFIRMED)
	->setCategories(["Ical", "Simple"])
	->setUrl("https://www.google.nl")
	->setGeo(new \Calendar\Type\Geo(52.373149,4.891342))
	->setLocationWizard(
		"Koninklijk Paleis Amsterdam",
		"Koninklijk Paleis Amsterdam, Nieuwezijds Voorburgwal 147, 1012 RJ Amsterdam, Nederland",
		new \Calendar\Type\Geo(52.373149,4.891342 )
	)
;

// Set event
$calender->setEvent($event);

// Render
echo $calender->serve(); // Render to string with headers

```
[See more examples](https://github.com/bvanhoekelen/icalendar-php/examples).

# Help, docs and links
- [Packagist](https://packagist.org/packages/bvanhoekelen/icalendar-php)

## Backlog & Feedback
If you have any suggestions to improve this performance tool? Please add your feature, bug or improvement to the [BACKLOG.dm](https://github.com/bvanhoekelen/icalendar-php/blob/master/BACKLOG.md). Or create a [issues](https://github.com/bvanhoekelen/icalendar-php/issues).
- [Open backlog](https://github.com/bvanhoekelen/icalendar-php/blob/master/BACKLOG.md)
- [Create issues](https://github.com/bvanhoekelen/icalendar-php/issues)
