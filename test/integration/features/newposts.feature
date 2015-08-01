Feature: Create new Posts

Scenario: I can create new post
    When I request "POST v1/posts" with values:
        | player | type | dh | paragonPonts:40,battleTag: 01, region: eu, seasonal: false, gameType: softcore |
        | query  | minParagon: 30, game: |type:grift, level: 40|
    Then I get a "302" response
    And the "page" property exists
    And the "page" property is a integer equalling "1"
    And scope into the first "_embedded.items" property
        And the properties exist:
            """
            id
            player
            query
            createdAt
            """


