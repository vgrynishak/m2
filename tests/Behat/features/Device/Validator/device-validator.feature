Feature: Validate CreateDeviceValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call CreateDeviceValidator
    Then I should get true result

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect id
    Given I'm set correct command
    But Device with id is already exist
    When I call CreateDeviceValidator
    Then I should get message error "Device has already created"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect CreatedBy
    Given I'm set correct command
    But User is not exist
    When I call CreateDeviceValidator
    Then I should get message error "User was not found"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect parentId
    Given I'm set correct command
    But Parent is not exist
    When I call CreateDeviceValidator
    Then I should get message error "Device parent was not found"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect divisionId
    Given I'm set correct command
    But Division is not exist
    When I call CreateDeviceValidator
    Then I should get message error "Division was not found"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect name
    Given I'm set correct command
    But Param name is 'ti'
    When I call CreateDeviceValidator
    Then I should get message error "Device`s name can not be less than 3"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect name
    Given I'm set correct command
    But Param name is 'more_than_256'
    When I call CreateDeviceValidator
    Then I should get message error "Device`s name can not be more than 256"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect alias
    Given I'm set correct command
    But Param alias is 'ti'
    When I call CreateDeviceValidator
    Then I should get message error "Device`s alias can not be less than 3"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect alias
    Given I'm set correct command
    But Param alias is 'more_than_256'
    When I call CreateDeviceValidator
    Then I should get message error "Device`s alias can not be more than 256"


  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect alias
    Given I'm set correct command
    But Param alias is 'ti'
    When I call CreateDeviceValidator
    Then I should get message error "Device`s alias can not be less than 3"

  Scenario: I want to Validate CreateDeviceValidatorInterface with incorrect level
    Given I'm set correct command
    But Param level is '4'
    When I call CreateDeviceValidator
    Then I should get message error "Device`s level can not be more than 3"