<?php
class BloomFilterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var BloomFilter
	 */
	private $bloomFilter;


	public function setup()
	{
		$hashCreator = new HashCreator();
		$numberOfBytestToUse = 16;

		$functions = $hashCreator->getFunctions(3, $numberOfBytestToUse);
		$this->bloomFilter = new BloomFilter($functions, $numberOfBytestToUse);
	}

	public function testCreate() {
		$this->assertNotNull(new BloomFilter(array(), 1));
	}

	public function testAddingAWordReturnsTrue() {
		$this->assertTrue($this->bloomFilter->add('test'));
	}

	public function tesWordNotFoundInEmptyFilter() {
		$this->assertFalse($this->bloomFilter->exists('ksadfkal'));
	}

	public function testFindWord() {
		$word = 'Test';
		$this->bloomFilter->add($word);
		$this->assertTrue($this->bloomFilter->exists($word));
	}

	public function testFindWordInFilterWithMoreThanOneWord() {
		$filter = $this->bloomFilter;

		$filter->add('word1');
		$filter->add('word2');
		$filter->add('word3');
		$filter->add('word4');

		$this->assertTrue($filter->exists('word3'));
	}

	public function testDontFindWordInFilterWithManyWord() {
		$filter = $this->bloomFilter;

		$filter->add('word1');
		$filter->add('word2');
		$filter->add('word3');
		$filter->add('word4');

		$this->assertFalse($filter->exists('word'));
	}

	public function testFindWordNoMatterTheCase() {
		$this->bloomFilter->add('ToSearch');
		$this->assertTrue($this->bloomFilter->exists('toSearch'));
	}

	public function testCountOnEmptyFilterIs0() {
		$this->assertSame(0, $this->bloomFilter->valueCount());
	}

	public function testCountIs1AfterAddingOneWord() {
		$this->bloomFilter->add('kfljsd');
		$this->assertSame(1, $this->bloomFilter->valueCount());
	}

}