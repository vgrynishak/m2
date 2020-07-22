Feature: Map ParagraphFilter Entity to ParagraphFilter Model
  Scenario: I want to map ParagraphFilter Entity to By Inspection ParagraphFilter  Model
    Given I’m set ParagraphFilter Entity with id "inspection"
    When I call ParagraphFilterEntityMapper
    Then I should get Filter that Implement Paragraph Filter Interface
    And Filter Id Value equal "inspection"

  Scenario: I want to map ParagraphFilter Entity to By Facility ParagraphFilter Model
    Given I’m set ParagraphFilter Entity with id "on_site"
    When I call ParagraphFilterEntityMapper
    Then I should get Filter that Implement Paragraph Filter Interface
    And Filter Id Value equal "on_site"

  Scenario: I want to map ParagraphFilter Entity to By Parent ParagraphFilter Model
    Given I’m set ParagraphFilter Entity with id "by_ancestor"
    When I call ParagraphFilterEntityMapper
    Then I should get Filter that Implement Paragraph Filter Interface
    And Filter Id Value equal "by_ancestor"

  Scenario: I want to map ParagraphFilter Entity to Same As Parent ParagraphFilter Model
    Given I’m set ParagraphFilter Entity with id "same_as_parent"
    When I call ParagraphFilterEntityMapper
    Then I should get Filter that Implement Paragraph Filter Interface
    And Filter Id Value equal "same_as_parent"
