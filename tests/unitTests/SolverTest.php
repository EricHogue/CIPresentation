<?php

class SolverTest extends PHPUnit_Framework_TestCase {
	private $solver;
	private $validator;
	private $grid;
	private $countToReturn = 1;

	public function setup() {
		$this->validator = $this->getMockBuilder('Validator')
			->disableOriginalConstructor()
			->getMock();

		$this->solver = new Solver($this->validator);

		$this->grid = $this->getMockBuilder('Grid')
			->getMock();
		$this->grid->expects($this->any())
			->method('cellsCount')
			->will($this->returnCallback(array($this, 'getCellsCount')));
	}

	/**
	 * @expectedException EmptyGridException
	 */
	public function testSolvingAnEmptyGridThrowsAnError() {
		$this->countToReturn = 0;
		$this->solver->solve($this->grid);
	}

	/**
	 * @expectedException DuplicateValuesException
	 */
	public function testSolvingAGridWithDuplicateValuesThrowsAnException() {
		$this->solver->solve($this->grid);
	}






	public function getCellsCount() {
		return $this->countToReturn;
	}
}
