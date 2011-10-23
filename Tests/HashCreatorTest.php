<?php

class HashCreatorTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var HashCreator
	 */
	private $creator;


	public function setup()
	{
		$this->creator = new HashCreator();
	}

	public function testCreate() {
		$this->assertNotNull(new HashCreator());
	}

	public function testGetHashFunctionsReturnArrayWithXFunctions() {
		$functions = $this->creator->getFunctions(4, 10);

		$this->assertSame(4, count($functions));
	}

	public function testGetFunctionsReturnCallables() {
		$functions = $this->creator->getFunctions(4, 10);

		$this->assertTrue(is_callable($functions[3]));
	}

	public function testHashFunctionReturnsIntBetween0AndMaxMinest1() {
		$maxValue = 10;
		$function = $this->creator->getFunctions(1, $maxValue);

		$value = $function[0]('test');
		$this->assertTrue($value >= 0 && $value < $maxValue);
	}


	public function testThirdHashFunctionReturnsIntBetween0AndMaxMinest1() {
		$maxValue = 10;
		$function = $this->creator->getFunctions(4, $maxValue);

		$value = $function[2]('test');
		$this->assertTrue($value >= 0 && $value < $maxValue);
	}

	public function test2HashFunctionsReturnsDifferentValues() {
		$functions = $this->creator->getFunctions(2, 10);

		$toHash = 'Test';
		$fistValue = $functions[0]($toHash);
		$secondValue = $functions[1]($toHash);

		$this->assertNotSame($fistValue, $secondValue);
	}

	public function testNeededCharsFor10BitsIsOne() {
		$this->assertSame(1, $this->creator->neededCharsForXBits(10));
	}

	public function testNeededCharsFor16BitsIsOne() {
		$this->assertSame(1, $this->creator->neededCharsForXBits(16));
	}

	public function testNeededCharsFor17BitsIsTwo() {
		$this->assertSame(2, $this->creator->neededCharsForXBits(17));
	}

	public function testHashValuesIsLessThanMax() {
		$numberOfBits = 10;
		$functions = $this->creator->getFunctions(3, $numberOfBits);

		$this->assertLessThan($numberOfBits, $functions[2]('123456789'));
	}

	public function testHashFunctionAlwaysReturnTheSameValueForSameText() {
		$functions = $this->creator->getFunctions(1, 100);
		$value1 = $functions[0]('Test');
		$value2 = $functions[0]('Test');

		$this->assertSame($value1, $value2);
	}

	public function testRequires2CharsFor128Bits() {
		$this->assertSame(2, $this->creator->neededCharsForXBits(128));
	}

	public function test128BitsHasIsSmallerThan128() {
		$max = 128;
		$functions = $this->creator->getFunctions(1, $max);
		$this->assertLessThan($max, $functions[0]('Crayola'));
	}
}