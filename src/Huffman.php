<?php

namespace App;

use App\HuffmanDictionary;

/**
 * This class allows you to encode and decode informations with a Huffman algorithm.
 * @version 2.0
 * @example tests.php
 * @author Heru-Luin
 * @link https://github.com/Heru-Luin
 */
class Huffman
{
    private $dictionary = null;

    /**
     * Specifies the dictionary to use for encoding/decoding.
     * @param HuffmanDictionary $dictionary An instance of HuffmanDictionary that you will use for encoding/decoding.
     */
    public function setDictionary(HuffmanDictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    /**
     * Gets the currently used dictionary
     * @return HuffmanDictionary The instance of HuffmanDictionary that is currently used by the Huffman object.
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * Deletes the currently used dictionary.
     */
    public function unsetDictionary()
    {
        $this->dictionary = null;
    }

    /**
     * Encodes some data with the Huffman algorithm. If the dictionary has not been set yet,
     * it is created with the $data.
     * @param mixed $data The data to encode. If $data is not a string, it will be serialized.s
     * @return string A string containing the encoded message.
     */
    public function encode($data)
    {
        if (!is_string($data)) {
            $data = serialize($data);
        }
        if (empty($data)) {
            return '';
        }
        if ($this->dictionary === null) {
            $this->generateDictionary($data);
        }
        $binaryString = '';
        for ($i = 0; isset($data[$i]); ++$i) {
            $binaryString .= $this->dictionary->get($data[$i]);
        }
        $splittedBinaryString = str_split('1'.$binaryString.'1', 8);
        $binaryString = '';
        foreach ($splittedBinaryString as $i => $c) {
            while (strlen($c) < 8) {
                $c .= '0';
            }
            $binaryString .= chr(bindec($c));
        }
        return $binaryString;
    }

    /**
     * Decodes some data with the Huffman algorithm. If the dictionary has not been set yet, an exception is thrown.
     * @param mixed $data The data to decode. If $data is not a string, an exception is thrown.
     * @return string A string containing the decoded message.
     */
    public function decode($data)
    {
        if (!is_string($data)) {
            throw new Exception('The data must be a string.');
        }
        if (empty($data)) {
            return '';
        }
        if ($this->dictionary === null) {
            throw new Exception('The dictionary has not been set.');
        }
        $binaryString = '';
        $dataLenght = strlen($data);
        $uncompressedData = '';
        for ($i = 0; $i < $dataLenght; ++$i) {
            $decbin = decbin(ord($data[$i]));
            while (strlen($decbin) < 8) {
                $decbin = '0'.$decbin;
            }
            if (!$i) {
                $decbin = substr($decbin, strpos($decbin, '1') + 1);
            }
            if ($i + 1 == $dataLenght) {
                $decbin = substr($decbin, 0, strrpos($decbin, '1'));
            }
            $binaryString .= $decbin;
            while (($c = $this->dictionary->getEntry($binaryString)) !== null) {
                $uncompressedData .= $c;
            }
        }
        return $uncompressedData;
    }

    /**
     * Creates a dictionary from $data.
     * @param mixed $data The data used to create the dictionary. If $data is not a string, it will be serialized.
     */
    public function generateDictionary($data)
    {
        if (!is_string($data)) {
            $data = serialize($data);
        }
        $occurences = array();
        while (isset($data[0])) {
            $occurences[] = array(substr_count($data, $data[0]), $data[0]);
            $data = str_replace($data[0], '', $data);
        }
        sort($occurences);
        while (count($occurences) > 1) {
            $row1 = array_shift($occurences);
            $row2 = array_shift($occurences);
            $occurences[] = array($row1[0] + $row2[0], array($row1, $row2));
            sort($occurences);
        }
        $this->dictionary = new HuffmanDictionary();
        $this->fillDictionary(is_array($occurences[0][1]) ? $occurences[0][1] : $occurences);
    }

    private function fillDictionary($data, $value = '')
    {
        if (!is_array($data[0][1])) {
            $this->dictionary->set($data[0][1], $value.'0');
        } else {
            $this->fillDictionary($data[0][1], $value.'0');
        }
        if (isset($data[1])) {
            if (!is_array($data[1][1])) {
                $this->dictionary->set($data[1][1], $value.'1');
            } else {
                $this->fillDictionary($data[1][1], $value.'1');
            }
        }
    }
}
