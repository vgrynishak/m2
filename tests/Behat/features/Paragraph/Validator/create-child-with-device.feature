Feature: Validate CreateChildWithDeviceCommand
  Scenario: Validate CreateChildWithDeviceCommand with correct params
    Given I'm set correct params
    When I call CreateChildWithDeviceValidator
    Then I should get true result

  Scenario: Validate CreateChildWithDeviceCommand whth duplicate Id
    Given I'm set correct params
    But I'm set param "id" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Duplicate paragraph ID"

  Scenario: Validate CreateChildWithDeviceCommand whth invalid ParentId
    Given I'm set correct params
    But I'm set param "parentId" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Parent paragraph was not found"

  Scenario: Validate CreateChildWithDeviceCommand whth invalid DeviceId
    Given I'm set correct params
    But I'm set param "deviceId" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Invalid device"

  Scenario: Validate CreateChildWithDeviceCommand whth invalid FilterId
    Given I'm set correct params
    But I'm set param "filterId" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Invalid filter"

  Scenario: Validate CreateChildWithDeviceCommand whth invalid CreatedBy
    Given I'm set correct params
    But I'm set param "user" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "User was not found"

  Scenario: Validate CreateChildWithDeviceCommand whth invalid StyleTemplateId
    Given I'm set correct params
    But I'm set param "styleTemplateId" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Invalid style template"

  Scenario: Validate CreateChildWithDeviceCommand whth maximum Level value
    Given I'm set correct params
    But I'm set param "level" with incorrect value
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Maximum nesting level reached"

  Scenario: Validate CreateChildWithDeviceCommand with invalid BaseHeaderInterface
    Given I'm set correct params
    But I'm set header with incorrect implementing
    When I call CreateChildWithDeviceValidator
    Then I should get message error "Invalid Header"

