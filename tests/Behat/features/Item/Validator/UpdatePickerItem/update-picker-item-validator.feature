Feature: Validate UpdatePickerItemCommand
  Scenario: Validate UpdatePickerItemCommand with correct params
    Given I'm set correct params
    When I call UpdatePickerItemValidator
    Then I should get true result

  Scenario: Validate UpdatePickerItemValidator with not exists itemId
    Given I'm set correct params
    But I'm set not exists param ItemId
    When I call UpdatePickerItemValidator
    Then I should get message error "Item Id is not exists"

  Scenario: Validate UpdatePickerItemValidator with duplicate not exists paragraphId
    Given I'm set correct params
    But I'm set not exists param paragraphId
    When I call UpdatePickerItemValidator
    Then I should get message error "Not found paragraphId"

  Scenario: Validate UpdatePickerItemValidator with invalid length label
    Given I'm set correct params
    But I'm set param "label" with incorrect value
    When I call UpdatePickerItemValidator
    Then I should get message error "Label must be >= 1 characters and <= 255 characters"

  Scenario: Validate UpdatePickerItemValidator with remember option true for paragraph without device
    Given I'm set correct params
    But I'm set param "paragraphId" without device and param remembered true
    When I call UpdatePickerItemValidator
    Then I should get message error "Remembered only in paragraphs linked to device"
