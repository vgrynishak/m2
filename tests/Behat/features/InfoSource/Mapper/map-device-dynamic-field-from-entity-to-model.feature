Feature: Map DeviceDynamicFieldEntity to DeviceDynamicFieldInterface with DoctrineEntityDeviceDynamicFieldMapper
  Scenario: I want to map DeviceDynamicFieldEntity to DeviceDynamicFieldInterface with DoctrineEntityDeviceDynamicFieldMapper
    Given I’m find and set correct DeviceDynamicFieldEntity
    When I call Method map
    Then I should get DeviceDynamicField that Implements DeviceDynamicFieldInterface
