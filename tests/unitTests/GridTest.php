<?php

class GridTest extends PHPUnit_Framework_TestCase {
	/** @var Grid */
	private $grid;

	public function setup() {
		$this->grid = new Grid();
	}

	public function testEmptyGridHasNoCell() {
		$this->assertSame(0, $this->grid->cellsCount());
	}

	public function testGridHas1CellAfterAdding1() {
		$this->grid->addCell(new Coordinate(1, 2), 1);
		$this->assertSame(1, $this->grid->cellsCount());
	}

	public function testGridHas4CellAfterAdding4() {
		for ($i = 0; $i < 4; $i++) {
			$this->grid->addCell(new Coordinate($i, 2), 1);
		}

		$this->assertSame(4, $this->grid->cellsCount());
	}

	public function testAddingAtSamePositionTwiceDoesNotIncrementCount() {
		$this->grid->addCell(new Coordinate(1, 2), 1);
		$this->grid->addCell(new Coordinate(1, 2), 2);
		$this->assertSame(1, $this->grid->cellsCount());
	}

	public function testCanRetrieveValueFromACell() {
		$coordinate = new Coordinate(6, 7);
		$this->grid->addCell($coordinate, 5);
		$this->assertSame(5, $this->grid->getValueAtCoordinate($coordinate));
	}

	public function testCellIsNotSet() {
		$this->assertFalse($this->grid->isCellSet(new Coordinate(3, 4)));
	}

	public function testCellIsSet() {
		$coordinate = new Coordinate(3, 6);
		$this->grid->addCell($coordinate, 3);
		$this->assertTrue($this->grid->isCellSet($coordinate));
	}

	public function testPossibleValuesAreNotSet() {
		$this->assertFalse($this->grid->hasPossibleValues(new Coordinate(0, 0)));
	}

	public function testPossibleValuesAreSet() {
		$coordinate = new Coordinate(0, 0);
		$this->grid->setPossibleValues($coordinate, array());
		$this->assertTrue($this->grid->hasPossibleValues($coordinate));
	}

	public function testPossibleValuesNotSetWhenAValueIsSet() {
		$coordinate = new Coordinate(3, 5);
		$this->grid->addCell($coordinate, 3);
		$this->assertFalse($this->grid->hasPossibleValues($coordinate));
	}

	public function testCellIsNotSetWhenPossibleValuesAreSet() {
		$coordinate = new Coordinate(7, 2);
		$this->grid->setPossibleValues($coordinate, array(3, 4));

		$this->assertFalse($this->grid->isCellSet($coordinate));
	}

	/**
	 * @expectedException CellNotSetException
	 */
	public function testAccessingUnsetCellsThrowsAnException() {
		$this->grid->getValueAtCoordinate(new Coordinate(1, 2));
	}
}
