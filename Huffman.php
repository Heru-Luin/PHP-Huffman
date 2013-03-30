<?php 
require_once ('HuffmanDictionnary.php');

/**
 * This class allows you to encode and decode informations with a Huffman algorithm.
 * @version 2.0
 * @example tests.php
 * @author Heru-Luin
 * @link https://github.com/Heru-Luin
 */
class		Huffman
{
	private	$dictionnary = null;

	/**
	 * Specifies the dictionnary to use for encoding/decoding.
	 * @param HuffmanDictionnary $dictionnary An instance of HuffmanDictionnary that you will use for encoding/decoding.
	 */
	public function	setDictionnary(HuffmanDictionnary $dictionnary)
	{
		$this->dictionnary = $dictionnary;
	}

	/**
	 * Gets the currently used dictionnary
	 * @return HuffmanDictionnary The instance of HuffmanDictionnary that is currently used by the Huffman object.
	 */
	public function	getDictionnary()
	{
		return $this->dictionnary;
	}

	/**
	 * Deletes the currently used dictionnary.
	 */
	public function	unsetDictionnary()
	{
		$this->dictionnary = null;
	}

	/**
	 * Encodes some data with the Huffman algorithm. If the dictionnary has not been set yet, it is created with the $data.
	 * @param mixed $data The data to encode. If $data is not a string, it will be serialized.s
	 * @return string A string containing the encoded message.
	 */
	public function	encode($data)
	{
		if (!is_string($data))
			$data = serialize($data);
		if (empty($data))
			return '';
		if ($this->dictionnary === null)
			$this->generateDictionnary($data);
		$binaryString = '';
		for ($i = 0; isset($data[$i]); ++$i)
			$binaryString .= $this->dictionnary->get($data[$i]);
		$splittedBinaryString = str_split('1'.$binaryString.'1', 8);
		$binaryString = '';
		foreach ($splittedBinaryString as $i => $c)
		{
			while (strlen($c) < 8)
				$c .= '0';
			$binaryString .= chr(bindec($c));
		}
		return $binaryString;
	}

	/**
	 * Decodes some data with the Huffman algorithm. If the dictionnary has not been set yet, an exception is thrown.
	 * @param mixed $data The data to decode. If $data is not a string, an exception is thrown.
	 * @return string A string containing the decoded message.
	 */
	public function	decode($data)
	{
		if (!is_string($data))
			throw new Exception('The data must be a string.');
		if (empty($data))
			return '';
		if ($this->dictionnary === null)
			throw new Exception('The dictionnary has not been set.');
		$binaryString = '';
		$dataLenght = strlen($data);
		$uncompressedData = '';
		for ($i = 0; $i < $dataLenght; ++$i)
		{
			$decbin = decbin(ord($data[$i]));
			while (strlen($decbin) < 8)
				$decbin = '0'.$decbin;
			if (!$i)
				$decbin = substr($decbin, strpos($decbin, '1') + 1);
			if ($i + 1 == $dataLenght)
				$decbin = substr($decbin, 0, strrpos($decbin, '1'));
			$binaryString .= $decbin;
			while (($c = $this->dictionnary->getEntry($binaryString)) !== null)
				$uncompressedData .= $c;
		}
		return $uncompressedData;
	}

	/**
	 * Creates a dictionnary from $data.
	 * @param mixed $data The data used to create the dictionnary. If $data is not a string, it will be serialized.
	 */
	public function	generateDictionnary($data)
	{
		if (!is_string($data))
			$data = serialize($data);
		$occurences = array();
		while (isset($data[0]))
		{
			$occurences[] = array(substr_count($data, $data[0]), $data[0]);
			$data = str_replace($data[0], '', $data);
		}
		sort($occurences);
		while (count($occurences) > 1)
		{
			$row1 = array_shift($occurences);
			$row2 = array_shift($occurences);
			$occurences[] = array($row1[0] + $row2[0], array($row1, $row2));
			sort($occurences);
		}
		$this->dictionnary = new HuffmanDictionnary();
		$this->fillDictionnary(is_array($occurences[0][1]) ? $occurences[0][1] : $occurences);
	}

	private function fillDictionnary($data, $value = '')
	{
		if (!is_array($data[0][1]))
			$this->dictionnary->set($data[0][1], $value.'0');
		else
			$this->fillDictionnary($data[0][1], $value.'0');
		if (isset($data[1]))
		{
			if (!is_array($data[1][1]))
				$this->dictionnary->set($data[1][1], $value.'1');
			else
				$this->fillDictionnary($data[1][1], $value.'1');
		}
	}
}
?>