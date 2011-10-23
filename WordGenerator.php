<?php
/**
 * WordGenerator
 */
class WordGenerator
{

	/**
	 * Class constructor
	 */
	public function __construct()
	{
	}

	/**
	 * Generate some words
	 *
	 * @return void
	 */
	public function generateWords($wordsToGenerate, $wordsLength) {
		$words = array();
		for ($i = 0; $i < $wordsToGenerate; $i++) {
			$words[] = $this->generateOneWord($wordsLength);
		}

		return $words;
	}

	/**
	 * Generate a word
	 *
	 * @return void
	 */
	public function generateOneWord($length) {
		$word = '';
		for ($i = 0; $i < $length; $i++) {
			$word .= chr(rand(65, 90));
		}

		return $word;
	}

}