Feature: Parse request for CreateReportTemplateCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call CreateReportTemplateParser
    Then I should get CreateReportTemplateCommand

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is empty
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. ReportTemplate Id is required field"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "id" with next value "incorrect_id"
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Invalid ReportTemplateId given"

  Scenario: Parse request without ServiceId param
    Given I'm set correct params
    But param "serviceId" is empty
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Service Id is required field"

  Scenario: Parse request with invalid serviceId
    Given I'm set correct params
    But I'm set param "serviceId" with next value "incorrect_id"
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Invalid ServiceId given"

  Scenario: Parse request without DeviceId param
    Given I'm set correct params
    But param "deviceId" is empty
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Device Id is required field"

  Scenario: Parse request with invalid deviceId
    Given I'm set correct params
    But I'm set param "deviceId" with next value "incorrect_id"
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Invalid DeviceId given"

  Scenario: Parse request without name param
    Given I'm set correct params
    But param "name" is empty
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Invalid Report Template Name"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call CreateReportTemplateParser
    Then I should get Exception "Bad request. Invalid root key"
