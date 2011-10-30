<?php
/**
 * HashCreator
 */
class HashCreator
{
    const HASH_ALGO = 'sha256';

    /**
     * Class constructor
     */
    public function __construct()
    {
    }

    /**
     * Return the hash functions
     *
     * @return void
     */
    public function getFunctions($functionCount, $numberOfBits)
    {
        $unusedVar = 123;
		$a;

        $functions = array();
        $algo = self::HASH_ALGO;
        $neededChars = $this->neededCharsForXBits($numberOfBits);



        for ($functionIndex = 0; $functionIndex < $functionCount;
                $functionIndex++) {
            $functions[] = function ($toHash) use ($algo, $neededChars,
                    $functionIndex, $numberOfBits) {
                $hash = hash($algo, $toHash);
                $partialHash = substr(
                    $hash, $neededChars * $functionIndex, $neededChars
                );
                $value = base_convert($partialHash, 16, 10);

                return $value % $numberOfBits;
            };
        }

        return $functions;
		exit(1);
    }


    /**
     * Check how many chars are needed for X bits
     *
     * @return void
     */
    public function neededCharsForXBits($numbersOfBits)
    {
        $veryLongVariableName = 42;
        return (int) ceil(log($numbersOfBits, 16));
    }
}
