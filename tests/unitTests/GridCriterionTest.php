<?php

use Sudoku\GridCriterion;

class GridCriterionTest extends PHPUnit_Framework_TestCase {

    /** @var GridCriterion */
    private $criterion;

    public function setup() {
        $this->criterion = new GridCriterion();
    }

    public function testGridHas9Lines() {
        $this->assertSame(9, $this->criterion->getLineCount());
    }

    public function testGridHas9Columns() {
        $this->assertSame(9, $this->criterion->getColumnCount());
    }

    public function testGridHas9SubGrids() {
        $this->assertSame(9, $this->criterion->getSubGridCount());
    }

    public function testGridAs3LinesBySubGrid() {
        $this->assertSame(3, $this->criterion->getLinesBySubGrid());
    }

    public function testGridAs3ColumnsBySubGrid() {
        $this->assertSame(3, $this->criterion->getColumnsBySubGrid());
    }

    public function test1IsValid() {
        $this->assertTrue($this->criterion->isValueValid(1));
    }

    public function test9IsValid() {
        $this->assertTrue($this->criterion->isValueValid(9));
    }

    public function test0IsNotValid() {
        $this->assertFalse($this->criterion->isValueValid(0));
    }

    public function test10IsNotValid() {
        $this->assertFalse($this->criterion->isValueValid(10));
    }

    public function testGridNeeds81ValuesToBeFull() {
        $this->assertSame(81, $this->criterion->numberOfNeededValues());
    }

}
