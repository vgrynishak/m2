Feature: Parse request for AllListGroupedByCategoryQuery
  Scenario: Parse request with correct params
    When I call ItemCategory Parser
    Then I should get AllListGroupedByCategoryQuery