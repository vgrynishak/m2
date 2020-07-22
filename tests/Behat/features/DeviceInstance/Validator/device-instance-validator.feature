Feature: Validate CreateDeviceInstanceValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call CreateDeviceInstanceValidator
    Then I should get true result

  Scenario: I want to Validate CreateDeviceInstanceValidatorInterface with incorrect id
    Given I'm set correct command
    But DeviceInstance with id is already exist
    When I call CreateDeviceInstanceValidator
    Then I should get message error "DeviceInstance has already created"

  Scenario: I want to Validate CreateDeviceInstanceValidatorInterface with incorrect deviceId
    Given I'm set correct command
    But Device is not exist
    When I call CreateDeviceInstanceValidator
    Then I should get message error "Device was not found"

  Scenario: I want to Validate CreateDeviceInstanceValidatorInterface with incorrect facilityId
    Given I'm set correct command
    But Facility is not exist
    When I call CreateDeviceInstanceValidator
    Then I should get message error "Facility was not found"

  Scenario: I want to Validate CreateDeviceInstanceValidatorInterface with incorrect CreatedBy
    Given I'm set correct command
    But User is not exist
    When I call CreateDeviceInstanceValidator
    Then I should get message error "User was not found"

  Scenario: I want to Validate CreateDeviceInstanceValidatorInterface with incorrect parentId
    Given I'm set correct command
    But Parent is not exist
    When I call CreateDeviceInstanceValidator
    Then I should get message error "DeviceInstance parent was not found"
