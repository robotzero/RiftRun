Feature: Wizards

Scenario: Returning a collection of wizards
    When I request "GET /v1/wizards"
    Then I get a "200" response
    And scope into the first "_embedded.wizards" property
        And the properties exist:
            """
            id
            battleTag
            region
            paragonPoints
            """
        And the "id" property is an integer
        And the "paragonPoints" property is an integer

Scenario: Returning a single wizard
    When I request "GET /v1/wizards/1"
    Then I get a "200" response
    And the properties exist:
            """
            id
            battleTag
            region
            paragonPoints
            """
    And the "id" property is an integer
    And the "paragonPoints" property is an integer
    # TODO test for _links.
    # And the "_links" property is an object
