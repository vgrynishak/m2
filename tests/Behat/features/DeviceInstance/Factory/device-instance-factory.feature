Feature: Make DeviceInstance by DeviceInstanceFactory
  Scenario: Making DeviceInstance
    Given I'm Set Correct Params For DeviceInstance
    When I Call Method make
    Then I Should Get Correct DeviceInstance