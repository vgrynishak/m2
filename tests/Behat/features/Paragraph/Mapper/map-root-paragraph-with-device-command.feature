Feature: Map RootParagraphWithDevice Command  to RootParagraphWithDevice
  Scenario: I want to map RootParagraphWithDevice Command to RootParagraphWithDevice model with full params
    Given I’m set full correct RootParagraphWithDevice Command
    When I call Method Map
    Then I should get RootParagraphWithDevice that Implement RootParagraphWithDeviceInterface
    And Paragraph base properties are correct
    And property styleTemplate should be instance of StyletemplateId
    And property Title should be "Test Title"

  Scenario: I want to map RootParagraphWithDevice Command to RootParagraphWithDevice model with empty Title
    Given I’m set full correct RootParagraphWithDevice Command
    But param Title is empty
    When I call Method Map
    Then I should get RootParagraphWithDevice that Implement RootParagraphWithDeviceInterface
    And Paragraph base properties are correct
    And property styleTemplate should be instance of StyletemplateId

  Scenario: I want to map RootParagraphWithDevice Command to RootParagraphWithDevice model with empty StyleTemplate
    Given I’m set full correct RootParagraphWithDevice Command
    But param StyleTemplate is empty
    When I call Method Map
    Then I should get RootParagraphWithDevice that Implement RootParagraphWithDeviceInterface
    And Paragraph base properties are correct
    And property Title should be "Test Title"


