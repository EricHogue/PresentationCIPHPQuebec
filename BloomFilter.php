<?php
/**
 * BloomFilter
 */
class BloomFilter
{
	/**
	 * @var array
	 */
	private $hashFunctions;

	/**
	 * @var int
	 */
	private $numberOfBytesToUse;

	/**
	 * @var array
	 */
	private $bitmap;

	/**
	 * @var integer
	 */
	private $numberOfValues = 0;




	/**
	 * Class constructor
	 */
	public function __construct(array $hashFunctions, $numberOfBytesToUse)
	{
		$this->hashFunctions = $hashFunctions;
		$this->numberOfBytesToUse = (int) $numberOfBytesToUse;

		$this->initializeBitmap();
	}

	/**
	 * Add a word
	 *
	 * @return void
	 */
	public function add($wordToAdd) {
		$loweredCaseWord = strtolower($wordToAdd);

		foreach ($this->hashFunctions as $function) {
			$value = $function($loweredCaseWord);
			$this->bitmap[$value] = 1;
		}

		$this->numberOfValues++;
		return true;
	}


	/**
	 * Check if a word exists in the filter
	 *
	 * @return void
	 */
	public function exists($wordToSearch) {
		$loweredCaseWord = strtolower($wordToSearch);

		foreach ($this->hashFunctions as $function) {
			$value = $function($loweredCaseWord);

			if (0 === $this->bitmap[$value]) return false;
		}

		return true;
	}

	public function __toString() {
		$onCount = 0;

		foreach ($this->bitmap as $isOn) {
			if (1 === $isOn) $onCount++;
		}

        return "On bits: {$onCount}/" . count($this->bitmap);
    }

    /**
     * Number of values in the filter
     *
     * @return integer
     */
    public function valueCount() {
    	return $this->numberOfValues;
    }

	/*
	 * Initialize the bitmap
	 *
	 * @return void
	 */
	private function initializeBitmap() {
		$bitmap = array();
		for ($index = 0; $index < $this->numberOfBytesToUse; $index++) {
			$bitmap[$index] = 0;
		}

		$this->bitmap = $bitmap;
	}
}