Feature: Map ListInputCommand to ItemModel
  Scenario: I want to map ListInputCommand to Item model
    Given I'm Set ListInputCommand with itemType quick_select
    When I Call Method Map
    Then I should get QuickSelectItem

  Scenario: I want to map ListInputCommand to Item model
    Given I'm Set ListInputCommand with itemType single_selection_list
    When I Call Method Map
    Then I should get SingleSelectListItem
