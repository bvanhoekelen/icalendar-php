<?php namespace Calendar\Type;

use Calendar\Element\Event;

class Location {
	protected $title;
	protected $streetAddress;
	protected $zipCode;
	protected $city;
	protected $country;
	protected $geo;

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): self {
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreetAddress(): string {
		return $this->streetAddress;
	}

	/**
	 * @param string $streetAddress
	 */
	public function setStreetAddress(string $streetAddress): self {
		$this->streetAddress = $streetAddress;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getZipCode(): string {
		return $this->zipCode;
	}

	/**
	 * @param string $zipCode
	 */
	public function setZipCode(string $zipCode): self {
		$this->zipCode = $zipCode;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity(): string {
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	public function setCity(string $city): self {
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCountry(): string {
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry(string $country): self {
		$this->country = $country;
		return $this;
	}

	/**
	 * @return Geo
	 */
	public function getGeo(): Geo {
		return $this->geo;
	}

	/**
	 * @param Geo $geo
	 */
	public function setGeo(Geo $geo): self {
		$this->geo = $geo;
		return $this;
	}

	private function combineZipCodeAndCity(): string {
		return ($this->zipCode ? $this->zipCode . ' ' : '') . $this->city;
	}

	public function getLocationLine(): string {
		return $this->title . '\n' . $this->streetAddress . '\, ' . $this->combineZipCodeAndCity() . '\, ' . $this->country;
	}

	public function getAppleXTitleLine(): string {
		return $this->title . '\n' . $this->streetAddress . ', ' . $this->combineZipCodeAndCity() . ', ' . $this->country;
	}

	public function getAppleStructuredLocationProperty($radius = 70.0): Property {
		$geoApple = '';
		if ($this->getGeo()) {
			$geoApple = ":geo:" . $this->getGeo()->latitude . "," . $this->getGeo()->longitude;
		}

		return new Property(Event::X_APPLE_STRUCTURED_LOCATION, null, [
			"VALUE" => "URI",
			"X-APPLE-RADIUS" => $radius,
			"X-TITLE" => '"' . $this->getAppleXTitleLine() . '"' . $geoApple,
		]);
	}

}
