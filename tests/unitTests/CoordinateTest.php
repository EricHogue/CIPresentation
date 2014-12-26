<?php

use Sudoku\Coordinate;

class CoordinateTest extends PHPUnit_Framework_TestCase {
	public function testGetKey() {
		$coordinate = new Coordinate(3, 6);
		$this->assertSame('3-6', $coordinate->getKey());
	}

	public function testToStringReturnsTheKey() {
		$coordinate = new Coordinate(3, 6);
		$this->assertSame($coordinate->getKey(), (string) $coordinate);
	}
}
