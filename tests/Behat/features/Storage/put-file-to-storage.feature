Feature: Put File To Storage
  Scenario: I want to put file to Simple Storage Service
    Given File param with file.data and file.key
    When I Call method put
    Then I should result Response with status 200
