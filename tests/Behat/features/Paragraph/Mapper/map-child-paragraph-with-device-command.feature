Feature: Map ChildParagraphWithDevice Command to ChildParagraphWithDevice
  Scenario: I want to map ChildParagraphWithDevice Command to ChildParagraphWithDevice model with full params
    Given I’m set full correct ChildParagraphWithDevice Command
    When I call Method Map
    Then I should get ChildParagraphWithDevice that Implement ChildParagraphWithDeviceInterface
    And Paragraph base properties are correct
    And property styleTemplate should be instance of StyletemplateId
    And property Title should be "Test Title"

  Scenario: I want to map ChildParagraphWithDevice Command to ChildParagraphWithDevice model with empty Title
    Given I’m set full correct ChildParagraphWithDevice Command
    But param Title is empty
    When I call Method Map
    Then I should get ChildParagraphWithDevice that Implement ChildParagraphWithDeviceInterface
    And Paragraph base properties are correct
    And property styleTemplate should be instance of StyletemplateId

  Scenario: I want to map ChildParagraphWithDevice Command to ChildParagraphWithDevice model with empty StyleTemplate
    Given I’m set full correct ChildParagraphWithDevice Command
    But param StyleTemplate is empty
    When I call Method Map
    Then I should get ChildParagraphWithDevice that Implement ChildParagraphWithDeviceInterface
    And Paragraph base properties are correct
    And property Title should be "Test Title"
