<?php
/**
 * BloomFilter
 */
class BloomFilter
{
    /**
     * @var array
     */
    private $_hashFunctions;

    /**
     * @var int
     */
    private $_numberOfBytesToUse;

    /**
     * @var array
     */
    private $_bitmap;

    /**
     * @var integer
     */
    private $_numberOfValues = 0;




    /**
     * Class constructor
     */
    public function __construct(array $hashFunctions, $numberOfBytesToUse)
    {
        $this->_hashFunctions = $hashFunctions;
        $this->_numberOfBytesToUse = (int) $numberOfBytesToUse;

        $this->initializeBitmap();
    }

    /**
     * Add a word
     *
     * @return void
     */
    public function add($wordToAdd)
    {
        $loweredCaseWord = strtolower($wordToAdd);

        foreach ($this->_hashFunctions as $function) {
            $value = $function($loweredCaseWord);
            $this->_bitmap[$value] = 1;
        }

        $this->_numberOfValues++;
        return true;
    }


    /**
     * Check if a word exists in the filter
     *
     * @return void
     */
    public function exists($wordToSearch)
    {
        $loweredCaseWord = strtolower($wordToSearch);

        foreach ($this->_hashFunctions as $function) {
            $value = $function($loweredCaseWord);

            if (0 === $this->_bitmap[$value]) return false;
        }

        return true;
    }

    public function __toString()
    {
        $onCount = 0;

        foreach ($this->_bitmap as $isOn) {
            if (1 === $isOn) $onCount++;
        }

        return "On bits: {$onCount}/" . count($this->_bitmap);
    }

    /**
     * Number of values in the filter
     *
     * @return integer
     */
    public function valueCount()
    {
        return $this->_numberOfValues;
    }

    /*
     * Initialize the bitmap
     *
     * @return void
     */
    private function initializeBitmap()
    {
        $bitmap = array();
        for ($index = 0; $index < $this->_numberOfBytesToUse; $index++) {
            $bitmap[$index] = 0;
        }

        $this->_bitmap = $bitmap;
    }
}
