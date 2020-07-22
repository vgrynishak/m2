Feature: Get array after adapt ItemCategoryCollection
  Scenario: I want to get right array item Category
    Given Item Category Collection with Item Types Collection
    When I call static method adaptCollection
    Then I should have array of Item Category DTO