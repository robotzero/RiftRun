Feature: Create new Posts

Background: Correct payload
    Given I have default payload:
        | player.type | player.paragonPoints | player.battleTag | player.region | player.seasonal | player.gameType | query.minParagon | query.characterType.type                        | query.game.type | query.game.level |
        | demon hunter| 20                   | #1000            | EU            | 1               | hardcore        | 20               | demon hunter,barbarian,wizard,monk,witch doctor | grift           | 40+              |

Scenario: I can create new post
    When I request "POST v1/posts" with payload
    And the properties exist:
        """
        postId
        searchQueryId
        """
    Then I get a "201" response
    And the "postId" property has "searchQueryId" property with "query" getter equalling id of object in the "Post" database

Scenario Outline: Diffrent game type
    When payload properties <properties> equals <values>
    And remove <rproperties> from payload
    And  I request "POST v1/posts" with payload
    Then I get a "201" response
    Examples:
        | properties                          | values           | rproperties      |
        | query.game.type,query.game.torment  | rift,1           | query.game.level |
        | query.game.type,query.game.level    | grift,40+        |                  |

Scenario Outline: Wrong object
    Given I have the object "<object>" item "<item>" value "<value>"
    When Object has set item to value
    And  I request "POST v1/posts" with payload
    Then I get a "400" response
    Examples:
        | object           | item               | value     |
#        | player           | type               |  missing  |
        | player           | type               | 1         |
        | player           | type               | null      |
        | player           | type               | false     |
        | player           | type               | true      |
        | player           | type               | 0         |
#        | "player"         | "type"             | ""        |
#        | "player"         | "type"             | "  "      |
#        | "player"         | "paragonPoints"    | "missing" |
        | player           | paragonPoints      | word       |
        | player           | paragonPoints      | 0         |
        | player           | paragonPoints      | -100    |
        | player           | paragonPoints      | null    |
        | player           | paragonPoints      | false   |
        | player           | paragonPoints      | true    |
#        | "player"         | "paragonPoints"    | ""        |
#        | "player"         | "paragonPoints"    | "  "      |
#        | "player"         | "battleTag"        | "missing" |
        | player           | battleTag          | 1         |
        | player           | battleTag          | 1000      |
        | player           | battleTag          | -100    |
        | player           | battleTag          | -00     |
        | player           | battleTag          | null    |
        | player           | battleTag          | false   |
        | player           | battleTag          | true    |
#        | "player"         | "battleTag"        | ""        |
#        | "player"         | "battleTag"        | "  "      |
#        | "player"         | "region"           | "missing" |
        | player           | region             | abcde   |
        | player           | region             | eu      |
        | player           | region             | na      |
        | player           | region             | 1         |
        | player           | region             | -100    |
        | player           | region             | null    |
        | player           | region             | false   |
        | player           | region             | true    |
#        | "player"         | "region"           | ""        |
#        | "player"         | "region"           | "  "      |
#        | "player"         | "seasonal"         | "missing" |
        | player           | seasonal           | 000     |
        | player           | seasonal           | 000       |
        | player           | seasonal           | 3         |
        | player           | seasonal           | -10     |
        | player           | seasonal           | abcde   |
        | player           | seasonal           | null    |
        | player           | seasonal           | false   |
#        | "player"         | "seasonal"         | ""        |
#        | "player"         | "seasonal"         | "  "      |
#        | "player"         | "gameType"         | "missing" |
        | player           | gameType           | blabla  |
        | player           | gameType           | SOFTCORE|
        | player           | gameType           | HARDCORE|
        | player           | gameType           | 0         |
        | player           | gameType           | -0      |
        | player           | gameType           | -100    |
        | player           | gameType           | 100       |
        | player           | gameType           | null    |
        | player           | gameType           | false   |
        | player           | gameType           | true    |
#        | "player"         | "gameType"         | ""        |
#        | "player"         | "gameType"         | "  "      |
#        | "post"           | "player"           | "missing" |
        | post             | player             | blabla  |
        | post             | player             | 0         |
        | post             | player             | -0      |
        | post             | player             | 100       |
        | post             | player             | null    |
        | post             | player             | false   |
        | post             | player             | true    |
#        | "post"           | "player"           | ""        |
#        | "post"           | "player"           | "  "      |
#        | "post"           | "query"            | "missing" |
        | post             | query              | blabla  |
        | post             | query              | 0         |
        | post             | query              | -0      |
        | post             | query              | 100       |
        | post             | query              | null    |
        | post             | query              | false   |
        | post             | query              | true    |
#        | "post"           | "query"            | ""        |
#        | "post"             | "query"            | "  "      |
#        | "query"            | "minParagon"       | "missing" |
        | query            | minParagon         | blabla  |
        | query            | minParagon         | 0         |
        | query            | minParagon         | -0      |
        | query            | minParagon         | -100    |
        | query            | minParagon         | null    |
        | query            | minParagon         | false   |
        | query            | minParagon         | true    |
#        | "query"            | "minParagon"       | ""        |
#        | "query"            | "minParagon"       | "  "      |
#        | "query"            | "game"             | "missing" |
        | query            | game               | blabla  |
        | query            | game               | 0         |
        | query            | game               | -0      |
        | query            | game               | -100    |
        | query            | game               | null    |
        | query            | game               | false   |
        | query            | game               | true    |
#        | "query"            | "game"             | ""        |
#        | query            | game             |   "   "      |
#        | "game"             | "level"            | "missing" |
        | game             | level              | blabla  |
        | game             | level              | 0         |
        | game             | level              | -0      |
        | game             | level              | -100    |
        | game             | level              | null    |
        | game             | level              | false   |
        | game             | level              | true    |
#        | "game"             | "level"            | ""        |
#        | "game"             | "level"            | "  "      |
#        | "query"            | "characterTypes"      | "missing" |
#        | "query"            | "characterTypes"      | "dh,barb,wiz" |
#        | "query"            | "characterTypes"      | "demon hunter,barb,wiz" |
#        | "query"            | "characterTypes"      | "demon hunter,barbarian,monk,witch" |
#        | "query"            | "characterTypes"      | "demon hunter,barbarian,monk,witch doctor,wizard,and" |
#        | "query"            | "characterTypes"      | "demon hunter,null" |
#        | "query"            | "characterTypes"      | "null" |
#        | "query"            | "characterTypes"      | "blabla"  |
#        | "query"            | "characterTypes"      | 0         |
#        | "query"            | "characterTypes"      | "-0"      |
#        | "query"            | "characterTypes"      | "-100"    |
#        | "query"            | "characterTypes"      | "false"   |
#        | "query"            | "characterTypes"      | "true"    |
#        | "query"            | "characterTypes"      | ""        |
#        | "query"            | "characterTypes"      | "  "      |
#        | "query"            | "characterTypes"      | "0,2,1"   |
#        | "query"            | "characterTypes"      | "less "   |
#        | "query"            | "characterType"      | "missing" |
#        | "query"            | "characterType"      | "dh,barb,wiz" |
#        | "query"            | "characterType"      | "demon hunter" |
#        | "query"            | "characterType"      | "null" |
#        | "query"            | "characterType"      | "blabla"  |
#        | "query"            | "characterType"      | 0         |
#        | "query"            | "characterType"      | "-0"      |
#        | "query"            | "characterType"      | "-100"    |
#        | "query"            | "characterType"      | "false"   |
#        | "query"            | "characterType"      | "true"    |
#        | "query"            | "characterType"      | ""        |
#        | "query"            | "characterType"      | "  "      |
#        | "query"            | "characterType"      | "0,2,1"   |