<?php

namespace Sudoku;

class Loader {
	public function loadFromText($gridText) {
		$grid = new Grid();
		$lines = explode("\n", trim($gridText));

		for ($lineNumber = 0; $lineNumber < count($lines); $lineNumber++) {
			$this->readLine($grid, $lines[$lineNumber], $lineNumber);
		}

		return $grid;
	}

	public function loadFromFile($file) {
		if (file_exists($file)) {
			return $this->loadFromText(file_get_contents($file));
		}

		throw new FileNotFoundException();
	}

	private function readLine(Grid $grid, $lineText, $lineNumber) {
		$cells = explode(' ', $lineText);

		for ($columnNumber = 0; $columnNumber < count($cells); $columnNumber++) {
			$value = $cells[$columnNumber];
			if (is_numeric($value)) {
				$grid->addCell(new Coordinate($lineNumber, $columnNumber), (int) $value);
			}
		}
	}
}
