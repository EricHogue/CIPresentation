<?php

use Sudoku\GridSplitter;
use Sudoku\GridCriterion;
use Sudoku\Grid;
use Sudoku\Coordinate;

class GridSplitterTest extends PHPUnit_Framework_TestCase {
    /** @var GridSplitter */
    private $splitter;

    /** @var Grid */
    private $grid;

    public function setup() {
        $this->grid = $this->getMock('Sudoku\\Grid');
        $this->splitter = new GridSplitter($this->grid, new GridCriterion());
    }

    public function testGetLinesReturns9Lines() {
        $this->assertSame(9, count($this->splitter->getLinesCoordinates()));
    }

    public function testLine5ContainsAllTheCorrectCoordinates() {
        $function = function($column) {
            return new Coordinate(5, $column);
        };
        $expected = array_map($function, range(0, 8));

        $lines = $this->splitter->getLinesCoordinates();
        $this->assertEquals($expected, $lines[5]);
    }

    public function testGetColumnsReturns9Columns() {
        $this->assertSame(9, count($this->splitter->getColumnsCoordinates()));
    }

    public function testColumn8ContainsAllTheCorrectCoordinates() {
        $function = function($line) {
            return new Coordinate($line, 8);
        };
        $expected = array_map($function, range(0, 8));

        $columns = $this->splitter->getColumnsCoordinates();
        $this->assertEquals($expected, $columns[8]);
    }

    public function testHas9SubGrids() {
        $this->assertSame(9, count($this->splitter->getSubGridsCoordinates()));
    }

    public function testSubGrids4HasAllTheCorrectCoordinates() {
        $expected = array();
        foreach (range(3, 5) as $line) {
            foreach (range(3, 5) as $column) {
                $expected[] = new Coordinate($line, $column);
            }
        }
        $subGrids = $this->splitter->getSubGridsCoordinates();
        $this->assertEquals($expected, $subGrids[4]);
    }

    public function testSubGrids6HasAllTheCorrectCoordinates() {
        $expected = array();
        foreach (range(6, 8) as $line) {
            foreach (range(0, 2) as $column) {
                $expected[] = new Coordinate($line, $column);
            }
        }

        $subGrids = $this->splitter->getSubGridsCoordinates();
        $this->assertEquals($expected, $subGrids[6]);
    }

    public function testNextEmptyCellIs00ForEmptyGrid() {
        $this->assertEquals(new Coordinate(0, 0), $this->splitter->nextEmptyCell());
    }

    public function testWhen00IsSetNextEmptyCellIs01() {
        $this->grid->expects($this->any())
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(true, false));
        $this->assertEquals(new Coordinate(0, 1), $this->splitter->nextEmptyCell());
    }

    public function testWhenFirst2RowsAreSetNextEmptyCellIs24() {
        $this->grid->expects($this->any())
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(true, true, true, true, true, true, true, true, true, true, true, true,
                true, true, true, true, true, true, true, true, true, true, false));
        $this->assertEquals(new Coordinate(2, 4), $this->splitter->nextEmptyCell());
    }

    public function testGetLineValues() {
        $this->grid->expects($this->exactly(9))
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(true, false, true, false, false, false, true, true, false));

        $this->grid->expects($this->exactly(4))
            ->method('getValueAtCoordinate')
            ->will($this->onConsecutiveCalls(5, 8, 9, 1));
        $this->assertEquals(array(1, 5, 8, 9), $this->splitter->getLineValues(3));
    }

    public function testGetColumnsValues() {
        $this->grid->expects($this->exactly(9))
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(false, true, false, true, false, false, true, true, false));

        $this->grid->expects($this->at(2))
            ->method('getValueAtCoordinate')
            ->with($this->equalTo(new Coordinate(1, 6)))
            ->will($this->returnValue(5));
        $this->grid->expects($this->at(5))
            ->method('getValueAtCoordinate')
            ->with(new Coordinate(3, 6))
            ->will($this->returnValue(8));
        $this->grid->expects($this->at(9))
            ->method('getValueAtCoordinate')
            ->with(new Coordinate(6, 6))
            ->will($this->returnValue(9));
        $this->grid->expects($this->at(11))
            ->method('getValueAtCoordinate')
            ->with(new Coordinate(7, 6))
            ->will($this->returnValue(1));

        $this->assertEquals(array(1, 5, 8, 9), $this->splitter->getColumnValues(6));
    }

    public function testGetSubGridValues() {
        $this->grid->expects($this->exactly(9))
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(false, true, false, true, false, false, true, false, true));

        $this->grid->expects($this->at(2))
            ->method('getValueAtCoordinate')
            ->with($this->equalTo(new Coordinate(3, 4)))
            ->will($this->returnValue(5));
        $this->grid->expects($this->at(5))
            ->method('getValueAtCoordinate')
            ->with(new Coordinate(4, 3))
            ->will($this->returnValue(8));
        $this->grid->expects($this->at(9))
            ->method('getValueAtCoordinate')
            ->with(new Coordinate(5, 3))
            ->will($this->returnValue(9));
        $this->grid->expects($this->at(12))
            ->method('getValueAtCoordinate')
            ->with(new Coordinate(5, 5))
            ->will($this->returnValue(1));

        $this->assertEquals(array(1, 5, 8, 9), $this->splitter->getSubGridValues(4));
    }

    public function testGetAllLinesValues() {
        $this->makeGetValueAtCoordinateReturnsTheCoordinate();
        $criterion = $this->getMockBuilder('Sudoku\GridCriterion')
            ->getMock();
        $criterion->expects($this->any())
            ->method('getLineCount')
            ->will($this->returnValue(3));
        $criterion->expects($this->any())
            ->method('getColumnCount')
            ->will($this->returnValue(3));

        $splitter = new GridSplitter($this->grid, $criterion);

        $this->grid->expects($this->exactly(9))
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(true, true, false, true, false, true, false, true, true));

        $expected = array(
            array('0-0', '0-1'),
            array('1-0', '1-2'),
            array('2-1', '2-2')
        );
        $this->assertEquals($expected, $splitter->getAllLinesValues());
    }

    public function testGetAllColumnsValues() {
        $this->makeGetValueAtCoordinateReturnsTheCoordinate();
        $criterion = $this->getMockBuilder('Sudoku\GridCriterion')
            ->getMock();
        $criterion->expects($this->any())
            ->method('getLineCount')
            ->will($this->returnValue(2));
        $criterion->expects($this->any())
            ->method('getColumnCount')
            ->will($this->returnValue(2));

        $splitter = new GridSplitter($this->grid, $criterion);

        $this->grid->expects($this->exactly(4))
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(true, true, true, true, true));

        $expected = array(
            array('0-0', '1-0'),
            array('0-1', '1-1')
        );
        $this->assertEquals($expected, $splitter->getAllColumnsValues());
    }

    public function testGetAllGridsValues() {
        $this->makeGetValueAtCoordinateReturnsTheCoordinate();
        $criterion = $this->getMockBuilder('Sudoku\GridCriterion')
            ->getMock();
        $criterion->expects($this->any())
            ->method('getLineCount')
            ->will($this->returnValue(4));
        $criterion->expects($this->any())
            ->method('getColumnCount')
            ->will($this->returnValue(4));
        $criterion->expects($this->any())
            ->method('getSubGridCount')
            ->will($this->returnValue(4));
        $criterion->expects($this->any())
            ->method('getLinesBySubGrid')
            ->will($this->returnValue(2));
        $criterion->expects($this->any())
            ->method('getColumnsBySubGrid')
            ->will($this->returnValue(2));


        $splitter = new GridSplitter($this->grid, $criterion);

        $this->grid->expects($this->exactly(16))
            ->method('isCellSet')
            ->will($this->onConsecutiveCalls(
                true, true, true, true,
                true, true, true, true,
                true, true, true, true,
                true, true, true, true));

        $expected = array(
            array('0-0', '0-1', '1-0', '1-1'),
            array('0-2', '0-3', '1-2', '1-3'),
            array('2-0', '2-1', '3-0', '3-1'),
            array('2-2', '2-3', '3-2', '3-3'),
        );
        $this->assertEquals($expected, $splitter->getAllSubGridsValues());
    }

    private function makeGetValueAtCoordinateReturnsTheCoordinate() {
        $callback = function(Coordinate $coordinate) {
            return $coordinate->getKey();
        };

        $this->grid->expects($this->any())
            ->method('getValueAtCoordinate')
            ->will($this->returnCallback($callback));
    }
}
