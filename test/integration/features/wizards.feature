Feature: Wizards

Scenario: Returning a collection of wizards
    When I request "GET /wizards"
    Then I get a "200" response
    And scope into the first "data" property
        And the properties exist:
            """
            id
            battleTag
            server
            """
        And the "id" property is an integer
