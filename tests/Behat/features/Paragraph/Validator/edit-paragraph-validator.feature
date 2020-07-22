Feature: Validate EditParagraphCommand
  Scenario: Validate EditParagraphCommand with correct params
    Given I'm set correct EditParagraphCommand
    When I call Method Validate
    Then I should get true result

  Scenario: Validate EditParagraphCommand with Title less then 3
    Given I'm set EditParagraphCommand with Title less then 3
    When I call Method Validate
    Then I should get message error "Title length must be greater then 3"

  Scenario: Validate EditParagraphCommand with Title greater then 100
    Given I'm set EditParagraphCommand with Title greater then 100
    When I call Method Validate
    Then I should get message error "Title length must be less then 100"

  Scenario: Validate EditParagraphCommand with not exists Id
    Given I'm set EditParagraphCommand with not exists Id
    When I call Method Validate
    Then I should get message error "Paragraph with this Id not exists"

  Scenario: Validate EditParagraphCommand with incorrect modifiedBy property
    Given I'm set EditParagraphCommand with not created User
    When I call Method Validate
    Then I should get message error "User was not created"
