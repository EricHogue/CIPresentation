<?php

class GridSplitter {
	/** @var Grid */
	private $grid;

	/** @var GridCriterion */
	private $criterion;

	public function __construct(Grid $grid, GridCriterion $criterion) {
		$this->grid = $grid;
		$this->criterion = $criterion;
	}

	public function getLinesCoordinates() {
		$lines = array();
		foreach (range(0, $this->criterion->getLineCount() - 1) as $lineNumber) {
			$lines[] = $this->getCoordinatesForLine($lineNumber);
		}

		return $lines;
	}

	public function getColumnsCoordinates() {
		$columns = array();
		foreach (range(0, $this->criterion->getColumnCount() - 1) as $columnNumber) {
			$columns[] = $this->getCoordinatesForColumn($columnNumber);
		}

		return $columns;
	}

	public function getSubGridsCoordinates() {
		$subGrids = array();
		foreach(range(0, $this->criterion->getSubGridCount() - 1) as $subGridNumber) {

			$subGrids[] = $this->getSubGridCoordinates($subGridNumber);
		}

		return $subGrids;
	}

	public function nextEmptyCell() {
		$linesCount = $this->criterion->getLineCount();
		$columnsCount = $this->criterion->getColumnCount();

		foreach (range(0, $linesCount - 1) as $lineNumber) {
			foreach (range(0, $columnsCount - 1) as $columnNumber) {
				$coord = new Coordinate($lineNumber, $columnNumber);
				if (!$this->grid->isCellSet($coord)) {
					return $coord;
				}
			}
		}

		return null;
	}

	public function getLineValues($lineNumber) {
		$values = array();
		$lines = $this->getLinesCoordinates();
		$lineCoordinates = $lines[$lineNumber];

		foreach ($lineCoordinates as $coord) {
			if ($this->grid->isCellSet($coord)) {
				$values[] = $this->grid->getValueAtCoordinate($coord);
			}
		}
		sort($values);

		return $values;
	}

	public function getColumnValues($columnNumber) {
		$values = array();
		$columns = $this->getColumnsCoordinates();
		$columnCoordinates = $columns[$columnNumber];

		foreach ($columnCoordinates as $coord) {
			if ($this->grid->isCellSet($coord)) {
				$values[] = $this->grid->getValueAtCoordinate($coord);
			}
		}
		sort($values);

		return $values;
	}

	public function getSubGridValues($subGridNumber) {
		$coordinates = $this->getSubGridCoordinates($subGridNumber);
		$values = array();

		foreach($coordinates as $coord) {
			if ($this->grid->isCellSet($coord)) {
				$values[] = $this->grid->getValueAtCoordinate($coord);
			}
		}
		sort($values);

		return $values;
	}

	public function getAllLinesValues() {
		$values = array();

		$lineCount = $this->criterion->getLineCount();

		for ($lineNumber = 0; $lineNumber < $lineCount; $lineNumber++) {
			$values[] = $this->getLineValues($lineNumber);
		}

		return $values;
	}

	public function getAllColumnsValues() {
		$values = array();

		$columnCount = $this->criterion->getColumnCount();

		for ($columnNumber = 0; $columnNumber < $columnCount; $columnNumber++) {
			$values[] = $this->getColumnValues($columnNumber);
		}

		return $values;
	}

	public function getAllSubGridsValues() {
		$values = array();

		$subGridCount = $this->criterion->getSubGridCount();

		for ($subGridNumber = 0; $subGridNumber < $subGridCount; $subGridNumber++) {
			$values[] = $this->getSubGridValues($subGridNumber);
		}

		return $values;
	}

	private function getCoordinatesForLine($line) {
		$func = function($column) use ($line) {
			return new Coordinate($line, $column);
		};

		return array_map($func, range(0, $this->criterion->getColumnCount() - 1));
	}

	private function getCoordinatesForColumn($column) {
		$grid = $this->grid;
		$func = function($line) use ($column, $grid) {
			return new Coordinate($line, $column);
		};

		return array_map($func, range(0, $this->criterion->getLineCount() - 1));
	}

	private function getStartingLineForSubGrid($subGrid) {
		$linesBySubGrid = $this->criterion->getLinesBySubGrid();
		return floor(($subGrid) / $linesBySubGrid) * $linesBySubGrid;
	}

	private function getStartingColumnForSubGrids($subGrid, $startingLine) {
		return floor(($subGrid - $startingLine)) * $this->criterion->getColumnsBySubGrid();
	}

	private function getSubGridCoordinates($subGridNumber) {
		$coord = $this->getStartingCoordinateForSubGrid($subGridNumber);

		$linesToAdd = $this->criterion->getLinesBySubGrid() - 1;
		$columnsToAdd = $this->criterion->getColumnsBySubGrid() - 1;
		$subGrid = array();

		foreach (range($coord->getRow(), $coord->getRow() + $linesToAdd) as $line) {
			foreach (range($coord->getColumn(), $coord->getColumn() + $columnsToAdd) as $column) {
				$subGrid[] = new Coordinate((int) $line, (int) $column);
			}
		}

		return $subGrid;
	}

	protected function getStartingCoordinateForSubGrid($subGridNumber) {
		$startingLine = $this->getStartingLineForSubGrid($subGridNumber);
		$startingColumn = $this->getStartingColumnForSubGrids($subGridNumber, $startingLine);

		return new Coordinate($startingLine, $startingColumn);
	}
}
