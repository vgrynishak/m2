Feature: Use CreateDeviceInstanceUseCaseInterface
  Scenario: I want to use CreateDeviceInstanceUseCaseInterface
    Given I'm set CreateDeviceInstanceCommandInterface
    When I call method create
    Then I should get DeviceInstanceInterface