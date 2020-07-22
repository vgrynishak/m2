Feature: Validate GetInfoSourceListByDeviceIdValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call InfoSourceListByDeviceIdValidator
    Then I should get true result

  Scenario: I want to Validate GetDeviceDynamicFieldListByDeviceIdValidatorInterface with incorrect id
    Given I'm set correct command
    But Device with id is not exist
    When I call InfoSourceListByDeviceIdValidator
    Then I should get message error "Dictionary is not exist"
