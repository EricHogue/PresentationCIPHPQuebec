<?php
class WordGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $_wordGenerator;


    public function setup()
    {
        $this->_wordGenerator = new WordGenerator();
    }

    public function testCreate()
    {
        $this->assertNotNull(new WordGenerator());
    }

    public function testGenerate0WordsReturnEmptyArray()
    {
        $this->assertSame(0, count($this->_wordGenerator->generateWords(0, 0)));
    }

    public function testGenerate1WordsReturnsArrayOf1Element()
    {
        $this->assertSame(1, count($this->_wordGenerator->generateWords(1, 5)));
    }

    public function testGenerate5WordsArrayCount()
    {
        $this->assertSame(5, count($this->_wordGenerator->generateWords(5, 5)));
    }

    public function testGenerateReturnsWordOfCorrectSize()
    {
        $words = $this->_wordGenerator->generateWords(1, 4);
        $this->assertSame(4, strlen($words[0]));
    }

    public function testGenerateOneWordOf0CharsReturnsEmptyString()
    {
        $word = $this->_wordGenerator->generateOneWord(0);
        $this->assertSame('', $word);
    }

    public function testGenerateOneWordReturnsWordOfCorrectLength()
    {
        $word = $this->_wordGenerator->generateOneWord(4);
        $this->assertSame(4, strlen($word));
    }

    public function testWordsHaveDifferentChars()
    {
        $word = $this->_wordGenerator->generateOneWord(2);
        $this->assertTrue(0 != strcasecmp($word[0], $word[1]));
    }

    public function testWordsAreMadeOfChars()
    {
        $word = $this->_wordGenerator->generateOneWord(1);
        $this->assertRegExp('/^\w$/', $word);
    }

    public function testWordsAreMadeOf2Chars()
    {
        $word = $this->_wordGenerator->generateOneWord(2);
        $this->assertRegExp('/^\w{2}$/', $word);
    }
}