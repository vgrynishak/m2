Feature: Validate CreateServiceInstanceValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call CreateServiceInstanceValidator
    Then I should get true result

  Scenario: I want to Validate CreateServiceInstanceValidatorInterface with incorrect id
    Given I'm set correct command
    But ServiceInstance with id is already exist
    When I call CreateServiceInstanceValidator
    Then I should get message error "ServiceInstance has already created"

  Scenario: I want to Validate CreateServiceInstanceValidatorInterface with incorrect serviceId
    Given I'm set correct command
    But Service is not exist
    When I call CreateServiceInstanceValidator
    Then I should get message error "Service was not found"

  Scenario: I want to Validate CreateServiceInstanceValidatorInterface with incorrect facilityId
    Given I'm set correct command
    But Facility is not exist
    When I call CreateServiceInstanceValidator
    Then I should get message error "Facility was not found"

  Scenario: I want to Validate CreateServiceInstanceValidatorInterface with incorrect CreatedBy
    Given I'm set correct command
    But User is not exist
    When I call CreateServiceInstanceValidator
    Then I should get message error "User was not found"
