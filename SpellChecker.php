<?php
require 'Tests/bootstrap.php';

$numberOfFunctions = 3;
$numberOfBits = pow(16, 5);

$hashCreator = new HashCreator();
$functions = $hashCreator->getFunctions($numberOfFunctions, $numberOfBits);

$bloomFilter = new BloomFilter($functions, $numberOfBits);

readDictionary($bloomFilter);

echo $bloomFilter . "\n";
echo 'Number of words in the filter: ' . $bloomFilter->valueCount() . "\n";

echo "Genrating words\n";
$generator = new WordGenerator();
$words = $generator->generateWords(1000, 5);

echo "Testing words\n";

$foundWords = array();
foreach ($words as $wordToCheck) {
	if ($bloomFilter->exists($wordToCheck))  {
		echo "{$wordToCheck} was found in the filter\n";
		$foundWords[strtolower($wordToCheck)] = false;
	}
}

$falsePositive = checkForFalsePositive($foundWords);
print_r($falsePositive);

/*
 * Read the file
 *
 * @return void
 */
function readDictionary(BloomFilter $filter) {
	error_log('Reading Dictionary');
	$file = fopen('/usr/share/dict/words', 'r');

	while ($line = fgets($file)) {
		$filter->add(trim($line));
	}
	error_log('Done Reading Dictionary');
}


/**
 * Check for false positive
 *
 * @return array
 */
function checkForFalsePositive(array $foundWords) {
	echo "Checking for false positive\n";
	$file = fopen('/usr/share/dict/words', 'r');

	while ($line = fgets($file)) {
		$word = strtolower(trim($line));
		if (array_key_exists($word, $foundWords)) {
			$foundWords[$word] = true;
		}
	}

	return $foundWords;
}