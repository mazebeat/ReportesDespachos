<?php namespace App\Util;

/**
 * Class arrayToCsv
 *
 * @package App\Util
 */
class arrayToCsv
{
	/**
	 * @var string
	 */
	protected $delimiter;
	/**
	 * @var string
	 */
	protected $text_separator;
	/**
	 * @var string
	 */
	protected $replace_text_separator;
	/**
	 * @var string
	 */
	protected $line_delimiter;

	/**
	 * @param string $delimiter
	 * @param string $text_separator
	 * @param string $replace_text_separator
	 * @param string $line_delimiter
	 */
	public function __construct($delimiter = ";", $text_separator = '"', $replace_text_separator = "'", $line_delimiter = "\n")
	{
		$this->delimiter              = $delimiter;
		$this->text_separator         = $text_separator;
		$this->replace_text_separator = $replace_text_separator;
		$this->line_delimiter         = $line_delimiter;
	}

	/**
	 * @param $input
	 *
	 * @return string
	 */
	public function convert($input)
	{
		$lines = array();
		foreach ($input as $v) {
			$lines[] = $this->convertLine($v);
		}

		return implode($this->line_delimiter, $lines);
	}

	/**
	 * @param $line
	 *
	 * @return string
	 */
	public function convertLine($line)
	{
		$csv_line = array();
		foreach ($line as $v) {
			$csv_line[] = is_array($v) ? $this->convertLine($v) : $this->text_separator . str_replace($this->text_separator, $this->replace_text_separator, $v) . $this->text_separator;
		}

		return implode($this->delimiter, $csv_line);
	}
}
