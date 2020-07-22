Feature: Validate CreateRootWithDeviceCommand
  Scenario: Validate CreateRootWithDeviceCommand with correct params
    Given I'm set correct params
    When I call CreateRootWithDeviceValidator
    Then I should get true result

  Scenario: Validate CreateRootWithDeviceCommand with duplicate Id
    Given I'm set correct params
    But I'm set param "id" with incorrect value
    When I call CreateRootWithDeviceValidator
    Then I should get message error "Duplicate paragraph ID"

  Scenario: Validate CreateRootWithDeviceCommand with invalid SectionId
    Given I'm set correct params
    But I'm set param "sectionId" with incorrect value
    When I call CreateRootWithDeviceValidator
    Then I should get message error "Invalid section"

  Scenario: Validate CreateRootWithDeviceCommand with invalid DeviceId
    Given I'm set correct params
    But I'm set param "deviceId" with incorrect value
    When I call CreateRootWithDeviceValidator
    Then I should get message error "Invalid device"

  Scenario: Validate CreateRootWithDeviceCommand with invalid FilterId
    Given I'm set correct params
    But I'm set param "filterId" with incorrect value
    When I call CreateRootWithDeviceValidator
    Then I should get message error "Invalid filter"

  Scenario: Validate CreateRootWithDeviceCommand with invalid CreatedBy
    Given I'm set correct params
    But I'm set param "user" with incorrect value
    When I call CreateRootWithDeviceValidator
    Then I should get message error "User was not found"

  Scenario: Validate CreateRootWithDeviceCommand with invalid StyleTemplateId
    Given I'm set correct params
    But I'm set param "styleTemplateId" with incorrect value
    When I call CreateRootWithDeviceValidator
    Then I should get message error "Invalid style template"

  Scenario: Validate CreateRootWithDeviceCommand with invalid BaseHeaderInterface
    Given I'm set correct params
    But I'm set header with incorrect implementing
    When I call CreateRootWithDeviceValidator
    Then I should get message error "Invalid Header"
