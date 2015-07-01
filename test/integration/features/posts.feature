Feature: Posts

# Scenario: When character or search query is missing for the given post
# 	  do not display this post.

Scenario: Returning a collection of posts from a first page
    Given I have at least 10 "posts" in the database
    When I request "GET /v1/posts"
    Then I get a "200" response
    And the "page" property exists
#     And the "page" property is a integer equalling "1"
#     And scope into the first "_embedded.items" property
#         And the properties exist:
#             """
#             id
#             battleTag
#             region
#             paragonPoints
#             """
#         And the "id" property is an integer
#         And the "paragonPoints" property is an integer
#     And scope into the "_links.self" property
#         And the "href" property exists
#         And the "href" property is a string equalling "http://localhost/v1/wizards?page=1&limit=20"

# Scenario Outline: Returning default paginated collection of wizards
#     Given I have at least 1000 "wizard" in the database
#     When I request "GET /v1/wizards" with parameters <params>
#     Then I get a "200" response
#     And the "page" property exists
#     And the "page" property is a integer equalling <page>
#     And the "pages" property exists
#     And the "pages" property is a integer equalling <pages>
#     And scope into the "_embedded" property
#     And the "items" property contains <items> items
#     And scope into the "_links.self" property
#          And the "href" property exists
#          And the "href" property is a string equalling <self>
#     And scope into the "_links.first" property
#          And the "href" property exists
#          And the "href" property is a string equalling <first>
#     And scope into the "_links.next" property
#         And the "href" property exists
#         And the "href" property is a string equalling <next>

#     Examples:
#         | params             |  page  | pages   | items | self                                           | first                                         | next                                             |
#         | "?page=10"         | "10"   | "50"    | 20    | "http://localhost/v1/wizards?page=10&limit=20" | "http://localhost/v1/wizards?page=1&limit=20" |  "http://localhost/v1/wizards?page=11&limit=20"  |
#         | "?page=15&limit=5" | "15"   | "200"   | 5     | "http://localhost/v1/wizards?page=15&limit=5"  | "http://localhost/v1/wizards?page=1&limit=5" |  "http://localhost/v1/wizards?page=16&limit=5"    |



# Scenario: Returning a single wizard
#     Given I have at least 10 "wizard" in the database
#     When I request "GET /v1/wizards/1"
#     Then I get a "200" response
#     And the properties exist:
#             """
#             id
#             battleTag
#             region
#             paragonPoints
#             """
#     And the "id" property is an integer
#     And the "paragonPoints" property is an integer
#     And scope into the "_links.self" property
#     And the "href" property exists
#     And the "href" property is a string equalling "http://localhost/v1/wizards/1"
