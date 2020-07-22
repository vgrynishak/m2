Feature: Make Paragraph by ParagraphFactory
  Scenario: Making Root Paragraph Without Device
    Given I'm Set Correct Params For Root Paragraph Without Device
    When I Call Method makeRootWithoutDevice
    Then I Should Get Correct Root Paragraph Without Device

  Scenario: Making Root Paragraph With Device
    Given I'm Set Correct Params For Root Paragraph With Device
    When I Call Method makeRootWithDevice
    Then I Should Get Correct Root Paragraph With Device
