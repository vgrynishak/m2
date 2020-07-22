Feature: Map StyleTemplate Entity to StyleTemplate
  Scenario: I want to map StyleTemplate Entity to StyleTemplate
    Given I’m set correct StyleTemplate Entity
    When I call Method Map
    Then I should get StyleTemplate that Implements StyleTemplate Interface
