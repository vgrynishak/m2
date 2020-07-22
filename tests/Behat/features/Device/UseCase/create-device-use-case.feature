Feature: Use CreateDeviceUseCaseInterface
  Scenario: I want to use CreateDeviceUseCaseInterface
    Given I'm set CreateDeviceCommandInterface
    When I call method create
    Then I should get DeviceInterface