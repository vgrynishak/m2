Feature: Find ParagraphFilter by Id
  Scenario: I want to get By Facility Paragraph Filter
    Given I'm Set param "on_site"
    When I Call Method Find
    Then I should get Filter that Implement Paragraph Filter Interface
    And property Id should be "on_site"

  Scenario: I want to get By Inspection Paragraph Filter
    Given I'm Set param "inspection"
    When I Call Method Find
    Then I should get Filter that Implement Paragraph Filter Interface
    And property Id should be "inspection"

  Scenario: I want to get By Parent Paragraph Filter
    Given I'm Set param "by_ancestor"
    When I Call Method Find
    Then I should get Filter that Implement Paragraph Filter Interface
    And property Id should be "by_ancestor"

  Scenario: I want to get Same As Parent Paragraph Filter
    Given I'm Set param "same_as_parent"
    When I Call Method Find
    Then I should get Filter that Implement Paragraph Filter Interface
    And property Id should be "same_as_parent"

  Scenario: I Want To Try To Find Not Exists Filter
    Given I'm Set incorrect param "test"
    When I Call Method Find
    Then I should get null result

