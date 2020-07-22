Feature: Map HeaderTypeEntity to BaseHeaderInterface
  Scenario: I want to map HeaderTypeEntity to NoHeaderInterface
    Given I’m find HeaderTypeEntity with "no_header" HeaderType
    When I call Method Map
    Then I should get Header that Implements NoHeaderInterface

  Scenario: I want to map HeaderTypeEntity to DeviceCardHeaderInterface
    Given I’m find HeaderTypeEntity with "device_card" HeaderType
    When I call Method Map
    Then I should get Header that Implements DeviceCardHeaderInterface

  Scenario: I want to map HeaderTypeEntity to CustomHeaderInterface
    Given I’m find HeaderTypeEntity with "custom_title" HeaderType
    When I call Method Map
    Then I should get Header that Implements CustomHeaderInterface
