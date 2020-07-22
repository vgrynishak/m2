Feature: Create Device by command
  Scenario: I want to Create device
    Given Device param id "63bea125-46f1-4d59-b6ec-13000d13ac9f" name "DeviceName" and parentId "63bea125-46f1-4d59-b6ec-65000d13ac1f" and alias "test_alias"
    When I call create device command handler
    Then I should have created Device entity
