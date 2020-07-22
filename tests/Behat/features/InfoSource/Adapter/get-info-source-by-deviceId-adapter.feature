Feature: Parse request for GetDeviceDynamicFieldsByDeviceIdCommandInterface
  Scenario: Adapt short DeviceDynamicFields by DeviceId
    Given I'm set correct InfoSource data for full adapter
    And Create correct predefined data
    When I compere GetInfoSourceByDeviceIdAdapter data with predefined data
    Then I should get the same structure

  Scenario: Adapt short DeviceDynamicFields by incorrect id
    Given I'm set incorrect DeviceDynamicFields data for short adapter
    And Create correct predefined data
    When I compere GetInfoSourceByDeviceIdAdapter data with predefined data
    Then I should not get the same structure
