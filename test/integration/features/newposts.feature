Feature: Create new Posts

Scenario: I can create new post
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | EU            | 0               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
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

# Scenario: Validation of player object
#     When I request "POST v1/posts" with values:
#         | type | paragonPoints | battleTag | region | seasonal | gameType | minParagon | game | level | char1 | char2 | char3 | char4 |
#         | dh   | 20            | 1000      | EU     | 0        | hardcore | 20         | grift| 40    | dh    | barb  | wizard| monk  |


