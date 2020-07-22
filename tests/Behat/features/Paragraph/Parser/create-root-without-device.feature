Feature: Parse request for CreateRootWithoutDeviceCommand
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call method Parse
    Then I should get Command implements CreateRootWithoutDeviceInterface
    And property isPrintable should be true
    And property createdBy should be instance of UserInterface
    And property header should be instance of CustomHeaderInterface

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "styleTemplateId" is absent
    When I call method Parse
    Then I should get Command implements CreateRootWithoutDeviceInterface
    And Style Template Id should be default

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "title" is absent
    When I call Method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Title is required field"

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "title" is empty
    When I call Method Parse
    Then I should get Command implements CreateRootWithoutDeviceInterface
    And Style HeaderType should be instance of NoHeaderInterface

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid root key"

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is absent
    When I call method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Paragraph Id is required field"

  Scenario: Parse request without SectionId param
    Given I'm set correct params
    But param "sectionId" is absent
    When I call method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Section Id is required field"

  Scenario: Parse request with invalid paragraph id
    Given I'm set correct params
    But I'm set param "id" with incorrect value
    When I call method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid Paragraph Id"

  Scenario: Parse request with invalid section id
    Given I'm set correct params
    But I'm set param "sectionId" with incorrect value
    When I call method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid Section Id"

  Scenario: Parse request with invalid section id
    Given I'm set correct params
    But I'm set param "styleTemplateId" with incorrect value
    When I call method Parse
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. "
