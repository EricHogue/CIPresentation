Feature: Solve a sudoku grid
	In order to play sudoku
	As a lazy guy
	I need the computer to solve it for me
	
	Scenario: I load an empty grid
		Given an empty grid
		When I try to solve it
		Then it should ask me for some initial values

	Scenario: I load a grid with errors
		Given a grid with duplicate values
		When I try to solve it
		Then it should return a duplicate values error

	Scenario: I load a grid to solve
		Given a grid with valid initial state
		When I try to solve it
		Then it should return a full valid grid
