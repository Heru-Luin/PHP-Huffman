<style>body {font-family: 'courier new';}</style>
<?php

require __DIR__ . '/vendor/autoload.php';

function printExampleResult($str, $encodedStr, $decodedStr)
{
    $strLen = strlen($str);
    $encodedStrLen = strlen($encodedStr);
    echo    'Original string :	'.$str.'<br />'.
        'Encoded string :	'.$encodedStr.'<br />'.
        'Decoded string :	'.$decodedStr.'<br />'.
        'Original length :	'.$strLen.'<br />'.
        'Encoded length :	'.$encodedStrLen.'<br />'.
        'Percentage gain :	'.(100 * $encodedStrLen / $strLen).'%<br /><br />';
}

// Classic use
$huffman = new App\Huffman();
$exampleString = '0123456789';
$encodedString = $huffman->encode($exampleString);
$decodedString = $huffman->decode($encodedString);
printExampleResult($exampleString, $encodedString, $decodedString);

// Generating a dictionnary
$huffman = new App\Huffman();
$huffman->generateDictionary('0123456789abcdef');
$dictionary = $huffman->getDictionary();
$exampleString = '4009814546017120030654ab480184190804298b01980908bb098981f989182804082040498249d840298e42984984290842984298042d980d49824928e402984f0984298429849082498498a98429802c498b42098';
$encodedString = $huffman->encode($exampleString);
$decodedString = $huffman->decode($encodedString);
printExampleResult($exampleString, $encodedString, $decodedString);

// Using a dictionnary
$huffman = new App\Huffman();
$huffman->setDictionary($dictionary);
$exampleString = md5(rand());
$encodedString = $huffman->encode($exampleString);
$decodedString = $huffman->decode($encodedString);
printExampleResult($exampleString, $encodedString, $decodedString);

// Classic use
$huffman = new App\Huffman();
$exampleString = sha1(rand());
$encodedString = $huffman->encode($exampleString);
$decodedString = $huffman->decode($encodedString);
printExampleResult($exampleString, $encodedString, $decodedString);

