Feature: Get File from Storage
  Scenario: I want to get file from Simple Storage Service
    Given param key with existing file
    When I Call method get
    Then I should get File

  Scenario: I want to get error for get File to Simple Storage Service
    Given param key without existing file
    When I Call method get
    Then I should get Exception FailGetObjectS3Storage

