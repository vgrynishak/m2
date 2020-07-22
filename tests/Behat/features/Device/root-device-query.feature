Feature: Get Group by query
  Scenario: I want to get Group
    Given Device param id "63bea125-46f1-4d59-b6ec-65000d13ac1f"
    When I call find by root device query handler
    Then I should have CollectionInterface
