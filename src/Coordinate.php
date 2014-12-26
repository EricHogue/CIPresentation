<?php

namespace Sudoku;

class Coordinate {
	/** @var int */
	private $row;

	/** @var int */
	private $column;

	public function __construct($row, $column) {
		$this->row = $row;
		$this->column = $column;
		$a = 3;
	}

	public function getKey() {
		return $this->row . '-'. $this->column;
	}

	public function getRow() {
		return $this->row;
	}

	public function getColumn() {
		return $this->column;
	}

	public function __toString() {
		return $this->getKey();
	}
}
