<?php namespace Calendar\Bag;

class LineBag {
	const LINE_LIMIT = 75;
	const LINE_BREAK = "\r\n";
	protected $lines = [];

	/**
	 * Create a line
	 *
	 * @param string $line
	 */
	public function set(string $line) : void {
		$this->lines[] = $line;
	}

	/**
	 * Return lines as a string
	 *
	 * @return string
	 */
	public function render() : string {
		$content = '';
		foreach ($this->lines as $line){
			$content .= $this->limitLine($line) . static::LINE_BREAK;
		}
		return $content;
	}

	/**
	 * Limit line length to LINE_LIMIT (75 characters)
	 * @param string $line
	 * @return string
	 */
	protected function limitLine(string $line) : string {
		$count = strlen($line);
		if($count < static::LINE_LIMIT){
			return $line;
		}
		$body = substr($line, 0, static::LINE_LIMIT) . static::LINE_BREAK;
		for($x = static::LINE_LIMIT; $x < $count; $x += static::LINE_LIMIT - 1){
			$body .= ' ' . substr($line, $x, static::LINE_LIMIT - 1) . static::LINE_BREAK;
		}
		return $body;
	}
}
