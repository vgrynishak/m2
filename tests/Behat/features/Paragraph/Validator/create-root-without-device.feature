Feature: Validate CreateRootWithoutDeviceCommand
  Scenario: Validate CreateRootWithoutDeviceCommand with correct params
    Given I'm set correct params
    When I call Method Validate
    Then I should get true result

  Scenario: Validate CreateRootWithoutDeviceCommand whth duplicate Id
    Given I'm set correct params
    But I'm set param "id" with incorrect value
    When I call Method Validate
    Then I should get message error "Paragraph with this Id already exists"

  Scenario: Validate CreateRootWithoutDeviceCommand whth invalid CreatedBy
    Given I'm set correct params
    But I'm set param "user" with incorrect value
    When I call Method Validate
    Then I should get message error "User was not created"

  Scenario: Validate CreateRootWithoutDeviceCommand whth invalid CreatedBy
    Given I'm set correct params
    But I'm set param "sectionId" with incorrect value
    When I call Method Validate
    Then I should get message error "Section with this Id is not exists"

  Scenario: Validate CreateRootWithoutDeviceCommand whth invalid StyleTemplateId
    Given I'm set correct params
    But I'm set param "styleTemplateId" with incorrect value
    When I call Method Validate
    Then I should get message error "Invalid style template"

  Scenario: Validate CreateRootWithoutDeviceCommand with invalid BaseHeaderInterface
    Given I'm set correct params
    But I'm set header with incorrect implementing
    When I call Method Validate
    Then I should get message error "Invalid Header"
