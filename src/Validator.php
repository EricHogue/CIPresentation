<?php

namespace Sudoku;

class Validator {
	/** @var Grid */
	private $grid;

	/** @var GridSplitter */
	private $splitter;

	/** @var GridCriterion */
	private $criterion;

	public function __construct(Grid $grid, GridSplitter $splitter, GridCriterion $criterion) {
		$this->grid = $grid;
		$this->splitter = $splitter;
		$this->criterion = $criterion;
	}

	public function areAllValuesSet() {
		//return $this->grid->cellsCount() === $this->criterion->numberOfNeededValues();
	}

	public function areValuesValid($values) {
		foreach($values as $toCheck) {
			if (!$this->criterion->isValueValid($toCheck)) return false;
		}

		return true;
	}

	public function haveDuplicates($values) {
		return array_unique($values) !== $values;
	}

	public function isValidGrid() {
		if (!$this->areAllValuesSet()) return false;

		$allSections = array_merge($this->splitter->getAllLinesValues(),
			$this->splitter->getAllColumnsValues(), $this->splitter->getAllSubGridsValues());

		foreach($allSections as $section) {
			if (!$this->areValuesValid($section)) return false;
			if ($this->haveDuplicates($section)) return false;
		}

		return true;
	}
}
