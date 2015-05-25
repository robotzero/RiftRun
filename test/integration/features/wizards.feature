Feature: Wizards

Scenario: Returning a collection of wizards
    When I request "GET /wizards"
    Then I get a "200" response
    And scope into the first "wizards" property
        And the properties exist:
            """
            id
            battle
            server
            """
        And the "id" property is an integer

Scenario: Returning single wizard
    When I request "GET /wizards/1"
    Then I get a "200" response
    And the properties exist:
            """
            id
            battle
            server
            """
    And the "id" property is an integer
