<?php

/**
 * This class is used to represent a dictionary of the Huffman algorithm. It should only be used by the Huffman class.
 * @version 1.0
 * @author Heru-Luin
 * @link https://github.com/Heru-Luin
 */
class	HuffmanDictionary
{
	private	$dictionary = array();

	private $minLength = -1;
	private $maxLength = -1;

	public function get($entry)
	{
		if (!is_string($entry) || strlen($entry) != 1)
			throw new Exception('Entry must be a one character string.');
		if (!array_key_exists($entry, $this->dictionary))
			throw new Exception('Character "'.$entry.'" is not in the dictionary.');
		return $this->dictionary[$entry];
	}

	public function set($entry, $value)
	{
		if (!is_string($entry) || strlen($entry) != 1)
			throw new Exception('Entry must be a one character string.');
		if (array_key_exists($entry, $this->dictionary))
			throw new Exception('Character "'.$entry.'" is already in the dictionary.');
		if (strlen(str_replace('0', '', str_replace('1', '', $value))) != 0)
			throw new Exception('Value of the entry is not correctly formatted.');
		$length = strlen($value);
		if ($this->minLength == -1 || $length < $this->minLength)
			$this->minLength = $length;
		if ($this->maxLength == -1 || $length > $this->maxLength)
			$this->maxLength = $length;
		$this->dictionary[$entry] = $value;
	}

	public function getEntry(&$value)
	{
		$length = strlen($value);
		if ($length < $this->minLength)
			return null;
		for ($i = $this->minLength; $i <= $this->maxLength; ++$i)
		{
			$needle = substr($value, 0, $i);
			foreach ($this->dictionary as $key => $val)
				if ($needle === $val)
				{
					$value = substr($value, $i);
					return $key;
				}
		}
		return null;
	}
}
?>
