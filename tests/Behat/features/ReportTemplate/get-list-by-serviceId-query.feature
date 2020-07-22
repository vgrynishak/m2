Feature: Get Report Templates List By ServiceId
  Scenario: I want to get Report Templates List
    Given Service param id "63bea125-46f1-4d59-b6ec-65000d13acc1"
    When I call handle list message Response
    Then I should have report templates list Response with status 200

  Scenario: I want to get error for get Report Templates List
    Given Service param id "test"
    When I call handle list message Response
    Then I should have report templates list Response with status 400
