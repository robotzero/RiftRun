Feature: Get Posts

Background: 50 post
    Given I have exactly 50 "posts" in the database

Scenario: Returning a collection of posts from a first page
    When I request "GET /v1/posts"
    Then I get a "200" response
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
        And the "id" property is a string
        And the "createdAt" property is a string
        And the "player" property is an object
        And the "query" property is an object
        And the "player.id" property is a string
        And the "player.type" property is a string
        And the "player.paragonPoints" property is an integer
        And the "player.battleTag" property is a string
        And the "player.region" property is a string
        And the "player.seasonal" property is a boolean
        And the "player.gameType" property is a string
        And the "query.id" property is a string
        And the "query.minParagon" property is an integer
        And the "query.game" property is an object
        And the "query.characterType" property is an array
        And the "query.game.level" property is a string
        And the "query.game.type" property is a string
        And scope into the "_links.self" property
            And the "href" property exists
            And the "href" property is a string equalling "http://localhost/v1/posts?page=1&limit=20"

Scenario: Returning a single post
    Given I know single random id of a resource
    When I request single resource "/v1/posts/"
    Then I get a "200" response
    And the properties exist:
             """
             id
             player
             query
             createdAt
             """
    And the "id" property is a string
    And the "player" property is an object
    And the "createdAt" property is a string
    And the "query" property is an object
    And scope into the "player" property
        And the "id" property is a string
        And the "type" property is a string
        And the "paragonPoints" property is an integer
        And the "battleTag" property is a string
        And the "region" property is a string
        And the "seasonal" property is a boolean
        And the "gameType" property is a string
    And scope into the "query" property
        And the "id" property is a string
        And the "minParagon" property is an integer
        And the "game" property is an object
        And the "characterType" property is an array
        And scope into the "query.game" property
            And the "level" property is a string
            And the "type" property is a string
    And scope into the "_links.self" property
        And the "href" property exists
        And the "href" property is a string equalling payload id

Scenario: When single post is not found return 404.
    When I request "GET /v1/posts/84136ccd-9ec1-48a7-8273-00a41a6f86b9"
    Then I get a "404" response

Scenario Outline: When object is missing for the given post do not display this post.
    Given I have <numberMissing> posts missing <object>
    When I request "GET /v1/posts?limit=500&page=1"
    Then I get a "200" response
    And the "page" property exists
    And the "page" property is a integer equalling "1"
    And the "total" property is a integer equalling <result>
    And scope into the "_embedded" property
        And the "items" property contains <items> items

    Examples:
        | numberMissing   | object        | result | items |
        | 10              | SearchQuery   |  "40"  |  40   |
        | 10              | Character     |  "40"  |  40   |
        | 10              | Grift         |  "40"  |  40   |
        | 10              | CharacterType |  "40"  |  40   |

Scenario: By default posts should be sorted by created date. Newest at the top.
    Given I have 10 posts in the database older than 29 days
    When I request "GET /v1/posts?limit=100"
    Then I get a "200" response
    And newest items are displayed at the top
    And 10 days old items are displayed at bottom

Scenario: Do not show posts older than month.
    Given I have 10 posts in the database older than 30 days
    When I request "GET /v1/posts?limit=25&page=2"
    Then I get a "200" response
    And the "page" property exists
    And the "page" property is a integer equalling "2"
    And the "total" property is a integer equalling "50"