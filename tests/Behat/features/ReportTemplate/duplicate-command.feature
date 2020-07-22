Feature: Duplicate Report Template by id
  Scenario: I want to duplicate Report Template
    Given ReportTemplate param id "6647e03a-4f98-4a25-acc7-0ebad8fba230"
    When I call handle duplicate message Response
    Then I should have report template result Response with status 200

  Scenario: I want to get error for duplicate Report Template
    Given ReportTemplate param id "ac0cec75-b17d-4509-b15a-29621c41b18"
    When I call handle duplicate message Response
    Then I should have report template result Response with status 400
