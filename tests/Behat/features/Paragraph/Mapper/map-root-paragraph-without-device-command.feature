Feature: Map RootParagraphWithoutDevice Command  to RootParagraphWithoutDevice
  Scenario: I want to map RootParagraphWithoutDevice Command to RootParagraphWithoutDevice model with full params
    Given I’m set full correct RootParagraphWithoutDevice Command
    When I call Method Map
    Then I should get RootParagraphWithoutDevice that Implement RootParagraphWithoutDeviceInterface
    And Paragraph base properties of RootParagraphWithoutDevice are correct
