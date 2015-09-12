<?php

require_once ('Huffman.php');

$huffman = new Huffman();
$exampleString = '0123456789';
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original length :	'.strlen($exampleString).'<br />'.
		'Encoded length :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';

$huffman = new Huffman();
$huffman->generateDictionary('0123456789abcdef');
$dictionary = $huffman->getDictionary();
$exampleString = '4009814546017120030654ab480184190804298b01980908bb098981f989182804082040498249d840298e42984984290842984298042d980d49824928e402984f0984298429849082498498a98429802c498b42098';
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original length :	'.strlen($exampleString).'<br />'.
		'Encoded length :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';

$huffman = new Huffman();
$huffman->setDictionary($dictionary);
$exampleString = md5(rand());
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original length :	'.strlen($exampleString).'<br />'.
		'Encoded length :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';

$huffman = new Huffman();
$exampleString = sha1(rand());
$encodedExampleString = $huffman->encode($exampleString);
$decodedExampleString = $huffman->decode($encodedExampleString);
echo	'Original string :	'.$exampleString.'<br />'.
		'Encoded string :	'.$encodedExampleString.'<br />'.
		'Decoded string :	'.$decodedExampleString.'<br />'.
		'Original length :	'.strlen($exampleString).'<br />'.
		'Encoded length :	'.strlen($encodedExampleString).'<br />'.
		'Percentage gain :	'.((100 * (strlen($exampleString) / strlen($encodedExampleString))) - 100).'%<br /><br />';

?>
