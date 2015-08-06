Feature: Create new Posts

Scenario: I can create new post
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | EU            | 0               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    #Then I get a "302" response
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

Scenario: Empty player object
    When I request "POST v1/posts" with values:
        | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty player.type object
    When I request "POST v1/posts" with values:
        | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | 20                   | 1000             | EU            | 0               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty player.paragonPoints object
    When I request "POST v1/posts" with values:
        | player.type | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 1000             | EU            | 0               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty player.battleTag object
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | EU            | 0               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty player.region object
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | 0               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty player.seasonal object
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | EU            | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty player.gameType object
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | EU            | 0               | 20               | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty query object
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType |  char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | EU            | 0               | hardcore        |  dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty query.minParagon property
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | 1000             | EU            | 0               | hardcore        | grift           | 40               | dh    | barb  | wizard| monk  |
    Then I get a "400" response

Scenario: Empty query.characterType object
    When I request "POST v1/posts" with values:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level |
        | dh          | 20                   | 1000             | EU            | 0               | hardcore        | 20               | grift           | 40               |
    Then I get a "400" response
