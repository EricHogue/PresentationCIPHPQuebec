<?php
class BloomFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BloomFilter
     */
    private $_bloomFilter;


    public function setup()
    {
        $hashCreator = new HashCreator();
        $numberOfBytestToUse = 16;

        $functions = $hashCreator->getFunctions(3, $numberOfBytestToUse);
        $this->_bloomFilter = new BloomFilter($functions, $numberOfBytestToUse);
    }

    public function testCreate()
    {
        $this->assertNotNull(new BloomFilter(array(), 1));
    }

    public function testAddingAWordReturnsTrue()
    {
        $this->assertTrue($this->_bloomFilter->add('test'));
    }

    public function tesWordNotFoundInEmptyFilter()
    {
        $this->assertFalse($this->_bloomFilter->exists('ksadfkal'));
    }

    public function testFindWord()
    {
        $word = 'Test';
        $this->_bloomFilter->add($word);
        $this->assertTrue($this->_bloomFilter->exists($word));
    }

    public function testFindWordInFilterWithMoreThanOneWord()
    {
        $filter = $this->_bloomFilter;

        $filter->add('word1');
        $filter->add('word2');
        $filter->add('word3');
        $filter->add('word4');

        $this->assertTrue($filter->exists('word3'));
    }

    public function testDontFindWordInFilterWithManyWord()
    {
        $filter = $this->_bloomFilter;

        $filter->add('word1');
        $filter->add('word2');
        $filter->add('word3');
        $filter->add('word4');

        $this->assertFalse($filter->exists('word'));
    }

    public function testFindWordNoMatterTheCase()
    {
        $this->_bloomFilter->add('ToSearch');
        $this->assertTrue($this->_bloomFilter->exists('toSearch'));
    }

    public function testCountOnEmptyFilterIs0()
    {
        $this->assertSame(0, $this->_bloomFilter->valueCount());
    }

    public function testCountIs1AfterAddingOneWord()
    {
        $this->_bloomFilter->add('kfljsd');
        $this->assertSame(1, $this->_bloomFilter->valueCount());
    }

}