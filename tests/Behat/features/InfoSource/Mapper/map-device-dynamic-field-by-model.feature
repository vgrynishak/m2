Feature: Map new DeviceDynamicFieldInterfaceCollection to DeviceDynamicFieldEntityCollection with DeviceDynamicFieldModel
  Scenario: I want to map new DeviceDynamicFieldInterfaceCollection to DeviceDynamicFieldEntityCollection with DeviceDynamicFieldModel
    Given I’m set correct DeviceInterface which contain new DeviceDynamicFieldInterfaceCollection
    When I call Method mapNewByDevice
    Then I should get DeviceDynamicFieldEntityCollection that Implements DeviceDynamicFieldEntity