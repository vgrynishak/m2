Feature: Parse request for Edit Paragraph
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call method Parse
    Then I should get Command that implements EditParagraphCommandInterface
    And property header should be instance of CustomHeaderInterface

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "title" is empty
    When I call Method Parse
    Then I should get Command that implements EditParagraphCommandInterface
    And Style HeaderType should be instance of DeviceCardInterface

  Scenario: Parse request with incorrect parentKey
    Given I'm set incorrect parentKey
    When I call method Parse
    Then I should get FailEditAction Exception
    And error message should be "Bad request. Invalid Root key"

  Scenario: Parse request with empty Title
    Given I'm set params without title
    When I call method Parse
    Then I should get FailEditAction Exception
    And error message should be "Bad request. Title is required field"

  Scenario: Parse request without Id param
    Given I'm set params without Id
    When I call method Parse
    Then I should get FailEditAction Exception
    And error message should be "Bad request. Paragraph Id is required field"

  Scenario: Parse request with incorrect Id param
    Given I'm set request with incorrect Id
    When I call method Parse
    Then I should get Exception

