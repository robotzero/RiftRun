Feature: Wizards

# Scenario: Returning a collection of wizards from a first page
#     When I request "GET /v1/wizards"
#     Then I get a "200" response
#     And the "page" property exists
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

Scenario: Returning default paginated collection of wizards
    When I request "GET /v1/wizards?page=10"
    Then I get a "200" response
    And the "page" property exists
    And the "page" property is a integer equalling "10"
    And the "pages" property exists
    And the "pages" property is a integer equalling "20"
    And scope into the "_embedded" property
    And the "items" property contains 20 items

#     And scope into the first "_embedded.wizards" property
#         And the property contains "20" items
#     And scope into the "_links.self" property
#         And the "href" property exists
#         And the "href" property is a string equalling "http://localhost/v1/wizards?page=1&limit=20"
#     And scope into the "_links.first" property
#         And the "href" property exists
#         And the "href" property is a string equalling "http://localhost/v1/wizards?page=1&limit=20"
#     And scope into the "_links.lst" property
#         And the "href" property exists
#         And the "href" property is a string equalling "http://localhost/v1/wizards?page=1&limit=20"

# Scenario: Returning a single wizard
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
