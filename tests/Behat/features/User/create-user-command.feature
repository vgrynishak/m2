Feature: Create User by command handler
  Scenario: I want to Create user
    Given User param username "test22333@test.com" and password "qwerty" and email "test2333@test.com" and enable "1" and roles "manager" and name "Cris" and last name "Hemsvort"
    When I call create user command handler
    Then I should have created User entity
