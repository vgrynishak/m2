Feature: Create Service
  Scenario: I want to create ServiceEntity by Service model
    Given I'm Set correct Service model
    When I Call Method Create
    Then I should get created service
