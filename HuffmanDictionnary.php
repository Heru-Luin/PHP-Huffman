<?php

/**
 * This class is used to represent a dictionnary of the Huffman algorithm. It should only be used by the Hyffman class.
 * @version 1.0
 * @author Heru-Luin
 * @link https://github.com/Heru-Luin
 */
class		HuffmanDictionnary
{
	private	$dictionnary = array();

	private $minLenght = -1;
	private $maxLenght = -1;

	public function get($entry)
	{
		if (!is_string($entry) || strlen($entry) != 1)
			throw new Exception('Entry must be a one character string.');
		if (!array_key_exists($entry, $this->dictionnary))
			throw new Exception('Character "'.$entry.'" is not in the dictionnary.');
		return $this->dictionnary[$entry];
	}

	public function set($entry, $value)
	{
		if (!is_string($entry) || strlen($entry) != 1)
			throw new Exception('Entry must be a one character string.');
		if (array_key_exists($entry, $this->dictionnary))
			throw new Exception('Character "'.$entry.'" is already in the dictionnary.');
		if (strlen(str_replace('0', '', str_replace('1', '', $value))) != 0)
			throw new Exception('Value of the entry is not correctly formatted.');
		$lenght = strlen($value);
		if ($this->minLenght == -1 || $lenght < $this->minLenght)
			$this->minLenght = $lenght;
		if ($this->maxLenght == -1 || $lenght > $this->maxLenght)
			$this->maxLenght = $lenght;
		$this->dictionnary[$entry] = $value;
	}

	public function getEntry(&$value)
	{
		$lenght = strlen($value);
		if ($lenght < $this->minLenght)
			return null;
		for ($i = $this->minLenght; $i <= $this->maxLenght; ++$i)
		{
			$needle = substr($value, 0, $i);
			foreach ($this->dictionnary as $key => $val)
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