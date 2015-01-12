<?php

use Sudoku\Loader;
use Sudoku\Coordinate;
use Sudoku\FileNotFoundException;

class LoaderTest extends PHPUnit_Framework_TestCase {
	private $sudoku = "
? ? 6 ? ? 4 9 8 ?
? 8 1 ? ? ? ? 4 ?
7 ? 4 ? 8 ? ? 2 6
? ? 5 6 ? 2 1 ? ?
? ? 7 5 ? 3 2 ? ?
? ? 2 7 ? 8 5 ? ?
6 7 ? ? 3 ? 4 ? 2
? 4 ? ? ? ? 6 7 ?
? 5 3 4 ? ? 8 ? ?
";

	/** @var Loader */
	private $loader;

	public function setup() {
		$this->loader = new Loader();
	}

	public function testLoadReturnsAGrid() {
		$this->assertInstanceOf('\Sudoku\Grid', $this->loader->loadFromText(''));
	}

	public function testEmptyStringGetsAnEmptyGrid() {
		$this->assertSame(0, $this->loader->loadFromText('')->cellsCount());
	}

	public function testCellsWithQuestionsMarksAreNotSet() {
		$this->assertFalse($this->loader->loadFromText($this->sudoku)->isCellSet(new Coordinate(8, 4)));
	}

	public function testCellsWithValueIsSet() {
		$this->assertTrue($this->loader->loadFromText($this->sudoku)->isCellSet(new Coordinate(7, 1)));
	}

	public function testLoadingFromFile() {
		$this->assertNotNull($this->loader->loadFromFile('data/sudoku1.txt'));
	}

	/**
	 * @expectedException \Sudoku\FileNotFoundException
	 */
	public function testReadInexistingFile() {
		$this->loader->loadFromFile('data/sudoku3.txt');
	}

	public function testCellsWithValueIsSetWhenLoadingFromFile() {
		$this->assertTrue($this->loader->loadFromFile('data/sudoku1.txt')->isCellSet(new Coordinate(7, 1)));
	}
}
