Feature: Validate Create Service Command
  Scenario: I want to Validate correct Command
    Given I'm set correct Command implements CreateServiceCommandInterface
    When I call Method Validate
    Then I should get true result

  Scenario: I want to Validate correct Command with duplicate ID
    Given I'm set correct Command implements CreateServiceCommandInterface
    But property ID already exists
    When I call Method Validate
    Then I should get message error "Duplicate Service ID"

  Scenario: I want to Validate correct Command with invalid DeviceId
    Given I'm set correct Command implements CreateServiceCommandInterface
    But property DeviceId not exists
    When I call Method Validate
    Then I should get message error "Device was not found"

  Scenario: I want to Validate correct Command with invalid FacilityId
    Given I'm set correct Command implements CreateServiceCommandInterface
    But property FacilityId not exists
    When I call Method Validate
    Then I should get message error "Facility was not found"

  Scenario: I want to Validate correct Command with short Name
    Given I'm set correct Command implements CreateServiceCommandInterface
    But property Name has length less then 3
    When I call Method Validate
    Then I should get message error "Service`s name cannot be less than 3"

  Scenario: I want to Validate correct Command with long Name
    Given I'm set correct Command implements CreateServiceCommandInterface
    But property Name has length more then 256
    When I call Method Validate
    Then I should get message error "Service`s name cannot be more than 256"

  Scenario: I want to Validate correct Command with invalid CreatedBy
    Given I'm set correct Command implements CreateServiceCommandInterface
    But user in CreatedBy not exists
    When I call Method Validate
    Then I should get message error "User was not found"

  Scenario: I want to Validate correct Command with invalid ModifiedBy
    Given I'm set correct Command implements CreateServiceCommandInterface
    But user in ModifiedBy not exists
    When I call Method Validate
    Then I should get message error "User was not found"
