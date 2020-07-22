Feature: Validate EditSectionCommandInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command params
    When I call EditSectionValidator
    Then I should get true result

  Scenario: I want to Validate EditSectionCommandInterface with incorrect id
    Given I'm set correct command params
    But Section with id is not exist
    When I call EditSectionValidator
    Then I should get message error "Section is not exist"

  Scenario: I want to Validate EditSectionCommandInterface with incorrect ModifiedBy
    Given I'm set correct command params
    But User is not created
    When I call EditSectionValidator
    Then I should get message error "Modified User was not found"

  Scenario: I want to Validate EditSectionCommandInterface with incorrect title
    Given I'm set correct command params
    But Param title is 'ti'
    When I call EditSectionValidator
    Then I should get message error "New section`s title can not be less than 3"

  Scenario: I want to Validate EditSectionCommandInterface with incorrect title
    Given I'm set correct command params
    But Param title is 'more_than_256'
    When I call EditSectionValidator
    Then I should get message error "New section`s title can not be more than 256"

