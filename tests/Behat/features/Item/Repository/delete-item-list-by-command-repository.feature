Feature: I want to delete item list with the ItemCommandRepositoryInterface
  Scenario: I want to delete Items CollectionInterface
    Given I'm find Items collection interface which I want to delete
    When I Call Method Delete
    Then I should not get this Items
