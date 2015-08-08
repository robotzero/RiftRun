Feature: Create new Posts

Background: Correct payload
    Given I have default payload:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.game.type | query.game.level | char1 | char2 | char3 | char4 |
        | dh          | 20                   | #1000            | EU            | 1               | hardcore        | 20               | grift           | 40               | dh    | barb  | wizard| monk  |

Scenario: I can create new post
    When I request "POST v1/posts" with payload
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

Scenario Outline: Wrong object player
    When the obj <object> has set <item> to <value>
    And  I request "POST v1/posts" with payload
    Then I get a "400" response
    Examples:
        | object           | item               | value     |
        # | "player"         | "type"             | "missing" |
        # | "player"         | "type"             | 1         |
        # | "player"         | "type"             | "null"    |
        # | "player"         | "type"             | "false"   |
        # | "player"         | "type"             | "true"    |
        # | "player"         | "type"             | 0         |
        # | "player"         | "type"             | ""        |
        # | "player"         | "type"             | "  "      |
        # | "player"         | "paragonPoints"    | "missing" |
        # | "player"         | "paragonPoints"    | "word"    |
        # | "player"         | "paragonPoints"    | 0         |
        # | "player"         | "paragonPoints"    | "-100"    |
        # | "player"         | "paragonPoints"    | "null"    |
        # | "player"         | "paragonPoints"    | "false"   |
        # | "player"         | "paragonPoints"    | "true"    |
        # | "player"         | "paragonPoints"    | ""        |
        # | "player"         | "paragonPoints"    | "  "      |
        # | "player"         | "battleTag"        | "missing" |
        # | "player"         | "battleTag"        | 1         |
        # | "player"         | "battleTag"        | 1000      |
        # | "player"         | "battleTag"        | "-100"    |
        # | "player"         | "battleTag"        | "-00"     |
        # | "player"         | "battleTag"        | "null"    |
        # | "player"         | "battleTag"        | "false"   |
        # | "player"         | "battleTag"        | "true"    |
        # | "player"         | "battleTag"        | ""        |
        # | "player"         | "battleTag"        | "  "      |
        # | "player"         | "region"           | "missing" |
        # | "player"         | "region"           | "abcde"   |
        # | "player"         | "region"           | "eu"      |
        # | "player"         | "region"           | "na"      |
        # | "player"         | "region"           | 1         |
        # | "player"         | "region"           | "-100"    |
        # | "player"         | "region"           | "null"    |
        # | "player"         | "region"           | "false"   |
        # | "player"         | "region"           | "true"    |
        # | "player"         | "region"           | ""        |
        # | "player"         | "region"           | "  "      |
        # | "player"         | "seasonal"         | "missing" |
        # | "player"         | "seasonal"         | "000"     |
        # | "player"         | "seasonal"         | 000       |
        # | "player"         | "seasonal"         | "-10"     |
        # | "player"         | "seasonal"         | "abcde"   |
        # | "player"         | "seasonal"         | "null"    |
        | "player"         | "seasonal"         | "false"   |
        # | "player"         | "seasonal"         | "true"    |
        # | "player"         | "seasonal"         | ""        |
        # | "player"         | "seasonal"         | "  "      |
        # | "player"         | "gameType"         | "missing" |
        # | "player"         | "gameType"         | "blabla " |
        # | "player"         | "gameType"         | "SOFTCORE"|
        # | "player"         | "gameType"         | "HARDCORE"|
        # | "player"         | "gameType"         | 0         |
        # | "player"         | "gameType"         | -0        |
        # | "player"         | "gameType"         | -100      |
        # | "player"         | "gameType"         | 100       |
        # | "player"         | "gameType"         | null      |
        # | "player"         | "gameType"         | false     |
        # | "player"         | "gameType"         | true      |
        # | "player"         | "gameType"         | ""        |
        # | "player"         | "gameType"         | "  "      |
