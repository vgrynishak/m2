Feature: I want to check requests in the ServiceInstanceQueryRepositoryInterface
  Scenario: I want to find ServiceInstanceInterface
    Given I'm set ServiceInstanceId
    When I Call Method find
    Then I should get ServiceInstanceInterface

  Scenario: I want to not find ServiceInstanceInterface
    Given I'm set incorrect ServiceInstanceId
    When I Call Method find
    Then I should not get ServiceInstanceInterface
