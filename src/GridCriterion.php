<?php

namespace Sudoku;

class GridCriterion {
	const GRID_SIZE = 9;
	const SUB_GRID_SIZE = 3;

	public function getLineCount() {
		return self::GRID_SIZE;
	}

	public function getColumnCount() {
		return self::GRID_SIZE;
	}

	public function getSubGridCount() {
		return self::GRID_SIZE;
	}

	public function getLinesBySubGrid() {
		return self::SUB_GRID_SIZE;
	}

	public function getColumnsBySubGrid() {
		return self::SUB_GRID_SIZE;
	}

	public function isValueValid($valueToCheck) {
		return in_array($valueToCheck, range(1, self::GRID_SIZE));
	}

	public function numberOfNeededValues() {
		return self::GRID_SIZE * self::GRID_SIZE;
	}
}
