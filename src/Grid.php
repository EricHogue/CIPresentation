<?php

class Grid {
	/** @var array */
	private $cells = array();

	public function cellsCount() {
		return count($this->cells);
	}

	public function addCell(Coordinate $coordinate, $value) {
		//$this->cells[$coordinate->getKey()] = $value;
	}

	public function getValueAtCoordinate(Coordinate $coordinate) {
		if (!$this->isCellSet($coordinate)) throw new CellNotSetException();

		return $this->cells[$coordinate->getKey()];
	}

	public function isCellSet(Coordinate $coordinate) {
		$key = $coordinate->getKey();
		return array_key_exists($key, $this->cells) && is_int($this->cells[$key]);
	}

	public function hasPossibleValues(Coordinate $coordinate) {
		$key = $coordinate->getKey();
		$cells = $this->cells;

		return array_key_exists($key, $cells) && is_array($cells[$key]);
	}

	public function setPossibleValues(Coordinate $coordinate, array $values) {
		$this->cells[$coordinate->getKey()] = $values;
	}
}
