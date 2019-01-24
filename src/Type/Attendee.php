<?php namespace Calendar\Type;

class Attendee {
	protected $rol;
	protected $partstat;
	protected $cn;

	protected $rules;

	// Property
	const ROL = 'ROL';
	const PARTSTAT = 'PARTSTAT';
	const RSVP = 'RSVP';
	const CN = 'CN';
	const CUTYPE = 'CUTYPE';
	const EMAIL = 'EMAIL';
	const SENT_BY = 'SENT-BY';
	const DELEGATED_FROM = 'DELEGATED-FROM';

	// X
	const X_NUM_GUESTS = 'X-NUM-GUESTS';

	// Rol
	const ROL_REQ_PARTICIPANT = 'REQ-PARTICIPANT';
	const ROL_OPT_PARTICIPANT = 'OPT-PARTICIPANT';
	const ROL_NON_PARTICIPANT = 'NON-PARTICIPANT';

	// PartStat
	const PARTSTAT_NEEDS_ACTION = 'NEEDS-ACTION';
	const PARTSTAT_ACCEPTED = 'ACCEPTED';
	const PARTSTAT_DECLINED = 'DECLINED';
	const PARTSTAT_TENTATIVE = 'TENTATIVE';
	const PARTSTAT_DELEGATED = 'DELEGATED';

	// CuType
	const CUTYPE_INDIVIDUAL = 'INDIVIDUAL';
	const CUTYPE_GROUP = 'GROUP';
	const CUTYPE_RESOURCE = 'RESOURCE';
	const CUTYPE_ROOM = 'ROOM';
	const CUTYPE_UNKNOWN = 'UNKNOWN';

	public function __construct($rules = []) {
		$this->rules = $rules;
	}

	public function wizard($partStat, $cn, $email): self {
		$this->setCuType(self::CUTYPE_INDIVIDUAL);
		$this->setRol(self::ROL_REQ_PARTICIPANT);
		$this->setPartStat($partStat);
		$this->rules[self::X_NUM_GUESTS] = 0;
		$this->setCnWizard($cn, $email);

		return $this;
	}

	public function setCuType(string $cuTupe): self {
		$this->cuTupe = $cuTupe;
		return $this;
	}

	public function setRol(string $rol): self {
		$this->rol = $rol;
		return $this;
	}

	public function setCn(string $cn): self {
		$this->cn = $cn;
		return $this;
	}

	public function setCnWizard(string $cn, string $email): self {
		$this->cn = $cn . ":mailto:" . $email;
		return $this;
	}

	public function setPartStat(string $status): self {
		$this->partstat = $status;
		return $this;
	}

	// Rules
	public function getRules(): array {
		$rules = $this->rules;
		if ($this->rol) {
			$rules[static::ROL] = $this->rol;
		}
		if ($this->partstat) {
			$rules[static::PARTSTAT] = $this->partstat;
		}
		if ($this->cn) {
			$rules[static::CN] = $this->cn;
		}

		return $rules;
	}

	public function setRules(array $rules): self {
		$this->rules = $rules;
		return $this;
	}

}
