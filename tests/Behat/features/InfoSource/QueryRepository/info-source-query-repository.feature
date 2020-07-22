Feature: I want to check requests in the InfoSourceQueryRepositoryInterface
  Scenario: I want to find InfoSourceInterface
    Given I'm set InfoSourceId
    When I Call Method find
    Then I should get InfoSourceInterface

  Scenario: I want to find InfoSourceInterface Collection
    Given I'm set DeviceId
    When I Call Method findAllByDeviceId
    Then I should get InfoSourceInterface Collection

  Scenario: I want to not find InfoSourceInterface
    Given I'm set incorrect InfoSourceId
    When I Call Method find
    Then I should not get InfoSourceInterface

  Scenario: I want to not find InfoSourceInterface Collection
    Given I'm set incorrect DeviceId
    When I Call Method findAllByDeviceId
    Then I should not get InfoSourceInterface Collection
