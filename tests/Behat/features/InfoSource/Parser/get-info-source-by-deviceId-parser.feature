Feature: Parse request for GetDeviceDynamicFieldListByDeviceIdParserInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call GetDeviceDynamicFieldListByDeviceIdParser
    Then I should get GetDeviceDynamicFieldListByDeviceIdParserInterface

  Scenario: Parse request without deviceId param
    Given I'm set correct params
    But param "dictionaryId" is empty
    When I call GetDeviceDynamicFieldListByDeviceIdParser
    Then I should get Exception "Bad request. Dictionary Id is required field"

  Scenario: Parse request with invalid deviceId
    Given I'm set correct params
    But I'm set param "dictionaryId" with next value "as"
    When I call GetDeviceDynamicFieldListByDeviceIdParser
    Then I should get Exception "Invalid DictionaryId given"
