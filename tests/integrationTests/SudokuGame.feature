Feature: Play a Sudoky game
	In order to play a game of sudoku
	As a user
	I need to be able to evaluate a grid
	
	Scenario: I load an empty grid
		Given an empty grid
		Then I should not be winning

	Scenario: I load an incomplete grid
		Given an incomplete grid
		Then I should not be winning

	Scenario: I have duplicates
		Given an incomplete grid
		When I add a duplicate value
		Then I should not be winning
	
		
	Scenario: I solve the puzzle
		Given an incomplete grid
		When I add the correct value
		Then I should be winning
