@pagination
Feature: pagination

Background: 1000 post
    Given I have exactly 1000 "posts" in the database

    Scenario Outline: Returning default paginated collection of posts
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
    | "?page=15&limit=5" | "15"   | "200"   | 5     | "http://localhost/v1/posts?page=15&limit=5"    | "http://localhost/v1/posts?page=1&limit=5"    |  "http://localhost/v1/posts?page=16&limit=5"    |
    | "?page=10"         | "10"   | "50"    | 20    | "http://localhost/v1/posts?page=10&limit=20"   | "http://localhost/v1/posts?page=1&limit=20"   |  "http://localhost/v1/posts?page=11&limit=20"  |