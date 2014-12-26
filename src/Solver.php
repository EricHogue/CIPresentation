<?php

namespace Sudoku;

class Solver {
	/** @var Validator */
	private $validator;

	public function __construct(Validator $validator) {
		$this->validator = $validator;
	}

	public function solve(Grid $grid) {
		if (0 === $grid->cellsCount()) throw new EmptyGridException();
		if (isset($this->validator)) throw new DuplicateValuesException();

	}
}
