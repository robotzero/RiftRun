Feature: Get Posts

Background: 1000 post
    Given I have at least 1000 "posts" in the database

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
        And the "id" property is an integer
        And the "createdAt" property is a string
        And the "player" property is an object
        And the "query" property is an object
        And the "player.id" property is an integer
        And the "player.type" property is a string
        And the "player.paragonPoints" property is an integer
        And the "player.battleTag" property is a string
        And the "player.region" property is a string
        And the "player.createdAt" property is a string
        And the "player.seasonal" property is a boolean
        And the "player.gameType" property is a string
        And the "query.id" property is an integer
        And the "query.minParagon" property is an integer
        And the "query.createdAt" property is a string
        And the "query.game" property is an object
        And the "query.characterClass" property is an array
        And the "query.game.level" property is a string
        And the "query.game.type" property is a string
        And scope into the "_links.self" property
            And the "href" property exists
            And the "href" property is a string equalling "http://localhost/v1/posts?page=1&limit=20"

Scenario Outline: Returning default paginated collection of wizards

     When I request "GET /v1/posts" with parameters <params>
     Then I get a "200" response
     And the "page" property exists
     And the "page" property is a integer equalling <page>
     And the "pages" property exists
     And the "pages" property is a integer equalling <pages>
     And scope into the "_embedded" property
     And the "items" property contains <items> items
     And scope into the "_links.self" property
          And the "href" property exists
          And the "href" property is a string equalling <self>
     And scope into the "_links.first" property
          And the "href" property exists
          And the "href" property is a string equalling <first>
     And scope into the "_links.next" property
         And the "href" property exists
         And the "href" property is a string equalling <next>

    Examples:
        | params             |  page  | pages   | items | self                                           | first                                         | next                                       |
        | "?page=15&limit=5" | "15"   | "200"   | 5     | "http://localhost/v1/posts?page=15&limit=5"  | "http://localhost/v1/posts?page=1&limit=5" |  "http://localhost/v1/posts?page=16&limit=5"    |
        | "?page=10"         | "10"   | "50"    | 20    | "http://localhost/v1/posts?page=10&limit=20" | "http://localhost/v1/posts?page=1&limit=20" |  "http://localhost/v1/posts?page=11&limit=20"  |

Scenario: Returning a single post
    When I request "GET /v1/posts/1"
    Then I get a "200" response
    And the properties exist:
             """
             id
             player
             query
             createdAt
             """
    And the "id" property is an integer
    And the "player" property is an object
    And the "createdAt" property is a string
    And the "query" property is an object
    And scope into the "player" property
        And the "id" property is an integer
        And the "type" property is a string
        And the "paragonPoints" property is an integer
        And the "battleTag" property is a string
        And the "region" property is a string
        And the "createdAt" property is a string
        And the "seasonal" property is a boolean
        And the "gameType" property is a string
    And scope into the "query" property
        And the "id" property is an integer
        And the "minParagon" property is an integer
        And the "createdAt" property is a string
        And the "game" property is an object
        And the "characterClass" property is an array
        And scope into the "query.game" property
            And the "level" property is a string
            And the "type" property is a string
    And scope into the "_links.self" property
        And the "href" property exists
        And the "href" property is a string equalling "http://localhost/v1/posts/1"

Scenario: Do not show posts older than a 30 days.
    Given I have at least 10 posts older than a month
    When I request "GET /v1/posts?limit=500&page=2"
    Then I get a "200" response
    And the "page" property exists
    And the "page" property is a integer equalling "2"
    And the "total" property is a integer equalling "1000"

Scenario Outline: When object is missing for the given post do not display this post.
    Given I have <numberMissing> posts missing <object> object starting from <ids>
    When I request "GET /v1/posts?limit=500&page=2"
    Then I get a "200" response
    And the "page" property exists
    And the "page" property is a integer equalling "2"
    And the "total" property is a integer equalling <result>
    And scope into the "_embedded" property
        And the "items" property contains <items> items

    Examples:
        | numberMissing   | object          | ids | result   | items |
        | 10              | "searchquery"   | 1   |  "990"   |  490  |
        | 10              | "characters"    | 11  |  "980"   |  480  |
        | 10              | "gametype"      | 21  |  "970"   |  470  |
        | 10              | "characterclass"| 31  |  "960"   |  460  |

Scenario: By default posts should be sorted by created date. Newest at the top.
    When I request
    And the newest posts are displayed at the top
